<?php
error_reporting(E_ERROR);
$blog = 1;
$doing_rss = 1;
$wp_inblock = 0;
require("wp-config.php");
param('feed','string','rss2');
param('p','string','');
param('name','string','');
param('withcomments','integer',0);

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
    case 'feed':
        require('wp-rss2.php');
        break;
    }
}
?>
