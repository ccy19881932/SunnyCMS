<?php 
	
	Class PostAction extends Action{
	 public function index ( $status = -1 ) {
	 	//Hook('pageHeader',array(1,2,3));
		$conn = D('Posts');
		$nowPage = 1;
		$eachArticls = 30;
		//批量设置文章状态
		if( (isset($_POST['group_choise']) && ($_POST['group-choise-1'] >= 0)) ) {
			$changePostStatus = array();
			for ($i=0; $i < $eachArticls; $i++) {
				if( isset( $_POST['cb-select-'.$i] ) ) {
					$changePostStatus[] = $this->_post('cb-select-'.$i,'',NULL); 
				}
			}
			$conn->setPostStatus($changePostStatus, $_POST['group-choise-1']);
		}
		if( (isset($_POST['group_choise_2']) && ($_POST['group-choise-2'] >= 0)) ) {
			$changePostStatus = array();
			for ($i=0; $i < $eachArticls; $i++) {
				if( isset( $_POST['cb-select-'.$i] ) ) {
					$changePostStatus[] = $this->_post('cb-select-'.$i,'',NULL); 
				}
			}
			$conn->setPostStatus($changePostStatus, $_POST['group-choise-2']);
		}

		if( $status != -1 && $status != 0 && $status != 1 && $status != 2 ) {
			$status = -1;
		}
		if( isset($_POST['filterSubmit']) ) {
			//点击筛选按钮后;
			//这里需要改动-------------------------------------------------------------------------
			$post_term_id = -1;
			$result = $conn->showPost($nowPage, $eachArticls, 'post_id', 'asc', $status, -1, $post_term_id, $this->_post('all-date'));
		} else {
			$result = $conn->showPost($nowPage, $eachArticls, 'post_id', 'asc', $status);		
		}
		// echo "<pre>";
		// print_r($result);
		// echo "</pre>";
		$conn->getPostInfo();

		$this->statusNum = $conn->statusNum;
		$this->status    = $status;
		$this->datePost  = $conn->postDateOrder;
		$this->result    = $result;
	    $this->display();
	 }

	 public function newPost ( $post_id = -1 ) {
	 	//post_id 不为 -1 时，即为更新文章
	 	$this->post_id	 = $post_id;	
		$this->title     = $this->_post('title');
		$this->content   = $this->_post('content');
		$this->postCheck = $this->_post('postCheck');
		$this->excerpt	 = $this->_post('excerpt');		
	 	$this->term_arr  = $this->_post('cat','',array());
		$userID = 1;

	 	$this->success_display = 'none;';
	 	$this->error_display = 'none;';
	 	if ( isset($_POST['submitArticle']) ) {
	 		// if( is_array($_POST['cat']) ){
	 		// 	$ = implode(glue, pieces)
	 		// }
	 		$postsConn = D('Posts');
	 		if ( $this->post_id == -1 ) {
	 			//新增文章
	 			$this->alert = '发布';
	 			$this->articleAction = '发布';	

	 			$this->post_id = $postsConn->addPost($userID, $this->title, $this->content, $this->term_arr, $this->postCheck, $this->excerpt);
	 			//返回-1即为新增失败
		 		if( $this->post_id != -1 ) {
		 			$this->success_display = 'block;';
		 			$this->articleAction = '更新';	
		 		} else {
		 			$this->error_display = 'block;';
		 		}
	 		} else {
	 			//更新文章
				$modify_data['uid']          = $userID;
				$modify_data['post_content'] = $this->content;
				$modify_data['post_title']   = $this->title;
				$modify_data['post_excerpt'] = $this->excerpt;
				$modify_data['post_status']  = $this->postCheck;
				$this->alert = '更新';
				$this->articleAction = '更新';
	 			if( $postsConn->updatePost($post_id, $modify_data, $this->term_arr) ) {
	 				$this->success_display = 'block;';				
	 			} else{
	 				$this->error_display = 'block;';
	 			}
	 		}
	 	} else {
	 		if ( $this->post_id == -1 ) {
		 		$this->articleAction = '发布';
	 		}else {
	 			$this->articleAction = '更新'; 			
	 		}

	 	}
	 	$this->display();
	 }

	 public function Category () {
	 	
	 }

	 public function Tags () {
	 	
	 }
	}
 ?>