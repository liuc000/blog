<?php 
namespace app\liuc\controller;
use think\Session;
use think\Request;
use think\Controller;
use app\liuc\model\Admin;
/**
* 登录注册页面
*/
class Login extends Controller
{
	public function _empty(){
		return View('404/index');
	}
	public function login(Request $r){
		//登录页面---登录验证
		if($r->isget()){

			return View('login/login');
		}else{
			$user = input('username');
			$pwd = $this->getpwd(input('password'));
			$admin = Admin::where('user',$user)->find();

			if(empty($admin)){
				return [
					'code'=>10,
					'text'=>'账号不存在',
				];
			}else{
				//查询到了账号
				if($admin->pwd == $pwd){
					Session::set('id',$admin->id);
					Session::set('user',$admin->user);
					Session::set('ltime',date("Y-m-d H:i:s",$admin->ltime));
					Session::set('rtime',date("Y-m-d H:i:s",$admin->rtime));
					$admin->ltime = time();
					$admin->save();

					return [
						'code'=>20,
						'text'=>'登录成功'
					];
				}else{
					return [
						'code'=>10,
						'text'=>'密码不正确'
					];

				}

			}
		}

	}

	// 这是后台的
	// 
	public function isPwd(Request $r){
		if ($r->isget()) {
			# code...
			return;
		}
		$user = Admin::where('id',input('id'))->find();
		$pwd = $this->getpwd(input('pwd'));
		if ($user->password != $pwd) {
			return [
				'code'=>10,
				'text'=>'密码错误'
			];
		}else{
			return [
				'code'=>20,
				'text'=>'密码正确'
			];
		}
		
	}
	public function upPwd(){
		//更改密码
		 $admin = new Admin();
		 $data = $admin->where('id',input('id'))->find();
		 $data->password = $this->getpwd(input('pwd'));
		 $save = $data->save();
		 if ($save) {
			session(null);
		 	return [
		 		'code'=>20,
		 		'text'=>'更改密码成功,请重新登录'
		 	];
		 }else{
		 	return [
		 		'code'=>10,
		 		'text'=>'更改密码失败'
		 	];
		 }
		
	}
	public function liu521(){
		echo $this->getpwd('liu521');
	}
	//后台end
	private function getpwd($pwd){
		//给密码加密
		$one = substr(md5($pwd),5,8);
		$two = substr(md5($pwd),2,5);
		return sha1($one.$two);
	}
	public function logout(){
		//退出登录
		session(null);
		return "<script>alert('退出成功');location.href='/liuc/login/login'</script>";
	}
	
}
