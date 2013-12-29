<?php 

// ThinkPHP	Auth辅助类
// 帮助快速完成 Auth 数据库部署和配置，提高开发效率
// 谌超逸 <ccy19881932@126.com>
// 220sushe.com
// 2013.12.13

 class UserViewModel extends ViewModel{

	private $m_allUser = array();
	/*
	*	用户表中 u_id 别名一定要设置，其余字段可以不用设置
	*/
	protected $viewFields = array (
		'list'              => array('id'=>'u_id', 'name'=>'u_name', 'sex'=>'u_sex', 'local'=>'u_local', 'age'=>'u_age'),
		'auth_group_access' => array('group_id'=>'g_id', '_on' => 'list.id = auth_group_access.uid', '_type' => 'LEFT'),
		'auth_group'        => array('title'=>'g_title', 'status'=>'g_status', 'rules'=>'r_id', '_on'=>'auth_group_access.group_id = auth_group.id','_type' => 'LEFT'),
		'auth_rule'         => array('name'=>'r_name', 'title' => 'r_function', 'status' => 'r_status', 'condition' => 'r_condition', '_on' => 'auth_rule.id = auth_group.rules', '_type' => 'LEFT'),
	);
  	/*
 	*	重新编排用户信息
 	*	参数：1.所需编排的字段，即主要字段 (string)
 	*		  2.排序顺序 asc/desc (string)
 	*	返回：重新编排后所有用户信息 (array)
 	*/
 	public function listAll ( $field = 'uid', $type = 'asc' ) {
 		$mainkey = $this->keyRoute($field);
 		if(empty($mainkey)) {
 			return false;
 		}
 		if( $mainkey != 'u_id' && $mainkey != 'g_id' && $mainkey != 'r_id' ) {
 			return $this->order("{$mainkey} {$type}")->select();
 		}
 		$this->m_allUser =  $this->order("{$field} {$type}")->select();
 		if( !isset($this->m_allUser) ) {
 			return false;
 		}
 		$results = $this->m_allUser;
 		$otherkey = $this->handleKeys($mainkey);
 		$final_results = array();
		foreach($results as $key => $value) {
			if( $key == 0 ) {
				$final_results[$key] = $value;
				continue;
			}		
			if( $results[$key][$mainkey] == $results[$key - 1][$mainkey] ) {
				$num = count($final_results);
				//按用户ID进行编排
				if( isset($otherkey['u']) && ($results[$key]['u_id'] != $results[$key - 1]['u_id']) ) {
					foreach ($otherkey['u'] as $g_key => $u_value) {
						$final_results[$num - 1][$u_value] .= ','.$results[$key][$u_value];
					}
				}	
				//按用户组ID进行编排
				if( isset($otherkey['g']) && ($results[$key]['g_id'] != $results[$key - 1]['g_id']) ) {
					foreach ($otherkey['g'] as $g_key => $g_value) {
						$final_results[$num - 1][$g_value] .= ','.$results[$key][$g_value];
					}
				}
				//按权限ID进行编排
				if( isset($otherkey['r']) && ($results[$key]['r_id'] != $results[$key - 1]['r_id']) ) {
					foreach ($otherkey['r'] as $r_key => $r_value) {
						$final_results[$num - 1][$r_value] .= ','.$results[$key][$r_value];
					}
				}	
			} else {
				array_push($final_results, $value);
			}
		}
		return $final_results;
 	}
  	/*
 	*	取出 除主要字段外 的 所有非主要字段
 	*	作用：如 u_id 为主要字段， 则取出 g_开头的所有字段以及 r_开头的所有字段
 	*	参数：主要字段 (string)
 	*	返回：过滤后的非主要字段 (string)
 	*/
 	private function handleKeys( $mainkey ) {
 		$allUser = $this->m_allUser;
 		$allkeys = array_keys($allUser[0]);
 		$otherkey = array();
 		switch ($mainkey) {
 			case 'u_id':
 				foreach ($allkeys as $key => $value) {
 					if( substr($value , 0 , 2) == 'g_' ) {
 						$otherkey['g'][] = $value;
 					}
 					if( substr($value , 0 , 2) == 'r_' ) {
 						$otherkey['r'][] = $value;
 					}
 				}
 				break;
 			case 'g_id':
 				foreach ($allkeys as $key => $value) {
 					if( substr($value , 0 , 2) == 'u_' ) {
 						$otherkey['u'][] = $value;
 					}
 					if( substr($value , 0 , 2) == 'r_' ) {
 						$otherkey['r'][] = $value;
 					}
 				}
 				break;
 			case 'r_id':
 				foreach ($allkeys as $key => $value) {
 					if( substr($value , 0 , 2) == 'g_' ) {
 						$otherkey['g'][] = $value;
 					}
 					if( substr($value , 0 , 2) == 'u_' ) {
 						$otherkey['u'][] = $value;
 					}
 				}
 				break;
 			default:
 				break;
 		}
 		return $otherkey;
 	}
 	/*
 	*	字段路由
 	*	作用：将 g_id（分组ID），r_id(权限ID)，u_id（用户ID）进行重新编排，取出主要字段
 	*	参数：所需编排的字段名 (string)
 	*	返回：经过路由后的主要字段 (string)
 	*/
 	private function keyRoute ( $field ) {
 		$head = substr($field , 0 , 2);
 		switch ($head) {
 			case 'g_':
 				if ($field == 'g_status') {
 					$mainkey = $field;
 				} else {
 					$mainkey = 'g_id';
 				}			
 				break;
 			case 'r_':
 				if ($field == 'r_status') {
 					$mainkey = $field;
 				} else {
 					$mainkey = 'r_id';
 				}	
 				break;
 			case 'u_':
 				if($field == 'u_id' || $field == 'u_name' ) {
 					$mainkey = 'u_id';
 				} else {
 					$mainkey = $field;
 				}
 				break;
 			default:
 				$mainkey = '';
 				break;
 		}
		return $mainkey;
 	}	

 	public function listSingle ( $table = 'List', $field = 'id', $type = 'asc' ) {
 		if(!empty($table)) {
 		 	$table = C('DB_PREFIX').strtolower($table);
 		 	return M()->Table($table)->order("{$field} {$type}")->select();
 		}else {
 			return false;
 		}
 	}

 }
 ?>