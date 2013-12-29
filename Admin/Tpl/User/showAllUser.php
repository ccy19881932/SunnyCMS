<table class="table table-bordered table-hover">
	<thead>
		<tr class="user-head">
			<td onclick="ajax_handle_avg('<?php echo U('User/showAllUser') ?>', 'u_id')">用户ID</td>
			<td onclick="ajax_handle_avg('<?php echo U('User/showAllUser') ?>', 'u_name')">用户名</td>
			<td onclick="ajax_handle_avg('<?php echo U('User/showAllUser') ?>', 'u_sex')">性别</td>
			<td onclick="ajax_handle_avg('<?php echo U('User/showAllUser') ?>', 'u_local')">住址</td>
			<td onclick="ajax_handle_avg('<?php echo U('User/showAllUser') ?>', 'u_age')">年纪</td>
			<td onclick="ajax_handle_avg('<?php echo U('User/showAllUser') ?>', 'g_id')">分组ID</td>
			<td onclick="ajax_handle_avg('<?php echo U('User/showAllUser') ?>', 'g_title')">分组名</td>
			<td onclick="ajax_handle_avg('<?php echo U('User/showAllUser') ?>', 'g_status')">分组状态</td>
			<td onclick="ajax_handle_avg('<?php echo U('User/showAllUser') ?>', 'r_id')">权限ID</td>
			<td onclick="ajax_handle_avg('<?php echo U('User/showAllUser') ?>', 'r_name')">权限名</td>
			<td onclick="ajax_handle_avg('<?php echo U('User/showAllUser') ?>', 'r_function')">权限作用</td>
			<td onclick="ajax_handle_avg('<?php echo U('User/showAllUser') ?>', 'r_status')">权限状态</td>
			<td onclick="ajax_handle_avg('<?php echo U('User/showAllUser') ?>', 'r_condition')">规则</td>
		</tr>
	</thead>
	<tbody>
		<?php foreach( $result as $value ) : ?>
		<tr>
			<td class="user"><?php handleUser($value['u_id']);?></td>
			<td class="user"><?php handleUser($value['u_name']);?></td>
			<td class="user"><?php handleUser($value['u_sex']);?></td>
			<td class="user"><?php handleUser($value['u_local']);?></td>
			<td class="user"><?php handleUser($value['u_age']);?></td>
			<td class="group"><?php handleUser($value['g_id']);?></td>
			<td class="group"><?php handleUser($value['g_title']);?></td>
			<td class="group"><?php handleUser($value['g_status']);?></td>
			<td class="rule"><?php handleUser($value['r_id']);?></td>
			<td class="rule"><?php handleUser($value['r_name']);?></td>
			<td class="rule"><?php handleUser($value['r_function']);?></td>
			<td class="rule"><?php handleUser($value['r_status']);?></td>
			<td class="rule"><?php handleUser($value['r_condition']);?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>