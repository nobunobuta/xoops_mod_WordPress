<?php
error_reporting(E_ERROR);
$blog = 1;
$doing_rss = 1;
//require('wp-blog-header.php');
$feed=$_GET['feed'];
$p=$_GET['p'];
$name=$_GET['name'];
$withcomments=$_GET['withcomments'];

if ($feed == '' || $feed == 'feed') {
    // TODO:  Get default feed from options DB.
    $feed = 'rss2';
}

if ( (($p != '') && ($p != 'all')) || ($name != '') || ($withcomments == 1) ) {
    require('wp-commentsrss2.php');
} else {
    switch ($feed) {
    case 'atom':
        require('wp-atom.php');
        break;
    case 'rdf':
        require('wp-rdf.php');
        break;
    case 'rss':
        require('wp-rss.php');
        break;
    case 'rss2':
        require('wp-rss2.php');
        break;
    }
}

?>
