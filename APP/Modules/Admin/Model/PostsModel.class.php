<?php 
	class PostsModel extends Model{

		protected $_validate = array(
				array('post_content','require','必须填写内容'),
				array('post_title','require','必须填写标题'), 
			);

		public $postDateOrder = array();

		public $statusNum = array('-1'=>0,'0'=>0,'1'=>0,'2'=>0);
		/**
		 * [新建一篇文章]
		* @param 	integer 	$user_id		用户ID
		* @param 	string 		$title 			文章标题
		* @param 	string  	$content 		文章内容
		* @param 	array   	$term_id_arr	所属分类
		* @param 	integer 	$status 		文章状态
		* @param 	string  	$excerpt  		SEO 文章摘要
		* @return 	integer 					文章编号ID(成功) 或-1(失败)
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
				return -1;
			}
			if( $post_id = $this->add($data) ) {	
				$data = array();
				foreach ($term_id_arr as $k => $v) {
					$data[$k]['post_id'] = $post_id;
					$data[$k]['term_id'] = $v;
				}		
				if( !(M('post_relation')->addAll($data)) ) {
					return -1;
				}		
			} else {
				return -1;
			}
			return $post_id;
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
				return false;
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
		 * @param  integer  	$group 		-1：全部; 0：已发布; 1：私密; 2：回收站
		 * @param  integer 		$post_id 	显示对应文章ID下的所有内容，默认显示所有文章
		 * @return array     	      		所有结果
		 */
		public function showPost ( $page = 1, $length = 10, $orderby = 'post_id', $order = 'asc', $group = -1, $post_id = -1, $term_id = -1, $dateStr = '' ) {
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
					"{$prefix}term.name" => 'term_name',
					"{$prefix}term.slug" => 'term_slug',
				);
			$orderArr = ($orderby == 'post_id') ? array($orderby => $order) : array($orderby => $order, 'post_id');
			$results = $this->page($page, $length)->field($field)->join("{$prefix}post_relation ON {$prefix}post_relation.post_id={$prefix}posts.post_id")->join("{$prefix}taxonomy ON {$prefix}taxonomy.term_id={$prefix}post_relation.term_id")->join("{$prefix}term ON {$prefix}term.term_id={$prefix}taxonomy.term_id")->join("{$prefix}list ON {$prefix}list.id={$prefix}posts.uid")->order($orderArr);
			if( $term_id >= 0 || !empty($dateStr) ) {
				//这里是通过搜索按钮搜索的结果 传入 term_id 和 datestr 参数
				$whereSql = '';
				if( $term_id >= 0 ) {
					$whereSql .= "{$prefix}post_relation.term_id={$term_id} AND ";
				}
				if( !empty($dateStr) && $dateStr != -1 ) {
					$whereSql .= "{$prefix}posts.modify_date like '{$dateStr}%' AND ";
				}
				if( $group > 0 ) {
					$whereSql .= "{$prefix}posts.post_status={$group}";
				}
				$whereSql = trim($whereSql, 'AND ');
				return $this->handleResult( $results->where($whereSql)->select() );
			} else {
				if( $group < 0 ) {
					//取出全部文章
					if( $post_id < 0 ) {
						return $this->handleResult( $results->select() );
					} else{
						return $this->handleResult( $results->where("{$prefix}posts.post_id={$post_id}")->select() );
					}	
				} else {
					if( $post_id < 0 ) {
						return $this->handleResult( $results->where("{$prefix}posts.post_status={$group}")->select() );
					} else{
						return $this->handleResult( $results->where("{$prefix}posts.post_id={$post_id} AND {$prefix}posts.post_status={$group}")->select() );
					}	
				}
			}
		}
		/**
		 * 处理视图查询的结果集
		 * @param  array 	$data 	视图查询的结果集
		 * @return array       		处理后的结果集
		 */
		private function handleResult ( $data ) {
			if(empty($data)) {
				return ;
			}
			$output_arr = array();
			$term_keys = array('term_id', 'parent', 'term_type', 'count', 'term_name', 'term_slug');
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
		/**
		 * 批量设置文章状态
		 * @param 	array 		$postIdArr 	所需更改状态的文章ID
		 * @param 	int 		$status    	需要更改到什么状态 0：设置为正常 1：设置为私密 2：移至回收站
		 * @return 	bool 					更改成功或失败
		 */
		public function setPostStatus ( $postIdArr, $status ) {
			$condition = array();
			$data['post_status'] = $status;
			foreach ($postIdArr as $key => $value) {
				$postIdArr[$key] = 'post_id='.$value;
			}
			$condition['_string'] = implode(' OR ', $postIdArr);
			$condition['_logic'] = 'OR';
			if( $this->where($condition)->save($data) === false ) {
				return false;
			}
			return true;
		}
		/**
		 * 提取 不同时间 和 不同文章状态 对应的文章数量
		 */
		public function getPostInfo () {
			$result = $this->field('post_id,modify_date,post_status')->order('post_id')->select();
			foreach ($result as $key => $value) {
				//提取时间对应的文章数
				foreach ($value as $k => $v) {
					if($key == 0) {
						//提取时间对应的文章数
						if($k == 'modify_date') {
							$postDate = getdate(strtotime($v));
							$postDateStr = $postDate['year'].'年'.$postDate['mon'].'月';
							$postDateSearch = $postDate['year'].'-'.$postDate['mon'];
							$this->postDateOrder[0]['datestr'] = $postDateStr;
							$this->postDateOrder[0]['search'] = $postDateSearch;
							$this->postDateOrder[0]['num'] = 1;
						}	
						//提取不同文章状态对应的文章数量		
						if( $k == 'post_status' ) {
							$this->statusNum[$v]++;
							$this->statusNum['-1']++;
						}
					} else {
						//提取时间对应的文章数
						if($k == 'modify_date') {
							$postDate = getdate(strtotime($v));
							$postDateStr = $postDate['year'].'年'.$postDate['mon'].'月';
							$postDateSearch = $postDate['year'].'-'.$postDate['mon'];
							$postDateNum = 0;
							foreach ($this->postDateOrder as $postDateKey => $postDateValue) {
								if($postDateValue['datestr'] == $postDateStr){
									$postDateNum++;
									$this->postDateOrder[$postDateKey]['num']++;
								}
							}
							if($postDateNum == 0) {
								//在 postDateOrder 中不存在这个年份月份对应的时间
								$postDateNum = count($this->postDateOrder);
								$this->postDateOrder[$postDateNum]['datestr'] = $postDateStr;
								$this->postDateOrder[$postDateNum]['search'] = $postDateSearch;
								$this->postDateOrder[$postDateNum]['num'] = 1;
							}
						}
						//提取不同文章状态对应的文章数量		
						if( $k == 'post_status' ) {
							$this->statusNum[$v]++;
							$this->statusNum['-1']++;
						}
					}
				} //endforeach
			} //endforeach
		}


	}
 ?>