<?php
namespace app\liuc\controller;
use think\Controller;
/**
* 后台
*/
class Admin extends Common
{
	public function index(){
		//后台主页
		return $this->fetch('admin/index');
	}	
	public function content(){
		//第一个展示的界面
		return $this->fetch('admin/content');
	}
}