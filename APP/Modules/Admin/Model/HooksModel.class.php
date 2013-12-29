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
 * @date    2013-08-14 11:31:21
 */

class HooksModel extends Model {

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
    protected $_validate = array(
        array('name','require','钩子名称必须！'), //默认情况下用正则进行验证
        array('description','require','钩子描述必须！'), //默认情况下用正则进行验证
    );

    /**
     * 文件模型自动完成
     * @var array
     */
    protected $_auto = array(
        array('update_time', NOW_TIME, self::MODEL_BOTH),
        );

    /**
     * 更新插件里的所有钩子对应的插件
     */
    public function updateHooks($plugin_name){
        $plugin_class = get_plugin_class( $plugin_name, false );
        if( !$plugin_class ) {
            $this->error = "未实现{$plugin_name}插件的入口文件";
                return false;
        }
        $methods = get_class_methods($plugin_class);
        $hooks = $this->getField('name', true);
        $common = array_intersect($hooks, $methods);
        if(!empty($common)){
            foreach ($common as $hook) {
                $flag = $this->updateAddons($hook, array($plugin_name));
                if(false === $flag){
                    $this->removeHooks($plugin_name);
                    return false;
                }
            }
        } else {
            $this->error = '插件未实现任何钩子';
            return false;
        }
        return true;
    }

    /**
     * 更新单个钩子处的插件
     */
    public function updateAddons($hook_name, $plugin_name){
        $o_plugins = $this->where("name='{$hook_name}'")->getField('plugins');
        if($o_plugins)
            $o_plugins = explode(',', $o_plugins);
        if($o_addons){
            $plugins = array_merge($o_plugins, $plugin_name);
            $plugins = array_unique($plugins);
        }else{
            $plugins = $plugin_name;
        }
        $plugins = implode(',', $plugins);
        $flag = $this->where("name='{$hook_name}'")
        ->setField('plugins',$plugins);
        if(false === $flag) {
            $o_plugins = implode(',', $o_plugins);
            $this->where("name='{$hook_name}'")->setField('plugins', $o_plugins);
        }
        return $flag;
    }

    /**
     * 去除插件所有钩子里对应的插件数据
     */
    public function removeHooks($plugin_name){
        // $addons_class = get_addon_class($addons_name);
        // if(!class_exists($addons_class)){
        //     return false;
        // }
        $plugin_class = get_plugin_class($plugin_name, false);
        if( !$plugin_class )
            return false;
        $methods = get_class_methods($plugin_class);
        $hooks = $this->getField('name', true);
        $common = array_intersect($hooks, $methods);
        if($common){
            foreach ($common as $hook) {
                $flag = $this->removePlugin($hook, array($plugin_name));
                if(false === $flag){
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * 去除单个钩子里对应的插件数据
     */
    public function removePlugin($hook_name, $plugin_name){
        $o_plugins = $this->where("name='{$hook_name}'")->getField('plugins');
        $o_plugins = explode(',', $o_plugins);
        if($o_plugins){
            $plugin = array_diff($o_plugins, $plugin_name);
        }else{
            return true;
        }
        $plugin = implode(',', $plugin);
        $flag = $this->where("name='{$hook_name}'")
                          ->setField('plugins',$plugin);
        if(false === $flag) {
            $o_plugins = implode(',', $o_plugins);
            $this->where("name='{$hook_name}'")
                      ->setField('plugins',$o_plugins);
        }
        return $flag;
    }
}
