

<p align="center" style="width: 100%" class="tabletoprow"><strong><a href="http://wordpress.xwd.jp/">WordPress </a><a href="http://www.kowa.org/"><?php echo $wp_version ?></a></strong> -  <a href="http://wordpress.xwd.jp/wiki/">Document</a> <a href="../wp-readme/">Readme</a> / 
<?php
	echo number_format(timer_stop(), 2)." seconds";
?>
</p>
<?php do_action('admin_footer', ''); ?>
</div>
<?php
if ($standalone == 0) {
	if ($profile == 0) {
		include(XOOPS_ROOT_PATH.'/footer.php');
	}
} else {
?>
</body>
</html>
<?php
}
?>
