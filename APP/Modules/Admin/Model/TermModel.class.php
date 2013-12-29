<?php 
	
	/**
	* 分类及标签的模型
	*/
	Class TermModel extends Model
	{

		private $m_termTable;
		private $m_taxTable ;
		private $m_relationTable;


		/**
		 * 构造函数，初始化term,taxonomy,post_term_relation表
		 */
		public function __construct () {
			parent::__construct();
			$this->m_termTable = M('Term');
			$this->m_taxTable =  M('Taxonomy');
			$this->m_relationTable = M('Post_relation');
		}
		
		/**
		 * 获取分类目录模型方法
		 * @param  array   $index  索引数组
		 * @param  boolean $merge  是否压缩层级
		 * @return array          数据集
		 */
		public function getTerms($index = array(), $merge = true, $html = '|——'){
			if( is_array($index) && !empty($index)){
				$re = $this->getAll(1,$index);
			} else {
				$re = $this->getAll(1);
			}
			if ($merge) {
				//$html = !empty($html) ? $html : '|——';
				$re = set_tree($re,$html);
			}
			return $re;
		}

		/**
		 * 添加分类的模型方法
		 * @param array $data 要添加的数据，包括键值parent, name, slug
		 */
		public function addTerm($data){
			extract($data);
			//dump($parent);
			if($term_id = $this->m_termTable->data(array('name'=>$name,'slug'=>$slug))->add()){
				if($tax_id = $this->m_taxTable->data(array('term_id'=>$term_id,'parent'=>$parent))->add()){
					return true;
				}
			}
			return false;

		}

		/**
		 * 删除分类模型方法
		 * @param  int $term_id 分类ID
		 * @return boolean      删除是否成功
		 */
		public function delTerm ($term_id) {
			// 删除term表中数据
			if (false !== $this->m_termTable->where('term_id='.$term_id)->delete()) {
				// 获取当前分类父类
				$parent = $this->m_taxTable->where('term_id='.$term_id)->getField('parent');
				// 获取当前分类子分类
				$child = $this->m_taxTable->where('parent='.$term_id)->field('term_id')->select();
				// 修改当前分类子分类的父类
				foreach ($child as $key => $value) {
					// dump($value['term_id']);
					// dump(array('parent'=>$parent));
					$this->m_taxTable->where('term_id='.$value['term_id'])->data(array('parent'=>$parent))->save();
				}
				// 删除taxonomy分类表
				if(false !== $this->m_taxTable->where('term_id='.$term_id)->delete()){
					// 删除文章分类关系表
					if (false !== $this->m_relationTable->where('term_id='.$term_id)->delete()) {
						return true;
					}
				} 
			} 
			return false;
			
		}

		/**
		 * 修改分类
		 * @param  array $data [description]
		 * @return boolean       [description]
		 */	
		public function editTerm ($data) {
			extract($data);
			// $name  $slug  $parent $term_id
			// 处理父分类
			// $parent_old =  $this->m_taxTable->where('term_id='.$term_id)->getField('parent');
			// if(intval($parent) != $parent_old){
			// 	$child = $this->m_taxTable->where('parent='.$term_id)->field('term_id')->select();
			// 	// 修改当前分类子分类的父类
			// 	foreach ($child as $key => $value) {
			// 		// dump($value['term_id']);
			// 		// dump(array('parent'=>$parent));
			// 		$this->m_taxTable->where('term_id='.$value['term_id'])->data(array('parent'=>$parent))->save();
			// 	}
			// }
			
			if(false !== $this->m_taxTable->where('term_id='.$term_id)->data(array('parent'=>$parent))->save()){
				//保存数据至term表
				//dump($this->m_termTable->where('term_id='.$term_id)->data(array('name'=>$name,'slug'=>$slug))->save());
				if(false !== $this->m_termTable->where('term_id='.$term_id)->data(array('name'=>$name,'slug'=>$slug))->save()){
					return true;
				}
			}
			return false;
		}
		/********************以下内容为标签管理内容*****************/

		/**
		 * 获取标签集
		 * @param  array  $index 需要获取的标签id
		 * @return array        返回的标签集
		 */
		public function getTags($index = array()){
			if( is_array($index) && !empty($index)){
				$re = $this->getAll(0,$index);
			} else {
				$re = $this->getAll(0);
			}
			return $re;
		}

		/**
		 * 添加标签模型方法
		 * @param array $data 要添加的数据
		 */	
		public function addTag($data){
			extract($data);
			if($tag_id = $this->m_termTable->data(array('name'=>$name,'slug'=>$slug))->add()){
				if($tag_id = $this->m_taxTable->data(array('term_id'=>$tag_id,'term_type'=>0))->add()){
					return true;
				}
			}
			return false;
		}

		/**
		 * 删除标签模型方法
		 * @param  [type] $tag_id [description]
		 * @return boolean         [description]
		 */
		public function delTag($tag_id){
			if (false !== $this->m_termTable->where('term_id='.$tag_id)->delete()) {
				if (false !== $this->m_taxTable->where('term_id='.$tag_id)->delete()) {
					if (false !== $this->m_relationTable->where('term_id='.$tag_id)->delete()) {
						return true;
					}
					return true;
				}
			}
			return false;
		}

		/**
		 * 编辑标签
		 * @param  array $data 标签数据
		 * @return boolean       修改成功与否
		 */
		public function editTag($data){

			extract($data);  // term_id, name ,slug
			if ($this->m_termTable->where('term_id='.$term_id)->data(array('name'=>$name,'slug'=>$slug))->save()) {
				return true;
			}
			return false;
		}
	
	/************************** PUBLIC FUNCTIONS ********************************/


		/**
		 * 获取所有的分类或标签，默认获取分类，获取标签时可以指定标签的id
		 * @param  integer $term_type 获取的是分类还是标签，分类为1，标签为0
		 * @param  array   $index     标签的id集合
		 * @return array             返回的数据集
		 */
		private function getAll($term_type = 1, $index = array()){
			$db_prefix = $this->tablePrefix;
			$table = $db_prefix.'term';
			$fields = array(
					$db_prefix.'term.term_id',
					$db_prefix.'term.name',
					$db_prefix.'term.slug',
					$db_prefix.'taxonomy.parent',
					//$db_prefix.'post_relation.post_id'
				);
			$join = array(
				$db_prefix.'taxonomy ON '.$db_prefix.'term.term_id='.$db_prefix.'taxonomy.term_id',
				//$db_prefix.'post_relation ON '.$db_prefix.'term.term_id='.$db_prefix.'post_relation.term_id',
				);
			$where = array(
				$db_prefix.'taxonomy.term_type'=>$term_type,
				);
			if (is_array($index) && !empty($index)) {
				$index[] = 'OR';
				$where[$db_prefix.'term.term_id'] = $index;
			}

			$re = M('Term')->table($table)->field($fields)->where($where)->join($join)->select();
			return $re;
		}


		/**
		 * 检测分类目录或标签是否存在
		 * @param  [type] $type [description]
		 * @param  [type] $name [description]
		 * @param  [type] $slug [description]
		 * @return [type]       [description]
		 */
		public function checkExist($type , $name ,$slug){
			$where = array(
				'name' => $name,
				'slug' => $slug,
				'_logic' =>'OR',
				);
			if($term_id = $this->m_termTable->where($where)->field('term_id')->select()){
				foreach ($term_id as $value) {
					if( $this->m_taxTable->where(array('term_id'=>$value['term_id'],'term_type'=>$type))->find()){
					return true;
					}
				}
			}
			return false;
		}
	}
 ?>