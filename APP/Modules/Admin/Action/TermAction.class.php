<?php 
	
	Class TermAction extends CommonAction{

		/**
		 * 显示分类列表页
		 * @return [type] [description]
		 */
		public function index(){
			$tree = D('Term')->getTerms(null,true);
			$this->terms = $tree;
			$this->display();
			return $tree;
		}

		/**
		 * 添加分类目录
		 */
		public function addTerm(){
			
			$data['parent'] = I('term_parent',0,'intval');
			$data['name']   = I('term_name');
			if ( empty($data['name']) ) {
				$this->error('名称不能为空！！');
			}
			$data['slug']   = I('term_slug',urlencode($data['name']));
			if ( $this->checkTermExist($data['name'],$data['slug']) ) {
				$this->$this->display();
			}
			if( D('Term')->addTerm($data) ){
				$this->display();
			} else {
				$this->display();
			}
		}

		/**
		 * 删除分类的控制器方法
		 * @return [type] [description]
		 */
		public function delTerm () {
			$term_id = I('pid',null,'intval');
			if (!empty($term_id)) {
				$termModel      = D('Term');
				if($termModel->delTerm($term_id)){
					$this->redirect(GROUP_NAME.'/Term/index');
				}else{
					$this->error('删除失败！');
				}
			}
		}


		/**
		 * 显示分类修改页面
		 * @return [type] [description]
		 */
		public function edit(){
			$terms = D('Term')->geteAll();
			$terms = set_tree($terms);
			if ( !empty($terms) ) {
				$this->terms = $terms;
			} else {
				$this->error('查无此分类');
			}
			$this->display();
		}

		/**
		 * 修改分类
		 * @return [type] [description]
		 */
		public function editTerm() {
			$data['term_id'] = I('term_id', null, 'intval');
			$data['parent'] = I('term_parent', null, 'intval');
			$data['name'] = I('term_name',false);
			if ( empty($data['name']) ) {
				$this->error('名称不能为空！！');
			}
			$data['slug'] = I('term_slug',urlencode($data['name'])); 
			if ( $this->checkTermExist($data['name'],$data['slug']) ) {
				$this->error('分类名或别名已存在！');
			}
			if (!empty($data) && D('Term')->editTerm($data)) {
				$this->redirect(GROUP_NAME.'/Term/index');
			} else {
				$this->error('没有分类ID啊，亲');
			}
		}

		/**
		 * 检测分类是否存在
		 * @param  string $name 分类名称
		 * @param  string $slug 分类别名
		 * @return boolean       是否存在，true存在，false不存在
		 */
		public function checkTermExist($name,$slug){
			return D('Term')->checkExist(1, $name, $slug);
		}
		/*public function listCat(){
			$re = D('Term')->geteAll();
			//$tree = list_to_tree($re,'term_id','parent');
			$tree = set_tree($re,'|——','<label for="%term_id%">%html%<input type="checkbox" id="%term_id%" value="%term_id%" title="%name%"/>','</label>');
			echo '<pre>';
			print_r($tree);
			$this->display();
		}*/

		/** 以下内容为标签 **/

		/**************** 显示标签列表 ***********/ 
		public function tags(){
			$re = D('Term')->getTags();
			$this->tags = $re;
			$this->display();
		}
		/**
		 * 添加标签
		 */
		public function addTag(){
			$data['name']   = I('tag_name');
			if ( empty($data['name']) ) {
				$this->error('名称不能为空！！');
				return false;
			}
			echo $data['slug']   = I('tag_slug',urlencode($data['name']));
			if ( $this->checkTagExist($data['name'],$data['slug'])){
				return false;
			}
			if(D('Term')->addTag($data)){
				return true;
			} else {
				return false;
			}
		}

		/**
		 * 删除标签的控制器
		 * @return [type] [description]
		 */
		public function delTag(){

			$tag_id = I('pid',null,'intval');

			if (!empty($tag_id)) {
				if(D('Term')->delTag($tag_id)){
					$this->redirect(GROUP_NAME.'/Term/tags');
				} else {
					$this->error('删除失败！');
				}
			} else {
				$this->error('标签id不符');
			}
		}

		/**
		 * 显示标签修改页面
		 * @return [type] [description]
		 */
		public function editTagPage(){
			$this->display();
		}
		
		/**
		 * 编辑标签
		 * @return [type] [description]
		 */
		public function editTag(){
			$data['term_id'] = I('tag_id',null, 'intval');
			$data['name']    = I('tag_name');
			if ( empty($data['name']) ) {
				$this->error('名称不能为空！！');
			}
			$data['slug']    = I('tag_slug',urlencode($data['name']));
			if ( $this->checkTagExist($data['name'],$data['slug']) ){
				$this->error('标签名或别名已存在');
			}
			if (!empty($data) && D('Term')->editTag($data)) {
				$this->redirect(GROUP_NAME.'/Term/tags');
			} else {
				$this->error('修改失败');
			}
		}

		/**
		 * 检测标签名或别名是否存在
		 * @param  string $name 标签名
		 * @param  string $slug 标签别名
		 * @return boolean       是否存在 true存在，false不存在
		 */
		public function checkTagExist($name,$slug){
			return D('Term')->checkExist(0, $name, $slug);
		}
	}
 ?>