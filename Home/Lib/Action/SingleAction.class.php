<?php 
	class SingleAction extends Action{
		public function index() {
			$this->display('Single:index');
			$this->show('这里是SingleAction方法');
			//return;
		}
	}
 ?>