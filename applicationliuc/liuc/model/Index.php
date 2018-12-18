<?php
namespace app\liuc\model;
use think\Model;
use think\Db;
/**
* 个人介绍
*/
class Index extends Model
{
	public function all_data(){
		$data = Db::query('SELECT * FROM index order by top,id desc');
		return $data;
	}	

}