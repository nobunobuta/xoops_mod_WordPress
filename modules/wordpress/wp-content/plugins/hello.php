<?php
/*
Plugin Name: Hello Dolly
Plugin URI: http://wordpress.org/#
Description:_LANG_PG_HELLO_DOLLY
Author: Matt Mullenweg
Author URI: http://photomatt.net/
*/ 

// These are the lyrics to Hello Dolly
$lyrics = "Hello, Dolly
Well, hello, Dolly
It's so nice to have you back where you belong
You're lookin' swell, Dolly
I can tell, Dolly
You're still glowin', you're still crowin'
You're still goin' strong
We feel the room swayin'
While the band's playin'
One of your old favourite songs from way back when
So, take her wrap, fellas
Find her an empty lap, fellas
Dolly'll never go away again
Hello, Dolly
Well, hello, Dolly
It's so nice to have you back where you belong
You're lookin' swell, Dolly
I can tell, Dolly
You're still glowin', you're still crowin'
You're still goin' strong
We feel the room swayin'
While the band's playin'
One of your old favourite songs from way back when
Golly, gee, fellas
Find her a vacant knee, fellas
Dolly'll never go away
Dolly'll never go away
Dolly'll never go away again";

// Here we split it into lines
$lyrics = explode("\n", $lyrics);
// And then randomly choose a line
global $chosen;
$chosen = wptexturize( $lyrics[ mt_rand(0, count($lyrics) ) ] );

// Now we set that function up to execute when the admin_footer action is called
add_action('admin_footer', 'hello_dolly');

if (!defined('WP_PLUGIN_HELLO')) {
define('WP_PLUGIN_HELLO',1);
// This just echoes the chosen line, we'll position it later
function hello_dolly() {
	global $chosen;
	echo "<p id='dolly'>$chosen</p>";
}
// We need some CSS to position the paragraph
function dolly_css() {
	echo "
	<style type='text/css'>
	#dolly {
		position: absolute;
		top: 5px;
margin: 0; padding: 0;
		right: 3em;
		font-size: 20px;
		color: #666;
	}
	</style>
	";
}
}
add_action('admin_head', 'dolly_css');

?>