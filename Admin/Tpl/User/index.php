<div class="box page">
	<div class="box l-page l_al">
		<ul class="nav nav-tabs nav-stacked">
		    <li class="chose"><a onclick="ajax_handle_avg('<?php echo U('User/showAllUser') ?>', 'u_id');"><i class="icon-user"></i> 所有用户<i class="icon-chevron-right" style="float:right;"></i></a></li>
	    </ul>
	</div>
	<div class="box r-page r_al">
		<h2 id="right-title">所有用户</h2><hr style="margin:5px;">
		<div id="right-contents">
			<p><?php echo $tpl_showAllUser; ?></p>
		</div>
		<div id="right-sub-contents">
			<p><?php echo $tpl_showUser; ?></p>
		</div>
	</div>
	<div calss="clear"></div>
</div>