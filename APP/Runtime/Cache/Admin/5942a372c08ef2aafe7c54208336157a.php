<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/style.css" />
    <script type="text/javascript" src="__PUBLIC__/Js/jquery.js"></script>

    <link rel="stylesheet" href="__PUBLIC__/plugin/kindeditor/themes/default/default.css" />
    <script type="text/javascript" src="__PUBLIC__/plugin/kindeditor/kindeditor-all-min.js"></script>
    <script charset="utf-8" src="__PUBLIC__/plugin/kindeditor/lang/zh_CN.js"></script>

    <script charset="utf-8" src="__PUBLIC__/plugin/iCheck/icheck.min.js"></script>
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/plugin/iCheck/skins/square/grey.css" />
    
</head>
<body>
<?php if (isset($message)): ?>
	<div class="success alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		恭喜，<?php echo $alert; ?>成功!
	</div>
<?php else: ?>
	<div class="error alert-error">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		不好意思,没有<?php echo $alert; ?>成功...
	</div>
<?php endif; ?>
<p class="jump">
页面自动 <a id="href" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait"><?php echo($waitSecond); ?></b>
</p>
</div>
<script type="text/javascript">
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time <= 0) {
		location.href = href;
		clearInterval(interval);
	};
}, 1000);
})();
</script>
</body>
    
    <!-- // <script type="text/javascript" src="__PUBLIC__/Js/jquery.sorted.js"></script> -->
    <script type="text/javascript" src="__PUBLIC__/Js/bootstrap.js"></script>
    <script type="text/javascript" src="__PUBLIC__/Js/ckform.js"></script>
    <script type="text/javascript" src="__PUBLIC__/Js/common.js"></script>
    <script type="text/javascript" src="__ROOTPUBLIC__/Js/ajax.js"></script>
    <style type="text/css">
        body {
            padding-bottom: 40px;
        }
        .sidebar-nav {
            padding: 9px 0;
        }

        @media (max-width: 980px) {
            /* Enable use of floated navbar text */
            .navbar-text.pull-right {
                float: none;
                padding-left: 5px;
                padding-right: 5px;
            }
        }
    </style>
	</body>
</html>