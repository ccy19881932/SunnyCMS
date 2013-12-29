<?php
return array(
	//'配置项'=>'配置值'
	'APP_GROUP_LIST' => 'Home,Admin',
	'DEFAULT_GROUP'  => 'Admin',
	'APP_GROUP_MODE' => 1,
	
	'SHOW_PAGE_TRACE'=>TRUE,
	//配置各个目录
	'APP_GROUP_PATH' => 'Modules',
	//'配置项'=>'配置值'
	'DB_PREFIX'            =>'think_',
	'DB_DSN'               =>'mysql://root:@localhost:3306/test',
	//默认错误跳转对应的模板文件
	'TMPL_ACTION_ERROR' => APP_PATH . 'Tpl/dispatch_jump.tpl',
	//默认成功跳转对应的模板文件
	'TMPL_ACTION_SUCCESS' => APP_PATH . 'Tpl/dispatch_jump.tpl',
);
?>