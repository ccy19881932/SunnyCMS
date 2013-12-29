<html>
	<head>
		<title>首页</title>
	</head>
	<body>
		<ul>
			<li>
				你好
				<?php foreach ($$name as $vo) {
					<?php echo $vo['name']; ?>
				<?php }  ?>
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