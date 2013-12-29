<table class="table table-bordered table-hover">
	<thead>
		<tr class="user-head">
			<td onclick="ajax_show_content_2('<?php echo U('User/showUser') ?>', 'id')">用户ID</td>
			<td onclick="ajax_show_content_2('<?php echo U('User/showUser') ?>', 'name')">用户名</td>
			<td onclick="ajax_show_content_2('<?php echo U('User/showUser') ?>', 'sex')">性别</td>
			<td onclick="ajax_show_content_2('<?php echo U('User/showUser') ?>', 'local')">住址</td>
			<td onclick="ajax_show_content_2('<?php echo U('User/showUser') ?>', 'age')">年纪</td>
			<td>更改</td>
		</tr>
	</thead>
	<tbody>
		<?php foreach( $result as $key => $value ) : ?>
		<tr>
			<td class="user"><?php handleUser($value['id']);?></td>
			<td class="user"><?php handleUser($value['name']);?></td>
			<td class="user"><?php handleUser($value['sex']);?></td>
			<td class="user"><?php handleUser($value['local']);?></td>
			<td class="user"><?php handleUser($value['age']);?></td>
			<td><a href="<?php echo '#myModal_'.$key ?>" role="button" class="btn" data-toggle="modal">更改</a></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<div id="myModal_0" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Modal header</h3>
	</div>
	<div class="modal-body">
		<p>One fine body…</p>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
		<button class="btn btn-primary">Save changes</button>
	</div>
</div>
    