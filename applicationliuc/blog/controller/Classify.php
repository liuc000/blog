<?php
namespace app\blog\controller;
use think\Controller;
use think\Request;
use app\liuc\model\Blogs as BlogModel;
use app\liuc\model\BlogType as BlogTypeModel;

/**
* 	分类展示页面
*/
class Classify extends Controller
{
	public function index(Request $r){
		//传递进来类别
		$type = input('type');
		$page = (int)input('page');//分页

		if ($type == "" && $page == "") {
			echo "<script>window.location.href='/blog/index/index'</script>";
		}
		
		$blog = new BlogModel(); //博客  
		//分类
		$blogtype = new BlogTypeModel(); //博文类型
		$data =  $blogtype->getAll();//分类



		// 统计有多少页 start
		$pageAmount = 6; //每页6条数据
		//开始截取的数据
		$dataStart = ($page - 1) * $pageAmount;

		$pagedata = $blog->getBlogType($type);//所有数据

		$pageCount = count($pagedata);//数据总数
		$pageTotal = ceil($pageCount / $pageAmount);//一共多少页
		// 统计有多少页 end

		if (isset($page) && $page === 0 || $page < 1 || $page > $pageTotal) {
				$page = 1;
		}
		if (isset($type) && $type === 0 || $type < 1 ) {
				$type = 1;
		}
		

		//分页
		$page = [
			'dataCount'=>$pageCount,//一共多少条数据
			'pageAmount'=>$pageAmount,//每页几条
			'pageTotal'=>$pageTotal,//一共多少页
			'page'=>$page,//初始页码
			'type'=>$type,//当前类型
		];
		$blogData = array_slice($pagedata,$dataStart,$pageAmount);//倒叙截取6条数据

		return $this->fetch('index/blogtype',['data'=>$data,'blogData'=>$blogData,'page'=>$page]);
	}

}