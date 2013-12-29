<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
	<a href="<?php echo U('Index/modify'); ?>">点这里</a>
	<?php echo 'URL:'.__URL__.'<br/>TMPL'.__TMPL__.'<br/>PUBLIC'.__PUBLIC__.'<br/>ROOT'.__ROOT__.'<br/>APP'.__APP__.'<br/>'; ?>
	<ul class="list"><li>姓名</li><li>性别</li><li>住址</li><li>年纪</li></ul>
	<ul class="list">	
		<?php foreach($user_result as $value) : ?>
				<li><?php echo $value['name'] ?></li><li><?php echo $value['sex']; ?></li><li><?php echo $value['age']; ?></li><li></li><li><a href=<?php echo U( 'Index/modify',array('id' => $value['id']) ); ?> >修改</a></li><br/>	
		<?php endforeach; ?>
	</ul>
</body>
</html>