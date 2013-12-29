<?php 

	Class CategoryWidget extends Widget{


		public function render ( $data ) {
			$data['trees'] = D('Term')->getTerms( null, true, '&nbsp;&nbsp;&nbsp;&nbsp;');
			if ( !isset($data['index']) || !is_array($data['index'])) {
				$data['index'] = array();
			}
			if (!isset($data['return_name']) || empty($data['return_name']) ) {
				$data['return_name'] = 'category';
			}
			return $this->renderFile('',$data);
		}
	}


 ?>