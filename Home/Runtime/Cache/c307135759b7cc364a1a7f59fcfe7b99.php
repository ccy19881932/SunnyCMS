<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		<title>首页</title>
	</head>
	<body>
		<ul>
			<li>
				你好
				<?php if(is_array($name)): $i = 0; $__LIST__ = $name;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; echo ($vo["name"]); endforeach; endif; else: echo "" ;endif; ?>
			</li>
			<li>
				我好me
			</li>
			<li>
				大家好me
			</li>
		</ul>
	</body>
</html>