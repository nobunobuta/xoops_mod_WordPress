<?php
header('Content-type: text/xml', true);
$blog = 1; // enter your blog's ID
$doing_rss = 1;
include_once (dirname(__FILE__)."/../../mainfile.php");
require('wp-blog-header.php');
echo '<?xml version="1.0"?>'; 
?>
<!-- generator="wordpress/<?php echo $wp_version ?>" -->
<rsd version="1.0" xmlns="http://archipelago.phrasewise.com/rsd">
  <service>
    <engineName>WordPress ME</engineName> 
    <engineLink>http://wordpress.xwd.jp/</engineLink>
    <homePageLink><?php bloginfo_rss("url") ?></homePageLink>
    <apis>
      <api name="MetaWeblog" preferred="true" apiLink="<?php echo $siteurl; ?>/xmlrpc.php" blogID="<?php echo $blog; ?>" />
      <api name="Blogger" preferred="true" apiLink="<?php echo $siteurl; ?>/xmlrpc.php" blogID="<?php echo $blog; ?>" />
    </apis>
  </service>
</rsd>
