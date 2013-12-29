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
    <span id="AlertMsg" ></span>
</div>
<form class="left-content" id="big-form" action="<?php echo U(GROUP_NAME.'/Plugin/saveConfig'); ?>" method="POST">
	<h2>设置插件 - [<?php echo $data['title']; ?>]</h2>
	<?php if(empty($custom_config)): if(is_array($data['config'])): foreach($data['config'] as $o_key=>$form): ?><div class="form-item cf">
				<label class="item-label" style="display:inline-block;">
					<?php echo (($form["title"])?($form["title"]):''); ?>
					<?php if(isset($form["tip"])): ?><span class="check-tips"><?php echo ($form["tip"]); ?></span><?php endif; ?>
				</label>
					<?php switch($form["type"]): case "text": ?><div class="controls">
							<input type="text" name="config[<?php echo ($o_key); ?>]" class="text input-large" value="<?php echo ($form["value"]); ?>">
						</div><?php break;?>
						<?php case "password": ?><div class="controls">
							<input type="password" name="config[<?php echo ($o_key); ?>]" class="text input-large" value="<?php echo ($form["value"]); ?>">
						</div><?php break;?>
						<?php case "hidden": ?><input type="hidden" name="config[<?php echo ($o_key); ?>]" value="<?php echo ($form["value"]); ?>"><?php break;?>
						<?php case "radio": ?><div class="controls">
							<?php if(is_array($form["options"])): foreach($form["options"] as $opt_k=>$opt): ?><label class="radio">
									<input type="radio" name="config[<?php echo ($o_key); ?>]" value="<?php echo ($opt_k); ?>" <?php if(($form["value"]) == $opt_k): ?>checked<?php endif; ?>> <?php echo ($opt); ?>
								</label><?php endforeach; endif; ?>
						</div><?php break;?>
						<?php case "checkbox": ?><div class="controls">
							<?php if(is_array($form["options"])): foreach($form["options"] as $opt_k=>$opt): ?><label class="checkbox">
									<?php is_null($form["value"]) && $form["value"] = array(); ?>
									<input type="checkbox" name="config[<?php echo ($o_key); ?>][]" value="<?php echo ($opt_k); ?>" <?php if(in_array(($opt_k), is_array($form["value"])?$form["value"]:explode(',',$form["value"]))): ?>checked<?php endif; ?>> <?php echo ($opt); ?>
								</label><?php endforeach; endif; ?>
						</div><?php break;?>
						<?php case "select": ?><div class="controls">
							<select name="config[<?php echo ($o_key); ?>]">
								<?php if(is_array($form["options"])): foreach($form["options"] as $opt_k=>$opt): ?><option value="<?php echo ($opt_k); ?>" <?php if(($form["value"]) == $opt_k): ?>selected<?php endif; ?>><?php echo ($opt); ?></option><?php endforeach; endif; ?>
							</select>
						</div><?php break;?>
						<?php case "textarea": ?><div class="controls">
							<label class="textarea input-large">
								<textarea name="config[<?php echo ($o_key); ?>]"><?php echo ($form["value"]); ?></textarea>
							</label>
						</div><?php break;?>
						<?php case "group": ?><ul class="tab-nav nav">
								<?php if(is_array($form["options"])): $i = 0; $__LIST__ = $form["options"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$li): $mod = ($i % 2 );++$i;?><li data-tab="tab<?php echo ($i); ?>" <?php if(($i) == "1"): ?>class="current"<?php endif; ?>><a href="javascript:void(0);"><?php echo ($li["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
								<li style="clear:both;"></li>
						    </ul>
						    <div class="tab-content">
						    <?php if(is_array($form["options"])): $i = 0; $__LIST__ = $form["options"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tab): $mod = ($i % 2 );++$i;?><div id="tab<?php echo ($i); ?>" class="tab-pane <?php if(($i) == "1"): ?>in<?php endif; ?> tab<?php echo ($i); ?>">
						    		<?php if(is_array($tab['options'])): foreach($tab['options'] as $o_tab_key=>$tab_form): ?><label class="item-label">
										<?php echo (($tab_form["title"])?($tab_form["title"]):''); ?>
										<?php if(isset($tab_form["tip"])): ?><span class="check-tips"><?php echo ($tab_form["tip"]); ?></span><?php endif; ?>
									</label>
						    		<div class="controls">
						    			<?php switch($tab_form["type"]): case "text": ?><input type="text" name="config[<?php echo ($o_tab_key); ?>]" class="text input-large" value="<?php echo ($tab_form["value"]); ?>"><?php break;?>
											<?php case "password": ?><input type="password" name="config[<?php echo ($o_tab_key); ?>]" class="text input-large" value="<?php echo ($tab_form["value"]); ?>"><?php break;?>
											<?php case "hidden": ?><input type="hidden" name="config[<?php echo ($o_tab_key); ?>]" value="<?php echo ($tab_form["value"]); ?>"><?php break;?>
											<?php case "radio": if(is_array($tab_form["options"])): foreach($tab_form["options"] as $opt_k=>$opt): ?><label class="radio">
														<input type="radio" name="config[<?php echo ($o_tab_key); ?>]" value="<?php echo ($opt_k); ?>" <?php if(($tab_form["value"]) == $opt_k): ?>checked<?php endif; ?>>　<?php echo ($opt); ?>
													</label><?php endforeach; endif; break;?>
											<?php case "checkbox": if(is_array($tab_form["options"])): foreach($tab_form["options"] as $opt_k=>$opt): ?><label class="checkbox">
														<?php is_null($tab_form["value"]) && $tab_form["value"] = array(); ?>
        												<input type="checkbox" name="config[<?php echo ($o_tab_key); ?>][]" value="<?php echo ($opt_k); ?>" <?php if(in_array(($opt_k), is_array($tab_form["value"])?$tab_form["value"]:explode(',',$tab_form["value"]))): ?>checked<?php endif; ?>> <?php echo ($opt); ?>
    												</label><?php endforeach; endif; break;?>
											<?php case "select": ?><select name="config[<?php echo ($o_tab_key); ?>]">
													<?php if(is_array($tab_form["options"])): foreach($tab_form["options"] as $opt_k=>$opt): ?><option value="<?php echo ($opt_k); ?>" <?php if(($tab_form["value"]) == $opt_k): ?>selected<?php endif; ?>><?php echo ($opt); ?></option><?php endforeach; endif; ?>
												</select><?php break;?>
											<?php case "textarea": ?><label class="textarea input-large">
													<textarea name="config[<?php echo ($o_tab_key); ?>]"><?php echo ($tab_form["value"]); ?></textarea>
												</label><?php break; endswitch;?>
										</div><?php endforeach; endif; ?>
						    	</div><?php endforeach; endif; else: echo "" ;endif; ?>
						    </div><?php break; endswitch;?>

				</div><?php endforeach; endif; ?>
	<?php else: ?>
		<?php if(isset($custom_config)): echo ($custom_config); endif; endif; ?>
	<input type="hidden" name="id" value="<?php echo I('id');?>" readonly>
	<button class="btn submit-btn ajax-post" target-form="form-horizontal" onclick="ajaxFormHandle('big-form', 'alert');">确 定</button>
	<button class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
</form>
<script src="__ROOTPUBLIC__/Js/jquery.form.min.js"></script>
<script type="text/javascript" charset="utf-8">
	//导航高亮
    if($('ul.tab-nav').length){
    	//当有tab时，返回按钮不显示
    	$('.btn-return').hide();
    }
	$(function(){
		//支持tab
		showTab();
	})
//标签页切换(无下一步)
function showTab() {
    $(".tab-nav li").click(function(){
        var self = $(this), target = self.data("tab");
        self.addClass("current").siblings(".current").removeClass("current");
        window.location.hash = "#" + target.substr(3);
        $(".tab-pane.in").removeClass("in");
        $("." + target).addClass("in");
    }).filter("[data-tab=tab" + window.location.hash.substr(1) + "]").click();
}
$(function(){
	$('input').iCheck({
    	checkboxClass: 'icheckbox_square-grey',
    	radioClass: 'iradio_square-grey',
    	increaseArea: '20%', // optional
  	});
});
</script>
    
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