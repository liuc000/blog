<?php
namespace app\blog\controller;
use think\Controller;
use think\Request;
use app\liuc\model\Blogs as BlogModel;
use app\liuc\model\BlogType as BlogTypeModel;
/**
* 博客
*/
class Blog extends Controller
{
	public function Content(Request $r){
		//博文内容
		$id = input('id');
		$blog = new BlogModel();

		//分类
		$blogtype = new BlogTypeModel(); //博文类型
		$data =  $blogtype->getAll();//分类

		$blogData = $blog->getContent($id);
		$this->assign('blogData',$blogData);
		return $this->fetch('blog/content',['blogData'=>$blogData,'data'=>$data]);
	}
	
}