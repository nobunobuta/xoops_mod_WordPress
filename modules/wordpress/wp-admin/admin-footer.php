

<p align="center" style="width: 100%" class="tabletoprow"><strong><a href="http://wordpress.xwd.jp/">WordPress <?php echo $wp_version ?></a></strong> - <a href="http://phpbb.xwd.jp/">Forum</a> <a href="http://detlog.org/document/docs.htm">Document</a> <a href="http://tekapo.com/wp_docs/readme_jp.html">Readme</a> / 
<?php
	echo number_format(timer_stop(), 2)." seconds";
?>
</p>
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
