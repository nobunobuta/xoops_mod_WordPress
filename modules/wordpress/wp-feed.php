<?php
error_reporting(E_ERROR);
$GLOBALS['blog'] = 1;
$GLOBALS['doing_rss'] = 1;
$GLOBALS['wp_inblock'] = 0;

require_once('wp-config.php');

init_param('GET', 'feed','string','rss2');
init_param('GET', 'p','string','');
init_param('GET', 'name','string','');
init_param('GET', 'withcomments','integer',0);

if ( (test_param('p') && ($p != 'all')) || test_param('name') || (get_param('withcomments') == 1) ) {
    require('wp-commentsrss2.php');
} else {
    switch (get_param('feed')) {
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
