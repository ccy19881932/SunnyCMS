<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: yangweijie <yangweijiester@gmail.com> <code-tech.diandian.com>
// +----------------------------------------------------------------------

// namespace Admin\Model;
// use Think\Model;

/**
 * 插件模型
 * @author yangweijie <yangweijiester@gmail.com>
 */

class PluginModel extends Model {

    /**
     * 查找后置操作
     */
    protected function _after_find(&$result,$options) {

    }

    protected function _after_select(&$result,$options){

        foreach($result as &$record){
            $this->_after_find($record,$options);
        }
    }
    /**
     * 文件模型自动完成
     * @var array
     */
    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),
    );
    /**
     * 自动验证
     * @var array
     */
    protected $_validate = array(
        array('name','require','插件名不能为空'), //默认情况下用正则进行验证
        array('name','','已经有同名插件存在！',Model::EXISTS_VALIDATE ,'unique',Model::MODEL_INSERT),
    );
    /**
     * 获取插件列表
     * @param string $addon_dir
     */
    public function getList($plugin_dir = ''){
        if(!$plugin_dir)
            $plugin_dir = './Plugin/';
        $dirs = array_map('basename',glob($plugin_dir.'*', GLOB_ONLYDIR));
        if($dirs === FALSE || !file_exists($plugin_dir)){
            $this->error = '插件目录不可读或者不存在';
            return FALSE;
        }
		$plugins		=	array();
		$where['name']	=	array('in',$dirs);
		$list			=	$this->where($where)->field(true)->select();
		foreach($list as $plugin){
			$plugin['uninstall']	    =	0;
			$plugins[$plugin['name']]	=	$plugin;
		}
        foreach ($dirs as $value) {
            if(!isset($plugins[$value])){
                $obj = get_plugin_class($value);
                if(empty($obj->info))
                    continue;
				$plugins[$value] = $obj->info;
				if($plugins[$value]){
					$plugins[$value]['uninstall'] = 1;
                    unset($plugins[$value]['status']);
				}
			}
        }
        int_to_string($plugins, array('status'=>array(-1=>'损坏', 0=>'禁用', 1=>'启用', null=>'未安装')));
        $plugins = list_sort_by($plugins,'uninstall','desc');
        return $plugins;
    }

    /**
     * 获取插件的后台列表
     */
    public function getAdminList(){
        $admin = array();
        $db_addons = $this->where("status=1 AND has_adminlist=1")->field('title,name')->select();
        if($db_addons){
            foreach ($db_addons as $value) {
                $admin[] = array('title'=>$value['title'],'url'=>"Addons/adminList?name={$value['name']}");
            }
        }
        return $admin;
    }
}
