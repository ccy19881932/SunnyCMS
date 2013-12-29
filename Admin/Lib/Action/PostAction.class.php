<?php 
	class PostAction extends BasecontrolAction {
		/*
		*	文章管理-大分类 
		*	这里 fetch 方法不能得到渲染后的模板 因此用函数返回值
		*/
		public function index () {
			$allPost = $this->allPost('index');
			$this->assign('allPost', $allPost);
			$this->output('Post:index',true);
			// echo "<br><br><br><br><br><br><br><br><br><br><br><br>";
			// var_dump($this->_post('post_content','strip_tags',false)); 
		}
		/*
		*	最新文章-小分类
		*/
		public function newPost () {	
			if( $this->checkAdmin() && $this->isAjax() ) {
				$data['info'] = '新建文章';
				$data['status'] = 1;
				$data['data'] = $this->fetch('Post/newPost');
				$this->ajaxReturn($data,'JSON');
			} //end checkAdmin

			$conn = D('Posts');
			echo "<pre>";
			//print_r( $conn->addPost(1,'这里是第一篇文章','这里是第一篇文章',array(1),1) );
			// $data = array(
			// 		//'post_id'	=> 10,
			// 		'post_title' => '呵呵呵hasaddsah呵dsfa',
			// 		'post_excerpt'=> '这sdfsdfdsdsffsdf里是摘要',
			// 		'post_content'=>'这fsdfsdsds内容hahah',
			// 	);
			//print_r( $conn->addPost(1,'今天写点什么呢','其实编程挺好玩的',array(1,2),1) );
			//var_dump( $conn->updatePost(36,$data,array(2,4,5,6)) );
			$result = $conn->showPost(1,100);
			print_r( $result );
			//var_dump($conn->delPost(24));
			echo "</pre>";
			$this->display();
		}
		/*
		*	所有文章-小分类
		*/
		public function allPost ( ) {		
			if( $this->checkAdmin() ) {
				$contents = '文章内容';
				$this->assign('contents', $contents);

				$conn = D('Posts');
				$result = $conn->showPost(1,100,'uid','desc');
				//$this->assign('result',$result);
				$this->result = $result;

				if( $this->isAjax() ) { 
					$data['info'] = '所有文章';
					$data['status'] = 1;
					$data['data'] = $this->fetch('Post/allPost');
					$this->ajaxReturn($data,'JSON');	
				} else {
					return $this->fetch('Post/allPost');
				}
			} //end checkAdmin
		}
		/*
		*	新建文章
		*/
		public function doNewPost () {
			if( $this->checkAdmin() && $this->isAjax() ) { 
				$contents = $this->_post('post_content','',false);
				echo $contents;
			} // end checkAdmin
		}
	} // end class
 ?>