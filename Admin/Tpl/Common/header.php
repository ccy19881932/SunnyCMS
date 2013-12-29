<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>仪表盘</title>
	<link rel="stylesheet" href="__PUBLIC__/css/bootstrap.min.css" />
	<link rel="stylesheet" href=<?php echo __ADMINPUBLIC__.'css/style.css'; ?> />
</head>
<body>
    <div class="navbar navbar-fixed-top navbar-inverse">
  		<div class="navbar-inner">
  			<a class="brand" href="#"></a>
			<ul class="nav">
				<li class="active"><a href="<?php echo U('Index/index'); ?>">首页</a></li>
				<li><a href="<?php echo U('Post/index'); ?>">文章管理</a></li>
				<li><a href="<?php echo U('Catalog/index'); ?>">目录管理</a></li>
				<li><a href="<?php echo U('User/index'); ?>">用户管理</a></li>
				<li></li>
				<li></li>
				<li></li>
			</ul>
			<form class="navbar-search">
		    	<input type="text" class="search-query" placeholder="Search">
		    </form>
		    <ul class="nav pull-right">
		    	<li><a><?php echo '欢迎您,'.$name; ?></a></li>
		    	<li><a href="<?php echo U('Index/logout'); ?>">退出</a></li>
		    	<li class="divider-vertical"></li>
		    </ul>
  		</div>
    </div>