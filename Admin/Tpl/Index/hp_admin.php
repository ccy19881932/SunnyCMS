<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>登陆</title>
	<link rel="stylesheet" href="__PUBLIC__/css/bootstrap.min.css" />
	<style>
		* {
			margin:0 auto;
			padding:0 auto;
		}

		.center {
			display: block;
			width:40%;
			margin-top: 15%;
			padding-top: 40px;
			border: 1px solid #DDDDDD;
		}

		.one_inline{
			display: inline;
		}
	</style>
</head>
<body>
<div class="center">
	<form class="form-horizontal" method="POST" action="<?php echo U('Index/do_login'); ?>">
	    <div class="control-group">
	    	<label class="control-label" for="username">用户名</label>
		    <div class="controls">
		    	<input type="text" id="username" placeholder="username" name="user_name">
		    </div>
	    </div>
	    <div class="control-group">
	    	<label class="control-label" for="inputPassword">密　码</label>
	   		<div class="controls">
	    		<input type="password" id="inputPassword" placeholder="Password" name="pass_word">
	    	</div>
	    </div>
	    <div class="control-group">
	    	<div class="controls">
	    		<label class="checkbox">
	    			<input type="checkbox"> 记住我
	    		</label>
	    		<button type="submit" class="btn" name="submit">登录</button>
	    		<p class="one_inline"><?php echo isset($alert)?$alert:''; ?></p>
	    	</div>
	    </div>
    </form>
</div>
	<script src="http://libs.baidu.com/jquery/1.9.0/jquery.min.js"></script>
	<script src="__PUBLIC__/js/bootstrap.min.js"></script>
</body>
</html>