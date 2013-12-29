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
<form class="left-content" id="big-form" action="" method="POST">
	<h2>文章<a class="add-new-h2" href="<?php echo U(GROUP_NAME.'/Post/newPost'); ?>">写文章</a></h2>
	<ul class="subsubsub">
		<li class="all">
			<a <?php echo ($status==-1)?'class="current"':''; ?> href="<?php echo U(GROUP_NAME.'/Post/index', array('status' => -1)); ?>">
				全部<span class="count"><?php echo '（'.$statusNum['-1'].'）';?></span>
			</a>|
		</li>
		<li class="publish">
			<a <?php echo ($status==0)?'class="current"':''; ?> href="<?php echo U(GROUP_NAME.'/Post/index', array('status' => 0)); ?>">
				已发布<span class="count"><?php echo '（'.$statusNum['0'].'）';?></span>
			</a>|
		</li>
		<li class="private">
			<a <?php echo ($status==1)?'class="current"':''; ?> href="<?php echo U(GROUP_NAME.'/Post/index', array('status' => 1)); ?>">
				私密<span class="count"><?php echo '（'.$statusNum['1'].'）';?></span>
			</a>|
		</li>
		<li class="trash">
			<a <?php echo ($status==2)?'class="current"':''; ?> href="<?php echo U(GROUP_NAME.'/Post/index', array('status' => 2)); ?>">
				回收站<span class="count"><?php echo '（'.$statusNum['2'].'）';?></span>
			</a>
		</li>
	</ul>
	<div id="posts-filter">
		<div class="input-append">
			<input type="text" name="search" class="search" id="search" placeholder="搜索文章">
			<span class="add-on" onclick="$('#big-form').submit();"><i class="icon-search"></i></span>
		</div>
	</div>
	<div class="tablenav top inline">	
	    <div class="form-inline subnav-left">
	    	<select class="group-select" name="group-choise-1">
	    		<option value="-1">批量选择</option>
	    		<option value="0">设置为正常</option>
	    		<option value="1">设置为私密</option>
	    		<option value="2">移至回收站</option>
	    	</select>
	    	<input type="submit" id="group_choise" style="display:none;" name="group_choise" value="group_choise">
	    	<a class="btn btn-small" onclick="$('#group_choise').click();"><i class="icon-refresh"></i> 应用</a>
	    </div>
		<div class="form-inline subnav-right">
			<input type="submit" style="display:none;" id="filterSubmit" name="filterSubmit" value="filterSubmit">
			<a class="btn btn-small pull-right" onclick="$('#filterSubmit').click();"><i class="icon-filter"></i> 筛选</a>		
			<select class="date-select pull-right" name="all-date">
	    		<option value="-1">所有日期</option>
	    		<?php foreach ($datePost as $datePostk => $datePostv): ?>
	    			<option value="<?php echo $datePostv['search']; ?>"><?php echo $datePostv['datestr'].'('.$datePostv['num'].')'; ?></option>
	    		<?php endforeach; ?>
	    	</select>
	    	<select class="cat-select pull-right" name="all-cat">
	    		<option value="-1">所有分类</option>
	    		<option value="1">1</option>
	    		<option value="2">2</option>
	    	</select>
		</div>
		<div style="clear:both"></div>
	</div>
	<table class="wp-list-table widefat" cellspacing="0">
		<thead>
			<tr>
				<th class="manage-column column-cb check-column"><input id="selectAll_1" type="checkbox"></th>
				<th class="manage-column table_title"><a href="<?php echo U('Post/allPost'); ?>">标题</a></th>
				<th class="manage-column table_auth">作者</th>
				<th class="manage-column table_cat">分类目录</th>
				<th class="manage-column table_tag">标签</th>
				<th class="manage-column table_date">日期</th>
				<th class="manage-column table_status">状态</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th><input id="selectAll_2" type="checkbox"></th>
				<th class="manage-column table_title">标题</th>
				<th class="manage-column table_auth">作者</th>
				<th class="manage-column table_cat">分类目录</th>
				<th class="manage-column table_tag">标签</th>
				<th class="manage-column table_date">日期</th>
				<th class="manage-column table_status">状态</th>
			</tr>
		</tfoot>
		<tbody id="postTable">
			<?php if(!empty($result)): foreach ($result as $key => $value) : ?>
				<tr>
					<th><input id="<?php echo 'cb-select-'.$key; ?>" type="checkbox" name="<?php echo 'cb-select-'.$key; ?>" value="<?php echo $value['post_id']; ?>"></th>
					<td class="manage-column table_title"><?php echo $value['post_title']; ?></td>	
					<td class="manage-column table_auth"><?php echo $value['user_name']; ?></td>	
					<td class="manage-column table_cat">
						<?php foreach ($value['group'] as $k => $v) : ?>			
								<?php if( $v['term_type'] == 1 ){ echo $v['term_name'].' '; } ?>	
						<?php endforeach; ?>
					</td>
					<td class="manage-column table_tag">
						<?php foreach ($value['group'] as $k => $v) : ?>
							<?php if( $v['term_type'] == 2 ){ echo !empty($v['term_name']) ? $v['term_name'].' ' : '--'; } ?>
						<?php endforeach; ?>
					</td>
					<td class="manage-column table_date">
						<?php echo '发布: '.$value['post_date']."<br>更新: ".$value['modify_date']; ?>
					</td>
					<td class="manage-column table_status">
						<?php if($value['post_status'] == 0) { echo '已发布'; } elseif($value['post_status'] == 1) { echo '私人收藏'; } elseif($value['post_status'] == 2) { echo '回收站'; } ?>
					</td>
				</tr>
			<?php  endforeach; else: echo "<tr><th></th><td>未找到文章</td></tr>"; endif; ?>
		</tbody>
	</table>
	<div class="tablenav top inline">	
	    <div class="form-inline subnav-left">
	    	<select class="group-select" name="group-choise-2">
	    		<option value="-1">批量选择</option>
	    		<option value="0">设置为正常</option>
	    		<option value="1">设置为私密</option>
	    		<option value="2">移至回收站</option>
	    	</select>
	    	<input type="submit" id="group_choise_2" style="display:none;" name="group_choise_2" value="group_choise_2">
	    	<a class="btn btn-small" onclick="$('#group_choise_2').click();"><i class="icon-refresh"></i> 应用</a>
	    </div>
    </div>
</from>
<script>
	$(document).ready(function(){
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