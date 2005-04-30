<?php
if( ! defined( 'WP_TEMPLATE_FUNCTIONS_INCLUDED' ) ) {
	define( 'WP_TEMPLATE_FUNCTIONS_INCLUDED' , 1 ) ;
/***** About-the-blog tags *****/
require_once(wp_base().'/wp-includes/template-functions-general.php');

/***** Links *****/
require_once(wp_base().'/wp-includes/template-functions-links.php');

/**** // Geo Tags ****/
require_once(wp_base().'/wp-includes/template-functions-geo.php');

/***** Author tags *****/
require_once(wp_base().'/wp-includes/template-functions-author.php');

/***** Post tags *****/
require_once(wp_base().'/wp-includes/template-functions-post.php');

/***** Category tags *****/
require_once(wp_base().'/wp-includes/template-functions-category.php');

/***** Comment tags *****/
require_once(wp_base().'/wp-includes/template-functions-comment.php');
}
?>