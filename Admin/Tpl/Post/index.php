
	<script src="<?php echo __ADMINPUBLIC__.'plugin/ueditor/ueditor.config.js'; ?>"></script>   
	<script src="<?php echo __ADMINPUBLIC__.'plugin/ueditor/ueditor.all.js'; ?>"></script>
<div class="box page">
	<div class="box l-page l_al">
		<ul class="nav nav-tabs nav-stacked">
		    <li class="chose"><a onclick="ajax_show_content('__URL__/allPost');"><i class="icon-user"></i> 所有文章<i class="icon-chevron-right" style="float:right;"></i></a></li>
		    <li><a onclick="ajax_show_content('__URL__/newPost');"><i class="icon-user"></i> 新建文章<i class="icon-chevron-right" style="float:right;"></i></a></li>
	    </ul>
	</div>
	<div class="box r-page r_al">
		
		<h2 id="right-title">所有文章</h2><hr style="margin:5px;">
		<div id="right-contents">
			<p><?php echo $allPost;?></p>
		</div>
	</div>
	<div calss="clear"></div>
</div>
