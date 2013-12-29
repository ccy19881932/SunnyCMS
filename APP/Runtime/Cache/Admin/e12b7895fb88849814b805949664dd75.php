<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <title>后台管理系统</title>
	<meta charset="UTF-8">
   <link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/style.css" />
    <script type="text/javascript" src="__PUBLIC__/Js/jquery.js"></script>
    <!--<script type="text/javascript" src="__PUBLIC__/Js/jquery.sorted.js"></script>-->
    <script type="text/javascript" src="__PUBLIC__/Js/bootstrap.js"></script>
    <script type="text/javascript" src="__PUBLIC__/Js/ckform.js"></script>
    <script type="text/javascript" src="__PUBLIC__/Js/common.js"></script>
    <script>
      var URL = '<?php echo U(GROUP_NAME.'/Login/verify');?>/';
      function change_verify_code(){
        $('#verify_code').attr('src',URL+Math.random());
        return false;
       }
    </script>
    <style type="text/css">
        body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            max-width: 300px;
            padding: 19px 29px 29px;
            margin: 0 auto 20px;
            background-color: #fff;
            border: 1px solid #e5e5e5;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
            -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
            box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
        }

        .form-signin .form-signin-heading,
        .form-signin .checkbox {
            margin-bottom: 10px;
        }

        .form-signin input[type="text"],
        .form-signin input[type="password"] {
            font-size: 16px;
            height: auto;
            margin-bottom: 15px;
            padding: 7px 9px;
        }
        .form-signin #verify_code{
            width:60px;
            height:30px;
            margin-bottom:15px;
        }
    </style>  
</head>
<body>
<div class="container">

    <form class="form-signin" method="post" action="<?php echo U(GROUP_NAME.'/Login/login');?>">
        <h2 class="form-signin-heading">登录系统</h2>
        <input type="text" name="username" class="input-block-level" placeholder="账号">
        <input type="password" name="password" class="input-block-level" placeholder="密码">
        <input type="text" name="verify" class="input-medium" placeholder="验证码">
        <img src="<?php echo U(GROUP_NAME .'/Login/verify');?>" alt="verify" id="verify_code" onclick="change_verify_code()"/><a href="javascript:void(change_verify_code())">看不清</a>
        <p><button class="btn btn-large btn-primary" type="submit">登录</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-large" href="#">回首页</a></p>
    </form>

</div>
</body>
</html>