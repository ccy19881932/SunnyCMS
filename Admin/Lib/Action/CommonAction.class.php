<?php 
	class CommonAction extends BasecontrolAction{
		public function header () {
	    	if( $username = $this->isAdmin() ) {
	    		$this->assign('name',$username);
	    		return $this->fetch('Common:header');
	    	} else {
	    		$this->redirect('Index/hp_admin');
	    	}
		}

		public function footer () {
			return $this->fetch('Common:footer');
		}
	}
 ?>