<?php 
	
	Class LoginAction extends Action{

	 // 登陆首页
	  public function index(){
	  	//echo md5('admin');
	  	$this->display();
	 }

	 // 登陆表单验证
	 public function login(){
	 	if(!IS_POST) halt('无此页面');
	 	// 验证码校验
	 	if (session('verify') != I('verify','','md5')) {
	 		$this->error('验证码错误');
	 	}

	 	$username = I('username');
	 	$password = I('password','','md5');

	 	$user = M('List');
	 	$data = array(
	 		'name'=> $username,
	 		'password' => $password,
	 		);
	 	dump($data);
	 	$num = $user->where($data)->count();
	 	dump($user->where($data)->select());
	 	if ($num > 0) {
	 		$data2 = array(
	 			'logintime' => time(),
	 			'loginip' => get_client_ip(),
	 			);
	 		$re = $user->where($data)->data($data2)->save();
	 		// dump($re);
	 		session('username',$username);
	 		session('logintime',$data2['logintime']);
	 		session('loginip',$data2['loginip']);
	 		$this->redirect(GROUP_NAME.'/Index/index');
	 	}else{
	 		$this->show('用户名或密码错误!');
	 	}
	 }

	 // 登出
	 public function logout(){
	 	session_unset();
	 	session_destroy();
	 	$this->redirect(GROUP_NAME.'/Index/index');
	 }
	 function add_user()
	 {
	 	$user = M('List');
	 	$data = array(
	 		'name' => 'admin',
	 		'password' => md5('admin'),
	 		'logintime'=> time(),
	 		'loginip'  => get_client_ip(),
	 		);
	 	echo $user->add($data);
	 }
	 // 生成验证码
	 public function verify(){
	 	import('ORG.Util.Image');
	 	Image::buildImageVerify(1);
	 }


}

 ?>