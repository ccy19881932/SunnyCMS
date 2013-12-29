	<form id="post">
		<textarea name="post_content" id="myEditor"></textarea>
		<a class="btn post-button" onclick="ajax_form_submit('__URL__/doNewPost','post');">完成</a>
	</form>
	<!-- UEdit start -->
	<script type="text/javascript">
	    var editor = new UE.ui.Editor();
	    editor.render("myEditor");
	    //1.2.4以后可以使用一下代码实例化编辑器
	    UE.getEditor('myEditor')
	</script> 
	<!-- UEdit end -->
	<div id="preshow"></div>