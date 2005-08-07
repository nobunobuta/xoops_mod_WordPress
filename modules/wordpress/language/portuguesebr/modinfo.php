<?php //* Brazilian Portuguese Translation by Marcelo Yuji Himoro <www.yuji.eu.org> *//
if (!defined('WP_LANGUAGE_XOOPS_MODINFO_READ')) {
define ('WP_LANGUAGE_XOOPS_MODINFO_READ','1');
// Module Info

// The name of this module
define("_MI_WORDPRESS_NAME","WordPress%s");

// A brief description of this module
define("_MI_WORDPRESS_DESC","M�dulo do WordPress ME para XOOPS.");
define("_MI_WORDPRESS_AUTHOR",'<a href="http://www.kowa.org/" target="_blank">nobunobu</a>');

// Sub menu titles
define("_MI_WORDPRESS_SMNAME1","Postar no blog");
define("_MI_WORDPRESS_SMNAME2","Archive");
// Sample Blog Message
define("_MI_WORDPRESS_INST_POST_CONTENT","'Parab�ns por instalar o WordPress ME para Xoops2.<br />Este � o primeiro post. Edite ou apague-o, e comece a bloggar!'");
define("_MI_WORDPRESS_INST_POST_TITLE","'Bem-vindo ao mundo de WordPress!'");
// Sample Comment
define("_MI_WORDPRESS_INST_COMMENT_CONTENT"," 'Este � um exemplo de coment�rio. <br />Para apagar um coment�rio, basta identificar-se e ver os coment�rios do post, onde haver� uma op��o para editar ou apag�-los.'");
// WordPress Date & Time Format
define("_MI_WORDPRESS_INST_OPTIONS_22","'pt_BR'");
define("_MI_WORDPRESS_INST_OPTIONS_52","'l, j \\de F \\de Y'");
define("_MI_WORDPRESS_INST_OPTIONS_53","'H:i.s'");
// Config titles
define("_MI_WPUSESPAW_CFG_MSG","Select WYSIWYG Editor");
define("_MI_WPUSESPAW_CFG_DESC","Select WYSIWYG Editor");
define("_MI_OPT_WYSIWYG_NONE","None");
define("_MI_OPT_WYSIWYG_SPAW","SPAW Editor");
define("_MI_OPT_WYSIWYG_KOIVI","KOIVI Editor");

define("_MI_WPEDITAUTHGRP_CFG_MSG","Grupo de editores:");
define("_MI_WPEDITAUTHGRP_CFG_DESC","O(s) grupo(s) que t�m autoriza��o para editar e fazer posts (N�vel 1 de usu�rio do WordPress).");

define("_MI_WPADMINAUTHGRP_CFG_MSG","Grupo de administradores:");
define("_MI_WPADMINAUTHGRP_CFG_DESC","O(s) grupo(s) que t�m autoriza��o para alterar as configura��es (N�vel 10 de usu�rio do WordPress).");

define("_MI_WP_USE_XOOPS_SMILE","Usar os smilies padr�o do XOOPS?");
define("_MI_WP_USE_XOOPS_SMILE_DESC","Se ativado, os smilies ser�o trocados pelos usados no XOOPS.");

define("_MI_WP_USE_THEME_TEMPLATE","Usar o template no diret�rio de temas quando exibir um bloco do blog?");
define("_MI_WP_USE_THEME_TEMPLATE_DESC","Se ativado, o template (content_block-template.php) existente no diret�rio \"themes\" ser� usado.");

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
define("_MI_WORDPRESS_BNAME1","Calend�rio%s do WordPress");
define("_MI_WORDPRESS_BDESC1","Calend�rio do WordPress");

define("_MI_WORDPRESS_BNAME2","Arquivos mensais do WordPress%s");
define("_MI_WORDPRESS_BDESC2","Arquivos mensais do WordPress");

define("_MI_WORDPRESS_BNAME3","Lista de categorias do WordPress%s");
define("_MI_WORDPRESS_BDESC3","Lista de categorias do WordPress");

define("_MI_WORDPRESS_BNAME4","Links do WordPress%s");
define("_MI_WORDPRESS_BDESC4","Links do WordPress");

define("_MI_WORDPRESS_BNAME5","Pesquisa no WordPress%s");
define("_MI_WORDPRESS_BDESC5","Pesquisa no WordPress");

define("_MI_WORDPRESS_BNAME6","�ltimos posts no WordPress%s");
define("_MI_WORDPRESS_BDESC6","�ltimos posts no WordPress");

define("_MI_WORDPRESS_BNAME7","�ltimos coment�rios no WordPress%s");
define("_MI_WORDPRESS_BDESC7","�ltimos coment�rios no WordPress");

define("_MI_WORDPRESS_BNAME8","�ltimo post do WordPress%s");
define("_MI_WORDPRESS_BDESC8","�ltimo post do WordPress");

define("_MI_WORDPRESS_BNAME9","Autores do blog WordPress%");
define("_MI_WORDPRESS_BDESC9","Autores do blog WordPress");

define("_MI_WORDPRESS_AD_MENU1","Configura��es do WordPress");
define("_MI_WORDPRESS_AD_MENU2","Permiss�es de acesso dos blocos");
}
?>