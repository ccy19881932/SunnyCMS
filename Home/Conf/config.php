<?php
return array(
	//'配置项'                =>'配置值'
	'TMPL_L_DELIM'         => '<{',
	'TMPL_R_DELIM'         => '}>',
	
	// 'DB_TYPE'           =>'mysql',
	// 'DB_HOST'           =>'localhost',
	// 'DB_NAME'           =>'test',
	// 'DB_USER'           =>'root',
	// 'DB_PWD'            =>'',
	// 'DB_PORT'           =>'3306',
	'DB_PREFIX'            =>'tp_',
	'DB_DSN'               =>'mysql://root:@localhost:3306/test',
	'SHOW_PAGE_TRACE'      => true,
	'DEFAULT_THEME'        => '220sushe',
	'TMPL_DETECT_THEME'    => true,
	
	//表单令牌环
	'TOKEN_ON'             =>true,
	'URL_CASE_INSENSITIVE' =>true,
	//PHP原生模板
	'TMPL_ENGINE_TYPE'     =>'PHP',
	'TMPL_TEMPLATE_SUFFIX' =>'.php',
	//开启语言包功能
	'LANG_SWITCH_ON'       => true,
	'LANG_LIST'            => 'zh-cn',
	'LANG_AUTO_DETECT'     => true, 
	'VAR_LANGUAGE'         => 'l',
	);
?>