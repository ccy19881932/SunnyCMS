<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>展示</title>
</head>
<style>
	.list li{
		display:inline-block;
		text-align: center;
		padding:5px 0;
		width: 100px;
	}
</style>
<body>
	<ul class="list"><li>姓名</li><li>性别</li><li>住址</li><li>年纪</li></ul>
	<ul class="list">
		<?php if(is_array($user_result)): $i = 0; $__LIST__ = $user_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($i % 2 );++$i;?><li><?php echo ($value["name"]); ?></li><li><?php echo ($value["sex"]); ?></li><li><?php echo ($value["local"]); ?></li><li><?php echo ($value["age"]); ?></li><li><a href="/thinkphp/index.php/Index/modify/id/<?php echo ($value["id"]); ?>">修改</a></li><br/><?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
</body>
</html>