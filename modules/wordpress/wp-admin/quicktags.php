<?php 
    foreach($wpsmiliestrans[$wp_id] as $smiley => $img) 
    { 
        print '<a href="javascript:bbinsert(document.post,\'\',\''.str_replace("'","\'",$smiley).'\')"><img src="' . $smilies_directory . '/'. $img . '" alt="' . $smiley . '" /></a> '; 
    } 
echo "<br />"; 
?>
<script src="quicktags.js" language="JavaScript" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript">edToolbar();</script>