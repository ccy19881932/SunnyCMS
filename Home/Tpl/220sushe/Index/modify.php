<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>更改</title>
	<script>
		window.onload=function(){
			if('<{$result.sex}>' == 'nan') {
				document.getElementsByName('sex')[0].checked = true;
			} else {
				document.getElementsByName('sex')[1].checked = true;
			}
		}
	</script>
</head>
<body>
	{__TOKEN__}
	<?php echo C('VAR_LANGUAGE').'<br/>你好啊，我是PHP大神'.__URL__; ?>
	<form action="" method="post">
		名字：<input type="text" value="<?php echo $result['name']; ?>" name="name"/><br/>
		性别：男<input type="radio" name="sex" value="1" />女<input type="radio" name="sex" value="2" /><br/>
		年纪：<input type="text" value="<?php echo $result['age']; ?>" name="age"/><br/>
		住址：<input type="text" value="<?php echo $result['local']; ?>" name="local"/><br/>
		提交：<input type="submit" id="submit" name="提交" />
	</form>
</body>
</html>