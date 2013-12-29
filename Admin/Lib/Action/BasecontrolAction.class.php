<?php 
	class BasecontrolAction extends Action {
		public function __construct() {
			parent::__construct();
		}

		private function get_header () {
			return A('Common')->header();
		}

		private function get_footer () {
			return A('Common')->footer();
		}

		public function output ( $tpl, $need_header_footer = false ) {
			if( $need_header_footer ) {
				$tpl_header = $this->get_header();
				$this->show($tpl_header);

				$this->display($tpl);

				$tpl_footer = $this->get_footer();
				$this->show($tpl_footer);
			} else {
				$this->display($tpl);
			}
		}

		public function isAdmin () {
			if( session('?username') ) {
				return session('username');
			} else {
				return false;
			}
		}

		public function checkAdmin () {
			if( $this->isAdmin() ) {
				return true;
			} else {
				$this->redirect('Index/hp_admin');
			}			
		}
		/*
	    *	空操作
	    */
	    public function _empty () {
	    	if( isset($username) ) {
	    		session('username', NULL);
	    		$this->redirect('Index/hp_admin');
	    	} else {
	    		$this->redirect('Index/index');
	    	}
	    }
	}
 ?>