<?php
namespace app\liuc\model;
use think\Model;
use think\Db;

/**
* 
*/
class Blogs extends Model
{
	public function selectBootstrap($offset,$limit,$order,$sort,$search=""){
		//查询bootstrap的情况
		$data = Db::table('blogs')->alias('a')->join('blog_type b','a.b_id=b.b_id')->where('id|title','like','%'.$search.'%')->order($sort? $sort : 'id',$order)->select();
		$count = count($data);
		$ret = [
			'total'=>$count,
			'rows'=>array_slice($data,$offset,$limit)
		];
		return json_encode($ret);
	}
	public function getType($offset,$pageAmount){
		//分类查询
		$data = Db::table('blogs')->alias('a')->join('blog_type b','a.b_id=b.b_id')->order('create_time','desc')->limit($offset,$pageAmount)->select();
		
		return $data;
	}
	public function getContent($id){
		//查询数据
		$data = Db::table('blogs')->alias('a')->join('blog_type b','a.b_id=b.b_id')->where('a.id',$id)->select();
		
		return $data;
	}




	/*
	 *	Blog 控制器 start
	 */
	public function getBlogType($type){
		// 查询分类的类型 倒叙
		$data = Db::table('blogs')->alias('a')->join('blog_type b','a.b_id=b.b_id')->where('a.b_id',$type)->order('create_time','desc')->select();
		return $data;
	}
}