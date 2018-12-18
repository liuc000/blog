<?php
namespace app\liuc\controller;
use think\Controller;

class Common extends Controller{
	//验证模块
	public function __construct(){
		//重新构造父类
		parent::__construct();
		if(empty(session('user'))){
			header("location:/liuc/login/login");
			die;
		}
	}
	public function _empty(){
		return View('404/index');
	}


}

