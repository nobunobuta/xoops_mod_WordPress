<?php
include ('../wp-config.php');
error_reporting(E_ERROR);
$bookmarklet_height= (get_settings('use_trackback')) ? 550 : 520;
if ($wp_use_spaw) {
	$range_text = "htmlText";
} else {
	$range_text = "text";
}
echo <<<EOD
<script type="text/javascript" defer>
<!--
doc=external.menuArguments.document;
Q=doc.selection.createRange().$range_text;
void(btw=window.open('$siteurl/wp-admin/bookmarklet.php?text='+escape(Q)+'&popupurl='+escape(external.menuArguments.location.href)+'&popuptitle='+escape(doc.title),'bookmarklet','scrollbars=yes,width=600,height=$bookmarklet_height,left=100,top=50,status=yes'));
btw.focus();
//-->
</script>
EOD;
