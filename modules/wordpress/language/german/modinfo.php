<?php
if (!defined('WP_LANGUAGE_XOOPS_MODINFO_READ')) {
define ('WP_LANGUAGE_XOOPS_MODINFO_READ','1');
// Module Info

// The name of this module
define("_MI_WORDPRESS_NAME","WordPress%s");

// A brief description of this module
define("_MI_WORDPRESS_DESC","XOOPS Module of WordPress.");
define("_MI_WORDPRESS_AUTHOR",'<a href="http://www.kowa.org/" target="_blank">nobunobu</a>');

// Sub menu titles
define("_MI_WORDPRESS_SMNAME1","Blog senden");
// Sample Blog Message
define("_MI_WORDPRESS_INST_POST_CONTENT","'Welcome to WordPress. This is the first post. Edit or delete it, then start blogging!'");
define("_MI_WORDPRESS_INST_POST_TITLE","'Hello world!'");
// Sample Comment
define("_MI_WORDPRESS_INST_COMMENT_CONTENT"," 'Hi, this is a comment.<br />To delete a comment, just log in, and view the posts\' comments, there you will have the option to edit or delete them.'");
// WordPress OptionTable Values
define("_MI_WORDPRESS_INST_OPTIONS_22","'de'");
define("_MI_WORDPRESS_INST_OPTIONS_52","'n/j/Y'");
define("_MI_WORDPRESS_INST_OPTIONS_53","'g:i a'");
// Config titles
define("_MI_WPUSESPAW_CFG_MSG","SPAW Editor verwenden");
define("_MI_WPUSESPAW_CFG_DESC","SPAW Editor verwenden");

define("_MI_WPEDITAUTHGRP_CFG_MSG","Editor Gruppen");
define("_MI_WPEDITAUTHGRP_CFG_DESC","Gruppen auswählen, die sofort posten und modifizieren dürfen.<br/>(WordPress User level 1)");

define("_MI_WPADMINAUTHGRP_CFG_MSG","Administratoren Gruppe");
define("_MI_WPADMINAUTHGRP_CFG_DESC","Gruppen auswählen, die WordPress Einstellungen modifizieren dürfen.<br/>(WordPress User level 10)");

define("_MI_WP_USE_XOOPS_SMILE","Nutze XOOPS Default Smilies");
define("_MI_WP_USE_XOOPS_SMILE_DESC","Wordpress verwendet die XOOPS Smilies anstatt der eigenen.");

define("_MI_WP_USE_THEME_TEMPLATE","Use Template file under theme directory, when display content XOOPS block.");
define("_MI_WP_USE_THEME_TEMPLATE_DESC","Use Template file(content_block-template.php) under theme directory, when display content XOOPS block.");
// Block Name
define("_MI_WORDPRESS_BNAME1","WordPress%s Kalender");
define("_MI_WORDPRESS_BDESC1","WordPress Kalender");

define("_MI_WORDPRESS_BNAME2","WordPress%s Monatsarchiv");
define("_MI_WORDPRESS_BDESC2","WordPress Monatsarchiv");

define("_MI_WORDPRESS_BNAME3","WordPress%s Kategorie Listing");
define("_MI_WORDPRESS_BDESC3","WordPress Kategorie Listing");

define("_MI_WORDPRESS_BNAME4","WordPress%s Link Listing");
define("_MI_WORDPRESS_BDESC4","WordPress Link Listing");

define("_MI_WORDPRESS_BNAME5","WordPress%s Blog Suche");
define("_MI_WORDPRESS_BDESC5","WordPress Blog Suche");

define("_MI_WORDPRESS_BNAME6","WordPress%s aktuelle Posts");
define("_MI_WORDPRESS_BDESC6","WordPress aktuelle Posts");

define("_MI_WORDPRESS_BNAME7","WordPress%s aktuelle Kommentare");
define("_MI_WORDPRESS_BDESC7","WordPress aktuelle Kommentare");

define("_MI_WORDPRESS_BNAME8","WordPress%s Inhalt");
define("_MI_WORDPRESS_BDESC8","WordPress Inhalt");

define("_MI_WORDPRESS_BNAME9","WordPress%s Authors");
define("_MI_WORDPRESS_BDESC9","WordPress Authors");

define("_MI_WORDPRESS_AD_MENU1","WordPress Option");
define("_MI_WORDPRESS_AD_MENU2","Blocks/Groups");
}
?>
