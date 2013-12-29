<?php 
	class UserCUDModel extends Model{

		protected $_validate = array();	

		public function setTable( $table ) {
			$this->tableName = $table;
			$table = strtolower($this->tableName);
			switch ($table) {
				case 'auth_group':
					$this->_validate = array(
						array('title', 'require', '用户组名称必须填写'), //用户组名称必须填
						array('title', '', '用户组名称已经存在', Model::MUST_VALIDATE, 'unique'), //用户组名称唯一	
						array('status', array(0,1), '范围不正确', Model::MUST_VALIDATE, 'in'), //在0-1范围内
						);	
					break;
				case 'auth_rule':
					$this->_validate = array(
						array('name', 'require', '权限标识必须填写'), //权限标识必须填写并唯一
						array('name', '', '权限标识已经存在', Model::MUST_VALIDATE, 'unique'), //权限标识唯一
						array('title', 'require', '权限中文名必须填写'),	//权限中文名必须填写
						array('title', '', '权限中文名已经存在', Model::MUST_VALIDATE, 'unique'),	//限中文名唯一
						array('status', array(0,1), '范围不正确', Model::MUST_VALIDATE, 'in'), //在0-1范围内
						);	
					break;
				default:
					break;
			}			
			return $this;
		}

		public function insertUser ( $data ) {
			if( empty($this->tableName) || empty($data) ) {
				return false;
			}
			$conn = M($this->tableName);
			$conn->setProperty("_validate",$this->_validate);
			$table = strtolower($this->tableName);
			switch ($table) {
				//用户表
				case 'list':
					$data['id'] = "";
					if( !($conn->add($data)) ) {
						return false;
					}
					break;
				//用户组表
				case 'auth_group':	
					$data['id'] = "";				
					if(!$data = $conn->create($data)){
						return $conn->getError();
					} else {
						if( !($conn->add()) ) {
							return false;
						}
					}
					break;
				//权限表
				case 'auth_rule':
					$data['id'] = "";
					if(!$data = $conn->create($data)){
						return $conn->getError();
					} else {
						if( !($conn->add()) ) {
							return false;
						}
					}
					break;
				default:
					return false;
					break;
			}
			return true;
		}

		public function delUser ($id) {
			if( empty($this->tableName) ) {
				return false;
			}
			$conn = M($this->tableName);
			$table = strtolower($this->tableName);
			switch ($table) {
				case 'list':
					//用户表，名可改
					$conn->startTrans();
					$result = $conn->where("id={$id}")->delete();			
					if( !empty($result) ) {
						$conn_2 = M('auth_group_access');
						if( $conn_2->where("uid={$id}")->find() ) {
							if($conn_2->where("uid={$id}")->delete()) {
								$conn->commit();				
							} else {
								$conn->rollback();
								return false;
							}
						} else {
							$conn->commit();
						}
					} else {
						return false;
					}	
					break;
				case 'auth_group':
					//用户组表，名不要改
					$conn->startTrans();
					$result = $conn->where("id={$id}")->delete();			
					if( !empty($result) ) {
						$conn_2 = M('auth_group_access');
						if( $conn_2->where("group_id={$id}")->find() ) {
							if($conn_2->where("group_id={$id}")->delete()) {
								$conn->commit();				
							} else {
								$conn->rollback();
								return false;
							}
						} else {
							$conn->commit();
						}
					} else {
						return false;
					}	
					break;
				case 'auth_rule':
					//权限表，名不要改
					$conn->startTrans();
					$result = $conn->where("id={$id}")->delete();
					if( !empty($result) ) {
						$conn_2 = M('auth_group');
						$map['rules'] =array('like',array("%{$id}%","%,{$id}%","%{$id},%"),'OR');
						$commit = true;
						if( $re = $conn_2->field('id,rules')->where($map)->select() ) {
							foreach ($re as $value) {
								$rules_arr = explode(',', $value['rules']);
								foreach ($rules_arr as $k => $v) {
									if( $id == $v ) {
										//删除对应的 用户组权限
										unset($rules_arr[$k]);
										$sava_data = array();
										$sava_data['rules'] = implode(',', $rules_arr);
										if( !($conn_2->where("id={$value['id']}")->save($sava_data)) ) {
											//失败一次即为不成功删除
											$commit = false;
										}
									}
								}	
							}
							if( $commit ) {
								$conn->commit();	
							} else {
								$conn->rollback();
								return false;
							}
						} else {
							$conn->commit();
						}
					} else {
						return false;
					}
					break;
				default:
					break;
			}
			return true;
		}
		/*
		*	增加 用户 用户组 权限 三个模块之间的联系
		*	模块		 可增加功能
		*	用户 		 增加用户组
		*	用户组 		 增加用户， 增加权限
		*	权限 		 无
		*	to_table 0:默认 1:权限表 2:access表
		*/
		public function addContactUser ( $from_id, $to_id, $to_table = 0 ) {
			if( empty($this->tableName) ) {
				return false;
			}
			$table = strtolower($this->tableName);
			switch ($table) {
				case 'list': 
					$conn = M('auth_group_access');	
					$uid = $from_id;
					$group_id = $to_id;
					if( $conn->where("uid={$uid} AND group_id={$group_id}")->find() ) {
						//该用户 已经关联了 该用户组
						return false;
					} else {
						//该用户没有关联该用户组
						//检查是否存在该用户 
						if( !($this->checkAllUserId($conn, $uid)) ){
							return false;
						}
						//检查是否存在该用户组
						if( !($this->checkAllGroupId($conn, $group_id)) ){
							return false;
						}
						$u_data['group_id'] = $group_id;
						$u_data['uid'] = $uid;
						if( !($conn->add($u_data)) ) {
							//插入失败
							return false;
						} 
					}
					break;
				case 'auth_group':
					if( $to_table == 1 ) {
						$conn = M('auth_group');
						$gid = $from_id;
						$rid = $to_id;
						$map['id'] = array('eq',$gid);
						$map['rules'] =array('like',array("%{$rid}%","%,{$rid}%","%{$rid},%"),'OR');				
						$value = $conn->where($map)->getField('rules');
						$rules_arr = explode(',', $value);
						if( in_array($rid, $rules_arr) ) {
							//该用户组 关联了 该权限
							return false;
						} else {
							//该用户组 没有关联 该权限
							//检查是否存在该用户组 
							if( !($this->checkAllGroupId($conn, $gid)) ){
								return false;
							}
							//检查是否存在该权限
							if( !($this->checkAllRuleId($conn, $rid)) ){
								return false;
							}
							$rules = $conn->where("id={$gid}")->getField('rules');
							$g_data['rules'] = trim("{$rules},{$rid}", ',');
							if( !($conn->where("id={$gid}")->save($g_data)) ) {
								return false;
							}
						}					
					} elseif( $to_table == 2 ) {
						$conn = M('auth_group_access');
						$gid = $from_id;
						$uid = $to_id;
						if( $conn->where("group_id={$gid} AND uid={$uid}")->find() ) {
							//该用户组 已经关联了 该用户
							return false;
						} else {
							//该用户组没有关联该用户
							//检查是否存在该用户组
							if( !($this->checkAllGroupId($conn, $gid)) ){
								return false;
							}
							//检查是否存在该用户
							if( !($this->checkAllUserId($conn, $uid)) ){
								return false;
							}
							$g_data['group_id'] = $gid;
							$g_data['uid'] = $uid;
							if( !($conn->add($g_data)) ) {
								return false;
							}
						}
					} else {
						//指向表错误
						return false;
					}
					break;
				case 'auth_rule':
					//暂时不需要关联功能
					return false;
					break;
				default:
					return false;
					break;
			}
			return true;
		}

		public function updateUser ( $data ) {
			if( empty($this->tableName) ) {
				return false;
			}
			$conn = M($this->tableName);
			$conn->setProperty("_validate",$this->_validate);
			$table = strtolower($this->tableName);
			switch ($table) {
				case 'list':
					//暂不能更改用户信息，如要修改可自行在此编写流程
					return false;
					break;
				case 'auth_group':
					//更改用户组信息
					if( !isset($data['title']) || !isset($data['id']) ) {
						return false;
					}
					if( !($conn->create($data)) ) {
						exit($conn->getError());
					} else {
						if( !($conn->where("id={$data['id']}")->save()) ) {
							return false;
						}
					}		
					break;
				case 'auth_rule':
					//更改权限信息
					if( !isset($data['name']) || !isset($data['title']) || !isset($data['id']) ) {
						return false;
					}
					if( !($conn->create($data)) ) {
						exit($conn->getError());
					} else {
						if( !($conn->where("id={$data['id']}")->save()) ) {
							return false;
						}
					}
					break;
				default:
					return false;
					break;
			}
			return true;
		}

		private function checkAllUserId ($conn, $uid) {
			$sql = "select `id` as uid from {$this->tablePrefix}list";
			$allusers = $conn->query($sql);
			$in_or_not = false;
			foreach ($allusers as $value) {
				if($value['uid'] == $uid) {
					$in_or_not = true;
					break;
				}
			}
			return $in_or_not;
		}

		private function checkAllGroupId ($conn, $gid) {
			$sql = "select `id` as gid from {$this->tablePrefix}auth_group";
			$allgroups = $conn->query($sql);
			$in_or_not = false;
			foreach ($allgroups as $value) {
				if($value['gid'] == $gid) {
					$in_or_not = true;
					break;
				}
			}
			return $in_or_not;
		}

		private function checkAllRuleId ($conn, $rid) {
			$sql = "select `id` as rid from {$this->tablePrefix}auth_rule";
			$allrules = $conn->query($sql);
			$in_or_not = false;
			foreach ($allrules as $value) {
				if($value['rid'] == $rid) {
					$in_or_not = true;
					break;
				}
			}
			return $in_or_not;	
		}
	}

 ?>