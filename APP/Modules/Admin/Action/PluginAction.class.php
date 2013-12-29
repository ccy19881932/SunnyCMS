<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: yangweijie <yangweijiester@gmail.com> <code-tech.diandian.com>
// +----------------------------------------------------------------------

// namespace Admin\Controller;

/**
 * 扩展后台管理页面
 * @author yangweijie <yangweijiester@gmail.com>
 */
class PluginAction extends CommonAction {

    static protected $deny  = array('addhook','edithook','delhook','updateHook');

    public function _initialize(){
        $this->assign('_extra_menu',array(
            '已装插件后台'=> D('Plugin')->getAdminList(),
        ));
        parent::_initialize();
    }

    //创建向导首页
    public function create(){
        // if(!is_writable(ONETHINK_ADDON_PATH))
        //     $this->error('您没有创建目录写入权限，无法使用此功能');
        $hooks = M('Hooks')->field('name,description')->select();
        $this->assign('Hooks',$hooks);
        $this->meta_title = '创建向导';
        $this->display('create');
    }

    //预览
    public function preview( $data ){
        $data['pluginOpen'] =   (int)$data['pluginOpen'];
        $extend                 =   array();
        $hook = '';
        foreach ($data['hookname'] as $value) {
            $hook .= <<<str
        //实现的{$value}钩子方法
        public function {$value}(\$param){

        }

str;
        }

        $tpl = <<<str
<?php

import('Class.Plugin', APP_PATH);

/**
 * {$data['pluginName']}插件
 * @author {$data['pluginAuth']}
 */

    class {$data['pluginID']}Plugin extends Plugin{

        public \$info = array(
            'name'=>'{$data['pluginID']}',
            'title'=>'{$data['pluginName']}',
            'description'=>'{$data['pluginDesc']}',
            'status'=>{$data['pluginOpen']},
            'author'=>'{$data['pluginAuth']}',
            'version'=>'{$data['pluginVision']}'
        );

        public function install(){
            return true;
        }

        public function uninstall(){
            return true;
        }

{$hook}
    }
str;
        return $tpl;
    }

    public function checkForm(){
        $data                   =   $_POST;
        $data['info']['name']   =   trim($data['info']['name']);
        if(!$data['info']['name'])
            $this->error('插件标识必须');
        //检测插件名是否合法
        $addons_dir             =   ONETHINK_ADDON_PATH;
        if(file_exists("{$addons_dir}{$data['info']['name']}")){
            $this->error('插件已经存在了');
        }
        $this->success('可以创建');
    }

