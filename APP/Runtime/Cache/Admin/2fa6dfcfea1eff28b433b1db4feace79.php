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
<div style="display:none;" id="alert">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <span id="AlertMsg">aa</span>
</div>
<form class="form-horizontal left-content" action="<?php echo U('Plugin/build'); ?>" method="POST" id="PluginForm">
	<fieldset>
		<div id="legend" class="">
			<h2>创建插件框架</h2>
		</div>
    	<div class="control-group">
          <label class="control-label" for="input01">插件唯一标识</label>
          <div class="controls">
            <input placeholder="example" class="input-xlarge" type="text" name="pluginID">
            <p class="help-block"></p>
          </div>
        </div>
    	<div class="control-group">
          <label class="control-label" for="input01">插件名</label>
          <div class="controls">
            <input placeholder="我的插件" class="input-xlarge" type="text" name="pluginName">
            <p class="help-block"></p>
          </div>
        </div>
    	<div class="control-group">
          <label class="control-label" for="input01">版本号</label>
          <div class="controls">
            <input placeholder="0.1" class="input-xlarge" type="text" name="pluginVision">
            <p class="help-block"></p>
          </div>
        </div>
    	<div class="control-group">
          <label class="control-label" for="input01">作者</label>
          <div class="controls">
            <input placeholder="未命名" class="input-xlarge" type="text" name="pluginAuth">
            <p class="help-block"></p>
          </div>
        </div>
    	<div class="control-group">
          <label class="control-label">插件描述</label>
          <div class="controls">
            <div class="textarea">
                  <textarea type="" class="" name="pluginDesc"> </textarea>
            </div>
          </div>
        </div>
    	<div class="control-group">
          <label class="control-label">默认是否启用</label>
          <div class="controls">
		      <label class="radio inline">
		        <input checked="checked" value="1" name="pluginOpen" type="radio"> 是
		      </label>
		      <label class="radio inline">
		        <input value="0" name="pluginOpen" type="radio"> 否
		      </label>
  			</div>
        </div>
	    <div class="control-group">
          <label class="control-label">是否需要配置文件</label>
          <div class="controls">
		      <label class="radio inline">
		        <input checked="checked" value="1" name="pluginConfig" type="radio"> 是
		      </label>
		      <label class="radio inline">
		        <input value="0" name="pluginConfig" type="radio"> 否
		      </label>
  		   </div>
	    </div>
    	<div class="control-group">
		  <label class="control-label">是否需要外部访问</label>
		  <div class="controls">
		      <label class="radio inline">
		        <input checked="checked" value="1" name="pluginPublic" type="radio"> 是
		      </label>
		      <label class="radio inline">
		        <input value="0" name="pluginPublic" type="radio"> 否
		      </label>
		  </div>
        </div>
   		<div class="control-group">
          <label class="control-label">选择钩子(Ctrl多选)</label>
          <div class="controls">
            <select class="input-xlarge" multiple="multiple" name="hookname[]">
            <?php foreach ($Hooks as $value): ?>
              <option value="<?php echo $value['name']; ?>" title="<?php echo $value['description']; ?>"><?php echo $value['name']; ?></option>
            <?php endforeach ?>
              <option value="otherhook" title="otherhook">otherhook</option>
            </select>
          </div>
      </div>
	    <div class="control-group">
	        <label class="control-label">是否需要后台列表</label>
	        <div class="controls">
		      <label class="radio inline">
		        <input checked="checked" value="1" name="pluginBack" type="radio"> 是
		      </label>
		      <label class="radio inline">
		        <input value="0" name="pluginBack" type="radio"> 否
		      </label>
	  		</div>
      </div>
      <button class="btn" onclick="ajaxFormHandle('PluginForm', 'alert');" id="submit">提　交</button>
    </fieldset>
  </form>
  <form action="<?php echo U(GROUP_NAME.'/Plugin/download'); ?>" method="POST">
    <input type="hidden" id="pluginID" name="filename">
    <input type="submit" id="download" style="display:none;">
  </form>
  
<script>
  $(function(){
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-grey',
        radioClass: 'iradio_square-grey',
        increaseArea: '20%', // optional
      });
  });
</script>
<script src="__ROOTPUBLIC__/Js/jquery.form.min.js"></script>
    
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