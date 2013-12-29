<?php
	define('APP_NAME', 'APP');
	define('APP_PATH', './APP/');
	define('ROOT_PATH', './');
	define('APP_DEBUG', true);
	define('PLUGIN_PATH', './Plugin/');

	define('__WEBSITE__','http://'.$_SERVER ['HTTP_HOST']);
	define('__ADMINPUBLIC__', '/thinkphp/public/admin/');
	define('__HOMEPUBLIC__', '/thinkphp/public/home/');

	require "/ThinkPHP/ThinkPHP.php";
?>