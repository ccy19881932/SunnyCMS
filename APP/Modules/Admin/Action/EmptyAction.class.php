<?php 
	Class EmptyAction extends Action{
		public function _initialize() {
			$this->redirect( GROUP_NAME.'/Index/index' );
		}
} ?>