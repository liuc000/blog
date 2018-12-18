<?php
namespace app\liuc\controller;

/**
* 前台个人信息
*/
class Index extends Common 
{
	public function index()
	{
		//页面
		return $this->fetch('index/index');
	}
}