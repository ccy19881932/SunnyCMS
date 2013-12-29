<include file="Common:header"/>
<?php if (isset($message)): ?>
	<div class="success alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		恭喜，<?php echo $alert; ?>成功!
	</div>
<?php else: ?>
	<div class="error alert-error">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		不好意思,没有<?php echo $alert; ?>成功...
	</div>
<?php endif; ?>
<p class="jump">
页面自动 <a id="href" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait"><?php echo($waitSecond); ?></b>
</p>
</div>
<script type="text/javascript">
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time <= 0) {
		location.href = href;
		clearInterval(interval);
	};
}, 1000);
})();
</script>
</body>
<include file="Common:footer"/>