    public function build(){
        $data             =   $_POST;
        $data['pluginID'] =   trim($data['pluginID']);
        $pluginFile = $this->preview($data);
        if(empty($data['pluginID'])) {
            $this->ajaxHandle(0,'插件唯一标识必须填写');
        }
        $plugin_path = PLUGIN_PATH.$data['pluginID'].'/';
        mkfile($plugin_path.$data['pluginID'].'Plugin.class.php');
        if($data['pluginConfig'] == 1) {
            $configPath    =   $plugin_path.'config.php';
            mkfile($configPath);
        }
        if($data['pluginPublic']){
            mkfile($plugin_path."Action/{$data['pluginID']}Action.class.php");
            mkfile($plugin_path."Model/{$data['pluginID']}Model.class.php");
        }
        //写文件
        file_put_contents($plugin_path.$data['pluginID'].'Plugin.class.php', $pluginFile);
        if($data['pluginPublic']){
            $pluginAction = <<<str
<?php

import('Admin.Action.Plugin', APP_PATH.GROUP_NAME);

class {$data['pluginID']}Action extends PluginAction{

}

str;
            file_put_contents( $plugin_path."Action/{$data['pluginID']}Action.class.php", $pluginAction);
            $pluginModel = <<<str
<?php

/**
 * {$data['pluginID']}模型
 */
class {$data['pluginID']}Model extends Model{

}

str;
            file_put_contents($plugin_path."Model/{$data['pluginID']}Model.class.php", $pluginModel);
        }

        if($data['pluginConfig'] == 1){
            $pluginConfig = <<<str
<?php

    return array(
        'random'=>array(//配置在表单中的键名 ,这个会是config[random]
            'title'=>'是否开启随机:',//表单的文字
            'type'=>'radio',         //表单的类型：text、textarea、checkbox、radio、select等
            'options'=>array(        //select 和radion、checkbox的子选项
                '1'=>'开启',       //值=>文字
                '0'=>'关闭',
            ),
            'value'=>'1',            //表单的默认值
        ),
    );

str;
            file_put_contents($plugin_path.'config.php', $pluginConfig );
        }
        import('Class.pclzip', APP_PATH);
        $zipPath = 'Data/PluginTem/'.$data['pluginID'].'.zip';
        $plugin = new PclZip( $zipPath );
        $v_list = $plugin->create( $plugin_path, PCLZIP_OPT_REMOVE_PATH, $plugin_path, PCLZIP_OPT_ADD_PATH, $data['pluginID'] );
        if ($v_list == 0) {
            $this->ajaxHandle(0, $plugin->errorInfo(true));
        }
        deldir($plugin_path);
        $this->ajaxHandle(1, '创建成功', './'.$zipPath);
    }
    /**
     * 下载文件
     * 可以指定下载显示的文件名，并自动发送相应的Header信息
     * 如果指定了content参数，则下载该参数的内容
     * @static
     * @access public
     * @param string $filename 下载文件名
     * @param string $showname 下载显示的文件名
     * @param string $content  下载的内容
     * @param integer $expire  下载内容浏览器缓存时间
     * @return void
     */
    function download ($filename, $showname='',$content='',$expire=180) {
        $filename = I('filename');
        if(is_file($filename)) {
            $length = filesize($filename);
        }elseif(is_file(UPLOAD_PATH.$filename)) {
            $filename = UPLOAD_PATH.$filename;
            $length = filesize($filename);
        }elseif($content != '') {
            $length = strlen($content);
        }else {
            $this->error('文件不存在');
        }
        if(empty($showname)) {
            $showname = $filename;
        }
        $showname = basename($showname);
        //发送Http Header信息 开始下载
        header("Pragma: public");
        header("Cache-control: max-age=".$expire);
        //header('Cache-Control: no-store, no-cache, must-revalidate');
        header("Expires: " . gmdate("D, d M Y H:i:s",time()+$expire) . "GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s",time()) . "GMT");
        header("Content-Disposition: attachment; filename=".$showname);
        header("Content-Length: ".$length);
        header("Content-type: application/zip");
        header('Content-Encoding: none');
        header("Content-Transfer-Encoding: binary" );
        if($content == '' ) {
            readfile($filename);
        }else {
          echo($content);
        }
        exit();
    }
    /**
     * 插件列表
     */
    public function index(){

        $this->meta_title = '插件列表';
        $this->list = D('Plugin')->getList();
        //$this->recordList($list);//分页用
        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->display();
    }

    /**
     * 插件后台显示页面
     * @param string $name 插件名
     */
    // public function adminList($name){
    //     $class = get_addon_class($name);
    //     if(!class_exists($class))
    //         $this->error('插件不存在');
    //     $addon  =   new $class();
    //     $this->assign('addon', $addon);
    //     $param  =   $addon->admin_list;
    //     if(!$param)
    //         $this->error('插件列表信息不正确');
    //     $this->meta_title = $addon->info['title'];
    //     extract($param);
    //     $this->assign('title', $addon->info['title']);
    //     if($addon->custom_adminlist)
    //         $this->assign('custom_adminlist', $addon->addon_path.$addon->custom_adminlist);
    //     $this->assign($param);
    //     if(!isset($fields))
    //         $fields = '*';
    //     if(!isset($map))
    //         $map = array();
    //     if(isset($model))
    //         $list = $this->lists(D("Addons://{$model}/{$model}")->field($fields),$map);
    //     $this->assign('_list', $list);
    //     $this->display();
    // }
    /**
     * 更新数据 并重置 Hook
     */
    private function updateRow ( $table, $where, $data, $alert) {
        $this->alert = $alert;
        if( M($table)->where($where)->save($data) ) {
            S('hooks', null);
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * 启用插件
     */
    public function enable(){
        $id   = I('data');      
        $data = array('status' => 1);
        $where = 'id='.$id;
        $status = $this->updateRow('Plugin', $where, $data, '启用插件');
        $info = ($status) ? '插件启用成功' : '插件启用失败';
        $this->ajaxHandle( $status, $info );
    }

    /**
     * 禁用插件
     */
    public function disable(){
        $id   =   I('data');
        $data =  array('status' => 0);
        $where = 'id='.$id;
        $status = $this->updateRow('Plugin', $where, $data, '禁用插件');
        $info = ($status) ? '插件禁用成功' : '插件禁用失败';
        $this->ajaxHandle( $status, $info );
    }

    /**
     * 设置插件页面
     */
    public function config(){
        $id     =   (int)I('id');
        $plugin  =   M('Plugin')->find($id);
        if(!$plugin)
            $this->ajaxHandle(0, '插件未安装');
        $pluginClass = get_plugin_class($plugin['name']);
        if( !$pluginClass ) {
            $this->ajaxHandle(0, '插件不存在');
        }
        $plugin['plugin_path'] = $pluginClass->plugin_path;
        //custom_config 并无内容-------------------------------------------
        $plugin['custom_config'] = $pluginClass->custom_config;
        $this->meta_title   =   '设置插件-'.$pluginClass->info['title'];
        $db_config = $plugin['config'];
        $plugin['config'] = include $pluginClass->config_file;
        if($db_config){
            $db_config = json_decode($db_config, true);
            foreach ($plugin['config'] as $key => $value) {
                if($value['type'] != 'group'){
                    $plugin['config'][$key]['value'] = $db_config[$key];
                }else{
                    foreach ($value['options'] as $gourp => $options) {
                        foreach ($options['options'] as $gkey => $value) {
                            $plugin['config'][$key]['options'][$gourp]['options'][$gkey]['value'] = $db_config[$gkey];
                        }
                    }
                }
            }
        }
        $this->assign('data',$plugin);
        if($plugin['custom_config'])
            $this->assign('custom_config', $plugin->fetch($plugin['plugin_path'].$plugin['custom_config']));
        $this->display();
    }
    /**
     * 通用 ajax 处理
     */
    private function ajaxHandle ( $status, $info, $otherInfo = '' ) {
        $data['status'] = $status;
        $data['info'] = $info;
        $data['other'] = $otherInfo;
        $this->ajaxReturn($data,'JSON');  
    }
    /**
     * 保存插件设置
     */
    public function saveConfig(){
        $id     =   (int)I('id');
        $config =   I('config');
        $flag = M('Plugin')->where("id={$id}")->setField('config',json_encode($config));
        if($flag !== false){
            $this->ajaxHandle(1, '保存成功');
        }else{
            $this->ajaxHandle(0, '保存失败');
        }
    }

    /**
     * 安装插件
     */
    public function install(){
        $plugin_name = trim(I('data'));
        $className = "{$plugin_name}Plugin";
        import("Plugin.{$plugin_name}.{$className}", ROOT_PATH);
        if(!class_exists($className)) {
            $this->ajaxHandle(0, '插件不存在');
        }
        $plugin  =   new $className;
        $info = $plugin->info;
        if(!$info || !$plugin->checkInfo())//检测信息的正确性
            $this->ajaxHandle(0, '插件信息缺失');
        session('plugin_install_error',null);
        $install_flag   =   $plugin->install();
        if(!$install_flag){
            $this->ajaxHandle(0, '执行插件预安装操作失败'.session('plugin_install_error'));
        }
        $pluginModel    =   D('Plugin');
        $data           =   $pluginModel->create($info);
        if (!$data) {
            $this->ajaxHandle(0, $pluginModel->getError());
        }    
        //插件后台界面
        if(is_array($plugin->admin_list) && $plugin->admin_list !== array()){
            $data['has_adminlist'] = 1;
        }else{
            $data['has_adminlist'] = 0;
        }
        if(!$data)
            $this->error($pluginModel->getError());
        if($pluginModel->add($data)){
            $config         =   array('config'=>json_encode($plugin->getConfig()));
            $pluginModel->where("name='{$plugin_name}'")->save($config);
            $hooks_update   =   D('Hooks')->updateHooks($plugin_name);
            if($hooks_update){
                S('hooks', null);
                $this->ajaxHandle(1, '插件安装成功');
            }else{
                $pluginModel->where("name='{$plugin_name}'")->delete();
                $this->ajaxHandle(0, '更新钩子处插件失败,请卸载后尝试重新安装');
            }

        }else{
            $this->ajaxHandle(0, '写入插件数据失败');
        }
    }

    /**
     * 卸载插件
     */
    public function uninstall(){
        $pluginModel    =   M('Plugin');
        $id             =   trim(I('data'));
        $db_plugin      =   $pluginModel->find($id);
        $class          =   get_plugin_class($db_plugin['name'], false);
        if( !$class || !$db_plugin ) {
            $this->ajaxHandle(0, '插件不存在');
        }
        session('addons_uninstall_error',null);
        $plugin =   new $class;
        $uninstall_flag =   $plugin->uninstall();
        if(!$uninstall_flag)
            $this->ajaxHandle(0, '执行插件预卸载操作失败'.session('addons_uninstall_error'));
        $hooks_update   =   D('Hooks')->removeHooks($db_plugin['name']);
        if($hooks_update === false){
            $this->ajaxHandle(0, '卸载插件所挂载的钩子数据失败');
        }
        S('hooks', null);
        $delete = $pluginModel->where("name='{$db_plugin['name']}'")->delete();
        if($delete === false){
            $this->ajaxHandle(0, '插件卸载失败');
        }else{
            $this->ajaxHandle(1, '插件卸载成功');
        }
    }

    /**
     * 钩子列表
     */
    public function hooks(){
        $this->meta_title   =   '钩子列表';
        $map    =   $fields =   array();
        $list   =   $this->lists(D("Hooks")->field($fields),$map);
        int_to_string($list, array('type'=>C('HOOKS_TYPE')));
        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->assign('list', $list );
        $this->display();
    }

    public function addhook(){
        $this->assign('data', null);
        $this->meta_title = '新增钩子';
        $this->display('edithook');
    }

    //钩子出编辑挂载插件页面
    public function edithook($id){
        $hook = M('Hooks')->field(true)->find($id);
        $this->assign('data',$hook);
        $this->meta_title = '编辑钩子';
        $this->display('edithook');
    }

    //超级管理员删除钩子
    public function delhook($id){
        if(M('Hooks')->delete($id) !== false){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

    public function updateHook(){
        $hookModel  =   D('Hooks');
        $data       =   $hookModel->create();
        if($data){
            if($data['id']){
                $flag = $hookModel->save($data);
                if($flag !== false)
                    $this->success('更新成功', Cookie('__forward__'));
                else
                    $this->error('更新失败');
            }else{
                $flag = $hookModel->add($data);
                if($flag)
                    $this->success('新增成功', Cookie('__forward__'));
                else
                    $this->error('新增失败');
            }
        }else{
            $this->error($hookModel->getError());
        }
    }

    public function execute($_addons = null, $_controller = null, $_action = null){
        if(C('URL_CASE_INSENSITIVE')){
            $_addons        =   ucfirst(parse_name($_addons, 1));
            $_controller    =   parse_name($_controller,1);
        }

        if(!empty($_addons) && !empty($_controller) && !empty($_action)){
            $Addons = A("Addons://{$_addons}/{$_controller}")->$_action();
        } else {
            $this->error('没有指定插件名称，控制器或操作！');
        }
    }

}
