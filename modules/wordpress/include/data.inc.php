<?php
//================================================================
// get aritciles from module
// http://linux.ohwada.net/
// 2003.12.20 K.OHWADA
//================================================================
function wordpress_new($limit=0, $offset=0)
{
global $xoopsDB;

$sql = "SELECT ID, post_title, post_content, post_date FROM ".$xoopsDB->prefix("wp_posts")." ORDER BY post_date DESC";
$result = $xoopsDB->query($sql,$limit,$offset);

$i = 0;
$ret = array();

while($myrow = $xoopsDB->fetchArray($result))
{

$ret[$i]['link'] = XOOPS_URL."modules/wordpress/index.php?p=".$myrow['ID']."";
$ret[$i]['title'] = $myrow['post_title'];
$dt = $myrow['post_date'];
$ret[$i]['time'] = mktime(substr($dt,11,2),substr($dt,14,2),substr($dt,17,2),substr($dt,5,2),substr($dt,8,2),substr($dt,0,4));

$ret[$i]['description'] = $myrow['post_content'];
$i++;
}

return $ret;
}

function wordpress_num()
{
global $xoopsDB;

$sql = "SELECT count(*) FROM ".$xoopsDB->prefix("wp_posts")." ORDER BY ID";
$array = $xoopsDB->fetchRow( $xoopsDB->query($sql) );
$num = $array[0];
if (empty($num)) $num = 0;

return $num;
}

function wordpress_data($limit=0, $offset=0)
{
global $xoopsDB;

$sql = "SELECT ID, post_title, post_date FROM ".$xoopsDB->prefix("wp_posts")." ORDER BY ID";
$result = $xoopsDB->query($sql,$limit,$offset);

$i = 0;
$ret = array();

while($myrow = $xoopsDB->fetchArray($result))
{
$id = $myrow['ID'];
$ret[$i]['id'] = $id;
$ret[$i]['link'] = XOOPS_URL."/modules/wordpress/index.php?p=".$id."";
$ret[$i]['title'] = $myrow['post_title'];
$dt = $myrow['post_date'];
$ret[$i]['time'] = mktime(substr($dt,11,2),substr($dt,14,2),substr($dt,17,2),substr($dt,5,2),substr($dt,8,2),substr($dt,0,4));

$i++;
}

return $ret;
}
?>
