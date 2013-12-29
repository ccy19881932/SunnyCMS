<?php 
	
	Class CommonAction extends Action{
		public function _initialize(){
			if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
			$this->redirect(GROUP_NAME.'/Login/index');
			}
		}

		public function Header () {
			$this->display('Common:Header');
		}

		public function Footer () {
			$this->display('Common:Footer');
		}

		public function Alert () {
			$this->display('Common:Alert');
		}

		public function _empty(){
		   $this->redirect( GROUP_NAME.'/Index/index' );
		}
	}
 ?>