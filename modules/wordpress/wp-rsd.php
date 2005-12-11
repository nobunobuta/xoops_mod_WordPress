<?php
$blog = 1; // enter your blog's ID
require_once(dirname(__FILE__).'/wp-config.php');
if(!get_settings('xmlrpc_autodetect')) {
	@header('HTTP/1.x 404 Not Found');
	echo ("404 Not Found");
	exit();
}
error_reporting(E_ERROR);
static_content_header(filemtime(__FILE__));
header('Content-type: text/xml', true);
echo '<?xml version="1.0"?>'; 
?>
<!-- generator="wordpress/<?php echo $wp_version ?>" -->
<rsd version="1.0" xmlns="http://archipelago.phrasewise.com/rsd">
  <service>
    <engineName>WordPress for XOOPS</engineName> 
    <engineLink>http://www.kowa.org/</engineLink>
    <homePageLink><?php bloginfo_rss('url') ?></homePageLink>
    <apis>
      <api name="MetaWeblog" preferred="true" apiLink="<?php echo wp_siteurl().'/'.get_settings('xmlrpc_filename'); ?>" blogID="<?php echo $blog; ?>" />
      <api name="Blogger" preferred="true" apiLink="<?php echo wp_siteurl().'/'.get_settings('xmlrpc_filename'); ?>" blogID="<?php echo $blog; ?>" />
    </apis>
  </service>
</rsd>
