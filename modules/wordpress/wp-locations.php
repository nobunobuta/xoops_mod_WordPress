<?php
$GLOBALS['blog'] = 1;
$GLOBALS['doing_rss'] = 1;
require(dirname(__FILE__).'/wp-config.php');
error_reporting(E_ERROR);
init_param('GET', 'num','integer');
if (test_param('num')) $GLOBALS['showposts'] = get_param('num');
require('wp-blog-header.php');
header('Content-type: text/xml');
?>
<?php echo '<?xml version="1.0" encoding="'.wp_get_rss_charset().'"?'.'>'; ?>
<travels>
<?php
$_start = count($GLOBALS['posts'])-1;
for ($_i = $_start; $_i >= 0; $_i--) {
    $GLOBALS['post'] = $GLOBALS['posts'][$_i];
    start_wp();
    if ((get_Lon() != "") && (get_Lon() != null) && (get_Lon() > -360) && (get_Lon() < 360 )) {
?>
    <location arrival="<?php the_date_xml() ?>">
        <name><?php the_title_rss() ?></name>
        <latitude><?php print_Lat(true) ?></latitude>
        <longitude><?php print_Lon(true) ?></longitude>
<?php
        $GLOBALS['more'] = 1;
        if (get_settings('rss_use_excerpt')) {
?>
        <note><?php the_excerpt_rss(get_settings('rss_excerpt_length'), get_settings('rss_encoded_html')) ?></note>
<?php
        } else { // use content
?>
        <note><?php the_content_rss('', 0, '', get_settings('rss_excerpt_length'), get_settings('rss_encoded_html')) ?></note>
<?php
        } // end else use content
?>
        <url><?php permalink_single_rss() ?></url>
    </location>
<?php
    } // end if lon valid
?>
<?php
} // end loop
?>
</travels>
