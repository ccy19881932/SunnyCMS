<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends BasecontrolAction {
	/*
	*	首页展示
	*/
    public function index () {
        // import('ORG.Util.Auth');
        // $auth = new Auth;
        // dump($auth->getGroups(2));
        // $auther = $auth->check('user_manage',2,'or');
        // $this->assign('author',$auther);
    	$this->output('Index:index',true);
    }
    /*
    *	登陆入口
    */
    public function hp_admin () {
		$this->display('Index:hp_admin');
    }

    /*
    *	验证登陆信息
    */
    public function do_login () {
    	$user_name = $this->_post('user_name','strip_tags',false);
    	$pass_word = $this->_post('pass_word','strip_tags',false);
    	// var_dump($user_name);
    	// var_dump($pass_word);
    	if ( !empty($user_name) && !empty($pass_word) ) {
    		$m_conn = M('List');
    		$sql = "SELECT `password` FROM {$m_conn->getTableName()} WHERE `name` = '%s'";
    		$result = $m_conn->query($sql, array($user_name));
    		if($result) {
    			if( $result[0]['password'] == $pass_word ) {
    				session('username',$user_name);  
    				$this->redirect('Index/index');
    			} else {
    				$alert = '密码不对哦';
    				$this->assign('alert',$alert);
    			}
    		} else {
    			$alert = '用户名不正确';
    			$this->assign('alert',$alert);
    		}
    	}
    	$this->display('Index:hp_admin');
    }
    /*
    *	退出操作
    */
    public function logout () {
    	$username = session('username');
    	if( isset($username) ) {
    		session('username', NULL);
    		$this->redirect('Index/hp_admin');
    	}
    }
}