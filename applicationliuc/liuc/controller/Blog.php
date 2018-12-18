<?php
namespace app\liuc\controller;
use think\Controller;
use think\Request;
use app\liuc\model\Blogs as BlogModel;
use app\liuc\model\BlogType as BlogTypeModel;
/**
* 后台博客
*/
class Blog extends Common
{
	public function list_table(Request $r){
		//-------博文列表
		if ($r->isget()) {
			$type = input('type');
			$this->assign('type',$type);

			switch ($type) {
				case 'blog':

					return $this->fetch('blog/list_table');
				case 'blog_type':
					return $this->fetch('blog/list_type');
				
				default:
					# code...
					return "出错啦!";
					break;
			}
		}
		


	}


	public function list_table_data(Request $r){
		//-------bootstraptable 的数据
		if ($r->isget()) {
			return;
		}
		//bootstrap-table data
		$offset = input('offset');	//开始页
		$limit = input('limit');	//数据条数
		$order = input('order');	//排序方式
		$sort = input('sort');	//分类--点击排序
		$search = input('search');	//搜索

		//渲染博文列表
		$model = new BlogModel;
		$data = $model->selectBootstrap($offset,$limit,$order,$sort,$search);
		echo $data;

	}
	public function list_type_data(Request $r){
		//-------bootstraptable 的数据
		if ($r->isget()) {
			return;
		}
		//bootstrap-table data
		$offset = input('offset');	//开始页
		$limit = input('limit');	//数据条数
		$order = input('order');	//排序方式
		$sort = input('sort');	//分类--点击排序
		$search = input('search');	//搜索


		//渲染博文分类
		//表格版-table start
		$model = new BlogTypeModel();
		$data = $model->selectBootstrap($offset,$limit,$order,$sort,$search);

		echo $data;
		
	}

	
	public function add_blog(Request $r){
		if ($r->isget()) {
			//添加博文页面
			$model = new BlogTypeModel();
			$data = $model->order('b_id','asc')->select();
			$this->assign('data',$data);
			return $this->fetch('blog/add_blog');
		}
		$model = new BlogModel();

		$title = input('title');
		$b_id = input('b_id');
		$presentation = input('presentation');
		$img = input('img');
		$content = input('content');

		$x = '';
		switch ($x) {
			case $title:
				return [
					'code'=>'10',
					'text'=>'标题不能为空'
				];
			case $presentation:
				return [
					'code'=>'10',
					'text'=>'导读部分不能为空'
				];
			case $content:
				return [
					'code'=>'10',
					'text'=>'内容不能为空'
				];
			default:
				# code...
				break;
		}
		$model->title = $title;
		$model->b_id = $b_id;
		$model->img = $img ? $img : null;
		$model->content = $content;
		$model->presentation = $presentation;
		$model->create_time = time();
		$model->update_time = time();
		$save = $model->save();
		if ($save) {
			return [
				'code'=>'20',
				'text'=>'保存成功'
			];
		}
		return [
			'code'=>'10',
			'text'=>'保存失败'
		];
	}

	public function add_type(Request $r){
		//博文分类添加
		$model = new BlogTypeModel();


		if ($r->isget()) {
			$data = $model->where('classify','0')->select();

			$this->assign('data',$data);
			return $this->fetch('blog/add_type');
		}
		// post

		$blog_type = input('blog_type');
		$classify = input('classify');
		if (empty($blog_type)) {
			return [
				'code'=>'10',
				'text'=>'分类名称不能为空'
			];
		}
		$model->blog_type = $blog_type;
		$model->classify = $classify;
		$res = $model->save();
		if ($res) {
			return [
				'code'=>'20',
				'text'=>'保存成功'
			];
		}
		return [
			'code'=>'10',
			'text'=>'保存失败'
		];
	}

	public function editor_blog(Request $r){
		//修改博客
		if ($r->isget()) {
			//分类
			$type = new BlogTypeModel();
			$data = $type->order('b_id','asc')->select();
			$this->assign('type',$data);

			$id = input('id');
			$model = new  BlogModel();
			$data = $model->where('id',$id)->find();
			$this->assign('data',$data);
			return $this->fetch('blog/editor_blog');
		}
		
		$model = new BlogModel();
		$id = input('id');
		$title = input('title');
		$b_id = input('b_id');
		$presentation = input('presentation');
		$img = input('img');
		$content = input('content');

		switch ("") {
			case $id:
				return [
					'code'=>'10',
					'text'=>'缺少相应参数'
					];
			case $title:
				return [
					'code'=>'10',
					'text'=>'标题不能为空'
					];
			case $b_id:
				return [
					'code'=>'10',
					'text'=>'类型选择错误'
					];
			case $presentation:
				return [
					'code'=>'10',
					'text'=>'导读部分不能为空'
					];
			case $content:
				return [
					'code'=>'10',
					'text'=>'内容不能为空'
					];
		}
		$data = $model->where('id',$id)->find();
		$data->title = $title;
		$data->b_id = $b_id;
		$data->img = $img ? $img : null;
		$data->content = $content;
		$data->presentation = $presentation;
		$data->update_time = time();
		$save = $data->save();
		if ($save) {
			return [
				'code'=>'20',
				'text'=>'修改成功'
			];
		}
		return [
			'code'=>'10',
			'text'=>'修改失败'
		];
	}

	public function del(Request $r){
		if ($r->isget()) {
			return;
		}

		$id = input('id');
		$model = new BlogModel();
		$data = $model->where('id',$id)->find();
		if (empty($data)) {
			//空数据
			return [
				'code'=>'10',
				'text'=>'数据为空'
			];
		}
		$del = $model->where('id',$id)->delete();
		if ($del) {
			return [
				'code'=>'20',
				'text'=>'删除成功'
			];
		}
		return [
			'code'=>'10',
			'text'=>'删除失败'
		];
		
	}

}