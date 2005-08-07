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
define("_MI_WORDPRESS_SMNAME1","Aggiungi un Blog");
define("_MI_WORDPRESS_SMNAME2","Archive");
// Sample Blog Message
define("_MI_WORDPRESS_INST_POST_CONTENT","'Benvenuto nel Blog. Questo è il tuo primo post. Puoi fare Modifiche o Cancellare. Poi inizia il tuo Blog!'");
define("_MI_WORDPRESS_INST_POST_TITLE","'Salve a Tutti!'");
// Sample Comment
define("_MI_WORDPRESS_INST_COMMENT_CONTENT"," 'Ciao, Questo e' un commento.<br />Per cancellare un commento, entra con il tuo nome utente sotto il Messaggio da commentare. Hai anche la possibilità di modificare o cancellare i tuoi commenti.'");
// WordPress OptionTable Values
define("_MI_WORDPRESS_INST_OPTIONS_22","'it'");
define("_MI_WORDPRESS_INST_OPTIONS_52","'n/j/Y'");
define("_MI_WORDPRESS_INST_OPTIONS_53","'g:i a'");
// Config titles
define("_MI_WPUSESPAW_CFG_MSG","Select WYSIWYG Editor");
define("_MI_WPUSESPAW_CFG_DESC","Select WYSIWYG Editor");
define("_MI_OPT_WYSIWYG_NONE","None");
define("_MI_OPT_WYSIWYG_SPAW","SPAW Editor");
define("_MI_OPT_WYSIWYG_KOIVI","KOIVI Editor");


define("_MI_WPEDITAUTHGRP_CFG_MSG","Edita gruppi");
define("_MI_WPEDITAUTHGRP_CFG_DESC","Seleziona i gruppi che possono postare ed editare.<br/>(Utenti Livello 1)");

define("_MI_WPADMINAUTHGRP_CFG_MSG","Amministra i gruppi");
define("_MI_WPADMINAUTHGRP_CFG_DESC","Seleziona i gruppi che posso cambiare le Opzioni del Blog.<br/>(Utenti Livello 10)");

define("_MI_WP_USE_XOOPS_SMILE","Usa le XOOPS Faccine");
define("_MI_WP_USE_XOOPS_SMILE_DESC","Faccine");

define("_MI_WP_USE_THEME_TEMPLATE","Scegli il Template per visualizzare i blocchi.");
define("_MI_WP_USE_THEME_TEMPLATE_DESC","Scegli il Template per visualizzare i contenuti.");

define("_MI_WP_USE_BLOCKCSSHEADER","Use CSS link Tag for Wordpress Style");
define("_MI_WP_USE_BLOCKCSSHEADER_DESC",'Use CSS link Tag for Wordpress Style in the HTML &lt;HEAD&gt; section.<br/>You must insert <b>&lt;{$xoops_block_header}&gt;</b> line at next line <b>&lt;{$xoops_module_header}&gt;</b> in theme.html of your XOOPS Theme.<br />Another way, you can use <b>&lt;{$xoops_themecss}&gt;</b>, if this variable is used with same format in default template');
define('_MI_OPT_BLOCKCSSHEADER_NONE', 'No');
define('_MI_OPT_BLOCKCSSHEADER_YES', 'Using &lt;{$xoops_block_header}&gt;');
define('_MI_OPT_BLOCKCSSHEADER_HACK', 'Using &lt;{$xoops_themecss}&gt;');

define("_MI_WP_USE_XOOPS_COMM","Using XOOPS Comment System");
define("_MI_WP_USE_XOOPS_COMM_DESC","Using XOOPS Comment System");

define("_MI_WP_SHOW_ARCHIVE_MENU","Show \"Archive\" Submenu");
define("_MI_WP_SHOW_ARCHIVE_MENU_DESC","Show \"Archive\" Submenu");

define("_MI_WP_USE_KAKASI","Use Kakasi with Archive Listing");
define("_MI_WP_USE_KAKASI_DESC","Only for Japanese Blog Title sorting");

define("_MI_WP_KAKASI_PATH","Path for kakasi");
define("_MI_WP_KAKASI_PATH_DESC","Only for Japanese Blog Title sorting");

define("_MI_WP_KAKASI_CHARSET","Charset of kakasi");
define("_MI_WP_KAKASI_CHARSET_DESC","Only for Japanese Blog Title sorting");

// Block Name
define("_MI_WORDPRESS_BNAME1","Calendario");
define("_MI_WORDPRESS_BDESC1","Calendario Blog");

define("_MI_WORDPRESS_BNAME2","Archivio");
define("_MI_WORDPRESS_BDESC2","Archivi per Mensilità");

define("_MI_WORDPRESS_BNAME3","Categorie");
define("_MI_WORDPRESS_BDESC3","Lista delle Categorie del Blog");

define("_MI_WORDPRESS_BNAME4","Links");
define("_MI_WORDPRESS_BDESC4","Lista dei Link esterni");

define("_MI_WORDPRESS_BNAME5","Ricerche");
define("_MI_WORDPRESS_BDESC5","Ricerche nel Blog");

define("_MI_WORDPRESS_BNAME6","Messaggi");
define("_MI_WORDPRESS_BDESC6","Messaggi Recenti");

define("_MI_WORDPRESS_BNAME7","Commenti");
define("_MI_WORDPRESS_BDESC7","Commenti recenti");

define("_MI_WORDPRESS_BNAME8","Contenuto");
define("_MI_WORDPRESS_BDESC8","Contenuto del Blog");

define("_MI_WORDPRESS_BNAME9","Autori");
define("_MI_WORDPRESS_BDESC9","Autori del Blog");

define("_MI_WORDPRESS_AD_MENU1","Opzioni");
define("_MI_WORDPRESS_AD_MENU2","Blocchi/Gruppi");
}
?>
