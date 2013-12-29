<?php 
	class PostsModel extends Model{

		protected $_validate = array(
				array('post_content','require','必须填写内容'),
				array('post_title','require','必须填写标题'), 
			);

		/**
		 * [新建一篇文章]
		* @param 	integer 	$user_id		用户ID
		* @param 	string 		$title 			文章标题
		* @param 	string  	$content 		文章内容
		* @param 	array   	$term_id_arr	所属分类
		* @param 	integer 	$status 		文章状态
		* @param 	string  	$excerpt  		SEO 文章摘要
		* @return 	integer 					文章编号ID
		 */
		public function addPost( $user_id, $title, $content, $term_id_arr = array(), $status = 1, $excerpt = '') {
			if( !$excerpt ) {
				//引入string类库
				import("ORG.Util.String");
				//截取100个字符串 这里截取字符串个数可以作为 option -----------------------------
				$excerpt = string::msubstr(strip_tags($content), 0, 100);
			}
			$data = array(
					'uid'          =>	$user_id,
					'post_date'    => 	date('Y-m-d H:i:s'),
					'modify_date'  =>	date('Y-m-d H:i:s'),
					'post_content' => 	$content,
					'post_title'   =>	$title,
					'post_excerpt' => 	$excerpt,
					'post_status'  =>	$status,
				);
			if( !($this->create($data)) ){
				return $this->getError();
			}
			if( $post_id = $this->add($data) ) {	
				$data = array();
				foreach ($term_id_arr as $k => $v) {
					$data[$k]['post_id'] = $post_id;
					$data[$k]['term_id'] = $v;
				}		
				if( !(M('post_relation')->addAll($data)) ) {
					return false;
				}		
			} else {
				return false;
			}
			return true;
		}
		/**
		 * 更新一篇文章
		 * @param  int 		$post_id     	文章ID
		 * @param  array  	$modify_data 	文章所有字段属性
		 * @param  array  	$term_id_arr 	文章所属分类
		 * @return bool              		更新成功或失败
		 */
		public function updatePost ( $post_id, $modify_data = array(), $term_id_arr = array() ) {
			//modify_data还需要进行数据库自动验证---------------------------------------------------
			$data = $modify_data;
			$data['modify_date'] = date('Y-m-d H:i:s');
			if( !isset($data['post_excerpt']) || empty($data['post_excerpt']) ) {
				//引入string类库
				import("ORG.Util.String");
				//截取100个字符串 这里截取字符串个数可以作为 option --------------------------------
				$data['post_excerpt'] = string::msubstr(strip_tags($data['post_content']), 0, 100);
			}
			if( !($this->create($data)) ){
				return $this->getError();
			}
			if( $this->where("post_id={$post_id}")->save($data) ) {		
				M('post_relation')->where("post_id={$post_id}")->delete();
				$data = array();
				foreach ($term_id_arr as $k => $v) {
					$data[$k]['post_id'] = $post_id;
					$data[$k]['term_id'] = $v;
				}
				if( !(M('post_relation')->addAll($data)) ) {
					return false;
				}
			} else {
				return false;
			}
			return true;
		}
		/**
		 * 删除一篇文章
		 * @param  int 		$post_id 	需要删除文章所对应的ID
		 * @return bool          		删除成功或失败
		 */
		public function delPost ( $post_id ) {
			if( $this->where(array('post_id' => $post_id))->delete() ) {
				if( M('post_relation')->where(array('post_id' => $post_id))->delete() === false ) {
					return false;
				}
			}else {
				return false;
			}
			return true;
		}
		/**
		 * 显示所有文章并按要求排序
		 * @param  integer 		$page    	分页的页码
		 * @param  integer 		$length  	分页后每一页显示文章数量
		 * @param  string  		$orderby 	按哪个字段进行排序
		 * @param  string  		$order 		升序还是降序
		 * @param  integer 		$post_id 	显示对应文章ID下的所有内容，默认显示所有文章
		 * @return array     	      		所有结果
		 */
		public function showPost ( $page = 1, $length = 10, $orderby = 'post_id', $order = 'asc', $post_id = -1 ) {
			$prefix = $this->tablePrefix;
			$field = array(
					"{$prefix}posts.post_id",
					"{$prefix}posts.uid",
					"{$prefix}posts.post_date",
					"{$prefix}posts.modify_date",
					"{$prefix}posts.post_title",
					"{$prefix}posts.post_status",
					"{$prefix}list.name" =>'user_name',
					"{$prefix}post_relation.term_id",
					"{$prefix}taxonomy.term_type",
					"{$prefix}terms.name" => 'term_name',
					"{$prefix}terms.slug" => 'term_slug',
				);
			$orderArr = ($orderby == 'post_id') ? array($orderby => $order) : array($orderby => $order, 'post_id');
			$results = $this->page($page, $length)->field($field)->join("{$prefix}post_relation ON {$prefix}post_relation.post_id={$prefix}posts.post_id")->join("{$prefix}taxonomy ON {$prefix}taxonomy.term_id={$prefix}post_relation.term_id")->join("{$prefix}terms ON {$prefix}terms.term_id={$prefix}taxonomy.term_id")->join("{$prefix}list ON {$prefix}list.id={$prefix}posts.uid")->order($orderArr);
			if( $post_id < 0 ) {
				return $this->handleResult( $results->select() );
			} else {
				return $this->handleResult( $results->where("{$prefix}posts.post_id={$post_id}")->select() );
			}
		}
		/**
		 * 处理视图查询的结果集
		 * @param  array 	$data 	视图查询的结果集
		 * @return array       		处理后的结果集
		 */
		private function handleResult ( $data ) {
			$output_arr = array();
			$term_keys = array('term_id', 'parent_term_id', 'term_type', 'count', 'term_name', 'term_slug');
			foreach ($data as $key => $value) {
				$keys_arr = array_keys($value);
				$output_num = count($output_arr);
				foreach ($value as $k => $v) {
					if($key == 0) {
						if(in_array($k, $term_keys)) {
							$output_arr[$key]['group'][0][$k] = $v;
						} else {
							$output_arr[$key][$k] = $v;
						}
						$term_num = -1;
						$last_key = 0;
					} else {
						if( $data[$key]['post_id'] == $data[$key - 1]['post_id'] ) {
							$term_num++;
							if($last_key == $key) {	
								if(in_array($k, $term_keys)) {
									$output_arr[$output_num-1]['group'][$term_num][$k] = $v;
								} else {
									$output_arr[$output_num-1][$k] = $v;
								}
								$term_num--;
							}	
							$last_key = $key;
						} else {
							$term_num = -1;
							if(in_array($k, $term_keys)) {
								$output_arr[$output_num]['group'][0][$k] = $v;
							} else {
								$output_arr[$output_num][$k] = $v;
							}
						}
					}
				} //endforeach
			} //endforeach
			return $output_arr;
		}


	}
 ?>