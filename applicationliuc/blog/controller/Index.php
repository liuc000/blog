<?php
namespace app\blog\controller;
use think\Controller;
use think\Request;
use app\liuc\model\Blogs as BlogModel;
use app\liuc\model\BlogType as BlogTypeModel;
/**
* 博客
*/
class Index extends Controller
{
	public function index(Request $r){
		//博客主页
		$page = (int)input('page');//分页
		$blog = new BlogModel(); //博客
		$blogtype = new BlogTypeModel(); //博文类型
		
		// 统计有多少页 start
		$pageAmount = 6; //每页6条数据
		$pageCount = $blog->count();//数据总数
		$pageTotal = ceil($pageCount / $pageAmount);//一共多少页
		// 统计有多少页 end
		if (isset($page) && $page === 0 || $page < 1 || $page > $pageTotal) {
				$page = 1;
		}
		

		//开始截取的数据
		$dataStart = ($page - 1) * $pageAmount;

		//分页
		$page = [
			'dataCount'=>$pageCount,//一共多少条数据
			'pageAmount'=>$pageAmount,//每页几条
			'pageTotal'=>$pageTotal,//一共多少页
			'page'=>$page,//初始页码
		];

		//渲染到页面的数据
		$data =  $blogtype->getAll();//分类
		$blogData = $blog->getType($dataStart,$pageAmount);//倒叙截取6条数据

		return $this->fetch('index/index',['data'=>$data,'blogData'=>$blogData,'page'=>$page]);

		
	}	



}