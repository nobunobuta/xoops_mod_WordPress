<?php
global $blog_charset;
$blog_charset = 'euc-jp';

if (!defined('WP_LANGUAGE_FILE_READ')) {
define ('WP_LANGUAGE_FILE_READ','1');
/* This is Multilingual correspondence file */
/* ���� */

/* Copylight 2004 -----------------------
Author : Otsukare
URL : http://wordpress.xwd.jp/
-------------------------------------- */

/* File Name wp-settings.php */
define('_LANG_WA_SETTING_GUIDE','<p>WordPress ME �Ϥޤ����󥹥ȡ��뤵��Ƥ��ޤ���<br /><a href="wp-admin/install.php">������򥯥�å�</a>���ƥ��󥹥ȡ����¹Ԥ��Ƥ���������</p>');

/* File Name wp-blog-header.php */
define('_LANG_WA_HEADER_GUIDE1','<p>�����С���� <b>wp-config.php</b> �ե����뤬¸�ߤ��ޤ���<br />WordPress ME �Υ��󥹥ȡ���ˤϤ��Υե����뤬ɬ�פǤ���<br /><br />�������<a href="wp-admin/install-config.php">����������</a>�����Ѥ��ƥ����С���� <b>wp-config.php</b> �ե������������뤳�Ȥ��Ǥ��ޤ�����������ˡ�Ϥ��٤ƤδĶ��Ǥ�ư����ݾ㤹�뤳�Ȥ��Ǥ��ޤ���ΤǤ�λ����������<br /><br />���������ɤ�¹Ԥ���ݤ��оݥǥ��쥯�ȥ�˽񤭹��߸��¤�Ϳ����ɬ�פ�����ޤ�(707��777) ����äƥѡ��ߥå������ѹ����Ƥ����Ƥ���������<br /><br />�����С��Ķ��ˤ�ꥦ�������ɤ��¹ԤǤ��ʤ����� <b>wp-config-sample.php</b> �򻲹ͤ˥������ <b>wp-config.php</b> ��������ƥ����С��˥��åץ��ɤ��Ƥ���������</p>');

/* File Name wp-admin/install-config.php */
define('_LANG_WA_CONFIG_GUIDE1','<p>�ե������<b>wp-config.php</b>�פϴ���¸�ߤ��ޤ������Υե�������ξ���Τ����Τɤ줫��ꥻ�åȤ���ɬ�פ�������ϡ��ޤ����Υե�����򥵡��С��夫�������Ƥ���������</p>');
define('_LANG_WA_CONFIG_GUIDE2','<p>���Υ��������ɤǤ� <b>wp-config-sample.php</b>�ե������ɬ�פȤ��ޤ������Υե����뤬�����С��˥��åץ��ɤ���Ƥ��뤫���ٳ�ǧ���Ƥ���������<p>');
define('_LANG_WA_CONFIG_GUIDE3','<p>�оݥǥ��쥯�ȥ�˽񤭹��߸��¤�Ϳ���Ƥ���������WordPress �ǥ��쥯�ȥ�Υѡ��ߥå������ѹ�����ʤ����ϡ�wp-config-sample.php �򻲹ͤ˼�ư�� <b>wp-config.php</b> ��������Ƥ���������</p>');
define('_LANG_WA_CONFIG_GUIDE4','WordPress ME �ؤ褦������<br />���åƥ��󥰤ˤϥǡ����١����ˤĤ��Ƥξ���ɬ�פǤ���<br />�ץ����οʹԤ����ˤ����ξ����������Ƥ���������');
define('_LANG_WA_CONFIG_DATABASE','�ǡ����١���̾');
define('_LANG_WA_CONFIG_USERNAME','�桼����̾');
define('_LANG_WA_CONFIG_PASSWORD','�ѥ����');
define('_LANG_WA_CONFIG_LOCALHOST','�ۥ���̾ (localhost)');
define('_LANG_WA_CONFIG_PREFIX','�ơ��֥���Ƭ��');
define('_LANG_WA_CONFIG_GUIDE5','���餫����ͳ�Ǥ��Υ��������ɤ���ǽ���ʤ����Ǥ⿴���פ�ޤ��󡣥ǡ����١�������Τ��٤Ƥ��̥ե�����ˤƹԤ����Ȥ�����ޤ��� <b>wp-config-sample.php</b> ��ƥ����ȥ��ǥ����ǳ�����ɬ�׾���򵭽Ҥ��������� <b>wp-config.php</b> �Ȥ�����¸�奵���С��إ��åץ��ɤ��Ƥ���������</p><p>���ʤ��Υǡ����١������������ʾ��ϡ����Υ��������ɤ�ʤ�����˥�󥿥륵���С�(�ۥ��ƥ���)�����ӥ����䤤��碌�Ƥ������������٤ƽ������Ǥ��Ƥ������<a href="install-config.php?step=1">������򥯥�å�</a>���Ƥ���������');
define('_LANG_WA_CONFIG_GUIDE6','�ʲ��Υե�����ˡ����ʤ��Υǡ����١�����³�ܺ٤����Ϥ��Ƥ��������������ʾ��ϥ�󥿥륵���С�(�ۥ��ƥ���)�����ӥ��ˤ��䤤��碌��������');
define('_LANG_WA_CONFIG_GUIDE7','<small>WordPress ME �ξ�����Ǽ���뤿��Υǡ����١���̾</small>');
define('_LANG_WA_CONFIG_GUIDE8','<small>MySQL �桼����̾</small>');
define('_LANG_WA_CONFIG_GUIDE9','<small>MySQL �ѥ����</small>');
define('_LANG_WA_CONFIG_GUIDE10','<small>99% localhost �Τޤ��ѹ�����ɬ�פϤ���ޤ���</small>');
define('_LANG_WA_CONFIG_GUIDE11','<small>ʣ���� WordPress ME �򥤥󥹥ȡ��뤹����ϸġ����ѹ����Ƥ�������</small>');
define('_LANG_WA_CONFIG_GUIDE12','<b>������λ !</b><br />���󥹥ȡ����ɬ�פʾ���·���ޤ�����<br />����� WordPress ME �ϥǡ����١�������³���뤳�Ȥ��Ǥ��ޤ����������Ǥ��Ƥ��������®<a href="install.php">���󥹥ȡ���</a>��¹Ԥ��Ƥ���������');


/* File Name wp-include/wp-db.php */
define('_LANG_WA_WPDB_GUIDE1','<b>�ǡ����١�������³�Ǥ��ޤ���</b><br />����ϡ����ʤ������Ͼ����������ʤ����Ȥ��̣���ޤ���<br />�������ǧ���ƺ�����³���ߤƤ���������');
define('_LANG_WA_WPDB_GUIDE2','�桼����̾���ѥ���ɤ����Τ˵������ޤ����� ?');
define('_LANG_WA_WPDB_GUIDE3','�ۥ���̾�����Τ˵������ޤ����� ?');
define('_LANG_WA_WPDB_GUIDE4','�ǡ����١����Ϻ����ѤǤ��� ?');


/* File Name wp-include/functions.php */
define('_LANG_F_TIMESTAMP','�����ॹ����פν���');
define('_LANG_F_NEW_COMMENT','�����������Ȥ��դ��Ƥ��ޤ�');
define('_LANG_F_ALL_COMMENTS','������ǥ����Ȥ����Ƥ򤹤٤Ƹ��뤳�Ȥ�����ޤ�:');
define('_LANG_F_NEW_TRACKBACK','�������ȥ�å��Хå�����Ƥ���Ƥ��ޤ�');
define('_LANG_F_ALL_TRACKBACKS','������ǥȥ�å��Хå������Ƥ򤹤٤Ƹ��뤳�Ȥ�����ޤ�:');
define('_LANG_F_NEW_PINGBACK','�������ԥ�Хå�������ޤ�');
define('_LANG_F_ALL_PINGBACKS','������ǥԥ�Хå������Ƥ򤹤٤Ƹ��뤳�Ȥ�����ޤ�:');
define('_LANG_F_COMMENT_POST','�����������Ȥ��դ��Ƥ��ޤ�');
define('_LANG_F_WAITING_APPROVAL','�ϡ����߾�ǧ�Ԥ��Ǥ�');
define('_LANG_F_APPROVAL_VISIT','�����Ȥξ�ǧ�Ϥ������:');
define('_LANG_F_DELETE_VISIT','�����Ȥκ���Ϥ������:');
define('_LANG_F_PLEASE_VISIT','��Υ����Ȥ���ǧ�Ԥ��Ǥ��� ��ǥ졼�����ѥͥ�ˤƤ���ǧ������:');

/* File Name wp-register.php */
define('_LANG_R_ENTER_LOGIN','<strong>ERROR</strong>: ��˾������̾�����Ϥ��Ƥ�������');
define('_LANG_R_PASS_TWICE','<strong>ERROR</strong>: 2����Ȥ�ѥ���ɤ����Ϥ��Ƥ�������');
define('_LANG_R_SAME_PASS','<strong>ERROR</strong>: ��ǧ�ѥѥ���ɤˤ�Ʊ����Τ����Ϥ��Ƥ�������');
define('_LANG_R_MAIL_ADDRESS','<strong>ERROR</strong>: �᡼�륢�ɥ쥹�����Ϥ��Ƥ�������');
define('_LANG_R_ADDRESS_CORRECT','<strong>ERROR</strong>: �᡼�륢�ɥ쥹�ε��Ҥ������Ǥ�');
define('_LANG_R_CHOOSE_ANOTHER','<strong>ERROR</strong>: ���Υ�����̾�ϴ��˻��Ѥ���Ƥ��ޤ����̤Τ�Τ򤴻��꤯������');
define('_LANG_R_REGISTER_CONTACT','<strong>ERROR</strong>: �Թ�ˤ�ꡢ���ʤ��Υ��С���Ͽ�ϵ��ĤǤ��ޤ��󡡾ܤ����ϡ�������</a>�����䤤��碌��������');
define('_LANG_R_USER_REGISTRATION','�������桼��������Ͽ����ޤ���');
define('_LANG_R_MAIL_REGISTRATION','������Ͽ����');
define('_LANG_R_R_COMPLETE','���С���Ͽ��λ');
define('_LANG_R_R_DISABLED','���С���Ͽ�����');
define('_LANG_R_R_CLOSED','���С���Ͽ�ϸ��ߵ��Ĥ���Ƥ��ޤ���');
define('_LANG_R_R_REGISTRATION','���С���Ͽ��Ԥ��ޤ�');
define('_LANG_R_USER_LOGIN','������̾:');
define('_LANG_R_USER_PASSWORD','�ѥ����:');
define('_LANG_R_TWICE_PASSWORD','�ѥ���ɺ�����:');
define('_LANG_R_USER_EMAIL','E-mail:');

/* File Name wp-login.php */
define('_LANG_L_LOGIN_EMPTY','������̾�����Ϥ��Ƥ�������');
define('_LANG_L_PASS_EMPTY','�ѥ���ɤ����Ϥ��Ƥ�������');
define('_LANG_L_WRONG_LOGPASS','������̾���ѥ���ɤ��㤤�ޤ�');
define('_LANG_L_RECEIVE_PASSWORD','������̾�����Ϥ���OK�򥯥�å����Ƥ��������� �ѥ���ɤ�ǡ����١�������Ͽ����Ƥ���E-mail���Ƥ��������ޤ���');
define('_LANG_L_EXIST_SORRY','���Ϥ��줿������̾���������ȤΥǡ����١�����¸�ߤ��ޤ��� �ְ�äƤ��ޤ��� ?');
define('_LANG_L_YOUR_LOGPASS','WordPress������ѥ����');
define('_LANG_L_NOT_SENT','�᡼�뤬�����Ǥ��ޤ���Ǥ���');
define('_LANG_L_DISABLED_FUNC','���顼�θ���: ���餯�����ѤΥ����С��� mail()�ؿ������ݡ��Ȥ���Ƥ��ʤ��Τ��Ȼפ��ޤ���');

define('_LANG_L_SUCCESS_SEND','���󰸤ƤΥ᡼�������������˹Ԥ��ޤ���');
define('_LANG_L_CLICK_ENTER','�����餫������󤷤Ƥ�������');
define('_LANG_L_WRONG_SESSION','Error: ������̾���ѥ���ɤ��㤤�ޤ�');
define('_LANG_L_BACK_BLOG','�ȥåפ���� ?');
define('_LANG_L_WP_RESIST','���С���Ͽ ?');
define('_LANG_L_WPLOST_YOURPASS','�ѥ����ʶ�� ?');

/* File Name wp-admin/post.php */
define('_LANG_P_NEWCOMER_MESS','������Ͽ���Ƥ���֤�ʤ��Τǡ������Ԥ����ʤ��Υ�٥��夲����Ƥ���Ĥ���ޤ��Ԥ��ʤ���Фʤ�ޤ��󡣡�ľ���˥�٥��夲�Ƥ�餤�������ϡ������Ԥ�ľ�ܥ᡼��򤹤뤳�Ȥ��Ǥ��ޤ��������ʤ�����硢���Υڡ��������ɤ�������ǥ�٥뤬ͭ���ˤʤ�ޤ���');
define('_LANG_P_DATARIGHT_EDIT','������Ƥ��Խ����뤳�ȤϽ���ޤ���');
define('_LANG_P_DATARIGHT_DELETE','������Ƥ������븢�¤�����ޤ���');
define('_LANG_P_DATARIGHT_ERROR','����˼��Ԥ��ޤ��� . . . �����ͤ�Ϣ���Ƥ���������');
define('_LANG_P_OOPS_IDCOM','����ID�ˤ�륳���ȤϤ���ޤ���');
define('_LANG_P_OOPS_IDPOS','����ID�ˤ����ƤϤ���ޤ���');
define('_LANG_P_ABOUT_FOLLOW','���Υ����Ȥ������褦�Ȥ��Ƥ��ޤ�:');
define('_LANG_P_SURE_THAT','�¹Ԥ��ޤ����������Ǥ��� ?');
define('_LANG_P_NICKNAME_DELETE','�������Ƥ������뤳�ȤϽ���ޤ���');
define('_LANG_P_COMHAS_APPR','�����Ȥ���ǧ����ޤ���');
define('_LANG_P_YOUR_DRAFTS','���:');
define('_LANG_P_WP_BOOKMARKLET','��Press it�� �򥯥�å�����ȡ����߱�����Ǥ��륵���ȤΥ�󥯾�����������ݥåץ��åץ�����ɥ��������ޤ���<br />����ˤ���®����Ƥ���ǽ�ˤʤ�ޤ���');

/* File Name wp-admin/categories.php */
define('_LANG_C_DEFAULT_CAT','���ƥ��꡼�������뤳�ȤϽ���ޤ��󡡤���ϥǥե���ȥ��åȤǤ���');
define('_LANG_C_EDIT_TITLECAT','Edit Category');
define('_LANG_C_NAME_SUBCAT','���ƥ��꡼̾:');
define('_LANG_C_NAME_SUBDESC','�յ�:');
define('_LANG_C_RIGHT_EDITCAT','���ʤ��ˤϥ��ƥ��꡼���Խ����븢�¤�����ޤ���<br />�ܤ����ϴ����������䤤��碌����������');
define('_LANG_C_NAME_CURRCAT','Current Categories');
define('_LANG_C_NAME_CATNAME','���ƥ��꡼̾');
define('_LANG_C_NAME_CATDESC','����');
define('_LANG_C_NAME_CATPOSTS','# ��ƿ�');
define('_LANG_C_NAME_CATACTION','���������');
define('_LANG_C_ADD_NEWCAT','Add New Category');
define('_LANG_C_NOTE_CATEGORY','���ƥ��꡼�������Ƥ⡢���Υ��ƥ��꡼����Ƽ��ΤϺ�����ޤ���<br />�ǥե���ȥ��ƥ��꡼�˰�ư���ޤ�');
define('_LANG_C_NAME_EDIT','�Խ�');
define('_LANG_C_NAME_DELETE','���');
define('_LANG_C_NAME_ADD','���Υ��ƥ��꡼���ɲä���');
define('_LANG_C_NAME_ADDBTN','���ƥ��꡼���ɲä��� &raquo;');
define('_LANG_C_NAME_EDITBTN','���ƥ��꡼���Խ����� &raquo;');
define('_LANG_C_NAME_PARENT','�ƥ��ƥ��꡼����');
define('_LANG_C_MESS_ADD','���ƥ��꡼���ɲä���ޤ���');
define('_LANG_C_MESS_DELE','���ƥ��꡼���������ޤ���');
define('_LANG_C_MESS_UP','���ƥ��꡼����������ޤ���');

/* File Name wp-admin/edit.php */
define('_LANG_E_LATEST_POSTS','���');
define('_LANG_E_LATEST_COMMENTS','������');
define('_LANG_E_AWAIT_MODER','��ǧ�Ԥ�������');
define('_LANG_E_SHOW_POSTS','��Ƥθ���:');
define('_LANG_E_TITLE_COMMENTS','������');
define('_LANG_E_FILL_REQUIRED','Error: ��̾���ȥ����Ȥ����Ϥ��Ƥ�������');
define('_LANG_E_TITLE_LEAVECOM','�����Ȥ����');
define('_LANG_E_RESULTS_FOUND','������� : ����̵��');

/* File Name wp-admin/edit-comments.php */
define('_LANG_EC_SHOW_COM','�����Ȥθ���:');
define('_LANG_EC_EDIT_COM','�����Ȥ��Խ�');
define('_LANG_EC_DELETE_COM','�����Ȥκ��');
define('_LANG_EC_EDIT_POST','��Ƥ��Խ� &#8220;');
define('_LANG_EC_VIEW_POST','��Ƥ�ɽ��');
define('_LANG_EC_SEARCH_MODE','���������ơ��᡼�륢�ɥ쥹��URL��IP���ɥ쥹�������Ϥ��Ƥθ���');
define('_LANG_EC_VIEW_MODE','ɸ��⡼��');
define('_LANG_EC_EDIT_MODE','�ޥ���Խ��⡼��');
define('_LANG_EC_CHECK_INVERT','�����å��ܥå�����ȿž');
define('_LANG_EC_CHECK_DELETE','�����å����������Ȥ���');
define('_LANG_EC_LINK_VIEW','ɽ��');
define('_LANG_EC_LINK_EDIT','�Խ�');
define('_LANG_EC_LINK_DELETE','���');

/* File Name wp-admin/edit-form.php */
define('_LANG_EF_PING_FORM','<label for="pingback"><a href="http://wordpress.xwd.jp/wiki/index.php?Reference%20Post%2FEdit#pingback" title="Help on Pingbacks"><strong>PingBack</strong> the <acronym title="Uniform Resource Locators">URL</acronym></a> ������ƤΥԥ�����Ф�</label><br />');
define('_LANG_EF_TRACK_FORM','<p><label for="trackback"><a href="http://wordpress.xwd.jp/wiki/index.php?Reference%20Post%2FEdit#trackback" title="Help on trackbacks"><strong>TrackBack</strong> an <acronym title="Uniform Resource Locator">URL</acronym></a>:</label> (ʣ����URL���������Ⱦ�ѥ��ڡ����Ƕ��ڤäƤ�������)<br />');
define('_LANG_EF_AD_POSTTITLE','�����ȥ�');
define('_LANG_EF_AD_CATETITLE','���ƥ��꡼');
define('_LANG_EF_AD_POSTAREA','�������');
define('_LANG_EF_AD_POSTQUICK','�����å�����');
define('_LANG_EF_AD_DRAFT','�����¸');
define('_LANG_EF_AD_PRIVATE','�ץ饤�١���');
define('_LANG_EF_AD_PUBLISH','�񤭽Ф�');
define('_LANG_EF_AD_EDITING','���٤��Խ� &raquo;');

/* File Name wp-admin/edit-form-advanced.php */
define('_LANG_EFA_POST_STATUS','��ƥ��ơ�����');
define('_LANG_EFA_AD_COMMENTS','����������');
define('_LANG_EFA_AD_PINGS','�ԥ������');
define('_LANG_EFA_POST_PASSWORD','�ѥ����');
define('_LANG_EFA_POST_CUSTOM','��������ե������');
define('_LANG_EFA_POST_EXCERPT','ȴ��');
define('_LANG_EFA_POST_LATITUDE','����:');
define('_LANG_EFA_POST_LONGITUDE','����:');
define('_LANG_EFA_POST_GEOINFO','����������ե��᡼�����');
define('_LANG_EFA_DEL_THISPOST','������Ƥ�������');
define('_LANG_EFA_SAVE_CONTINUE','��¸�����Խ���³����');
define('_LANG_EFA_STATUS_OPEN','�����ץ�');
define('_LANG_EFA_STATUS_CLOSE','������');
define('_LANG_EFA_STATUS_UPLOAD','�ե����륢�åץ���');
define('_LANG_EFA_STATUS_DISCUSS','�����ȥ��ơ�����');
define('_LANG_EFA_STATUS_ALLOWC','�����Ȥ�ǧ');
define('_LANG_EFA_STATUS_ALLOWP','�ԥ�����');
define('_LANG_EFA_STATUS_SLUG','�оݥݥ���');
define('_LANG_EFA_STATUS_POST','�������');

/* File Name wp-admin/edit-form-comment.php */
define('_LANG_EFC_BUTTON_TEXT','�Խ��μ¹�');
define('_LANG_EFC_COM_NAME','��Ƽ�̾:');
define('_LANG_EFC_COM_MAIL','�᡼�륢�ɥ쥹:');
define('_LANG_EFC_COM_URI','�ۡ���ڡ���:');
define('_LANG_EFC_COM_COMMENT','����������:');

/* File Name wp-admin/link-add.php */
define('_LANG_WLA_MANAGE_LINK','��󥯥ޥ͡�������');
define('_LANG_WLA_ADD_LINK','��󥯤��ɲ�');
define('_LANG_WLA_LINK_CATE','��󥯥��ƥ��꡼');
define('_LANG_WLA_IMPORT_BLOG','�֥�å����륤��ݡ���');
define('_LANG_WLA_LINK_TITLE','<strong>Add Link:</strong>');
define('_LANG_WLA_SUB_URI','URL:');
define('_LANG_WLA_SUB_NAME','������̾:');
define('_LANG_WLA_SUB_IMAGE','���᡼��');
define('_LANG_WLA_SUB_RSS','RSS URL: ');
define('_LANG_WLA_SUB_DESC','����');
define('_LANG_WLA_SUB_REL','REL:');
define('_LANG_WLA_SUB_XFN','XFN');
define('_LANG_WLA_SUB_NOTE','�н�:');
define('_LANG_WLA_SUB_RATE','ɾ��:');
define('_LANG_WLA_SUB_TARGET','�������å�');
define('_LANG_WLA_SUB_VISIBLE','ɽ��:');
define('_LANG_WLA_SUB_CAT','���ƥ��꡼:');
define('_LANG_WLA_SUB_FRIEND','�ե��ɥ��å�');
define('_LANG_WLA_SUB_PHYSICAL','�ե�������');
define('_LANG_WLA_SUB_PROFESSIONAL','�ץ�ե��å���ʥ�');
define('_LANG_WLA_SUB_GEOGRAPH','��������ե�����');
define('_LANG_WLA_SUB_FAMILY','�ե��ߥ꡼');
define('_LANG_WLA_SUB_ROMANTIC','��ޥ�ƥ��å�');
define('_LANG_WLA_CHECK_ACQUA','�ο�');
define('_LANG_WLA_CHECK_FRIE','ͧ��');
define('_LANG_WLA_CHECK_NONE','̵��');
define('_LANG_WLA_CHECK_MET','��� ?');
define('_LANG_WLA_CHECK_WORKER','Ʊν');
define('_LANG_WLA_CHECK_COLL','���翦');
define('_LANG_WLA_CHECK_RESI','Ʊ���');
define('_LANG_WLA_CHECK_NEIG','�ٿ�');
define('_LANG_WLA_CHECK_CHILD','�Ҷ�');
define('_LANG_WLA_CHECK_PARENT','��');
define('_LANG_WLA_CHECK_SIBLING','����');
define('_LANG_WLA_CHECK_SPOUSE','�۶���');
define('_LANG_WLA_CHECK_MUSE','�һפ�');
define('_LANG_WLA_CHECK_CRUSH','����');
define('_LANG_WLA_CHECK_DATE','�ʹ���');
define('_LANG_WLA_CHECK_HEART','����');
define('_LANG_WLA_CHECK_ZERO','0��ɾ�����оݤˤʤ�ޤ���');
define('_LANG_WLA_CHECK_STRICT','�������å�°���ϡ���XHTML 1.1�ס�1.0 Strict�פǤ�ʸˡ���顼�Ȥʤ�ޤ�');
define('_LANG_WLA_TEXT_TOOLBAR','Mozilla��Netscape�ǤϺ���������󥯤�ġ���С��˥ɥ�å����뤳�Ȥ�����ޤ�<br />�ݥåץ��åץ�����ɥ������Ѥ������ε�ǽ�ϸ��߻��Ǥ���');
define('_LANG_WLA_BUTTON_TEXTNAME','���Υ�󥯤��ɲä���');

/* File Name wp-admin/link-categories.php */
define('_LANG_WLC_DONOT_DELETE','ID��1�Υ��ƥ��꡼�Ϻ����������Ǥ��ޤ���');
define('_LANG_WLC_TITLE_TEXT','Edit Link Category &#8220;');
define('_LANG_WLC_EPAGE_TITLE','<strong>Edit</strong> a link category:');
define('_LANG_WLC_ADD_TITLE','Add a Link Category:');
define('_LANG_WLC_SUBEDIT_NAME','���ƥ��꡼̾:');
define('_LANG_WLC_SUBEDIT_TOGGLE','��ư����?');
define('_LANG_WLC_SUBEDIT_SHOW','ɽ����������:');
define('_LANG_WLC_SUBEDIT_ORDER','�����Ƚ�:');
define('_LANG_WLC_SUBEDIT_IMAGES','���᡼��');
define('_LANG_WLC_SUBEDIT_DESC','����');
define('_LANG_WLC_SUBEDIT_RATE','ɾ��');
define('_LANG_WLC_SUBEDIT_UPDATE','����');
define('_LANG_WLC_SUBEDIT_SORT','�����Ƚ�:');
define('_LANG_WLC_SUBEDIT_DESCEND','�߽�?');
define('_LANG_WLC_SUBEDIT_BEFORE','���ϥ���:');
define('_LANG_WLC_SUBEDIT_BETWEEN','��֥���:');
define('_LANG_WLC_SUBEDIT_AFTER','��λ����:');
define('_LANG_WLC_SUBEDIT_LIMIT','��ߥå�:');
define('_LANG_WLC_ADDBUTTON_TEXT','���ƥ��꡼���ɲä���');
define('_LANG_WLC_SAVEBUTTON_TEXT','��¸');
define('_LANG_WLC_CANCELBUTTON_TEXT','���ä�');
define('_LANG_WLC_SUBCATE_NAME','���ƥ��꡼̾');
define('_LANG_WLC_SUBCATE_ATT','��ư����?');
define('_LANG_WLC_SUBCATE_SHOW','ɽ����ˡ');
define('_LANG_WLC_SUBCATE_SORT','�����Ƚ�');
define('_LANG_WLC_SUBCATE_DESC','�߽�?');
define('_LANG_WLC_SUBCATE_LIMIT','��ߥå�');
define('_LANG_WLC_SUBCATE_IMAGES','���᡼��?');
define('_LANG_WLC_SUBCATE_MINIDESC','�߽�?');
define('_LANG_WLC_SUBCATE_RATE','ɾ��?');
define('_LANG_WLC_SUBCATE_UPDATE','����?');
define('_LANG_WLC_SUBCATE_BEFORE','������');
define('_LANG_WLC_SUBCATE_BETWEEN','��֥���');
define('_LANG_WLC_SUBCATE_AFTER','�ĥ���');
define('_LANG_WLC_SUBCATE_EDIT','�Խ�');
define('_LANG_WLC_SUBCATE_DELETE','���');
define('_LANG_WLC_SUBEDIT_EMPTY','���ĤΥ�󥯤�ɽ�����뤫 : ���ˤ����̵����');
define('_LANG_WLC_EPAGE_EMPTY','���ˤ����̵����');
define('_LANG_WLC_EPAGE_NOTE','���ƥ��꡼�����������Ƥ⡢���Υ��ƥ��꡼����Ͽ���Ƥ����󥯼��ΤϺ������ޤ���<br />�ǥե���ȥ��ƥ��꡼�˺ƥ��åȤ���ޤ���  :');
define('_LANG_WLC_RIGHT_PROM','���ʤ��ˤϥ�󥯥��ƥ��꡼���Խ����븢�¤�����ޤ���<br />�ܤ����ϴ����������䤤��碌��������');

/* File Name wp-admin/link-import.php */
define('_LANG_WLI_ROLL_TITLE','Import Blogroll');
define('_LANG_WLI_ROLL_DESC','Import your blogroll from another system ');
define('_LANG_WLI_ROLL_OPMLCODE','�ǥ����󥤥�塢Get Code�򥯥�å�����OPMLCode��������Ƥ���������');
define('_LANG_WLI_ROLL_OPMLLINK','�ǥ����󥤥�塢��¦��Welcome Back Box�ˤ���share�򥯥�å�����OPMLCode��������Ƥ���������(favorites.opml)');
define('_LANG_WLI_ROLL_BELOW','����򥳥ԡ����Ƥ��������Ϥ��Ƥ�������');
define('_LANG_WLI_ROLL_YOURURL','Your OPML URL:');
define('_LANG_WLI_ROLL_UPLOAD','�ǥ����ȥå׾��OPML file�򥢥åץ��ɤ������Ѥ��뤳�Ȥ��ǽ�Ǥ�');
define('_LANG_WLI_ROLL_THISFILE','���åץ����оݥե�����: ');
define('_LANG_WLI_ROLL_CATEGORY','�����Υ�󥯤����줿�����ƥ��꡼�����򤷤Ƥ���������<br />���ƥ��꡼: ');
define('_LANG_WLI_ROLL_BUTTONTEXT','����ݡ��� !');

/* File Name wp-admin/link-manager.php */
define('_LANG_WLM_PAGE_TITLE','Manage Links');
define('_LANG_WLM_LEVEL_ERROR','���ʤ��ˤϥ�󥯤��Խ����븢�¤�����ޤ���<br />�ܤ����ϴ����������䤤��碌����������');
define('_LANG_WLM_SHOW_LINKS','���ƥ��꡼���󥯤θ���:');
define('_LANG_WLM_ORDER_BY','��������������:');
define('_LANG_WLM_SHOW_BUTTONTEXT','����');
define('_LANG_WLM_SHOW_ACTIONTEXT','���������');
define('_LANG_WLM_MULTI_LINK','Manage Multiple Links:');
define('_LANG_WLM_CHECK_CHOOSE','���Υ����å��ܥå�����ޤȤ�����򤷺�Ȥ��뤳�Ȥ�����ޤ�');
define('_LANG_WLM_ASSIGN_TEXT','������Ƥ�');
define('_LANG_WLM_OWNER_SHIP','����');
define('_LANG_WLM_TOGGLE_TEXT','����');
define('_LANG_WLM_VISIVILITY_TEXT','ɽ������');
define('_LANG_WLM_MOVE_TEXT','��ư');
define('_LANG_WLM_TO_CATEGORY',' ���򥫥ƥ��꡼��');
define('_LANG_WLM_TOGGLE_BOXES','����/���');
define('_LANG_WLM_EDIT_LINK','Edit a link:');
define('_LANG_WLM_SAVE_CHANGES','�ѹ�����¸');
define('_LANG_WLM_EDIT_CANCEL','����󥻥�');

/* File Name wp-admin/menu.php */
define('_LANG_ADMIN_MENU_WRITE','���');
define('_LANG_ADMIN_MENU_EDIT','�Խ�');
define('_LANG_ADMIN_MENU_CATE','���ƥ��꡼');
define('_LANG_ADMIN_MENU_LINK','���');
define('_LANG_ADMIN_MENU_USER','�桼����');
define('_LANG_ADMIN_MENU_OPTION','���ץ����');
define('_LANG_ADMIN_MENU_PLUG','�ץ饰����');
define('_LANG_ADMIN_MENU_TEMP','�ƥ�ץ졼��');
define('_LANG_ADMIN_MENU_UPLOAD','���åץ���');
define('_LANG_ADMIN_MENU_PROFILE','�ץ�ե�����');
define('_LANG_ADMIN_MENU_VIEW','������ɽ�� &raquo;');
define('_LANG_ADMIN_MENU_LOGOUT','�������� (%s)');

/* File Name wp-admin/moderation.php */
define('_LANG_WPM_USER_LEVEL','���ʤ��ˤϥ����Ȥ�ǧ���븢�¤�����ޤ���<br />�ܤ����ϴ����������䤤��碌����������');
define('_LANG_WPM_LATE_POSTS','���');
define('_LANG_WPM_LATE_COMS','������');
define('_LANG_WPM_AWIT_MODERATION','��ǧ�Ԥ�');
define('_LANG_WPM_COM_APPROV','��Υ����Ȥ���ǧ����ޤ�����');
define('_LANG_WPM_COMS_APPROVS','��Υ����Ȥ���ǧ����ޤ�����');
define('_LANG_WPM_COM_DEL','��Υ����Ȥ��������ޤ�����');
define('_LANG_WPM_COMS_DELS','��Υ����Ȥ��������ޤ�����');
define('_LANG_WPM_COM_UNCHANGE','��Υ����Ȥ���α����ޤ�����');
define('_LANG_WPM_COMS_UNCHANGES','��Υ����Ȥ���α����ޤ�����');
define('_LANG_WPM_WAIT_APPROVAL','�����Υ����Ȥ���ǧ�Ԥ��Ǥ�:');
define('_LANG_WPM_CURR_COMAPP','��ǧ�Ԥ��Υ����ȤϤ���ޤ���');
define('_LANG_WPM_DEL_LATER','<p>�����ȤΡ־�ǧ�סֺ���ס���α�פ�����:</p>');
define('_LANG_WPM_PUBL_VISIBLE','<p><em>��ǧ</em>: ��ǧ��Ԥ��ȡ�Blog���ɽ�������褦�ˤʤ�ޤ���');
define('_LANG_WPM_AUTHOR_NOTIFIED','��Ƥ��Ф��ƥ����Ȥ��Ĥ�����硢�᡼��ˤ����Τ���ޤ���');
define('_LANG_WPM_ASKED_AGAIN','<p><em>���</em>: �����Ȥκ����¹Ԥ�������ɬ���Ƴ�ǧ���Ƥ��������� (��: ���ٺ�����Ƥ��ޤ��ȥ����Ȥ�����Ͻ���ޤ���)</p><p><em>��α</em>: �����Ȥΰ�����ä��δ���α���ޤ���</p>');
define('_LANG_WPM_MODERATE_BUTTON','�����Ȥ�ǧ');
define('_LANG_WPM_DO_NOTHING','��α');
define('_LANG_WPM_DO_DELETE','���');
define('_LANG_WPM_DO_APPROVE','��ǧ');
define('_LANG_WPM_DO_ACTION','����:');
define('_LANG_WPM_JUST_THIS','���Υ����Ȥ���');
define('_LANG_WPM_JUST_EDIT','�Խ�');
define('_LANG_WPM_COMPOST_NAME','��Ƽ�:');
define('_LANG_WPM_COMPOST_MAIL','�᡼��:');
define('_LANG_WPM_COMPOST_URL','URL:');

/* File Name wp-admin/options.php */
define('_LANG_WOP_USER_LEVEL','���ʤ��ˤϥ��ץ������Խ����븢�¤�����ޤ���<br />�ܤ����ϴ����������䤤��碌����������');
define('_LANG_WOP_PERM_LINKS','Permalinks');
define('_LANG_WOP_PERM_CONFIG','�ѡ��ޥͥ�ȥ�󥯤�����');
define('_LANG_WOP_NO_HELPS',' ���Υ��ץ����˴ؤ���إ�פϤ���ޤ���');
define('_LANG_WOP_SUBMIT_TEXT','�������¸');
define('_LANG_WOP_SETTING_SAVED',' ��Υ��åƥ��󥰤��ѹ����ޤ���');

/* File Name wp-admin/options-permalink.php */
define('_LANG_WPL_EDIT_UPDATED','�ѡ��ޥ�󥯹�¤�򹹿����ޤ�����');
define('_LANG_WPL_EDIT_STRUCT','Edit Permalink Structure');
define('_LANG_WPL_CREATE_CUSTOM','WordPress�Ǥϥѡ��ޥͥ�ȥ�󥯵ڤӥ��������֤ΰ٤Υ�������URI��������뤳�Ȥ�����ޤ���<br />���ѤǤ��륿���ϰʲ����̤�Ǥ���');
define('_LANG_WPL_CODE_YEAR','ǯ���ɽ������ˤϡ���<code>2004</code>�פΤ褦��4��ο����������ޤ���');
define('_LANG_WPL_CODE_MONTH','���ɽ������ˤϡ���<code>05</code>�פΤ褦��2��ο����������ޤ���');
define('_LANG_WPL_CODE_DAY','����ɽ������ˤϡ���<code>28</code>�פΤ褦��2��ο����������ޤ���');
define('_LANG_WPL_CODE_HOUR','����ɽ������ˤϡ���<code>15</code>�פΤ褦��2��ο����������ޤ���');
define('_LANG_WPL_CODE_MINUTE','ʬ��ɽ������ˤϡ���<code>43</code>�פΤ褦��2��ο����������ޤ���');
define('_LANG_WPL_CODE_SECOND','�ä�ɽ������ˤϡ���<code>33</code>�פΤ褦��2��ο����������ޤ���');
define('_LANG_WPL_CODE_POSTNAME','�ݥ���̾���this-is-a-great-post�פΤ褦�ˤ���С���This Is A Great Post!�� �ȥ��˥���������ޤ���');
define('_LANG_WPL_CODE_POSTID','��Ƥ���̤��뤿��Υ�ˡ���ID');
define('_LANG_WPL_USE_EXAMPLE','<p>��Ȥ���</p>
<p><code>/archives/%year%/%monthnum%/%day%/%postname%/</code></p>
<p>�Τ褦�˽񤱤С��ѡ��ޥ�󥯤ϼ��Τ褦�ˤʤ�ޤ�</p>
<p><code>/archives/2003/05/23/my-cheese-sandwich/</code></p>
<p>�̾盧�ε�ǽ�ϥ����С��˥��󥹥ȡ��뤵�줿 mod_rewrite �����Ѥ��ʤ��ƤϤʤ�ޤ��󤬡��ʲ��Τ褦�˥ե�����̾��������������� WordPress �Ϥ��Υե�����̾����Ѥ��ư������Ϥ����Ȼ�ߤޤ���</p>
<p><code>/index.php/archives/%year%/%monthnum%/%day%/%postname%/</code> </p>
<p>���ε�ǽ�����Ѥ���� mod_rewrite �Υ롼���̵�뤹�뤳�Ȥ��Ǥ��ޤ���</p>
');
define('_LANG_WPL_USE_TEMPTEXT','�Ǥϡ��嵭�θ��ܤ򻲹ͤˤ��ƥ�����������Ƥ���������');
define('_LANG_WPL_USE_BLANK','���ƥ��꡼ URI �ѤΥ���������Ƭ�����Ͽ���뤳�Ȥ�����ޤ����㤨�С�<code>/taxonomy/categorias</code> �����Ϥ���� <code>http://example.org/taxonomy/categorias/general/</code> �Τ褦�ʥ��ƥ��꡼��󥯤���������ޤ������Υե�����ɤ����ξ��ϥǥե���Ȥ����꤬���Ѥ���ޤ���');
define('_LANG_WPL_USE_HTACCESS','���ߤΥѡ��ޥ�󥯹�¤���͡�<code>%s</code>������Ѥ���ˤϡ�<code>.htaccess</code> �˰ʲ��� mod_rewrite �롼��ε��Ҥ�ɬ�פǤ����ե�����ɤ򥯥�å�����<kbd>CTRL + a</kbd> �����Ǥ��٤Ƥ����򤷤ޤ���');
define('_LANG_WPL_ENGINE_ON','RewriteEngine On RewriteBase');
define('_LANG_WPL_EDIT_TEMPLATE','<p>WordPress �ˤ�� <code>.htaccess</code> �ؤν񤭹��ߤ���ǽ�ʾ��֤Ǥ���С�<a href=\"%s\">�ƥ�ץ졼�ȥ��󥿡��ե��������̤����Խ�</a>���뤳�Ȥ��Ǥ��ޤ���</p>');
define('_LANG_WPL_MOD_REWRITE','���ߥ������ޥ������줿�ѡ��ޥ�󥯤���Ѥ��Ƥ��ޤ����ä� mod_rewrite �롼���ɬ�פǤϤ���ޤ���');
define('_LANG_WPL_SUBMIT_UPDATE','�ѡ��ޥ�󥯹�¤�򹹿� &raquo;');

/* File Name wp-admin/profile.php */
define('_LANG_WPF_ERR_NICKNAME','<strong>ERROR</strong>: �˥å��͡�������Ϥ��Ƥ������� (������̾��Ʊ���ǹ����ޤ���)');
define('_LANG_WPF_ERR_ICQUIN','<strong>ERROR</strong>: ICQ UIN �Ͽ����Ǥ���ɬ�פ�����ޤ���ʸ����ϼ����դ����ޤ���');
define('_LANG_WPF_ERR_TYPEMAIL','<strong>ERROR</strong>: �᡼�륢�ɥ쥹�����Ϥ��Ƥ�������');
define('_LANG_WPF_ERR_CORRECT','<strong>ERROR</strong>: �᡼�륢�ɥ쥹�ε��Ҥ������Ǥ�');
define('_LANG_WPF_ERR_TYPETWICE','<strong>ERROR</strong>: 2����Ȥ�ѥ���ɤ����Ϥ��Ƥ�������');
define('_LANG_WPF_ERR_DIFFERENT','<strong>ERROR</strong>: ��ǧ�ѥѥ���ɤˤ�Ʊ����Τ����Ϥ��Ƥ�������');
define('_LANG_WPF_ERR_PROFILE','<strong>ERROR</strong>: �ץ�ե�������Խ�������ޤ��� . . . �����������䤤��碌����������');
define('_LANG_WPF_SUBT_VIEW','View Profile');
define('_LANG_WPF_SUBT_FIRST','̾:');
define('_LANG_WPF_SUBT_LAST','��:');
define('_LANG_WPF_SUBT_NICK','�˥å��͡���:');
define('_LANG_WPF_SUBT_MAIL','E-Mail:');
define('_LANG_WPF_SUBT_URL','URL:');
define('_LANG_WPF_SUBT_ICQ','ICQ:');
define('_LANG_WPF_SUBT_AIM','AIM:');
define('_LANG_WPF_SUBT_MSN','MSN IM:');
define('_LANG_WPF_SUBT_YAHOO','Yahoo IM:');
define('_LANG_WPF_SUBT_ONE','��󥯥�å��֥å��ޡ���');
define('_LANG_WPF_SUBT_COPY','One-click bookmarklet��ͭ���ˤ���ˤϡ�<br />
�ʲ���ƥ����ȥե�����إڡ����Ȥ��Ƥ�������:');
define('_LANG_WPF_SUBT_BOOK','wordpress.reg�Ȥ��Ƥ������¸���ơ����Υե��������֥륯��å����Ƥ���������<br />����������Ƥ���Internet Explorer��Ƶ�ư���Ƥ���������<br /><br />�ʾ�Ǵ�λ�Ǥ���IE������ɥ�����Ǳ�����å�����ȡ�<br />bookmarklet����Ȥ������򤷤�WordPress�ؤ���ƥե����ब�����ޤ���');
define('_LANG_WPF_SUBT_CLOSE','���Υ�����ɥ����Ĥ���');
define('_LANG_WPF_SUBT_UPDATED','�ץ�ե����뤬��������ޤ���');
define('_LANG_WPF_SUBT_EDIT','Edit Your Profile');
define('_LANG_WPF_SUBT_USERID','User ID:');
define('_LANG_WPF_SUBT_LEVEL','Level:');
define('_LANG_WPF_SUBT_POSTS','Posts:');
define('_LANG_WPF_SUBT_LOGIN','Login:');
define('_LANG_WPF_SUBT_DESC','���ʾҲ�:');
define('_LANG_WPF_SUBT_IDENTITY','����BLOG���Ʊ���ʪ: ');
define('_LANG_WPF_SUBT_NEWPASS','<strong>���ѥ����</strong> (�ѹ����ʤ�����̤������)');
define('_LANG_WPF_SUBT_MOZILLA','�����ɥС������Ĥ���ޤ��� �����Mozilla 0.9.4�ʹߤε�ǽ�Ǥ�');
define('_LANG_WPF_SUBT_SIDEBAR','�����ɥС�');
define('_LANG_WPF_SUBT_FAVORITES','�������������Ͽ����:');
define('_LANG_WPF_SUBT_UPDATE','���åץǡ���');

/* File Name wp-admin/sidebar.php */
define('_LANG_WAS_SIDE_POSTED','��ƴ�λ');
define('_LANG_WAS_SIDE_AGAIN','³������Ƥ���ˤ�<a href="sidebar.php">������</a>�򥯥�å�');

/* File Name wp-admin/templates.php */
define('_LANG_WAT_LEVEL_ERR','<p>���ʤ��ˤϥƥ�ץ졼�Ȥ��Խ����븢�¤�����ޤ���<br />
�ܤ����ϴ����������䤤��碌����������</p>');
define('_LANG_WAT_SORRY_EDIT','���Υե�������Խ����뤳�ȤϽ���ޤ���<br />���ʤ���WordPress�ۡ���ǥ��쥯�ȥ꡼��Υե�������Խ����褦�Ȥ��Ƥ���С��ե�����̾�����Ϥ��������OK�Ǥ���');
define('_LANG_WAT_SORRY_PATH','�����ե������ƤӽФ����Ȥ�����ޤ���');
define('_LANG_WAT_EDITED_SUCCESS','<em>�ե�������Խ����������ޤ���</em>');
define('_LANG_WAT_FILE_CHMOD','�Խ�������ϳ����ե�����Υѡ��ߥå�����766�ˤ��Ƥ�������');
define('_LANG_WAT_OOPS_EXISTS','<p>���Τ褦�ʥե������¸�ߤ��ޤ��󡡥ե�����̾��Ƴ�ǧ���Ƥ�������</p>');
define('_LANG_WAT_OTHER_FILE','�ѡ��ߥå�����[766]�ˤ��뤳�Ȥˤ�äơ����β��̤ˤ�<a href="templates.php?file=wp-comments.php">�����ȥƥ�ץ졼��</a>��<a href="templates.php?file=wp-comments-popup.php">�ݥåץ��åס������ȥƥ�ץ졼��</a>���Խ����뤳�Ȥ�����ޤ���������ˡ�¾�Υե��������ꤷ���Խ����뤳�Ȥ��ǽ�Ǥ���');
define('_LANG_WAT_TYPE_HERE','�����ե�����̾�����Ϥ��Ƥ�������:');
define('_LANG_WAT_FTP_CLIENT','������ƥ����ȥ��ǥ������ǥƥ�ץ졼�Ȥ��Խ����������򥢥åץ��ɤ��뤳�Ȥ��Ǥ��ޤ���<br />���Υ���饤�󡦥��ǥ������ϥ�����Ǥ��Խ����Ѥ路����������Ȥ��Ƥ��Ȥ�����������');
define('_LANG_WAT_UPTEXT_TEMP','���åץǡ��� !');

/* File Name wp-admin/upload.php */
define('_LANG_WAU_ADMIN_DISABLED','�����ͤˤ�ꡢ���ε�ǽ����ߤ���Ƥ��ޤ�');
define('_LANG_WAU_FILE_UPLOAD','�ե����륢�åץ���');
define('_LANG_WAU_CAN_TYPE','���åץ��ɲ�ǽ�ʥե������ĥ��:');
define('_LANG_WAU_MAX_SIZE','�ե�����κ��祵����:');
define('_LANG_WAU_FILE_DESC','����������(alt):');
define('_LANG_WAU_BUTTON_TEXT','���åץ��� !');
define('_LANG_WAU_ATTACH_ICON','ź�եե�����Υ�������Τ�');

/* File Name wp-admin/users.php */
define('_LANG_WUS_WHOSE_LEVEL','���ʤ����⤤�桼������٥�Υ�٥���ѹ����뤳�ȤϤǤ��ޤ���');
define('_LANG_WUS_WHOSE_DELETE','���ʤ����⤤��٥�Υ桼�����������뤳�ȤϤǤ��ޤ���');
define('_LANG_WUS_CANNOT_DELU','���Υ桼�����Ϻ���Ǥ��ޤ���');
define('_LANG_WUS_CANNOT_DELUPOST','���Υ桼��������ƤϺ���Ǥ��ޤ���');
define('_LANG_WUS_AU_THOR','Authors');
define('_LANG_WUS_AU_NICK','�˥å��͡���');
define('_LANG_WUS_AU_NAME','������̾');
define('_LANG_WUS_AU_MAIL','E-Mail');
define('_LANG_WUS_AU_URI','URL');
define('_LANG_WUS_AU_LEVEL','��٥�');
define('_LANG_WUS_AU_POSTS','��ƿ�');
define('_LANG_WUS_AU_USERS','Users');
define('_LANG_WUS_AU_WARNING','�桼�����������뤿��ˤϡ��ޤ������桼�����Υ�٥���0�פˤ��Ƥ�������<br />���ˡ��֤�X�ޡ����򥯥�å����Ƥ�������<br />�� �桼�����κ���ϡ����Υ桼�����ˤ����Ƥ⤹�٤ƺ������ޤ���');
define('_LANG_WUS_ADD_USER','���Υ桼�������ɲä���');
define('_LANG_WUS_ADD_THEMSELVES','������Υ��С���Ͽ���̤�Ʊ���������Υڡ����Ǥ⿷�������С�����Ͽ���뤳�Ȥ�����ޤ���');
define('_LANG_WUS_ADD_FIRST','�ե������ȥ͡��� ');
define('_LANG_WUS_ADD_LAST','�饹�ȥ͡��� ');
define('_LANG_WUS_ADD_TWICE','�ѥ���� (2�ս�) ');

/* File Name wp-comments.php */
define('_LANG_WPCM_LOAD_DIRECTLY','���Υǥ��쥯�ȥ�Υե������ľ�ܤ������������ޤ���');
define('_LANG_WPCM_ENTER_PASS','<p>�����Ȥ򸫤뤿��Υѥ���ɤ����Ϥ��Ƥ���������<p>');
define('_LANG_WPCM_COM_TITLE','������');
define('_LANG_WPCM_COM_RSS','���Υ����Ȥ�<abbr title="Really Simple Syndication">RSS</abbr>');
define('_LANG_WPCM_COM_TRACK','TrackBack URL : ');
define('_LANG_WPCM_COM_YET','������Ƥˤϡ��ޤ������Ȥ��դ��Ƥ��ޤ���');
define('_LANG_WPCM_COM_LEAVE','�����Ȥ����');
define('_LANG_WPCM_HTML_ALLOWED','���Ԥ�����ϼ�ư�Ǥ�<br />URL��E-mail�ϼ�ưŪ�˥�󥯤���ޤ��Τǡ�&lt;a&gt;���������פǤ���<br /><acronym title="Hypertext Markup Language">HTML</acronym> allowed: ');
define('_LANG_WPCM_COM_YOUR','�����Ȥ�ɤ���');
define('_LANG_WPCM_PLEASE_NOTE','<strong>����� : </strong>���åƥ��󥰤ˤ�ꡢ��������Ƥ���ºݤ˱����Ǥ���褦�ˤʤ�ޤǻä����֤��ݤ����礬����ޤ��� ����Ƥ�ɬ�פϤ���ޤ���Τǡ�ɽ�������ޤǤ��Ԥ���������');
define('_LANG_WPCM_COM_SAYIT','Say it !');
define('_LANG_WPCM_THIS_TIME','�����ʤ��������ߥ����Ȥ��դ��뤳�ȤϽ���ޤ���');
// define('_LANG_WPCM_GO_BACK','Go Back');
define('_LANG_WPCM_COM_NAME','Name');

/* File Name wp-comments-post.php */
define('_LANG_WPCP_SORRY_ITEM','�����ʤ���  ������Ƥ��Ф��륳���Ȥϼ����դ��Ƥ��ޤ���');
define('_LANG_WPCP_ERR_FILL','Error: ��̾���ȥ᡼�륢�ɥ쥹�������Ƥ�������');
define('_LANG_WPCP_ERR_TYPE','Error: �����Ȥ������Ƥ�������');
define('_LANG_WPCP_SORRY_SECONDS','�����ʤ���  ³������Ƥ������10�ðʾ���֤�����Ƥ�������');

/* File Name wp-admin/upload.php */
define('_LANG_WAU_UPLOAD_DISABLED','�����ͤˤ�ꤳ�ε�ǽ�λ��Ѥ����Ĥ���Ƥ��ޤ���');
define('_LANG_WAU_UPLOAD_DIRECTORY','���ꤵ�줿�ǥ��쥯�ȥ꡼���񤭹��߲�ǽ�ˤʤäƤ��ޤ���Τǡ����ߥ��åץ��ɵ�ǽ�����Ѥ��뤳�Ȥ��Ǥ��ޤ���<br />�ǥ��쥯�ȥ꡼�Υѡ��ߥå����ڤӥե�ѥ�����٥����å����Ƥ�������');
define('_LANG_WAU_UPLOAD_EXTENSION','���åץ��ɲ�ǽ�ʥե�����μ��� : ');
define('_LANG_WAU_UPLOAD_BYTES','���åץ��ɲ�ǽ�ʥե�����Υ����� : ');
define('_LANG_WAU_UPLOAD_OPTIONS','Admin���¤򤪻����ʤ饪�ץ��������Ǥ������ͤ����ꤹ�뤳�Ȥ��Ǥ��ޤ�');
define('_LANG_WAU_UPLOAD_FILE','�ե����������:');
define('_LANG_WAU_UPLOAD_ALT','���� (ALT):');
define('_LANG_WAU_UPLOAD_THUMBNAIL','����ͥ���������ץ����');
define('_LANG_WAU_UPLOAD_NO','�������ʤ�');
define('_LANG_WAU_UPLOAD_SMALL','���⡼�륵���� (Ĺ��¦ 200px)');
define('_LANG_WAU_UPLOAD_LARGE','�顼�������� (Ĺ��¦ 400px)');
define('_LANG_WAU_UPLOAD_CUSTOM','�������ॵ����');
define('_LANG_WAU_UPLOAD_PX','px (Ĺ��¦)');
define('_LANG_WAU_UPLOAD_BTN','�ե����륢�åץ���');
define('_LANG_WAU_UPLOAD_SUCCESS','���ꤵ�줿�ե�����Υ��åץ��ɤ���λ���ޤ��� : ');
define('_LANG_WAU_UPLOAD_CODE','�������ɽ���ѥ����ɤ򤪻Ȥ������� :');
define('_LANG_WAU_UPLOAD_START','���åץ��ɤ�³����');
define('_LANG_WAU_UPLOAD_DUPLICATE','�ե�����̾����ʣ���Ƥ��ޤ��� ?');
define('_LANG_WAU_UPLOAD_EXISTS','����̾���Υե�����ϴ���¸�ߤ��ޤ� : ');
define('_LANG_WAU_UPLOAD_RENAME','��ǧ���뤫��̾���Ƥ�������:');
define('_LANG_WAU_UPLOAD_ALTER','����̾:');
define('_LANG_WAU_UPLOAD_REBTN','��͡���');
define('_LANG_WAU_UPLOAD_CODEIN','���Υ����ɤ���ƥե����������');
define('_LANG_WAU_UPLOAD_AMAZON','���ޥ��󥢥���������');

/* File Name wp-admin/options-general.php */
define('_LANG_WAO_GENERAL_DISABLED','���ʤ��ϡ�����Blog���Խ����븢�¤���äƤ��ޤ���');
define('_LANG_WAO_GENERAL_WPTITLE','�����֥������ȥ�:');
define('_LANG_WAO_GENERAL_TAGLINE','�����饤��:');
define('_LANG_WAO_GENERAL_URI','���ɥ쥹(URI):');
define('_LANG_WAO_GENERAL_MAIL','���ɥ쥹(E-Mail):');
define('_LANG_WAO_GENERAL_MEMBER','���С����å�:');
define('_LANG_WAO_GENERAL_GMT','����˥å�ɸ���:');
define('_LANG_WAO_GENERAL_DIFFER','����(GMT+):');
define('_LANG_WAO_GENERAL_EXPLIAIN','���˴ؤ���Weblog�� (description)');
define('_LANG_WAO_GENERAL_ADMIN','���Υ��ɥ쥹�ϴ����Τ���ˤΤ߻��Ѥ���ޤ���');
define('_LANG_WAO_GENERAL_REGISTER','���С���Ͽ����Ĥ���');
define('_LANG_WAO_GENERAL_ARTICLES','���С��⵭�����ɽ���뤳�Ȥ��Ǥ���');
define('_LANG_WAO_GENERAL_UPDATE','���åץǡ���');

/* File Name wp-admin/options-writing.php */
define('_LANG_WAO_WRITING_ERROR','���ʤ��ˤϡ����Υ��ץ������Խ����븢�¤�����ޤ���');
define('_LANG_WAO_WRITING_TITLE','Writing Options');
define('_LANG_WAO_WRITING_SIMPLE','����ץ륹������');
define('_LANG_WAO_WRITING_ADVANCED','��ĥ��������');
define('_LANG_WAO_WRITING_LINES','��');
define('_LANG_WAO_WRITING_DISPLAY',':-) �� :-P �򥰥�ե��å����֤�������ɽ������');
define('_LANG_WAO_WRITING_XHTML','XHTML�ι�ʸ���顼��ưŪ�˽�������');
define('_LANG_WAO_WRITING_CHARACTER','ʸ�������ɤλ��� (UTF-8 ��侩)');
define('_LANG_WAO_WRITING_STYLE','��ƥե������ɽ����������:');
define('_LANG_WAO_WRITING_BOX','��ƥե�����Υ�����:');
define('_LANG_WAO_WRITING_FORMAT','�ե����ޥå�:');
define('_LANG_WAO_WRITING_ENCODE','���󥳡���:');
define('_LANG_WAO_WRITING_SERVICES','���åץǡ��ȥ����ӥ�');
define('_LANG_WAO_WRITING_SOMETHING','������ƻ��˥ԥ�����Ф�URL��ꥹ�Ȥˤ��Ƥ����������Ǥ���<br />���Ԥ�����뤳�Ȥ�ʣ���Υ����Ȥ���ꤹ�뤳�Ȥ�����ޤ���');
define('_LANG_WAO_WRITING_UPDATE','���ץ����򹹿�');

/* File Name wp-admin/options-discussion.php */
define('_LANG_WAO_DISCUSS_TITLE','Discussion Options');
define('_LANG_WAO_DISCUSS_INDIVIDUAL','��ƤΤ����ɸ�ॻ�åƥ���: (�����Υ��åƥ��󥰤ˤ�ꥪ���С��饤�ɤ���ޤ�)');
define('_LANG_WAO_DISCUSS_NOTIFY','��Ƶ����椫���󥯤������٤Ƥ�Weblog�����Τ��� (�¹Ԥ˻��֤��ݤ���ޤ�)');
define('_LANG_WAO_DISCUSS_PINGTRACK','¾��Weblogs����Υ�����Τ���Ĥ��� (Pingback �� Trackback)');
define('_LANG_WAO_DISCUSS_PEOPLE','��Ƥ��Ф���ï�Ǥ⥳���Ȥ�Ĥ��뤳�Ȥ������褦�ˤ���');
define('_LANG_WAO_DISCUSS_EMAIL','�᡼�����Τ˴ؤ���:');
define('_LANG_WAO_DISCUSS_ANYONE','���٤ƤΥ����Ȥ��Ф������Τ���');
define('_LANG_WAO_DISCUSS_DECLINED','�����Ȥ���ǧ����뤫�Ѳ����줿�Ȥ������Τ���');
define('_LANG_WAO_DISCUSS_APPEARS','������ɽ������ˡ:');
define('_LANG_WAO_DISCUSS_ADMIN','�����Ȥ�ɽ���ˤϴ����Ԥε��Ĥ�ɬ�� (�ʲ�������˺������줺)');
define('_LANG_WAO_DISCUSS_MODERATION','���ꤷ��̾����URL���뤤�ϥ᡼�륢�ɥ쥹��ʲ���ñ��Τ����β��줫��ޤ�Ǥ��륳���Ⱦ�硢�����ͤξ�ǧ�Ԥ��ˤ��뤳�Ȥ�����ޤ�:(���Ԥˤ����ĤǤ���ꤹ�뤳�Ȥ�����ޤ�)');

/* File Name wp-admin/options-reading.php */
define('_LANG_WAO_READING_TITLE','Reading Options');
define('_LANG_WAO_READING_FRONT','�ե��ȥڡ���');
define('_LANG_WAO_READING_RECENT','�ǿ����ɽ����:');
define('_LANG_WAO_READING_FEEDS','�������̥ե�����');
define('_LANG_WAO_READING_ARTICLE','ɽ����ˡ:');
define('_LANG_WAO_READING_ENCODE','����ʸ��������:');
define('_LANG_WAO_READING_CHARACTER','ʸ�������ɤλ��� (<a href="http://developer.apple.com/documentation/macos8/TextIntlSvcs/TextEncodingConversionManager/TEC1.5/TEC.b0.html">UTF-8 ��侩</a>)');
define('_LANG_WAO_READING_GZIP','gzip�����Ѥ���');
define('_LANG_WAO_READING_BTNTXT','���ץ����򹹿�');

/* Cheatin&#8217; uh? */
define('_LANG_P_CHEATING_ERROR','���ߤΥ�٥�ǤϤ����Ѥ��������ޤ���');


/* Start Install ************************************************/
/* File Name wp-admin/install.php */
define('_LANG_INST_GUIDE_WPCONFIG','<p>�����С���� <b>wp-config.php</b> �ե����뤬¸�ߤ��ޤ���<br />WordPress ME �Υ��󥹥ȡ���ˤϤ��Υե����뤬ɬ�פǤ���<br /><br />�������<a href="install-config.php">����������</a>�����Ѥ��ƥ����С���� <b>wp-config.php</b> �ե������������뤳�Ȥ��Ǥ��ޤ�����������ˡ�Ϥ��٤ƤδĶ��Ǥ�ư����ݾ㤹�뤳�Ȥ��Ǥ��ޤ���ΤǤ�λ����������<br /><br />�Ǥ�μ¤���ˡ�� <b>wp-config-sample.php</b> �򻲹ͤ˼�ư�ǥե������������뤳�ȤǤ���</p>');
define('_LANG_INST_GUIDE_INSTALLED','<p>����WordPress ME �ϥ��󥹥ȡ��뤵��Ƥ��ޤ���<br />�ƥ��󥹥ȡ��뤹����ϥǡ����١�������ơ��֥�������Ƥ���������</p></body></html>');
define('_LANG_INST_GUIDE_WEL','<br />�����Ǥϡ����󥹥ȡ���ΰ٤δ��Ĥ��Υ��ƥåפ򤴰��⤷�ޤ���<br />���󥹥ȡ����Ϥ�����ˡ����ʤ��Ȥ� 4.0.6 ��PHP�С������ɬ�פǤ���<br />
���ߤ�������Υ����С��˥��󥹥ȡ��뤵��Ƥ���С������Ϥ�����Ǥ� : ');
define('_LANG_INST_GUIDE_COM','<p>���Υ��ƥåפ˿ʤ����� wp-config.php �ǥǡ����١�����³�����������ɬ�פ�����ޤ�(���������ɼ¹�����������פǤ�) �ޤ���weblogs.com.changes.cache �Ȥ����ե�����Υѡ��ߥå�����[666]�ˤ���ɬ�פ�����ޤ���<br /><br />Readme��Ƴ�ǧ����ˤ�<a href="../wp-readme/">������</a>�����٤ƽ������Ǥ��Ƥ������ <a href="install.php?step=1">Step 1</a> �ؿʤ�Ǥ���������</p>');
define('_LANG_INST_STEP1_FIRST','<p>��󥯥ǡ����١����򥻥åȥ��åפ��ޤ�<br />Weblogs.com ����Ͽ���뤳�Ȥǡ�blogroll �����Ѥ��뤳�Ȥ���ǽ�Ǥ���</p>');
define('_LANG_INST_STEP1_LINKS','<p>WP-Links �򥤥󥹥ȡ�����Ǥ���</p><p>�ǡ����١����ơ��֥������å���</p>');
define('_LANG_INST_STEP1_ALLDONE','���Ф餷�� !��������ؤ����ˤ��ޤ����͡� ���Τޤ� <a href="install.php?step=2">Step 2</a> �ؿʤ�Ǥ���������');
define('_LANG_INST_STEP2_INFO','�ǡ����١��������ɬ�פ�Blog�ơ��֥��������ޤ���');
/* base options from b2cofig */
define('_LANG_INST_BASE_VALUE1','���ʤ���Blog��URL�Ǥ�(�Ǹ�˥���å���ϤĤ��ʤ��ǲ�����)');
define('_LANG_INST_BASE_VALUE2','�ǥե���ȤΥե�����̾����ꤷ�Ƥ�������');
define('_LANG_INST_BASE_VALUE3','����Blog��̾������ꤷ�Ƥ�������(������̾)');
define('_LANG_INST_BASE_VALUE4','���ʤ���Blog������(description)');
define('_LANG_INST_BASE_VALUE7','�����桼�����������˵�������Ƥ��뤳�Ȥ������褦�ˤ���');
define('_LANG_INST_BASE_VALUE8','�����桼��������Ͽ����Ĥ���');
define('_LANG_INST_BASE_VALUE54','�����ͤΥ᡼�륢�ɥ쥹 (���Τ�)');
// general blog setup
define('_LANG_INST_BASE_VALUE9','���λϤ����������');
define('_LANG_INST_BASE_VALUE11','[b]bold[/b]�Τ褦��BBCode����Ѥ���');
define('_LANG_INST_BASE_VALUE12','**bold** \\\\italic\\\\ __underline__�Τ褦��<br>GreyMatter-style����Ѥ���');
define('_LANG_INST_BASE_VALUE13','�ܥ���ˤ�륯���å���������Ѥ��� (Mac IE�Ǥ����ѤǤ��ޤ���)');
define('_LANG_INST_BASE_VALUE14','����! ���졢���ܸ졢�ڹ�줽��¾�Υޥ���Х��ȸ���Ǥ�<br>���ѻ��ˤ�ɬ��[false]�ˤ��Ƥ�������');
define('_LANG_INST_BASE_VALUE15','��������Ĥ�����硢���줬������̤򾷤���礬����ޤ���<br>���Ѿ����ˤ���ޤ���[false]�ˤ��뤳�Ȥ򤪴��ᤷ�ޤ�');
define('_LANG_INST_BASE_VALUE16','��ƻ��˥��ޥ��꡼��������λ��Ѥ���Ĥ��뤳�Ȥǡ�<br>��̯�ʥ˥奢�󥹤������뤳�Ȥ���ǽ�Ȥʤ�ޤ�');
define('_LANG_INST_BASE_VALUE17','���ޥ��꡼��������Τ���ǥ��쥯�ȥ����� (�Ǹ�Υ���å��������)');
define('_LANG_INST_BASE_VALUE18','��������ƻ���̾���ȥ᡼�륢�ɥ쥹�����Ϥ�ɬ�ܤˤ��롣<br>[false]�ˤ���ȡ�����餬̤�����Ǥ⥳���Ȥ���Ƥ��뤳�Ȥ�����ޤ�');
define('_LANG_INST_BASE_VALUE20','�����Ȥ���Ƥ��줿�ݥ᡼�����Τ���');
/* rss/rdf feeds */
define('_LANG_INST_BASE_VALUE21','RSS�˽��Ϥ��뵭����');
define('_LANG_INST_BASE_VALUE22','RSS�˽��Ϥ������<br>(����:<a href="http://backend.userland.com/stories/storyReader$16" target="_blank">http://backend.userland.com/stories/storyReader$16</a>');
define('_LANG_INST_BASE_VALUE23','b2rss.php�ˤ�&lt;description>���HTML��������Ĥ��ޤ��� ?');
define('_LANG_INST_BASE_VALUE24','RSS�ǽ��Ϥ���ȴ�赭����Ĺ��(0=̵����)<br>�� : b2rss.php�Ǥϥ����ɲ����줿HTML����Ѥ����0�˥��åȤ���ޤ���');
define('_LANG_INST_BASE_VALUE25','RSS�����Ѥ�ȴ��ե�����ɤ���Ѥ���');
define('_LANG_INST_BASE_VALUE26','��Ƶ�����http://weblogs.com/�ˤƥꥹ�Ȳ�����뤳�Ȥ���Ĥ���');
define('_LANG_INST_BASE_VALUE27','��Ƶ�����http://blo.gs/�ˤƥꥹ�Ȳ�����뤳�Ȥ���Ĥ���');
define('_LANG_INST_BASE_VALUE28','������ѹ�����ɬ�פϤ���ޤ���');
define('_LANG_INST_BASE_VALUE29','Trackback�λ��Ѥ���Ĥ��뤫���ʤ��������ꤷ�Ƥ�������<br>[false]�ˤ�������ѤǤ��ʤ��ʤ�ޤ���');
define('_LANG_INST_BASE_VALUE30','Pingback�λ��Ѥ���Ĥ��뤫���ʤ��������ꤷ�Ƥ�������<br>[false]�ˤ�������ѤǤ��ʤ��ʤ�ޤ���');
define('_LANG_INST_BASE_VALUE31','[true]�ǥե�����Υ��åץ��ɤ���ġ�[false]�Ƕػ�');
define('_LANG_INST_BASE_VALUE32','�����򥢥åץ��ɤ���ǥ��쥯�ȥ�����Хѥ��ǻ��ꤷ�Ƥ�������<br>(�Ǹ�Υ���å��������)�������С���UNIX�Ķ��ξ��ϡ�<br>�����ǥ��쥯�ȥ�Υѡ��ߥå�����[766]�ʾ�ˤ��Ƥ�������');
define('_LANG_INST_BASE_VALUE33','���Υǥ��쥯�ȥ꡼��URL�����Ϥ��ޤ�<br>(���åץ��ɤ��줿�ե�����ؤΥ�󥯤��������뤿��˻��Ѥ���ޤ�)<br>�������Ǹ�Υ���å�������פǤ�');
define('_LANG_INST_BASE_VALUE34','���Ĥ���ե����륿���פ���ꤷ�ޤ� ���Υꥹ�Ȥ��������Ȥ��Ǥ��ޤ�<br>(�ƥե����륿���פ�Ⱦ�ѥ��ڡ����Ƕ��ڤäƤ�������)');
define('_LANG_INST_BASE_VALUE35','���åץ��ɲ�ǽ�ʥե����륵��������ꤷ�Ƥ���������<br>�ۤȤ�ɤΥ����С��Ǥ�2048KB�����¤���Ƥ��ޤ�<br>(�����С��θ³��ͤ��⤤�ͤ򥻥åȤ��Ƥ��̣������ޤ���)');
define('_LANG_INST_BASE_VALUE36','�ե�����Υ��åץ��ɤ���Ĥ���桼������٥�����ꤷ�Ƥ�������');
define('_LANG_INST_BASE_VALUE37','�������Ȥϴط��ʤ��������ͤ����ꤷ������Υ桼���������ե������<br>���åץ��ɤ���Ĥ��뤳�Ȥ����ޤ���<br>���ξ��Ϥ�����ǥ桼����̾����ꤷ�ޤ���<br>ʣ���ξ���Ⱦ�ѥ��ڡ����Ƕ��ڤäƤ���������');
/* email settings */
define('_LANG_INST_BASE_VALUE38','�᡼�륵���С�̾');
define('_LANG_INST_BASE_VALUE39','������̾');
define('_LANG_INST_BASE_VALUE40','�ѥ����');
define('_LANG_INST_BASE_VALUE41','�ݡ����ֹ�');
define('_LANG_INST_BASE_VALUE42','��Ƥ���ǥե���ȥ��ƥ��꡼�λ���');
define('_LANG_INST_BASE_VALUE43','��̾�ˤĤ�����Ƭ��');
define('_LANG_INST_BASE_VALUE44','�����ߥ͡��������ȥ��<br>(��ʸ���餳��ʸ����ǻϤޤ���ʬ��������)');
define('_LANG_INST_BASE_VALUE45','[true]�ˤ���ȥƥ��ȥ⡼�ɤˤʤ�ޤ�');
define('_LANG_INST_BASE_VALUE46','������[true]�ˤ��뤳�Ȥǡ��������äΥ᡼�륵���ӥ��ʤɤ����<br>ʬ�䤷�����ƤǤ��Ĥ���ʸ�Ȥ���Ĵ������ޤ�');
define('_LANG_INST_BASE_VALUE47','��å���������������ݤϥ�����̾��³���ƥѥ���ɤ�����ޤ���<br> ʬ����������ʸ�Ϥ�Ҥ��뤿��Υ��ѥ졼�������ȥ�󥰤�<br>�����ǻ��ꤷ�Ƥ���������');
define('_LANG_INST_BASE_VALUE48','����ǥå�����ɽ��������ƿ�');
define('_LANG_INST_BASE_VALUE49','����̡������̤ʤɤ�ɽ���������������');
define('_LANG_INST_BASE_VALUE50','���������ֲ�����ñ�̤�����');
define('_LANG_INST_BASE_VALUE51','�����С������ॾ�����Ĵ��');
define('_LANG_INST_BASE_VALUE52','���դΥե����ޥå� : <a href="http://php.planetmirror.com/manual/ja/function.date.php" target="_blank">����</a>');
define('_LANG_INST_BASE_VALUE53','���֤Υե����ޥå� : <a href="http://php.planetmirror.com/manual/ja/function.date.php" target="_blank">����</a>');
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
define('_LANG_INST_BASE_VALUE55','������ƤΥǥե���ȥ��å�');
define('_LANG_INST_BASE_VALUE56','�����ȤΥǥե���ȥ��å�');
define('_LANG_INST_BASE_VALUE57','������Ƥ��Ф���Ping�Υǥե���ȥ��å�');
define('_LANG_INST_BASE_VALUE58','PingBack�ˤ����Ƥ�ǥե���Ȥǥ����å�����');
define('_LANG_INST_BASE_VALUE59','������ƤΥǥե���ȥ��ƥ��꡼');
define('_LANG_INST_BASE_VALUE83','�Խ��ե������ɽ�����뵭���ο� (min 3, max 100)');
define('_LANG_INST_BASE_VALUE60','��󥯤��Խ��Ǥ���桼������٥������');
define('_LANG_INST_BASE_VALUE61','������[false]�ˤ��뤳�ȤǤ��٤ƤΥ�󥯤�ɽ�����졢<br>ï�Ǥ��󥯥ޥ͡����㡼���Խ����뤳�Ȥ������褦�ˤʤ�ޤ�');
define('_LANG_INST_BASE_VALUE62','ɾ��ɽ���˻��Ѥ��륿���פ���ꤷ�ޤ�');
define('_LANG_INST_BASE_VALUE63','�����Ȥ���礳���ǻ��ꤷ�ޤ�');
define('_LANG_INST_BASE_VALUE64','0�β��ͤ���ꤷ�ޤ��� ������[true]�ˤ�����硢<br>0��ɾ���δ��ˤʤ�ޤ���');
define('_LANG_INST_BASE_VALUE65','Ʊ��ɾ���ݥ���Ȥˤ�Ʊ�����᡼������Ѥ���');
define('_LANG_INST_BASE_VALUE66','ɾ��0�Υ��᡼��');
define('_LANG_INST_BASE_VALUE67','ɾ��1�Υ��᡼��');
define('_LANG_INST_BASE_VALUE68','ɾ��2�Υ��᡼��');
define('_LANG_INST_BASE_VALUE69','ɾ��3�Υ��᡼��');
define('_LANG_INST_BASE_VALUE70','ɾ��4�Υ��᡼��');
define('_LANG_INST_BASE_VALUE71','ɾ��5�Υ��᡼��');
define('_LANG_INST_BASE_VALUE72','ɾ��6�Υ��᡼��');
define('_LANG_INST_BASE_VALUE73','ɾ��7�Υ��᡼��');
define('_LANG_INST_BASE_VALUE74','ɾ��8�Υ��᡼��');
define('_LANG_INST_BASE_VALUE75','ɾ��9�Υ��᡼��');
define('_LANG_INST_BASE_VALUE76','�񤭹��߲�ǽ�ʥ���å���ե�����');
define('_LANG_INST_BASE_VALUE77','weblogs.com����������ե�����');
define('_LANG_INST_BASE_VALUE78','����å�������Ѥ������(ʬ)');
define('_LANG_INST_BASE_VALUE79','���դΥե����ޥå�');
define('_LANG_INST_BASE_VALUE80','�ǿ���󥯤ؤΥƥ����ȵ���(Next)');
define('_LANG_INST_BASE_VALUE81','�ǿ���󥯤ؤΥƥ����ȵ���(Back)');
define('_LANG_INST_BASE_VALUE82','������������󥯤Ȥ��ư�������(ʬ)');
define('_LANG_INST_BASE_VALUE84','WordPress��GeoURL�ǻȤ���褦�ˤ���');
define('_LANG_INST_BASE_VALUE85','�ǥե���Ȥ� GeoURL ICBM �������ѤǤ���褦�ˤ���');
define('_LANG_INST_BASE_VALUE86','ICBM�Υǥե���Ȱ��� - <a href="http://www.geourl.org/resources.html" target="_blank">see here</a>');
define('_LANG_INST_BASE_VALUE87','ICBM�Υǥե���ȷ���');
/* Last Question */
define('_LANG_INST_STEP2_LAST','�ǡ����Υ��󥵡��ȤϤܴۤ�λ���ޤ����� <br />��Ϥ��μ��������������Ǥ���');
define('_LANG_INST_STEP2_URL','����Blog�����֤���URL�ʺǸ�Υ���å��������)');
define('_LANG_INST_STEP3_SET','<p>��®�������餫��<a href="../wp-login.php">������</a>���ƤߤƤ��������� ������̾��"<strong>admin</strong>" ���ѥ���ɤϤ�����Ǥ��� "');
define('_LANG_INST_STEP3_UP','".</p><p><strong>�ѥ���ɤ�˺��ʤ��褦ɬ����⤷�Ƥ���������</strong> ����Ϥ��ʤ��ΰ٤˥�������������줿Ǥ�դΥѥ���ɤǤ��������ʶ������ȥǡ����١�������ơ��֥��������WordPress��ƥ��󥹥ȡ��뤷�ʤ���Фʤ�ʤ��ʤ�ޤ��ΤǤ���դ���������</p>');
define('_LANG_INST_STEP3_DONE','���¿������ؤ���Ԥ��Ƥ��ޤ����� ?<br />��ǰ�ʤ��餳��Ǥ��٤ƴ�λ�Ǥ��� �Ǥ� WordPress �򤪳ڤ��ߤ���������');
define('_LANG_INST_CAUTIONS','���������ɤ����Ѥ��ƥ��󥹥ȡ��뤵�줿���ϡ�WordPress ME ���оݥǥ��쥯�ȥ�� <b>wp-config.php</b> ��ɬ�������եƥ��ѡ��ߥå������ᤷ�Ƥ���������<ul><li>�ǥ��쥯�ȥ� : [755]</li><li>wp-config.php : [604��644]</li></ul>');

/* Start Upgrade ************************************************/
/* File Name wp-admin/upgrade.php */
define('_LANG_UPG_STEP_INFO','�����С����wp-config.php�ե����뤬¸�ߤ��ޤ���<br />Ŭ�ڤʥǡ����١�����³�����������wp-config.php�ե�������Ѱդ��Ƥ���������');
define('_LANG_UPG_STEP_INFO2','<p>WordPress���С�����󤫤饢�åץ��졼�ɤ��ޤ�<br />�������֤��ݤ���ޤ������Ǹ�ޤǤ�������դ��礤��������</p><p>�������Ǥ��ޤ�����<a href="upgrade.php?step=1">������</a>�ؿʤ�Ǥ���������</p>');
define('_LANG_UPG_STEP_INFO3','<p>���Υץ��������Ǥ��٤Ƥκ�Ȥ���λ���ޤ����� �Ǥ�<a href="../">���ڤ��߲�����</a></p>');

/* File Name wp-admin/upgrade-functions.php */
define('_LANG_INST_BASE_VALUE88','��ǧ���줿�����ȤΤ�ɽ�������褦�ˤ��롣');
define('_LANG_INST_BASE_VALUE89','������[true]�ˤ��Ƥ������Ȥǡ���ǧ�Ԥ������Ȥ����뤳�Ȥ�<br>�᡼������β�ǽ�ˤʤ�ޤ���');
define('_LANG_INST_BASE_VALUE90','�ѡ��ޥͥ�ȥ�󥯥��ץ����ˤĤ��Ƥξܤ���������<a href="options-permalink.php">������Υڡ���</a>�Ǥ������������ޤ���');
define('_LANG_INST_BASE_VALUE91','�ե�������ϻ���gzip��ͭ���ˤ��뤫�ɤ��������򤷤Ƥ��������� <br>���Ȥ��Υ����֥����С�Apache��mod_gzip�Ȥ����⥸�塼�뤬<br>�Ȥ߹��ޤ�Ƥ��ʤ����ϡ�������[true]�ˤ��Ƥ���������');
define('_LANG_INST_BASE_VALUE92','Hack�ե��������Ѥ�����Ϥ�����[true]�ˤ��Ƥ���������<br>Hack�ե������WordPress�Υ롼�Ⱦ���֤��ơ�my-hacks.php��<br>�褦�˸ƤӽФ��ޤ���<br>����ϥ��åץ��졼�ɻ��˾�񤭤���ʤ��褦�ˤ��뤿��Τ�ΤǤ���');
define('_LANG_INST_BASE_VALUE93','Blog�Υ���饯�������å� (<a href="http://developer.apple.com/documentation/macos8/TextIntlSvcs/TextEncodingConversionManager/TEC1.5/TEC.b0.html">ʸ�������ɥꥹ��</a>');
define('_LANG_INST_BASE_VALUE94','����˥å�ɸ���(GMT)����λ���');

/* File Name wp-admin/plugins.php */
define('_LANG_PG_LEAST_LEVEL','�ץ饰���������ˤϥ桼������٥�8�ʾ夬ɬ�פǤ���');
define('_LANG_PG_ACTIVATED_OK','�ץ饰����ǽ <strong>ͭ��</strong>');
define('_LANG_PG_DEACTIVATED_OK','�ץ饰����ǽ <strong>̵��</strong>');
define('_LANG_PG_PAGE_TITLE','Plugin Management');
define('_LANG_PG_NEED_PUT','�ץ饰����Ȥϡ��̾� WordPress �Ȥ����Ӥ˥�������ɤ��� "��ǽ���ɲä���" ����Υե�����Ǥ����ץ饰����򥤥󥹥ȡ��뤹��ˤϡ�<code>wp-content/plugins</code> �ǥ��쥯�ȥ꡼�˥ץ饰����ե���������������Ǥ�����ö�ץ饰���󤬥��󥹥ȡ��뤵���С����Υڡ����Ǥ��Υץ饰�����ͭ������������̵�����������ꤹ�뤳�Ȥ��Ǥ��ޤ���');
define('_LANG_PG_OPEN_ERROR','plugins �ǥ��쥯�ȥ꡼�򳫤����Ȥ��Ǥ��ʤ��������Ѳ�ǽ�ʥץ饰����¸�ߤ��ޤ���');
define('_LANG_PG_SUB_PLUGIN','�ץ饰����');
define('_LANG_PG_SUB_VERSION','�С������');
define('_LANG_PG_SUB_AUTHOR','���');
define('_LANG_PG_SUB_DESCR','����');
define('_LANG_PG_SUB_ACTION','���������');
define('_LANG_PG_SUB_DEACTIVATE','̵���ˤ���');
define('_LANG_PG_SUB_ACTIVATE','ͭ���ˤ���');
define('_LANG_PG_GOOGLE_HILITE','Google��Yahoo ���θ������󥸥󡢤��뤤�� WordPress ���Ȥǥ֥��򸡺��������ˡ����Υץ饰����ˤ�äƸ�����礬�ϥ��饤�Ȥ���ޤ���<a href="http://photomatt.net/">Matt</a> �ˤ��ѥå������󥰡�');
define('_LANG_PG_MARK_DOWN','Markdown �ϥ����֤ǽ�ʪ�򤹤�ͤΤ���Ρ��ƥ����Ȥ��� HTML �ؤ��Ѵ��ġ���Ǥ���<a href="http://daringfireball.net/projects/markdown/syntax">Markdown syntax</a> �ˤ�äơ��ɤߤ䤹���񤭤䤹���ץ쥤��ƥ����ȡ��ե����ޥåȤ���Ѥ��ƽ񤯤��Ȥ��Ǥ��������Ƥ����¤Ū��Ŭ�礷�� XHTML ���Ѵ����ޤ������Υץ饰�������Ƥȥ����Ȥ��Ф��� Markdown ��ͭ���ˤ��ޤ���Markdown �� <a href="http://daringfireball.net/">John Gruber</a> �ˤ�ä� Perl �Ǻ������졢<a href="http://www.michelf.com/">Michel Fortin</a> �ˤ�ä� PHP �˰ܿ����졢<a href="http://photomatt.net/">Matt</a> �ˤ�ä� WP �Υץ饰���󤬺���ޤ��������Υץ饰�������Ѥ�����ϡ�����եꥯ�Ȥ�������Τ� Textile 1 �� 2 ��̵���ˤ��Ƥ���������');
define('_LANG_PG_TEXTILE_2','����� Textile �Ȥ����Τ��� <a href="http://textism.com/?wp">Dean Allen</a> �� Humane Web Text Generator ��ñ��ʥ�åѡ��Ǥ������ΥС�����󣲤Ǥϡ��ۤȤ�� HTML �᥿����Ȥʤ뤯�餤��¿���ν��������ä��ޤ�������������Ȥ����٤��ʤäƤ��ޤ������Υץ饰�������Ѥ�����ϡ����ˤϤ��ޤ���ư���ʤ��Τ� Textile 1 �� Markdown ��̵���ˤ��Ƥ���������');
define('_LANG_PG_HELLO_DOLLY','����Ϥ����Υץ饰����ǤϤ���ޤ���Louis Armstrong �ˤ�äƲΤ�줿�Ǥ�ͭ̾����Ĥ�ñ������󤵤�롢Ʊ������Τ��٤Ƥο͡��δ�˾�Ⱦ�Ǯ���ħ�����ΤǤ����Ȥ���ǡ�����������Ǻǽ�� WordPress �����ץ饰����Ǥ������Υץ饰����ͭ���ˤ����ȡ��ץ饰����������̰ʳ��� Admin ���̤α���� "Hello, Dolly" ����βλ줬�������ɽ������ޤ���');
define('_LANG_PG_TEXTILE_1','����� <a href="http://www.textism.com/tools/textile/">Textile</a> �Ȥ����Τ��� <a href="http://textism.com/?wp">Dean Allen</a> �� Humane Web Text Generator ��ñ��ʥ�åѡ��Ǥ������Υץ饰�������Ѥ�����ϡ����ˤϤ��ޤ���ư���ʤ��Τ� Textile 2 �� Markdown ��̵���ˤ��Ƥ���������');


}
?>