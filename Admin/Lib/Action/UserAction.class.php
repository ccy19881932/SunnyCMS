<?php 
	class UserAction extends BasecontrolAction {
		public $m_section_name;

		public function __construct() {
			parent::__construct();
			$this->m_section_name = '所有用户';
		}

		public function index () {
			$tpl_showAllUser = $this->showAllUser();
			$tpl_showUser = $this->showUser();
			$this->assign('tpl_showAllUser', $tpl_showAllUser);
			$this->assign('tpl_showUser', $tpl_showUser);
			$this->output('User:index',true);
		}

		public function showAllUser () {
			if( $this->checkAdmin() ) {
				$m_conn = D('UserView');
				
				if( $this->isAjax() ) {		
					$avg = $this->_post('avg','',false);
					$result = $m_conn->listAll($avg);
					$this->assign('result', $result);
					$allusers = $this->fetch('User/showAllUser');
					//$json_result = json_encode($result);
					$this->ajaxReturn($allusers, $this->m_section_name, 1);
				} else {
					$result = $m_conn->listAll('u_id');
					$this->assign('result', $result);
					return $this->fetch('User:showAllUser');
				}
			}
		}

		public function showUser () {
			if( $this->checkAdmin() ) {
				$m_conn = D('UserView');	
				if( $this->isAjax() ) {		
					$avg = $this->_post('avg','',false);
					$result = $m_conn->listSingle('List', $avg);
					$this->assign('result', $result);
					$allusers = $this->fetch('User:showUser');
					//$json_result = json_encode($result);
					$this->ajaxReturn($allusers, $this->m_section_name, 1);
				} else {
					$result = $m_conn->listSingle('List');
					$this->assign('result', $result);
					return $this->fetch('User:showUser');
				}
			}
		}

		public function testReletion () {
			// import("ORG.Util.Auth");
			// $auth=new Auth();  
			// $re = $auth->check('post_manger','1');

			$m_conn = D('UserCUD');	
			//var_dump($m_conn->listSingle('List'));
			$re = $m_conn->setTable('List')->addContactUser(3,3);
			// $m_conn->setTable('Auth_group')->addContactUser(3,5,1);
			// $m_conn->setTable('Auth_group')->addContactUser(17,5,1);
			//$re = $m_conn->setTable('Auth_rule')->delUser(14);
			var_dump($re);


			// $data['name'] = 'hello';
			// $data['title'] = '123';
			// $data['condition'] = '123';

			//$data['__hash__'] = 'e799ce66000b324aeb843b1be6209db4_4adfe63b7a6a2b6927b942d243262595';
			//$re = $m_conn->setTable('auth_rule')->insert($data);
			//$conn_2 = M('auth_group_access');
			//var_dump($conn_2->where("uid=4")->find());

			//$re = $m_conn->setTable('Auth_rule')->delUser(12);
			//var_dump($re);
			

			//$data['name'] = "chenchaoyi123";
			// $data['Auth_group_access'] = array(
			// 		'uid'		=> 100,
			// 		'group_id'	=> 100,
			// 	);
			//$sql = "UPDATE think_auth_group_access SET `group_id` = '%d' WHERE ( `uid`='%d' )";
			//$result = $m_conn->execute($sql, array(100,10));
			//$sql = "SHOW FIELDS FROM  `think_list`";
			//$data['title'] = 'dsfds';
			// $data['status'] = '1';
			// $data['rules'] = 'hahah';
			// //$data['id'] = 567;
			
			// $re = $m_conn->setOption('Auth_group', $data)->insert();
			//  dump($re);
			//$result = $m_conn->query($sql);
			//$result = $m_conn->relation("g_access")->where('id=1')->save($data);
			//$result = $m_conn->relation(true)->select();
			//$sql = "INSERT INTO {$m_conn->getTableName()}(`name`, `password`, `sex`, `local`, `age`) VALUES('%s', '%d', '%d', '%s', '%d')";
			//var_dump($m_conn->execute($sql, array('xinglaide', '123', '1', 'jiujiang', '20')));
			echo "<pre>";
			//print_r($m_conn);
			echo "</pre>";
			$this->display();
		}


	}
 ?>