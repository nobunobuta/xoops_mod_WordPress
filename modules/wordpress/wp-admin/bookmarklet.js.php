<?php
$url = 'http://'.$_SERVER["SERVER_NAME"];
$url .= ($_SERVER["SERVER_PORT"]==80) ? '' : ':'.$_SERVER["SERVER_PORT"];
$url .= dirname($_SERVER["REQUEST_URI"]) . "/bookmarklet.php";
echo <<<EOD
<script type="text/javascript" defer>
<!--
doc=external.menuArguments.document;
Q=doc.selection.createRange().text;
void(btw=window.open('$url?text='+escape(Q)+'&trackback=1&pingback=1&popupurl='+escape(external.menuArguments.location.href)+'&popuptitle='+escape(doc.title),'bookmarklet','scrollbars=no,width=480,height=550,status=yes'));
btw.focus();
//-->
</script>
EOD;
