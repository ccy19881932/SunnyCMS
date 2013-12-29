<style>
.wp-list-table{
	background: none repeat scroll 0 0 #FFFFFF;
	border: 1px solid #E5E5E5;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.04);
    table-layout: fixed;
    border-spacing: 0;
    clear: both;
    margin: 0;
    width: 100%;
}
.wp-list-table tr {
	background-color: #F9F9F9;
	vertical-align: top;
    width: 2.2em;
    border-bottom: 1px solid #E1E1E1;
}
.wp-list-table tr td{
	padding-right:5px;
	height:25px;
	line-height:25px;
	overflow:hidden; 
}
.widefat td, .widefat th {
    padding: 8px 10px 8px 0;
}
.widefat thead th.check-column {
    padding-top: 10px;
    padding-left:10px;
}
.widefat tbody th {
    padding-left:10px;
}
.widefat tfoot th input{
    margin-left:10px;
}
.widefat .check-column {
    padding: 10px 0 10px;
    vertical-align: top;
}
.widefat th {
    font-weight: 400;
    text-align: left;
}
.widefat th, .widefat td {
    overflow: hidden;
}
.widefat td {
    font-size: 12px;
}
.widefat td a{
    font-size: 14px;
}
.widefat thead th.column-cb {
	width:5%;
}
.widefat thead th.table_title {
	width:30%;
}
.widefat thead th.table_auth {
	width:15%;
}
.widefat thead th.table_cat {
	width:20%;
}
.widefat thead th.table_tag {
	width:10%;
}
.widefat thead th.table_date {
	width:20%;
}
.widefat thead th.table_status {
	width:5%;
}
</style>
<!-- <table class="table table-condensed"> -->
<table class="wp-list-table widefat" cellspacing="0">
	<caption><?php echo $contents; ?></caption>
	<thead>
		<tr>
			<th class="manage-column column-cb check-column"><input id="cb-select-all-1" type="checkbox"></th>
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
			<th><input id="cb-select-all-2" type="checkbox"></th>
			<th class="manage-column table_title">标题</th>
			<th class="manage-column table_auth">作者</th>
			<th class="manage-column table_cat">分类目录</th>
			<th class="manage-column table_tag">标签</th>
			<th class="manage-column table_date">日期</th>
			<th class="manage-column table_status">状态</th>
		</tr>
	</tfoot>
	<tbody>
		<?php if(!empty($result)):
			 foreach ($result as $key => $value) : ?>
			<tr>
				<th><input id="<?php echo 'cb-select-'.($key+3); ?>" type="checkbox"></th>
				<td class="manage-column table_title"><?php echo $value['post_title']; ?></td>	
				<td class="manage-column table_auth"><?php echo $value['user_name']; ?></td>	
				<td class="manage-column table_cat">
					<?php foreach ($value['group'] as $k => $v) : ?>			
							<?php if( $v['term_type'] == 1 ){
								echo $v['term_name'].' ';
							} ?>	
					<?php endforeach; ?>
				</td>
				<td class="manage-column table_tag">
					<?php foreach ($value['group'] as $k => $v) : ?>
						<?php if( $v['term_type'] == 2 ){
							echo !empty($v['term_name']) ? $v['term_name'].' ' : '--';
						} ?>
					<?php endforeach; ?>
				</td>
				<td class="manage-column table_date">
					<?php echo '发布: '.$value['post_date']."<br>更新: ".$value['modify_date']; ?>
				</td>
				<td class="manage-column table_status">
					<?php if($value['post_status'] == 1) {
						echo '已发布';
					} elseif($value['post_status'] == 2) {
						echo '私人收藏';
					} ?>
				</td>
			</tr>
		<?php 
				endforeach; 
			else:
				echo "<tr><th></th><td>未找到文章</td></tr>";
			endif;
		?>
	</tbody>
</table>



