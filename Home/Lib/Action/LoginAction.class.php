<?php
	class LoginAction extends Action{
		public function index() {
			$this->display('login:index');
		}

		public function dologin() {
			if( isset($_POST['code']) && !empty($_POST['code']) ) {
				if ( $_SESSION['verify'] != md5($_POST['code']) ) {
					$this->error('验证码错误');
				}
			}
			if( (isset($_POST['username']) && !empty($_POST['username'])) && (isset($_POST['password']) && !empty($_POST['password'])) ) 
			{
				$m_conn = M();
				$result = $m_conn->query("select `password` FROM tp_list WHERE `name` = '{$_POST['username']}'");
				if(!$result[0]['password']) {
					$this->error('您还没有注册哦','__APP__/Index/index');
				} else {
					if($_POST['password'] == $result[0]['password']) {
						$this->success('登陆成功~');
					} else {
						$this->error('密码错误');
					}		
				}
			} else {
				$this->error('请输入正确的用户名和密码');
			}
		}

		Public function code(){
		    import('ORG.Util.Image');
		    Image::buildImageVerify();
		}

	}
?>