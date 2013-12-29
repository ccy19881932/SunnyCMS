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
<form class="left-content" id="big-form" action="" method="POST">
	<h2>
		<?php echo $meta_title; ?>
		<a class="add-new-h2" href="<?php echo U(GROUP_NAME.'/Plugin/create'); ?>">创建插件</a>
		<a class="add-new-h2" href="">上传插件</a>
	</h2>
	<table class="wp-list-table widefat" cellspacing="0">
		<thead>
			<tr>
				<th class="manage-column column-cb check-column"><input id="selectAll_1" type="checkbox"></th>
				<th class="manage-column table_plugin_name">插件</th>
				<th class="manage-column table_plugin_desc">描述</th>
			</tr>
		</thead>
		<tfoot>
			<th><input id="selectAll_2" type="checkbox"></th>
			<th class="manage-column table_plugin_name">插件</th>
			<th class="manage-column table_plugin_desc">描述</th>
		</tfoot>
		<tbody id="postTable">
			<?php foreach ($list as $key => $value): ?>
				<tr>
					<th><input id="<?php echo 'cb-select-'.$key; ?>" type="checkbox" name="<?php echo 'cb-select-'.$key; ?>" value="<?php echo $value['id']; ?>"></th>
					<td class="plugin-title">
						<strong><?php echo $value['title']; ?></strong>
						<div>
						<?php if ($value['uninstall']): ?>
							<span class="install"><a onclick="ajax_handle('__GROUP__/Plugin/install','<?php echo $value['name']; ?>', 'alert');">安装</a></span>	
						<?php else: ?>
							<span>
								<?php if ($value['status']): ?>
									<a onclick="ajax_handle('__GROUP__/Plugin/disable',<?php echo $value['id']; ?>, 'alert');">停用</a>
								<?php else: ?>
									<a onclick="ajax_handle('__GROUP__/Plugin/enable',<?php echo $value['id']; ?>, 'alert');">启用</a>
								<?php endif; ?>
							</span>
							<span>
							<?php if ($value['has_adminlist']): ?>
								|<a href="<?php echo U( GROUP_NAME.'/Plugin/config', array('id' => $value['id']) ); ?>">设置</a>
							<?php endif; ?>
							</span>
							<span class="delete">|<a onclick="ajax_handle('__GROUP__/Plugin/uninstall',<?php echo $value['id']; ?>, 'alert');">删除</a></span>
						<?php endif; ?>
						</div>
					</td>
					<td>
						<?php echo $value['description']; ?>
						<div>
							<span><?php echo $value['version'].'版本'; ?></span>
							<span><?php echo '| 作者为: '.$value['author']; ?></span>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</form>
<script>
	$(function(){
		$('input').iCheck({
	    	checkboxClass: 'icheckbox_square-grey',
	    	radioClass: 'iradio_square-grey',
	    	increaseArea: '20%', // optional
	  	});
	  $('#selectAll_1').on('ifChecked', function(event){
		$('#postTable tr th input').iCheck('check');
		$('#selectAll_2').iCheck('check');
	  });
	  $('#selectAll_2').on('ifChecked', function(event){
		$('#postTable tr th input').iCheck('check');
		$('#selectAll_1').iCheck('check');
	  });
	  $('#selectAll_1').on('ifUnchecked', function(event){
		$('#postTable tr th input').iCheck('uncheck');
		$('#selectAll_2').iCheck('uncheck');
	  });
	  $('#selectAll_2').on('ifUnchecked', function(event){
		$('#postTable tr th input').iCheck('uncheck');
		$('#selectAll_1').iCheck('uncheck');
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