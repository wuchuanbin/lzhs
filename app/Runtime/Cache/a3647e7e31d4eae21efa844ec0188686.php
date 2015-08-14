<?php if (!defined('THINK_PATH')) exit();?><body style='background-color:#B0E0E6;'>
<div style="margin:120 150 0 150;">
	<div style='height:80px; line-height:80px; font-size:45px; color:red; text-align:center;'><?php echo ($title); ?></div>
	<div style='height:60px; line-height:60px; font-size:18px;  text-align:center;'><?php echo ($message); ?></div>
	<div style='height:60px;font-size:12px;  text-align:center; color:gray;'>
		您访问的页面将在2秒后自动跳转，您也可以直接点击跳转！
		<a href='<?php echo ($jumpUrl); ?>'>点击跳转</a>
	</div>
</div>
</body>
<script>
	setTimeout(function(){window.location.href='<?php echo ($jumpUrl); ?>';} , 2000);
</script>