<?php
global $blog_charset;
$blog_charset = 'iso-8859-1';
if (!defined('WP_LANGUAGE_FILE_READ')) {
define ('WP_LANGUAGE_FILE_READ','1');
/* This is Multilingual correspondence file */

/* Copylight 2004 -----------------------
Author : Otsukare
URL : http://wordpress.xwd.jp/
-------------------------------------- */
/* File Name wp-settings.php */
define('_LANG_WA_SETTING_GUIDE','<p>It doesn\'t look like you\'ve installed WP yet. Try running <a href=\'wp-admin/install.php\'>install.php</a>.</p>');

/* File Name wp-blog-header.php */
define('_LANG_WA_HEADER_GUIDE1','<p>There doesn\'t seem to be a <code>wp-config.php</code> file. I need this before we can get started. Need more help? <a href=\'http://wordpress.org/docs/faq/#wp-config\'>We got it</a>. You can <a href=\'wp-admin/install-config.php\'>create a <code>wp-config.php</code> file through a web interface</a>, but this doesn\'t work for all server setups. The safest way is to manually create the file.</p>');

/* File Name wp-admin/install-config.php */
define('_LANG_WA_CONFIG_GUIDE1','<p>The file \'wp-config.php\' already exists. If you need to reset any of the configuration items in this file, please delete it first.</p>');
define('_LANG_WA_CONFIG_GUIDE2','<p>Sorry, I need a wp-config-sample.php file to work from. Please re-upload this file from your WordPress installation.<p>');
define('_LANG_WA_CONFIG_GUIDE3','<p>Sorry, I can\'t write to the directory. You\'ll have to either change the permissions on your WordPress directory or create your wp-config.php manually.</p>');
define('_LANG_WA_CONFIG_GUIDE4','Welcome to WordPress. Before getting started, we need some information on the database. You will need to know the following items before proceeding.');
define('_LANG_WA_CONFIG_DATABASE','Database name');
define('_LANG_WA_CONFIG_USERNAME','Database username');
define('_LANG_WA_CONFIG_PASSWORD','Database password');
define('_LANG_WA_CONFIG_LOCALHOST','Database host');
define('_LANG_WA_CONFIG_PREFIX','Table prefix');
define('_LANG_WA_CONFIG_GUIDE5','<strong>If for any reason this automatic file creation doens\'t work, don\'t worry. All this does is fill in the database information to a configuration file. You may also simply open <code>wp-config-sample.php</code> in a text editor, fill in your information, and save it as <code>wp-config.php</code>. </strong></p>
<p>In all likelyhood, these items were supplied to you by your ISP. If you do not have this information, then you will need to contact them before you can continue. If you&#8217;re all ready, <a href="install-config.php?step=1">let&#8217;s go</a>! ');
define('_LANG_WA_CONFIG_GUIDE6','Below you should enter your database connection details. If you\'re not sure about these, contact your host. ');
define('_LANG_WA_CONFIG_GUIDE7','<small>The name of the database you want to run WP in. </small>');
define('_LANG_WA_CONFIG_GUIDE8','<small>Your MySQL username</small>');
define('_LANG_WA_CONFIG_GUIDE9','<small>...and MySQL password.</small>');
define('_LANG_WA_CONFIG_GUIDE10','<small>99% chance you won\'t need to change this value.</small>');
define('_LANG_WA_CONFIG_GUIDE11','<small>If you want to run multiple WordPress installations in a single database, change this.</small>');
define('_LANG_WA_CONFIG_GUIDE12','All right sparky! You\'ve made it through this part of the installation. WordPress can now communicate with your database. If you are ready, time now to <a href="install.php">run the install!</a>');


/* File Name wp-include/wp-db.php */
define('_LANG_WA_WPDB_GUIDE1','<strong>Error establishing a database connection!</strong> This probably means that the connection information in youn <code>wp-config.php</code> file is incorrect. Double check it and try again.');
define('_LANG_WA_WPDB_GUIDE2','Are you sure you have the correct user/password?');
define('_LANG_WA_WPDB_GUIDE3','Are you sure that you have typed the correct hostname?');
define('_LANG_WA_WPDB_GUIDE4','Are you sure that the database server is running?');

/* File Name wp-include/functions.php */
define('_LANG_F_TIMESTAMP','Edit timestamp');
define('_LANG_F_NEW_COMMENT','New comment on your post');
define('_LANG_F_ALL_COMMENTS','You can see all comments on this post here:');
define('_LANG_F_NEW_TRACKBACK','New trackback on your post');
define('_LANG_F_ALL_TRACKBACKS','You can see all trackbacks on this post here:');
define('_LANG_F_NEW_PINGBACK','New pingback on your post');
define('_LANG_F_ALL_PINGBACKS','You can see all pingbacks on this post here:');
define('_LANG_F_COMMENT_POST','A new comment on the post');
define('_LANG_F_WAITING_APPROVAL','is waiting for your approval');
define('_LANG_F_APPROVAL_VISIT','To approve this comment, visit:');
define('_LANG_F_DELETE_VISIT','To delete this comment, visit:');
define('_LANG_F_PLEASE_VISIT','Currently comments are waiting for approval. Please visit the moderation panel:');

/* File Name wp-register.php */
define('_LANG_R_ENTER_LOGIN','<strong>ERROR</strong>: Please enter a login.');
define('_LANG_R_PASS_TWICE','<strong>ERROR</strong>: Please enter your password twice.');
define('_LANG_R_SAME_PASS','<strong>ERROR</strong>: Please type the same password in the two password fields.');
define('_LANG_R_MAIL_ADDRESS','<strong>ERROR</strong>: Please type your e-mail address.');
define('_LANG_R_ADDRESS_CORRECT','<strong>ERROR</strong>: The email address isn&#8217;t correct.');
define('_LANG_R_CHOOSE_ANOTHER','<strong>ERROR</strong>: This login is already registered, please choose another one.');
define('_LANG_R_REGISTER_CONTACT','<strong>ERROR</strong>: Couldn&#8217;t register you... please contact the webmaster !');
define('_LANG_R_USER_REGISTRATION','New user registration on your blog');
define('_LANG_R_MAIL_REGISTRATION','New User Registration');
define('_LANG_R_R_COMPLETE','Registration Complete');
define('_LANG_R_R_DISABLED','Registration Disabled');
define('_LANG_R_R_CLOSED','User registration is currently not allowed.');
define('_LANG_R_R_REGISTRATION','Registration');
define('_LANG_R_USER_LOGIN','Login:');
define('_LANG_R_USER_PASSWORD','Password:');
define('_LANG_R_TWICE_PASSWORD','Twice:');
define('_LANG_R_USER_EMAIL','E-mail');

/* File Name wp-login.php */
define('_LANG_L_LOGIN_EMPTY','the login field is empty');
define('_LANG_L_PASS_EMPTY','the password field is empty');
define('_LANG_L_WRONG_LOGPASS','wrong login or password');
define('_LANG_L_RECEIVE_PASSWORD','Please enter your information here. We will send you a new password. ');
define('_LANG_L_EXIST_SORRY','Sorry, that user does not seem to exist in our database. Perhaps you have the wrong username or email address? <a href="wp-login.php?action=lostpassword">Try again</a>.');
define('_LANG_L_YOUR_LOGPASS','Your weblog&#8217;s login/password');
define('_LANG_L_NOT_SENT','The email could not be sent.');
define('_LANG_L_DISABLED_FUNC','Possible reason: your host may have disabled the mail() function...');
define('_LANG_L_SUCCESS_SEND',' : The email was sent successfully to email address.');
define('_LANG_L_CLICK_ENTER','Click here to login!');
define('_LANG_L_WRONG_SESSION','Error: wrong login/password');
define('_LANG_L_BACK_BLOG','Back to blog?');
define('_LANG_L_WP_RESIST','Register?');
define('_LANG_L_WPLOST_YOURPASS','Lost your password?');

/* File Name wp-admin/post.php */
define('_LANG_P_NEWCOMER_MESS','Since you&#8217;re a newcomer, you&#8217;ll have to wait for an admin to raise your level to 1, in order to be authorized to post.<br />You can also e-mail the admin to ask for a promotion.<br />When you&#8217;re promoted, just reload this page and you&#8217;ll be able to blog. :)');
define('_LANG_P_DATARIGHT_EDIT',' : You don&#8217;t have the right to edit posts.');
define('_LANG_P_DATARIGHT_DELETE',' : You don&#8217;t have the right to delete posts.');
define('_LANG_P_DATARIGHT_ERROR','Error in deleting... contact the webmaster.');
define('_LANG_P_OOPS_IDCOM','Oops, no comment with this ID.');
define('_LANG_P_OOPS_IDPOS','Oops, no post with this ID.');
define('_LANG_P_ABOUT_FOLLOW','You are about to delete the following comment:');
define('_LANG_P_SURE_THAT','Are you sure you want to do that?');
define('_LANG_P_NICKNAME_DELETE','You don&#8217;t have the right to delete post comments.');
define('_LANG_P_COMHAS_APPR','Comment has been approved.');
define('_LANG_P_YOUR_DRAFTS','Your Drafts:');
define('_LANG_P_WP_BOOKMARKLET','You can drag the following link to your links bar or add it to your bookmarks and when you "Press it" it will open up a popup window with information and a link to the site you&#8217;re currently browsing so you can make a quick post about it. Try it out:');

/* File Name wp-admin/categories.php */
define('_LANG_C_DEFAULT_CAT','Can\'t delete the <strong>%s</strong> category: this is the default one');
define('_LANG_C_EDIT_TITLECAT','Edit Category');
define('_LANG_C_NAME_SUBCAT','Category name:');
define('_LANG_C_NAME_SUBDESC','Description:');
define('_LANG_C_RIGHT_EDITCAT','You have no right to edit the categories for this blog.<br />Ask for a promotion to your <a href="mailto:%s">blog admin</a>. :)');
define('_LANG_C_NAME_CURRCAT','Current Categories');
define('_LANG_C_NAME_CATNAME','Name');
define('_LANG_C_NAME_CATDESC','Description:');
define('_LANG_C_NAME_CATPOSTS','# Posts');
define('_LANG_C_NAME_CATACTION','Action');
define('_LANG_C_ADD_NEWCAT','Add New Category');
define('_LANG_C_NOTE_CATEGORY','<strong>Note:</strong><br />Deleting a category does not delete posts from that category, it will just set them back to the default category <strong>%s</strong>.');
define('_LANG_C_NAME_EDIT','EDIT');
define('_LANG_C_NAME_DELETE','DELETE');
define('_LANG_C_NAME_ADDBTN','Add Category &raquo;');
define('_LANG_C_NAME_EDITBTN','Edit category &raquo;');
define('_LANG_C_NAME_PARENT','Category parent:');
define('_LANG_C_MESS_ADD','Category added.');
define('_LANG_C_MESS_DELE','Category deleted.');
define('_LANG_C_MESS_UP','Category updated.');

/* File Name wp-admin/edit.php */
define('_LANG_E_LATEST_POSTS','Latest Posts');
define('_LANG_E_LATEST_COMMENTS','Latest Comments');
define('_LANG_E_AWAIT_MODER','Comments Awaiting Moderation');
define('_LANG_E_SHOW_POSTS','Show posts:');
define('_LANG_E_TITLE_COMMENTS','Comments');
define('_LANG_E_FILL_REQUIRED','Error: please fill the required fields (name & comment)');
define('_LANG_E_TITLE_LEAVECOM','Leave Comment');
define('_LANG_E_RESULTS_FOUND','No results found.');

/* File Name wp-admin/edit-comments.php */
define('_LANG_EC_SHOW_COM','Show comments:');
define('_LANG_EC_EDIT_COM','Edit Comment');
define('_LANG_EC_DELETE_COM','Delete Comment');
define('_LANG_EC_EDIT_POST','Edit Post &#8220;');
define('_LANG_EC_VIEW_POST','View Post');
define('_LANG_EC_SEARCH_MODE','Searches within comment text, email, URI, and IP address.');
define('_LANG_EC_VIEW_MODE','View Mode');
define('_LANG_EC_EDIT_MODE','Mass Edit Mode');
define('_LANG_EC_CHECK_INVERT','Invert Checkbox Selection');
define('_LANG_EC_CHECK_DELETE','Delete Checked Comments');
define('_LANG_EC_LINK_VIEW','View');
define('_LANG_EC_LINK_EDIT','Edit');
define('_LANG_EC_LINK_DELETE','Delete');

/* File Name wp-admin/edit-form.php */
define('_LANG_EF_PING_FORM','<label for="pingback"><strong>PingBack</strong> the <acronym title="Uniform Resource Locators">URL</acronym>s in this post</label> <a href="http://wordpress.org/docs/reference/post/#pingback" title="Help on Pingbacks">?</a><br />');
define('_LANG_EF_TRACK_FORM','<p><label for="trackback"><a href="http://wordpress.org/docs/reference/post/#trackback" title="Help on trackbacks"><strong>TrackBack</strong> an <acronym title="Uniform Resource Locator">URL</acronym></a>:</label> (Separate multiple <acronym title="Uniform Resource Locator">URL</acronym>s with spaces.)<br />');
define('_LANG_EF_AD_POSTTITLE','Title');
define('_LANG_EF_AD_CATETITLE','Categories');
define('_LANG_EF_AD_POSTAREA','Post');
define('_LANG_EF_AD_POSTQUICK','Quicktags');
define('_LANG_EF_AD_DRAFT','Save as Draft');
define('_LANG_EF_AD_PRIVATE','Save as Private');
define('_LANG_EF_AD_PUBLISH','Publish');
define('_LANG_EF_AD_EDITING','Advanced Editing &raquo;');

/* File Name wp-admin/edit-form-advanced.php */
define('_LANG_EFA_POST_STATUS','Post Status');
define('_LANG_EFA_AD_COMMENTS','Comments');
define('_LANG_EFA_AD_PINGS','Pings');
define('_LANG_EFA_POST_PASSWORD','Post Password');
define('_LANG_EFA_POST_EXCERPT','Excerpt');
define('_LANG_EFA_POST_LATITUDE','Latitude:');
define('_LANG_EFA_POST_LONGITUDE','Longitude:');
define('_LANG_EFA_POST_GEOINFO','click for Geo Info');
define('_LANG_EFA_DEL_THISPOST','Delete this post');
define('_LANG_EFA_SAVE_CONTINUE','Save and Continue Editing');
define('_LANG_EFA_STATUS_OPEN','Open');
define('_LANG_EFA_STATUS_CLOSE','Closed');
define('_LANG_EFA_STATUS_UPLOAD','Upload a file or image');
define('_LANG_EFA_STATUS_DISCUSS','Discussion');
define('_LANG_EFA_STATUS_ALLOWC','Allow Comments');
define('_LANG_EFA_STATUS_ALLOWP','Allow Pings');
define('_LANG_EFA_STATUS_SLUG','Post Slug');
define('_LANG_EFA_STATUS_POST','Post');

/* File Name wp-admin/edit-form-comment.php */
define('_LANG_EFC_BUTTON_TEXT','Edit this!');
define('_LANG_EFC_COM_NAME','Name:');
define('_LANG_EFC_COM_MAIL','E-Mail:');
define('_LANG_EFC_COM_URI','URI:');
define('_LANG_EFC_COM_COMMENT','Comment:');

/* File Name wp-admin/link-add.php */
define('_LANG_WLA_MANAGE_LINK','Manage Links');
define('_LANG_WLA_ADD_LINK','Add Link');
define('_LANG_WLA_LINK_CATE','Link Categories');
define('_LANG_WLA_IMPORT_BLOG','Import Blogroll');
define('_LANG_WLA_LINK_TITLE','<strong>Add</strong> a link:');
define('_LANG_WLA_SUB_URI','URI:');
define('_LANG_WLA_SUB_NAME','Link Name:');
define('_LANG_WLA_SUB_IMAGE','Image');
define('_LANG_WLA_SUB_RSS','RSS URI: ');
define('_LANG_WLA_SUB_DESC','Description');
define('_LANG_WLA_SUB_REL','rel:');
define('_LANG_WLA_SUB_XFN','XFN');
define('_LANG_WLA_SUB_NOTE','Notes:');
define('_LANG_WLA_SUB_RATE','Rating:');
define('_LANG_WLA_SUB_TARGET','Target');
define('_LANG_WLA_SUB_VISIBLE','Visible:');
define('_LANG_WLA_SUB_CAT','Category:');
define('_LANG_WLA_SUB_FRIEND','friendship');
define('_LANG_WLA_SUB_PHYSICAL','physical');
define('_LANG_WLA_SUB_PROFESSIONAL','professional');
define('_LANG_WLA_SUB_GEOGRAPH','geographical');
define('_LANG_WLA_SUB_FAMILY','family');
define('_LANG_WLA_SUB_ROMANTIC','romantic');
define('_LANG_WLA_CHECK_ACQUA','acquaintance');
define('_LANG_WLA_CHECK_FRIE','friend');
define('_LANG_WLA_CHECK_NONE','none');
define('_LANG_WLA_CHECK_MET','met');
define('_LANG_WLA_CHECK_WORKER','co-worker');
define('_LANG_WLA_CHECK_COLL','colleague');
define('_LANG_WLA_CHECK_RESI','co-resident');
define('_LANG_WLA_CHECK_NEIG','neighbor');
define('_LANG_WLA_CHECK_CHILD','child');
define('_LANG_WLA_CHECK_PARENT','parent');
define('_LANG_WLA_CHECK_SIBLING','sibling');
define('_LANG_WLA_CHECK_SPOUSE','spouse');
define('_LANG_WLA_CHECK_MUSE','muse');
define('_LANG_WLA_CHECK_CRUSH','crush');
define('_LANG_WLA_CHECK_DATE','date');
define('_LANG_WLA_CHECK_HEART','sweetheart');
define('_LANG_WLA_CHECK_ZERO','Leave at 0 for no rating.');
define('_LANG_WLA_CHECK_STRICT','Note that the <code>target</code> attribute is illegal in XHTML 1.1 and 1.0 Strict.');
define('_LANG_WLA_TEXT_TOOLBAR','You can drag "Link This" to your toolbar and when you click it a window will pop up that will allow you to add whatever site you&#8217;re on to your links! Right now this only works on Mozilla or Netscape, but we&#8217;re working on it.');

/* File Name wp-admin/link-categories.php */
define('_LANG_WLC_DONOT_DELETE','Can&#8217;t delete the link category. this is the default one');
define('_LANG_WLC_TITLE_TEXT','Edit Link Category &#8220;');
define('_LANG_WLC_EPAGE_TITLE','<strong>Edit</strong> a link category:');
define('_LANG_WLC_ADD_TITLE','Add a Link Category:');
define('_LANG_WLC_SUBEDIT_NAME','Name:');
define('_LANG_WLC_SUBEDIT_TOGGLE','auto-toggle?');
define('_LANG_WLC_SUBEDIT_SHOW','Show:');
define('_LANG_WLC_SUBEDIT_ORDER','Sort order:');
define('_LANG_WLC_SUBEDIT_IMAGES','images');
define('_LANG_WLC_SUBEDIT_DESC','description');
define('_LANG_WLC_SUBEDIT_RATE','rating');
define('_LANG_WLC_SUBEDIT_UPDATE','updated');
define('_LANG_WLC_SUBEDIT_SORT','Sort by:');
define('_LANG_WLC_SUBEDIT_DESCEND','Descending?');
define('_LANG_WLC_SUBEDIT_BEFORE','Before:');
define('_LANG_WLC_SUBEDIT_BETWEEN','Between:');
define('_LANG_WLC_SUBEDIT_AFTER','After:');
define('_LANG_WLC_SUBEDIT_LIMIT','Limit:');
define('_LANG_WLC_ADDBUTTON_TEXT','Add Category!');
define('_LANG_WLC_SAVEBUTTON_TEXT','Save');
define('_LANG_WLC_CANCELBUTTON_TEXT','Cancel');
define('_LANG_WLC_SUBCATE_NAME','Name');
define('_LANG_WLC_SUBCATE_ATT','Auto<br />Toggle?');
define('_LANG_WLC_SUBCATE_SHOW','Show');
define('_LANG_WLC_SUBCATE_SORT','Sort Order');
define('_LANG_WLC_SUBCATE_DESC','Desc?');
define('_LANG_WLC_SUBCATE_LIMIT','Limit');
define('_LANG_WLC_SUBCATE_IMAGES','images?');
define('_LANG_WLC_SUBCATE_MINIDESC','desc?');
define('_LANG_WLC_SUBCATE_RATE','rating?');
define('_LANG_WLC_SUBCATE_UPDATE','updated?');
define('_LANG_WLC_SUBCATE_BEFORE','before');
define('_LANG_WLC_SUBCATE_BETWEEN','between');
define('_LANG_WLC_SUBCATE_AFTER','after');
define('_LANG_WLC_SUBCATE_EDIT','Edit');
define('_LANG_WLC_SUBCATE_DELETE','Delete');
define('_LANG_WLC_SUBEDIT_EMPTY','How many links are shown. Empty for unlimited.');
define('_LANG_WLC_EPAGE_EMPTY','leave empty for no limit');
define('_LANG_WLC_EPAGE_NOTE','Deleting a link category does not delete links from that category.<br />It will just set them back to the default category  :');
define('_LANG_WLC_RIGHT_PROM','You have no right to edit the link categories for this blog.<br>Ask for a promotion to your blog admin :)');

/* File Name wp-admin/link-import.php */
define('_LANG_WLI_ROLL_TITLE','Import Blogroll');
define('_LANG_WLI_ROLL_DESC','Import your blogroll from another system ');
define('_LANG_WLI_ROLL_OPMLCODE','Go to Blogrolling.com and sign in. Once you&#8217;ve done that, click on <strong>Get Code</strong>, and then look for the <strong><abbr title="Outline Processor Markup Language">OPML</abbr> code</strong>');
define('_LANG_WLI_ROLL_OPMLLINK','Or go to Blo.gs and sign in. Once you&#8217;ve done that in the &#8217;Welcome Back&#8217; box on the right, click on <strong>share</strong>, and then look for the <strong><abbr title="Outline Processor Markup Language">OPML</abbr> link</strong> (favorites.opml)');
define('_LANG_WLI_ROLL_BELOW','Select that text and copy it or copy the link/shortcut into the box below.');
define('_LANG_WLI_ROLL_YOURURL','Your OPML URL:');
define('_LANG_WLI_ROLL_UPLOAD','<strong>or</strong> you can upload an OPML file from your desktop aggregator:');
define('_LANG_WLI_ROLL_THISFILE','Upload this file: ');
define('_LANG_WLI_ROLL_CATEGORY','Now select a category you want to put these links in.<br />Category: ');
define('_LANG_WLI_ROLL_BUTTONTEXT','Import!');

/* File Name wp-admin/link-manager.php */
define('_LANG_WLM_PAGE_TITLE','Manage Links');
define('_LANG_WLM_LEVEL_ERROR','You have no right to edit the links for this blog.<br />Ask for a promotion to your blog admin. :)');
define('_LANG_WLM_SHOW_LINKS','<strong>Show</strong> links in category:');
define('_LANG_WLM_ORDER_BY','<strong>Order</strong> by:');
define('_LANG_WLM_SHOW_BUTTONTEXT','Show');
define('_LANG_WLM_SHOW_ACTIONTEXT','Action');
define('_LANG_WLM_MULTI_LINK','Manage Multiple Links:');
define('_LANG_WLM_CHECK_CHOOSE','Use the checkboxes on the right to select multiple links and choose an action below:');
define('_LANG_WLM_ASSIGN_TEXT','Assign');
define('_LANG_WLM_OWNER_SHIP','ownership to:');
define('_LANG_WLM_TOGGLE_TEXT','Toggle ');
define('_LANG_WLM_VISIVILITY_TEXT','Visibility');
define('_LANG_WLM_MOVE_TEXT','Move');
define('_LANG_WLM_TO_CATEGORY',' to category');
define('_LANG_WLM_TOGGLE_BOXES','Toggle Checkboxes');
define('_LANG_WLM_EDIT_LINK','Edit a link:');
define('_LANG_WLM_SAVE_CHANGES','Save Changes');
define('_LANG_WLM_EDIT_CANCEL','Cancel');

/* File Name wp-admin/moderation.php */
define('_LANG_WPM_USER_LEVEL','Your level is not high enough to moderate comments. Ask for a promotion from your blog admin. :)');
define('_LANG_WPM_LATE_POSTS','Posts');
define('_LANG_WPM_LATE_COMS','Comments');
define('_LANG_WPM_AWIT_MODERATION','Awaiting Moderation');
define('_LANG_WPM_COM_APPROV',' comment approved ');
define('_LANG_WPM_COMS_APPROVS',' comments approved ');
define('_LANG_WPM_COM_DEL',' comment deleted ');
define('_LANG_WPM_COMS_DELS',' comment deleted ');
define('_LANG_WPM_COM_UNCHANGE',' comment unchanged ');
define('_LANG_WPM_COMS_UNCHANGES',' comments unchanged ');
define('_LANG_WPM_WAIT_APPROVAL','The following comments wait for approval:');
define('_LANG_WPM_CURR_COMAPP','Currently there are no comments to be approved.');
define('_LANG_WPM_DEL_LATER','<p>For each comment you have to choose either <em>approve</em>, <em>delete</em> or <em>later</em>:</p>');
define('_LANG_WPM_PUBL_VISIBLE','<p><em>approve</em>: approves comment, so that it will be publically visible');
define('_LANG_WPM_AUTHOR_NOTIFIED','the author of the post will be notified about the new comment on his post.');
define('_LANG_WPM_ASKED_AGAIN','<p><em>delete</em>: remove the content from your blog (note: you won&#8242;t be asked again, so you should double-check that you really want to delete the comment - once deleted you can&#8242;t bring them back!)</p><p><em>later</em>: don&#8242;t change the comment&#8242;s status at all now.</p>');
define('_LANG_WPM_MODERATE_BUTTON','Moderate Comments');
define('_LANG_WPM_DO_NOTHING','Do nothing');
define('_LANG_WPM_DO_DELETE','Delete');
define('_LANG_WPM_DO_APPROVE','Approve');
define('_LANG_WPM_DO_ACTION','Bulk action:');
define('_LANG_WPM_JUST_THIS','Delete just this comment');
define('_LANG_WPM_JUST_EDIT','Edit');
define('_LANG_WPM_COMPOST_NAME','Name:');
define('_LANG_WPM_COMPOST_MAIL','Email:');
define('_LANG_WPM_COMPOST_URL','URI:');

/* File Name wp-admin/options.php */
define('_LANG_WOP_USER_LEVEL','You have no right to edit the options for this blog.<br />Ask for a promotion from your blog admin :)');
define('_LANG_WOP_PERM_LINKS','Permalinks');
define('_LANG_WOP_PERM_CONFIG','Permanent link configuration');
define('_LANG_WOP_NO_HELPS',' No help for this group of options.');
define('_LANG_WOP_SUBMIT_TEXT','Update Settings');
define('_LANG_WOP_SETTING_SAVED',' setting(s) saved... ');

/* File Name wp-admin/permalink.php */
define('_LANG_WPL_EDIT_UPDATED','Permalink structure updated.');
define('_LANG_WPL_EDIT_STRUCT','Edit Permalink Structure');
define('_LANG_WPL_CREATE_CUSTOM','WordPress offers you the ability to create a custom URI structure for your permalinks and archives. The following &#8220;tags&#8221; are available:');
define('_LANG_WPL_CODE_YEAR','The year of the post, 4 digits, for example <code>2004</code>');
define('_LANG_WPL_CODE_MONTH','Month of the year, for example <code>05</code>');
define('_LANG_WPL_CODE_DAY','Day of the month, for example <code>28</code>');
define('_LANG_WPL_CODE_HOUR','Hour of the day, for example <code>15</code>');
define('_LANG_WPL_CODE_MINUTE','Minute of the hour, for example <code>43</code>');
define('_LANG_WPL_CODE_SECOND','Second of the minute, for example <code>33</code>');
define('_LANG_WPL_CODE_POSTNAME','A sanitized version of the title of the post. So &#8220;This Is A Great Post!&#8221; becomes &#8220;<code>this-is-a-great-post</code>&#8221; in the URI');
define('_LANG_WPL_CODE_POSTID','The unique ID # of the post, for example <code>423</code>');
define('_LANG_WPL_USE_EXAMPLE','<p>So for example a value like:</p>
<p><code>/archives/%year%/%monthnum%/%day%/%postname%/</code> </p>
<p>would give you a permalink like:</p>
<p><code>/archives/2003/05/23/my-cheese-sandwich/</code></p>
<p> In general for this you must use mod_rewrite, however if you put a filename at the beginning WordPress will attempt to use that to pass the arguments, for example:</p>
<p><code>/index.php/archives/%year%/%monthnum%/%day%/%postname%/</code> </p>
<p>If you use this option you can ignore the mod_rewrite rules. </p>');
define('_LANG_WPL_USE_TEMPTEXT','Use the template tags above to create a virtual site structure:');
define('_LANG_WPL_USE_BLANK','If you like, you may enter a custom prefix for your category URIs here. For example, <code>/taxonomy/categorias</code> would make your category links like <code>http://example.org/taxonomy/categorias/general/</code>. If you leave this blank the default will be used.');
define('_LANG_WPL_USE_HTACCESS','Using the permalink structure value you currently have, <code>%s</code>, these are the mod_rewrite rules you should have in your <code>.htaccess</code> file. Click in the field and press <kbd>CTRL + a</kbd> to select all.');
define('_LANG_WPL_ENGINE_ON','RewriteEngine On RewriteBase');
define('_LANG_WPL_EDIT_TEMPLATE','<p>If your <code>.htaccess</code> file is writable by WordPress, you can <a href="%s">edit it through your template interface</a>.</p>');
define('_LANG_WPL_MOD_REWRITE','You are not currently using customized permalinks. No special mod_rewrite rules are needed.');
define('_LANG_WPL_SUBMIT_UPDATE','Update Permalink Structure &raquo;');

/* File Name wp-admin/profile.php */
define('_LANG_WPF_ERR_NICKNAME','<strong>ERROR</strong>: please enter your nickname (can be the same as your login)');
define('_LANG_WPF_ERR_ICQUIN','<strong>ERROR</strong>: your ICQ UIN can only be a number, no letters allowed');
define('_LANG_WPF_ERR_TYPEMAIL','<strong>ERROR</strong>: please type your e-mail address');
define('_LANG_WPF_ERR_CORRECT','<strong>ERROR</strong>: the email address isn&#8217;t correct');
define('_LANG_WPF_ERR_TYPETWICE','<strong>ERROR</strong>: you typed your new password only once. Go back to type it twice.');
define('_LANG_WPF_ERR_DIFFERENT','<strong>ERROR</strong>: you typed two different passwords. Go back to correct that.');
define('_LANG_WPF_ERR_PROFILE','<strong>ERROR</strong>: couldn&#8217;t update your profile... please contact the webmaster !');
define('_LANG_WPF_SUBT_VIEW','View Profile');
define('_LANG_WPF_SUBT_FIRST','First name:');
define('_LANG_WPF_SUBT_LAST','Last name:');
define('_LANG_WPF_SUBT_NICK','Nickname:');
define('_LANG_WPF_SUBT_MAIL','Email:');
define('_LANG_WPF_SUBT_URL','Website:');
define('_LANG_WPF_SUBT_ICQ','ICQ:');
define('_LANG_WPF_SUBT_AIM','AIM:');
define('_LANG_WPF_SUBT_MSN','MSN IM:');
define('_LANG_WPF_SUBT_YAHOO','Yahoo IM:');
define('_LANG_WPF_SUBT_ONE','IE one-click bookmarklet');
define('_LANG_WPF_SUBT_COPY','To have a one-click bookmarklet, just copy and paste this<br />into a new text file:');
define('_LANG_WPF_SUBT_BOOK','Save it as wordpress.reg, and double-click on this file in an Explorer<br />window. Answer Yes to the question, and restart Internet Explorer.<br /><br />That&#8242;s it, you can now right-click in an IE window and select <br />&#8242;Post to WP&#8242; to make the bookmarklet appear. :)');
define('_LANG_WPF_SUBT_CLOSE','Close this window');
define('_LANG_WPF_SUBT_UPDATED','Profile updated.');
define('_LANG_WPF_SUBT_EDIT','Edit Your Profile');
define('_LANG_WPF_SUBT_USERID','Login:');
define('_LANG_WPF_SUBT_LEVEL','Level:');
define('_LANG_WPF_SUBT_POSTS','Posts:');
define('_LANG_WPF_SUBT_LOGIN','Login:');
define('_LANG_WPF_SUBT_DESC','Profile:');
define('_LANG_WPF_SUBT_IDENTITY','Identity on blog: ');
define('_LANG_WPF_SUBT_NEWPASS','New <strong>Password</strong> (Leave blank to stay the same.)');
define('_LANG_WPF_SUBT_MOZILLA','No Sidebar found!  You must use Mozilla 0.9.4 or later!');
define('_LANG_WPF_SUBT_SIDEBAR','SideBar');
define('_LANG_WPF_SUBT_FAVORITES','Add this link to your favorites:');
define('_LANG_WPF_SUBT_UPDATE','Update');

/* File Name wp-admin/sidebar.php */
define('_LANG_WAS_SIDE_POSTED','Posted !');
define('_LANG_WAS_SIDE_AGAIN','<a href="sidebar.php">Click here</a> to post again.');

/* File Name wp-admin/templates.php */
define('_LANG_WAT_LEVEL_ERR','<p>You have no right to edit the template for this blog.<br />Ask for a promotion to your blog admin. :)</p>');
define('_LANG_WAT_SORRY_EDIT','Sorry, can&#8217;t edit files with ".." in the name. If you are trying to edit a file in your WordPress home directory, you can just type the name of the file in.');
define('_LANG_WAT_SORRY_PATH','Sorry, can&#8217;t call files with their real path.');
define('_LANG_WAT_EDITED_SUCCESS','<em>File edited successfully.</em>');
define('_LANG_WAT_FILE_CHMOD','you cannot update that file/template: must make it writable, e.g. CHMOD 766');
define('_LANG_WAT_OOPS_EXISTS','<p>Oops, no such file exists! Double check the name and try again, merci.</p>');
define('_LANG_WAT_OTHER_FILE','<p>To edit a file, type its name here. You can edit any file writable by the server, e.g. CHMOD 766.</p>');
// define('_LANG_WAT_TYPE_HERE','To edit a file, type its name here:');
define('_LANG_WAT_FTP_CLIENT','Note: of course, you can also edit the files/templates in your text editor of choice and upload them. This online editor is only meant to be used when you don&#8217;t have access to a text editor or FTP client.');
define('_LANG_WAT_UPTEXT_TEMP','Update file !');

/* File Name wp-admin/users.php */
define('_LANG_WUS_WHOSE_LEVEL','Can&#8217;t change the level of a user whose level is higher than yours.');
define('_LANG_WUS_WHOSE_DELETE','Can&#8217;t delete a user whose level is higher than yours.');
define('_LANG_WUS_CANNOT_DELU','Couldn&#8217;t delete user');
define('_LANG_WUS_CANNOT_DELUPOST','Couldn&#8217;t delete user&#8217;s post');
define('_LANG_WUS_AU_THOR','Authors');
define('_LANG_WUS_AU_NICK','Nickname');
define('_LANG_WUS_AU_NAME','Name');
define('_LANG_WUS_AU_MAIL','E-mail');
define('_LANG_WUS_AU_URI','URI');
define('_LANG_WUS_AU_LEVEL','Level');
define('_LANG_WUS_AU_POSTS','Posts');
define('_LANG_WUS_AU_USERS','Users');
define('_LANG_WUS_AU_WARNING','To delete a user, bring his level to zero, then click on the red X.<br /><strong>Warning:</strong> deleting a user also deletes all posts made by this user.');
define('_LANG_WUS_ADD_USER','Add User');
define('_LANG_WUS_ADD_THEMSELVES','Users can register themselves or you can manually create users here.');
define('_LANG_WUS_ADD_FIRST','First Name ');
define('_LANG_WUS_ADD_LAST','Last Name ');
define('_LANG_WUS_ADD_TWICE','Password (twice) ');

/* File Name wp-comments.php */
define('_LANG_WPCM_LOAD_DIRECTLY','Please do not load this page directly. Thanks!');
define('_LANG_WPCM_ENTER_PASS','<p>Enter your password to view comments.<p>');
define('_LANG_WPCM_COM_TITLE','Comments');
define('_LANG_WPCM_COM_RSS','<abbr title="Really Simple Syndication">RSS</abbr> feed for comments on this post.');
define('_LANG_WPCM_COM_TRACK','The <acronym title="Uniform Resource Identifier">URI</acronym> to TrackBack this entry is: ');
define('_LANG_WPCM_COM_YET','No comments yet.');
define('_LANG_WPCM_COM_LEAVE','Leave a Comment');
define('_LANG_WPCM_HTML_ALLOWED','Line and paragraph breaks automatic, website trumps email, <acronym title="Hypertext Markup Language">HTML</acronym> allowed: ');
define('_LANG_WPCM_COM_YOUR','Your Comment');
define('_LANG_WPCM_PLEASE_NOTE','<strong>Please note:</strong> Comment moderation is currently enabled so there may be a delay between when you post your comment and when it shows up. Patience is a virtue; there&#8217;s no need to resubmit your comment.');
define('_LANG_WPCM_COM_SAYIT','Say it!');
define('_LANG_WPCM_THIS_TIME','Sorry, the comment form is closed at this time.');
// define('_LANG_WPCM_GO_BACK','Go back');
define('_LANG_WPCM_COM_NAME','Name');

/* File Name wp-comments-post.php */
define('_LANG_WPCP_SORRY_ITEM','Sorry, comments are closed for this item.');
define('_LANG_WPCP_ERR_FILL','Error: please fill the required fields (name, email).');
define('_LANG_WPCP_ERR_TYPE','Error: please type a comment.');
define('_LANG_WPCP_SORRY_SECONDS','Sorry, you can only post a new comment once every 10 seconds. Slow down cowboy.');

/* File Name wp-admin/upload.php */
define('_LANG_WAU_UPLOAD_DISABLED','The admin disabled this function');
define('_LANG_WAU_UPLOAD_DIRECTORY','It doesn\'t look like you can use the file upload feature at this time because the directory you have specified doesn\'t appear to be writable by WordPress. Check the permissions on the directory and for typos.');

define('_LANG_WAU_UPLOAD_EXTENSION','You can upload files with the extension : ');
define('_LANG_WAU_UPLOAD_BYTES','As long as they are no larger than <abbr title="Kilobytes">KB</abbr> : ');
define('_LANG_WAU_UPLOAD_OPTIONS','If you\'re an admin you can configure these values under <a href="options.php?option_group_id=4">options</a>.');
define('_LANG_WAU_UPLOAD_FILE','File:');
define('_LANG_WAU_UPLOAD_ALT','Description:');
define('_LANG_WAU_UPLOAD_THUMBNAIL','Create a thumbnail?');
define('_LANG_WAU_UPLOAD_NO','No thanks');
define('_LANG_WAU_UPLOAD_SMALL','Small (200px largest side)');
define('_LANG_WAU_UPLOAD_LARGE','Large (400px largest side)');
define('_LANG_WAU_UPLOAD_CUSTOM','Custom size');
define('_LANG_WAU_UPLOAD_PX','px (largest side)');
define('_LANG_WAU_UPLOAD_BTN','Upload File');
define('_LANG_WAU_UPLOAD_SUCCESS','Your file was uploaded successfully : ');
define('_LANG_WAU_UPLOAD_CODE','Here\'s the code to display it:');
define('_LANG_WAU_UPLOAD_START','Start over');
define('_LANG_WAU_UPLOAD_DUPLICATE','Duplicate File ?');
define('_LANG_WAU_UPLOAD_EXISTS','The filename already exists : ');
define('_LANG_WAU_UPLOAD_RENAME','Confirm or rename:');
define('_LANG_WAU_UPLOAD_ALTER','Alternate name:');
define('_LANG_WAU_UPLOAD_REBTN','Rename');
define('_LANG_WAU_UPLOAD_CODEIN','It inserts in form.');
define('_LANG_WAU_UPLOAD_AMAZON','Amazon Associate');
define('_LANG_WAU_ATTACH_ICON','File attachment ICON only');

/* File Name wp-admin/options-general.php */
define('_LANG_WAO_GENERAL_DISABLED','You have do not have sufficient permissions to edit the options for this blog.');
define('_LANG_WAO_GENERAL_WPTITLE','Weblog title: ');
define('_LANG_WAO_GENERAL_TAGLINE','Tagline:');
define('_LANG_WAO_GENERAL_URI','Web address (URI): ');
define('_LANG_WAO_GENERAL_MAIL','E-mail address: ');
define('_LANG_WAO_GENERAL_MEMBER','Membership:');
define('_LANG_WAO_GENERAL_GMT','<acronym title="Greenwich Meridian Time">GMT</acronym> time is: ');
define('_LANG_WAO_GENERAL_DIFFER','Times in the weblog should differ by: ');
define('_LANG_WAO_GENERAL_EXPLIAIN','In a few words, explain what this weblog is about.');
define('_LANG_WAO_GENERAL_ADMIN','This address is used only for admin purposes.');
define('_LANG_WAO_GENERAL_REGISTER','Anyone can register');
define('_LANG_WAO_GENERAL_ARTICLES','Any registered member can publish articles');
define('_LANG_WAO_GENERAL_UPDATE','Update Options');

/* File Name wp-admin/options-writing.php */
define('_LANG_WAO_WRITING_ERROR','You have do not have sufficient permissions to edit the options for this blog.');
define('_LANG_WAO_WRITING_TITLE','Writing Options');
define('_LANG_WAO_WRITING_SIMPLE','Simple controls');
define('_LANG_WAO_WRITING_ADVANCED','Advanced controls');
define('_LANG_WAO_WRITING_LINES','lines');
define('_LANG_WAO_WRITING_DISPLAY','Convert emoticons like :-) and :-P to graphics on display');
define('_LANG_WAO_WRITING_XHTML','WordPress should correct invalidly nested XHTML automatically');
define('_LANG_WAO_WRITING_CHARACTER','The character encoding you write your blog in (UTF-8 recommended)');
define('_LANG_WAO_WRITING_STYLE','When starting a post, show:');
define('_LANG_WAO_WRITING_BOX','Size of the writing box:');
define('_LANG_WAO_WRITING_FORMAT','Formatting:');
define('_LANG_WAO_WRITING_ENCODE','Character Encoding:');
define('_LANG_WAO_WRITING_SERVICES','Update Services');
define('_LANG_WAO_WRITING_SOMETHING','Enter the sites that you would like to notify when you publish a new post. For a list of some recommended sites to ping please see [LINK TO SOMETHING]. Seperate multiple URIs by line breaks.');
define('_LANG_WAO_WRITING_UPDATE','Update Options');

/* File Name wp-admin/options-discussion.php */
define('_LANG_WAO_DISCUSS_TITLE','Discussion Options');
define('_LANG_WAO_DISCUSS_INDIVIDUAL','Usual settings for an article: <em>(These settings may be overidden for individual articles.)</em>');
define('_LANG_WAO_DISCUSS_NOTIFY','Attempt to notify any Weblogs linked to from the article. (Slows down posting.)');
define('_LANG_WAO_DISCUSS_PINGTRACK','Allow link notifications from other Weblogs. (Pingbacks and trackbacks.)');
define('_LANG_WAO_DISCUSS_PEOPLE','Allow people to post comments on the article');
define('_LANG_WAO_DISCUSS_EMAIL','Email me whenever:');
define('_LANG_WAO_DISCUSS_ANYONE','Anyone posts a comment');
define('_LANG_WAO_DISCUSS_DECLINED','A comment is approved or declined');
define('_LANG_WAO_DISCUSS_APPEARS','Before a comment appears:');
define('_LANG_WAO_DISCUSS_ADMIN','An administrator must approve the comment (regardless of any matches below)');
define('_LANG_WAO_DISCUSS_MODERATION','When a comment contains any of these words in its content, name, URI, or email, hold it in the moderation queue: (Seperate multiple words with new lines.)');

/* File Name wp-admin/options-reading.php */
define('_LANG_WAO_READING_TITLE','Reading Options');
define('_LANG_WAO_READING_FRONT','Front Page');
define('_LANG_WAO_READING_RECENT','Show the most recent:');
define('_LANG_WAO_READING_FEEDS','Syndication Feeds');
define('_LANG_WAO_READING_ARTICLE','For each article, show:');
define('_LANG_WAO_READING_ENCODE','Encoding for pages and feeds:');
define('_LANG_WAO_READING_CHARACTER','The character encoding you write your blog in (UTF-8 recommended<a href="http://developer.apple.com/documentation/macos8/TextIntlSvcs/TextEncodingConversionManager/TEC1.5/TEC.b0.html"></a>)');
define('_LANG_WAO_READING_GZIP','WordPress should compress articles (gzip) if browsers ask for them');
define('_LANG_WAO_READING_BTNTXT','Update Options');

/* Cheatin&#8217; uh? */
define('_LANG_P_CHEATING_ERROR','Cheatin&#8217; uh?');


/* Start Install ************************************************/
/* File Name install.php */
define('_LANG_INST_GUIDE_WPCONFIG','There doesn\'t seem to be a wp-config.php file. You must create one before moving on.');
define('_LANG_INST_GUIDE_INSTALLED','<p>You appear to already have WordPress installed. If you would like to reinstall please clear your old database files first.</p></body></html>');
define('_LANG_INST_GUIDE_WEL','<br />Welcome to WordPress. We&#8217;re now going to go through a few steps to get you up and running with the latest in personal publishing platforms. Before we get started, remember that we require a PHP version of at least 4.0.6, you
  have ');
define('_LANG_INST_GUIDE_COM','. Look good? You also need to set up the database connection information in <code>wp-config.php</code>. Have you looked at the <a href="../wp-readme/">readme</a>? If you&#8217;re all ready, <a href="install.php?step=1">let\'s
  go</a>! ');
define('_LANG_INST_STEP1_FIRST','<p>Okay first we&#8217;re going to set up the links database. This will allow you to host your own blogroll, complete with Weblogs.com updates.</p>');
define('_LANG_INST_STEP1_LINKS','<p>Installing WP-Links.</p><p>Checking for tables...</p>');
define('_LANG_INST_STEP1_ALLDONE','Did you defeat the boss monster at the end? Great! You&#8217;re ready for <a href="install.php?step=2">Step 2</a>.');
define('_LANG_INST_STEP2_INFO','First we&#8217;re going to create the necessary blog tables in the database...');
/* base options from b2cofig */
define('_LANG_INST_BASE_VALUE1','siteurl is your blog\'s URL: for example, \'http://example.com/wordpress\' (no trailing slash !)');
define('_LANG_INST_BASE_VALUE2','blogfilename is the name of the default file for your blog');
define('_LANG_INST_BASE_VALUE3','blogname is the name of your blog');
define('_LANG_INST_BASE_VALUE4','blogdescription is the description of your blog');
define('_LANG_INST_BASE_VALUE7','whether you want new users to be able to post entries once they have registered');
define('_LANG_INST_BASE_VALUE8','whether you want to allow users to register on your blog');
define('_LANG_INST_BASE_VALUE54','Your email (obvious eh?)');
// general blog setup
define('_LANG_INST_BASE_VALUE9','day at the start of the week');
define('_LANG_INST_BASE_VALUE11','use BBCode, like [b]bold[/b]');
define('_LANG_INST_BASE_VALUE12','use GreyMatter-styles: **bold** \\\\italic\\\\ __underline__');
define('_LANG_INST_BASE_VALUE13','buttons for HTML tags (they won\'t work on IE Mac yet)');
define('_LANG_INST_BASE_VALUE14','IMPORTANT! set this to false if you are using Chinese, Japanese, Korean, or other double-bytes languages');
define('_LANG_INST_BASE_VALUE15','this could help balance your HTML code. if it gives bad results, set it to false');
define('_LANG_INST_BASE_VALUE16','set this to 1 to enable smiley conversion in posts (note: this makes smiley conversion in ALL posts)');
define('_LANG_INST_BASE_VALUE17','the directory where your smilies are (no trailing slash)');
define('_LANG_INST_BASE_VALUE18','set this to true to require e-mail and name, or false to allow comments without e-mail/name');
define('_LANG_INST_BASE_VALUE20','set this to true to let every author be notified about comments on their posts');
/* rss/rdf feeds */
define('_LANG_INST_BASE_VALUE21','number of last posts to syndicate');
define('_LANG_INST_BASE_VALUE22','the language of your blog ( see this: http://backend.userland.com/stories/storyReader$16 )');
define('_LANG_INST_BASE_VALUE23','for b2rss.php: allow encoded HTML in &lt;description> tag?');
define('_LANG_INST_BASE_VALUE24','length (in words) of excerpts in the RSS feed? 0=unlimited note: in b2rss.php, this will be set to 0 if you use encoded HTML');
define('_LANG_INST_BASE_VALUE25','use the excerpt field for rss feed.');
define('_LANG_INST_BASE_VALUE26','set this to true if you want your site to be listed on http://weblogs.com when you add a new post');
define('_LANG_INST_BASE_VALUE27','set this to true if you want your site to be listed on http://blo.gs when you add a new post');
define('_LANG_INST_BASE_VALUE28','You shouldn\'t need to change this.');
define('_LANG_INST_BASE_VALUE29','set this to 0 or 1, whether you want to allow your posts to be trackback\'able or not note: setting it to zero would also disable sending trackbacks');
define('_LANG_INST_BASE_VALUE30','set this to 0 or 1, whether you want to allow your posts to be pingback\'able or not note: setting it to zero would also disable sending pingbacks');
define('_LANG_INST_BASE_VALUE31','set this to false to disable file upload, or true to enable it');
define('_LANG_INST_BASE_VALUE32','enter the real path of the directory where you\'ll upload the pictures \nif you\'re unsure about what your real path is, please ask your host\'s support staff \nnote that the  directory must be writable by the webserver (chmod 766) \nnote for windows-servers users: use forwardslashes instead of backslashes');
define('_LANG_INST_BASE_VALUE33','enter the URL of that directory (it\'s used to generate the links to the uploded files)');
define('_LANG_INST_BASE_VALUE34','accepted file types, separated by spaces. example: \'jpg gif png\'');
define('_LANG_INST_BASE_VALUE35','by default, most servers limit the size of uploads to 2048 KB, if you want to set it to a lower value, here it is (you cannot set a higher value than your server limit)');
define('_LANG_INST_BASE_VALUE36','you may not want all users to upload pictures/files, so you can set a minimum level for this');
define('_LANG_INST_BASE_VALUE37','...or you may authorize only some users. enter their logins here, separated by spaces. if you leave this variable blank, all users who have the minimum level are authorized to upload. example: \'barbara anne george\'');
/* email settings */
define('_LANG_INST_BASE_VALUE38','mailserver settings');
define('_LANG_INST_BASE_VALUE39','mailserver settings');
define('_LANG_INST_BASE_VALUE40','mailserver settings');
define('_LANG_INST_BASE_VALUE41','mailserver settings');
define('_LANG_INST_BASE_VALUE42','by default posts will have this category');
define('_LANG_INST_BASE_VALUE43','subject prefix');
define('_LANG_INST_BASE_VALUE44','body terminator string (starting from this string, everything will be ignored, including this string)');
define('_LANG_INST_BASE_VALUE45','set this to true to run in test mode');
define('_LANG_INST_BASE_VALUE46','some mobile phone email services will send identical subject & content on the same line if you use such a service, set use_phoneemail to true, and indicate a separator string');
define('_LANG_INST_BASE_VALUE47','when you compose your message, you\'ll type your subject then the separator string then you type your login:password, then the separator, then content');
define('_LANG_INST_BASE_VALUE48','How many posts/days to show on the index page.');
define('_LANG_INST_BASE_VALUE49','Posts, days, or posts paged');
define('_LANG_INST_BASE_VALUE50','Which \'unit\' to use for archives.');
define('_LANG_INST_BASE_VALUE51','if you\'re not on the timezone of your server');
define('_LANG_INST_BASE_VALUE52','see note for format characters');
define('_LANG_INST_BASE_VALUE53','see note for format characters');
/* 'pages' of options */
define('_LANG_INST_BASE_HELP1','Posts per page etc. Original options page');
define('_LANG_INST_BASE_HELP2','Things you\'ll probably want to tweak');
define('_LANG_INST_BASE_HELP3','Settings for RSS/RDF Feeds, Track/ping-backs');
define('_LANG_INST_BASE_HELP4','Settings for file uploads');
define('_LANG_INST_BASE_HELP5','Settings for blogging via email');
define('_LANG_INST_BASE_HELP6','Basic settings required to get your blog working');
define('_LANG_INST_BASE_HELP7','Default settings for new posts.');
define('_LANG_INST_BASE_HELP8','Various settings for the link manager.');
define('_LANG_INST_BASE_HELP9','Settings which control the posting and display of Geo Options');
define('_LANG_INST_BASE_VALUE55','The default state of each new post');
define('_LANG_INST_BASE_VALUE56','The default state of comments for each new post');
define('_LANG_INST_BASE_VALUE57','The default ping state for each new post');
define('_LANG_INST_BASE_VALUE58','Whether the \'PingBack the URLs in this post\' checkbox should be checked by default');
define('_LANG_INST_BASE_VALUE59','The default category for each new post');
define('_LANG_INST_BASE_VALUE83','The number of rows in the edit post form (min 3, max 100)');
define('_LANG_INST_BASE_VALUE60','The minimum admin level to edit links');
define('_LANG_INST_BASE_VALUE61','set this to false to have all links visible and editable to everyone in the link manager');
define('_LANG_INST_BASE_VALUE62','Set this to the type of rating indication you wish to use');
define('_LANG_INST_BASE_VALUE63','If we are set to \'char\' which char to use.');
define('_LANG_INST_BASE_VALUE64','What do we do with a value of zero? set this to true to output nothing, 0 to output as normal (number/image)');
define('_LANG_INST_BASE_VALUE65','Use the same image for each rating point? (Uses links_rating_image[0])');
define('_LANG_INST_BASE_VALUE66','Image for rating 0 (and for single image)');
define('_LANG_INST_BASE_VALUE67','Image for rating 1');
define('_LANG_INST_BASE_VALUE68','Image for rating 2');
define('_LANG_INST_BASE_VALUE69','Image for rating 3');
define('_LANG_INST_BASE_VALUE70','Image for rating 4');
define('_LANG_INST_BASE_VALUE71','Image for rating 5');
define('_LANG_INST_BASE_VALUE72','Image for rating 6');
define('_LANG_INST_BASE_VALUE73','Image for rating 7');
define('_LANG_INST_BASE_VALUE74','Image for rating 8');
define('_LANG_INST_BASE_VALUE75','Image for rating 9');
define('_LANG_INST_BASE_VALUE76','path/to/cachefile needs to be writable by web server');
define('_LANG_INST_BASE_VALUE77','Which file to grab from weblogs.com');
define('_LANG_INST_BASE_VALUE78','cache time in minutes (if it is older than this get a new copy)');
define('_LANG_INST_BASE_VALUE79','The date format for the updated tooltip');
define('_LANG_INST_BASE_VALUE80','The text to prepend to a recently updated link');
define('_LANG_INST_BASE_VALUE81','The text to append to a recently updated link');
define('_LANG_INST_BASE_VALUE82','The time in minutes to consider a link recently updated');
define('_LANG_INST_BASE_VALUE84','Turns on the geo url features of WordPress');
define('_LANG_INST_BASE_VALUE85','enables placement of default GeoURL ICBM location even when no other specified');
define('_LANG_INST_BASE_VALUE86','The default Latitude ICBM value - <a href="http://www.geourl.org/resources.html" target="_blank">see here</a>');
define('_LANG_INST_BASE_VALUE87','The default Longitude ICBM value');
/* Last Question */
define('_LANG_INST_STEP2_LAST','OK. We\'re nearly done now. We just need to ask you a couple of things:');
define('_LANG_INST_STEP2_URL','User setup successful!');
define('_LANG_INST_STEP3_SET','<p>Now you can <a href="../wp-login.php">log in</a> with the <strong>login</strong> "admin" and <strong>password</strong> "');
define('_LANG_INST_STEP3_UP','".</p><p><strong><em>Note that password</em></strong> carefully! It is a <em>random</em> password that was generated just for you. If you lose it, you
  will have to delete the tables from the database yourself, and re-install WordPress.</p>');
define('_LANG_INST_STEP3_DONE','Were you expecting more steps? Sorry to disappoint. All done!');
define('_LANG_INST_CAUTIONS','<ul><li>Directory : [755]</li><li>wp-config.php : [604Å`644]</li></ul>');

/* Start Upgrade ************************************************/
/* File Name wp-admin/upgrade.php */
define('_LANG_UPG_STEP_INFO','There doesn\'t seem to be a wp-config.php file. Double check that you updated wp-config.sample.php with the proper database connection information and renamed it to wp-config.php.');
define('_LANG_UPG_STEP_INFO2','<p>This file upgrades you from any previous version of WordPress to the latest. It may take a while though, so be patient. </p><p>If you&#8217;re all ready, <a href="upgrade.php?step=1">let\'s go</a>! </p>');
define('_LANG_UPG_STEP_INFO3','<p>There\'s actually only one step. So if you see this, you\'re done. <a href="../">Have fun</a>! </p>');

/* File Name wp-admin/upgrade-functions.php */
define('_LANG_INST_BASE_VALUE88','If enabled, comments will only be shown after they have been approved.');
define('_LANG_INST_BASE_VALUE89','Set this to true if you want to be notified about new comments that wait for approval');
define('_LANG_INST_BASE_VALUE90','How the permalinks for your site are constructed. See <a href=\"options-permalink.php\">permalink options page</a> for necessary mod_rewrite rules and more information.');
define('_LANG_INST_BASE_VALUE91','Whether your output should be gzipped or not. Enable this if you don&#8217;t already have mod_gzip running.');
define('_LANG_INST_BASE_VALUE92','Set this to true if you plan to use a hacks file. This is a place for you to store code hacks that won&#8217;t be overwritten when you upgrade. The file must be in your wordpress root and called <code>my-hacks.php</code>');
define('_LANG_INST_BASE_VALUE93','blog_charset');
define('_LANG_INST_BASE_VALUE94','The difference in hours between GMT and your timezone');

/* File Name wp-admin/plugins.php */
define('_LANG_PG_LEAST_LEVEL','Sorry, you must be at least a level 8 user to modify plugins.');
define('_LANG_PG_ACTIVATED_OK','Plugin <strong>activated</strong>');
define('_LANG_PG_DEACTIVATED_OK','Plugin <strong>deactivated</strong>');
define('_LANG_PG_PAGE_TITLE','Plugin Management');
define('_LANG_PG_NEED_PUT','Plugins are files you usually download seperately from WordPress that add functionality. To install a plugin you generally just need to put the plugin file into your <code>wp-content/plugins</code> directory. Once a plugin is installed, you may activate it or deactivate it here.');
define('_LANG_PG_OPEN_ERROR','Couldn\'t open plugins directory or there are no plugins available.');
define('_LANG_PG_SUB_PLUGIN','Plugin');
define('_LANG_PG_SUB_VERSION','Version');
define('_LANG_PG_SUB_AUTHOR','Author');
define('_LANG_PG_SUB_DESCR','Description');
define('_LANG_PG_SUB_ACTION','Action');
define('_LANG_PG_SUB_DEACTIVATE','Deactivate');
define('_LANG_PG_SUB_ACTIVATE','Activate');
define('_LANG_PG_GOOGLE_HILITE','When someone is referred from a search engine like Google, Yahoo, or WordPress\' own, the terms they search for are highlighted with this plugin. Packaged by <a href="http://photomatt.net/">Matt</a>.');
define('_LANG_PG_MARK_DOWN','Markdown is a text-to-HTML conversion tool for web writers. <a href="http://daringfireball.net/projects/markdown/syntax">Markdown syntax</a> allows you to write using an easy-to-read, easy-to-write plain text format, then convert it to structurally valid XHTML. This plugin <strong>enables Markdown for your posts and comments</strong>. Written by <a href="http://daringfireball.net/">John Gruber</a> in Perl, translated to PHP by <a href="http://www.michelf.com/">Michel Fortin</a>, and made a WP plugin by <a href="http://photomatt.net/">Matt</a>. If you use this you should disable Textile 1 and 2 because the syntax conflicts.');
define('_LANG_PG_TEXTILE_2','This is a simple wrapper for <a href="http://textism.com/?wp">Dean Allen\'s</a> Humane Web Text Generator, also known as <a href="http://www.textism.com/tools/textile/">Textile</a>. Version 2 adds a lot of flexibility that makes it almost a HTML meta-language. As a cost, it\'s slower. If you use this plugin you should disable Textile 1 and Markdown, as they don\'t play well together.');
define('_LANG_PG_HELLO_DOLLY','This is not just a plugin, it symbolizes the hope and enthusiasm of an entire generation summed up in two words sung most famously by Louis Armstrong. Hello, Dolly. This is, by the way, the world\'s first official WordPress plugin. When enabled you will randomly see a lyric from <cite>Hello, Dolly</cite> in the upper right of your admin screen on every page but the plugins page.');
define('_LANG_PG_TEXTILE_1','This is a simple wrapper for <a href="http://textism.com/?wp">Dean Allen\'s</a> Humane Web Text Generator, also known as <a href="http://www.textism.com/tools/textile/">Textile</a>. If you use this plugin you should disable Textile 2 and Markdown, as they don\'t play well together.');
}
?>