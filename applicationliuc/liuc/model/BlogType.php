<?php
namespace app\liuc\model;
use think\Model;
use think\Db;

/**
* 博文类型
*/
class BlogType extends Model
{
	public function selectBootstrap($offset,$limit,$order,$sort,$search){
		//------bootstrap
		$data = Db::table('blog_type')->where('b_id|blog_type','like','%'.$search.'%')->order('b_id',$order)->select();
		$count = count($data);
		$ret = [
			'total'=>$count,
			'rows'=>array_slice($data,$offset,$limit)
		];
		return json_encode($ret);
	}
	public function getAll($sort='b_id',$order='asc'){
		//获取所有
		$data = Db::table('blog_type')->order($sort,$order)->select();
		return $data;
	}
	
}