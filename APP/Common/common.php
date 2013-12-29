<?php 

function p($arr){
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}

/**
 * 把返回的数据集转换成Tree
 * @access public
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 */
function list_to_tree($list, $pk='id',$pid = 'pid',$child = '_child',$root=0) {
    // 创建Tree
    $tree = array();
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            }else{
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}
/**
 * 将树形数组压缩成平级层，并添加前缀
 * @param  [type]  $tree  [description]
 * @param  string  $html  [description]
 * @param  integer $level [description]
 * @return [type]         [description]
 */
function print_tree($tree,$html="|--",$level=0){
	$arr = array();
	foreach ($tree as $k => $v) {
		$v['html'] = str_repeat($html, $level);
        if (is_array($v['_child'])) {
    		$child = $v['_child'];
    		unset($v['_child']);
    		$arr[] = $v;
    		$arr = array_merge($arr,print_tree($child,$html,$level+1));
        } else {
        	$arr[] = $v;
        }
	}
    return $arr;
}


function set_tree($data,$html='|--',$parent=0,$level=0){
	$arr = array();
	foreach ($data as $key => $value) {
		$value['html'] = str_repeat($html, $level);
		if ($value['parent'] == $parent) {
			$arr[] = $value;
			$arr = array_merge($arr,set_tree($data,$html,$value['term_id'],$level+1));
		}
	}
	return $arr;
}

function Hook ( $hookName, $para = array() ) {
    Hook::listen($hookName, $para);
}

/**
 * select返回的数组进行整数映射转换
 *
 * @param array $map  映射关系二维数组  array(
 *                                          '字段名1'=>array(映射关系数组),
 *                                          '字段名2'=>array(映射关系数组),
 *                                           ......
 *                                       )
 * @author 朱亚杰 <zhuyajie@topthink.net>
 * @return array
 *
 *  array(
 *      array('id'=>1,'title'=>'标题','status'=>'1','status_text'=>'正常')
 *      ....
 *  )
 *
 */
function int_to_string(&$data,$map=array('status'=>array(1=>'正常',-1=>'删除',0=>'禁用',2=>'未审核',3=>'草稿'))) {
    $data = (array)$data;
    foreach ($data as $key => $row){
        foreach ($map as $col=>$pair){
            if(isset($row[$col]) && isset($pair[$row[$col]])){
                $data[$key][$col.'_text'] = $pair[$row[$col]];
            }
        }
    }
    return $data;
}


/**
* 对查询结果集进行排序
* @access public
* @param array $list 查询结果
* @param string $field 排序的字段名
* @param array $sortby 排序类型
* asc正向排序 desc逆向排序 nat自然排序
* @return array
*/
function list_sort_by($list,$field, $sortby='asc') {
   if(is_array($list)){
       $refer = $resultSet = array();
       foreach ($list as $i => $data)
           $refer[$i] = &$data[$field];
       switch ($sortby) {
           case 'asc': // 正向排序
                asort($refer);
                break;
           case 'desc':// 逆向排序
                arsort($refer);
                break;
           case 'nat': // 自然排序
                natcasesort($refer);
                break;
       }
       foreach ( $refer as $key=> $val)
           $resultSet[] = &$list[$key];
       return $resultSet;
   }
   return false;
}

/**
 * 获取插件类的类名
 * @param strng $name 插件名
 */
function get_plugin_class($name, $newOrNot = true){
    // $class = "Addons\\{$name}\\{$name}Addon";
    // return $class;
    $className = "{$name}Plugin";
    import("Plugin.{$name}.{$className}", ROOT_PATH);

    if(!class_exists($className)){ // 实例化插件失败忽略执行
        return false;
    }
    if($newOrNot) {
      return $obj = new $className;
    }
    return $className;
}
/**
 * 生成目录下文件，并写入相关内容
 */
function mkfile ( $file, $contents = '', $append = false ) {
    $filePath = substr($file, 0, -(strlen($file) - strrpos($file, '/')) );
    if(file_exists($filePath))
      return false;
    if( !@mkdir($filePath ,0777, true) ) {
      return false;
    }
    $flag = ($append==false) ? 'LOCK_EX | FILE_APPEND' : 'LOCK_EX';
    if( false === @file_put_contents($file, $contents, $flag) ) {
      return false;
    }
    return true;
}
/**
 * 删除目录
 */
function deldir($dir) {
    $dh=opendir($dir);
    while ($file=readdir($dh)) {
      if($file!="." && $file!="..") {
        $fullpath=$dir."/".$file;
        if(!is_dir($fullpath)) {
            unlink($fullpath);
        } else {
            deldir($fullpath);
        }
      }
    }
    closedir($dh);
    if(rmdir($dir)) {
      return true;
    } else {
      return false;
    }
}
 ?>