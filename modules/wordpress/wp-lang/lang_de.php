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
define('_LANG_WA_SETTING_GUIDE','<p>Anscheinend ist WP noch nicht installiert. Ausf¸hren: <a href=\'wp-admin/install.php\'>install.php</a>.</p>');

/* File Name wp-blog-header.php */
define('_LANG_WA_HEADER_GUIDE1','<p>Die Datei <code>wp-config.php</code> scheint nicht zu exisitiern. Ohne diese Datei geht es nicht weiter. Hilfe?: <a href=\'http://wordpress.org/docs/faq/#wp-config\'>Gibt es hier</a>. Die Datei <code>wp-config.php</code> kann <a href=\'wp-admin/install-config.php\'>mit Hilfe des Webinterfaces erstellt werden</a>, funktioniert aber nicht immer mit allen Setups. Am sichersten ist es die Datei manuell zu erstellen.</p>');

/* File Name wp-admin/install-config.php */
define('_LANG_WA_CONFIG_GUIDE1','<p>Die Datei \'wp-config.php\' exisitiert bereits. Sollte es notwendig sein, Parameter in dieser Datei zu ‰ndern, ist die alte Datei vorher zu lˆschen.</p>');
define('_LANG_WA_CONFIG_GUIDE2','<p>Achtung, eine wp-config-sample.php ist notwendig um fortzufahren. Bitte erneut uploaden.<p>');
define('_LANG_WA_CONFIG_GUIDE3','<p>Achtung, in das Verzeichnis kann nicht geschrieben werden. Entweder muss die Verzeichnisberechtigung ge‰ndert werden, oder die Datei wp-config.php manuell erstellt werden.</p>');
define('_LANG_WA_CONFIG_GUIDE4','Willkommen bei WordPress. Bevor es losgehen kann, sind einige Daten bzgl. der Datenbank notwendig. Folgende Informationen m¸ssen bekannt sein:');
define('_LANG_WA_CONFIG_DATABASE','Datenbank Name');
define('_LANG_WA_CONFIG_USERNAME','Datenbank User');
define('_LANG_WA_CONFIG_PASSWORD','Database Passwort');
define('_LANG_WA_CONFIG_LOCALHOST','Datenbank Host');
define('_LANG_WA_CONFIG_PREFIX','Tabellen Pr‰fix');
define('_LANG_WA_CONFIG_GUIDE5','<strong>Sollte aus irgendeinem Grund die automatische Generierung nicht funktionieren besteht kein Grung zur Besorgnis. Alles was diese Datei macht, ist das Schreiben der Datenbank Informationen in eine Konfigurationsdatei. Es besteht die Option die Datei <code>wp-config-sample.php</code> in einem Texteditor zu modifizieren, die fehlenden Informationen einzutragen und die Datei als <code>wp-config.php</code> abzuspeichern. </strong></p><p>In den meisten F‰llen kˆnnen die Informationen vom ISP bezogen werden. Sollten die Informationen nicht vorliegen, kann die Installation erst dann fortgef¸hrt werden, wenn diese Informationen vorliegen. Ansonsten kann es jetzt <a href="install-config.php?step=1">endlich losgehen</a>! ');
define('_LANG_WA_CONFIG_GUIDE6','Bitte die Verbindungsdaten zur Datenbank eingeben. Falls unbekannt, kontaktiere Deinen Administrator. ');
define('_LANG_WA_CONFIG_GUIDE7','<small>Name der Datenbank in der WP installiert werden soll. </small>');
define('_LANG_WA_CONFIG_GUIDE8','<small>MySQL Username</small>');
define('_LANG_WA_CONFIG_GUIDE9','<small>...und MySQL Passwort.</small>');
define('_LANG_WA_CONFIG_GUIDE10','<small>In 99% aller F‰lle muss dieser Wert nicht ge‰ndert werden.</small>');
define('_LANG_WA_CONFIG_GUIDE11','<small>Sollen multiple WP Installationen in einer einzigen Datenbnak laufen, bitte diesen Wert ‰ndern.</small>');
define('_LANG_WA_CONFIG_GUIDE12','Ok mein Freund! Diesen Teil der Installation kannst Du jetzt vergessen. WordPress kann n‰mlich mit der Datenbank kommunizieren. Wenn Du soweit bist, geht es jetzt los mit <a href="install.php">der Installation!</a>');


/* File Name wp-include/wp-db.php */
define('_LANG_WA_WPDB_GUIDE1','<strong>Fehler beim Aufbau einer Datenbankverbindung!</strong> Wahrscheinlich stimmen die Verbindungsadten in der Datei <code>wp-config.php</code> nicht. Bitte ¸berpr¸fen und nochmals versuchen.');
define('_LANG_WA_WPDB_GUIDE2','Stimmt die User/Passwort Kombination?');
define('_LANG_WA_WPDB_GUIDE3','Stimmt der Hostname?');
define('_LANG_WA_WPDB_GUIDE4','L‰uft der Datenbankserver?');

/* File Name wp-include/functions.php */
define('_LANG_F_TIMESTAMP','Timestamp editieren');
define('_LANG_F_NEW_COMMENT','Neuer Kommentar auf Dein Post');
define('_LANG_F_ALL_COMMENTS','Hier alle Kommentare zu dem Post anzeigen lassen:');
define('_LANG_F_NEW_TRACKBACK','Neues Traceback auf Dein Post');
define('_LANG_F_ALL_TRACKBACKS','Hier kannst Du alle Tracebacks zu diesem Post sehen:');
define('_LANG_F_NEW_PINGBACK','Neues Pingback auf Dein Post');
define('_LANG_F_ALL_PINGBACKS','Hier kannst Du alle Pingbacks zu diesem Post sehen:');
define('_LANG_F_COMMENT_POST','Es gibt einen neuen Kommentar auf das Posting');
define('_LANG_F_WAITING_APPROVAL','das freigegeben werden muss.');
define('_LANG_F_APPROVAL_VISIT','Um den Kommentar freizugeben, hier klicken:');
define('_LANG_F_DELETE_VISIT','Um den Kommentar zu lˆschen, hier klicken:');
define('_LANG_F_PLEASE_VISIT','Es warten neue Kommentare auf die Freigabe. Weiter im Mod-Panel:');

/* File Name wp-register.php */
define('_LANG_R_ENTER_LOGIN','<strong>FEHLER</strong>: Bitte Login angeben.');
define('_LANG_R_PASS_TWICE','<strong>FEHLER</strong>: Bitte Passwort zweimal eingeben.');
define('_LANG_R_SAME_PASS','<strong>FEHLER</strong>: Bitte dasgleiche Passwort in beide Felder eingeben.');
define('_LANG_R_MAIL_ADDRESS','<strong>FEHLER</strong>: Bitte Emailadresse eingeben.');
define('_LANG_R_ADDRESS_CORRECT','<strong>FEHLER</strong>: Die Emailadresse ist ung¸ltig.');
define('_LANG_R_CHOOSE_ANOTHER','<strong>FEHLER</strong>: Dieses Login ist bereits vergeben, bitte ein Anderes w‰hlen.');
define('_LANG_R_REGISTER_CONTACT','<strong>FEHLER</strong>: Registrierung fehlgeschlagen... bitte wende Dich an den Webmaster!');
define('_LANG_R_USER_REGISTRATION','Neue User Registrierung in Blog');
define('_LANG_R_MAIL_REGISTRATION','Neue User Registrierung');
define('_LANG_R_R_COMPLETE','Registrierung abgeschlossen');
define('_LANG_R_R_DISABLED','Registrierung deaktiviert');
define('_LANG_R_R_CLOSED','User Registrierungen sind zur Zeit nicht mˆglich.');
define('_LANG_R_R_REGISTRATION','Registrierung');
define('_LANG_R_USER_LOGIN','Login:');
define('_LANG_R_USER_PASSWORD','Passwort:');
define('_LANG_R_TWICE_PASSWORD','Passwort Wiederholung:');
define('_LANG_R_USER_EMAIL','Email');

/* File Name wp-login.php */
define('_LANG_L_LOGIN_EMPTY','das Login Feld ist leer');
define('_LANG_L_PASS_EMPTY','das Passwort Feld ist leer');
define('_LANG_L_WRONG_LOGPASS','falsches Login oder Passwort');
define('_LANG_L_RECEIVE_PASSWORD','Bitte gib deine Informationen ein. Wir senden Dir dann ein neues Passwort zu. ');
define('_LANG_L_EXIST_SORRY','Leider existiert der User nicht in unserer Datenbank. Stimmt der Username oder die Mailadresse nicht? <a href="wp-login.php?action=lostpassword">Versuch\'s nochmal</a>.');
define('_LANG_L_YOUR_LOGPASS','Dein WeBlog Login/Passwort');
define('_LANG_L_NOT_SENT','Email konnte nicht zugesandt werden.');
define('_LANG_L_DISABLED_FUNC','M&ouml;glicher Grund: Dein Host unterst¸tzt die mail()-Funktion nicht...');
define('_LANG_L_SUCCESS_SEND',' : Email erfolgreich versandt.');
define('_LANG_L_CLICK_ENTER','Hier klicken f¸r Login!');
define('_LANG_L_WRONG_SESSION','Fehler: falsches Login/Passwort');
define('_LANG_L_BACK_BLOG','Zur&uuml;ck zum DevBlog?');
define('_LANG_L_WP_RESIST','Registrieren?');
define('_LANG_L_WPLOST_YOURPASS','Passwort vergessen?');

/* File Name wp-admin/post.php */
define('_LANG_P_NEWCOMER_MESS','Als Newcomer musst Du warten bis Dich ein Admin auf Level 1 setzt. Erst dann darfst Du posten.<br />Du kannst auch eine Mail schreiben mit der Bitte um Dich auf Level 1 zu setzen.<br />Wenn Du bef&ouml;rdert wurdest, brauchst Du die Seite nur neu zu laden um zu bloggen. :)');
define('_LANG_P_DATARIGHT_EDIT',' : Keine Berechtigung zum Editieren des Posts.');
define('_LANG_P_DATARIGHT_DELETE',' : Keine Berechtigung zum L&ouml;schen des Posts.');
define('_LANG_P_DATARIGHT_ERROR','Fehler beim L&ouml;schen ... konataktiere den bitte den Webmaster.');
define('_LANG_P_OOPS_IDCOM','Oops, mit dieser ID ist Kommentieren nicht m&ouml;glich.');
define('_LANG_P_OOPS_IDPOS','Oops, mit dieser ID ist Posten nicht m&ouml;glich.');
define('_LANG_P_ABOUT_FOLLOW','L&ouml;sche den folgenden Kommentar:');
define('_LANG_P_SURE_THAT','Wirklich l&ouml;schen?');
define('_LANG_P_NICKNAME_DELETE','Keine Berechtigung zum L&ouml;schen von Kommentaren auf Posts.');
define('_LANG_P_COMHAS_APPR','Kommentar wurde freigegeben.');
define('_LANG_P_YOUR_DRAFTS','Deine Entw&uuml;rfe:');
define('_LANG_P_WP_BOOKMARKLET','Der folgende Link kann zur Linkleiste oder zu den Bookmarks hinzugef&uuml;gt werden. "Press it" &ouml;ffnet ein Popup mit den Informationen und einem Link zu der Seite. Du kannst also ein Quickpost machen. Versuchs:');

/* File Name wp-admin/categories.php */
define('_LANG_C_DEFAULT_CAT','Kategorie kann nicht gel&ouml;scht werden (Default-Kategorie).');
define('_LANG_C_EDIT_TITLECAT','Kategorie editieren');
define('_LANG_C_NAME_SUBCAT','Kategoriename:');
define('_LANG_C_NAME_SUBDESC','Beschreibung:');
define('_LANG_C_RIGHT_EDITCAT','Berechtigung zum Editieren der Kategorie verweigert.<br />Frag doch mal beim BlogAdmin nach. :)');
define('_LANG_C_NAME_CURRCAT','Aktuelle Kategorien');
define('_LANG_C_NAME_CATNAME','Name');
define('_LANG_C_NAME_CATDESC','Beschreibung:');
define('_LANG_C_NAME_CATPOSTS','# Posts');
define('_LANG_C_NAME_CATACTION','Aktion');
define('_LANG_C_ADD_NEWCAT','Neue Kategorie hinzuf&uuml;gen');
define('_LANG_C_NOTE_CATEGORY','<strong>Note:</strong><br />Deleting a category does not delete posts from that category, it will just set them back to the default category.');
define('_LANG_C_NAME_EDIT','EDITIEREN');
define('_LANG_C_NAME_DELETE','L&Ouml;SCHEN');
define('_LANG_C_NAME_ADDBTN','Hinzuf&uuml;gen &raquo;');
define('_LANG_C_NAME_EDITBTN','Edit category &raquo;');
define('_LANG_C_NAME_PARENT','&Uuml;bergeordnete Kategorie:');
define('_LANG_C_MESS_ADD','Category added.');
define('_LANG_C_MESS_DELE','Category deleted.');
define('_LANG_C_MESS_UP','Category updated.');

/* File Name wp-admin/edit.php */
define('_LANG_E_LATEST_POSTS','Neueste Posts');
define('_LANG_E_LATEST_COMMENTS','Neueste Kommentare');
define('_LANG_E_AWAIT_MODER','Freizugebende Kommentare');
define('_LANG_E_SHOW_POSTS','Zeige Posts:');
define('_LANG_E_TITLE_COMMENTS','Kommentare');
define('_LANG_E_FILL_REQUIRED','Fehler: bitte die notwendigen Felder ausf¸llen (Name & Kommentar)');
define('_LANG_E_TITLE_LEAVECOM','Kommentar abegeben');
define('_LANG_E_RESULTS_FOUND','Kein(e) Treffer gefunden.');

/* File Name wp-admin/edit-comments.php */
define('_LANG_EC_SHOW_COM','Kommentare zeigen:');
define('_LANG_EC_EDIT_COM','Kommentar editieren');
define('_LANG_EC_DELETE_COM','Kommentar l&ouml;schen');
define('_LANG_EC_EDIT_POST','Post kommentieren &#8220;');
define('_LANG_EC_VIEW_POST','Post zeigen');
define('_LANG_EC_SEARCH_MODE','Suche &uuml;ber Kommentare, Emails, URI und IP-Adresse hinweg.');
define('_LANG_EC_VIEW_MODE','Anzeige-Modus');
define('_LANG_EC_EDIT_MODE','Masseneditierungs-Modus');
define('_LANG_EC_CHECK_INVERT','Checkbox Auswahl umkehren');
define('_LANG_EC_CHECK_DELETE','Markierte Kommentare l&ouml;schen');
define('_LANG_EC_LINK_VIEW','Zeigen');
define('_LANG_EC_LINK_EDIT','Editieren');
define('_LANG_EC_LINK_DELETE','L&ouml;schen');

/* File Name wp-admin/edit-form.php */
define('_LANG_EF_PING_FORM','<label for="pingback"><strong>PingBack</strong> die <acronym title="Uniform Resource Locators">URL</acronym>s in diesem Post</label> <a href="http://wordpress.org/docs/reference/post/#pingback" title="Help on Pingbacks">?</a><br />');
define('_LANG_EF_TRACK_FORM','<p><label for="trackback"><a href="http://wordpress.org/docs/reference/post/#trackback" title="Help on trackbacks"><strong>TrackBack</strong> an <acronym title="Uniform Resource Locator">URL</acronym></a>:</label> (Mehrere <acronym title="Uniform Resource Locator">URL</acronym>s mit Leerzeichen trennen.)<br />');
define('_LANG_EF_AD_POSTTITLE','Titel');
define('_LANG_EF_AD_CATETITLE','Kategorien');
define('_LANG_EF_AD_POSTAREA','Post');
define('_LANG_EF_AD_POSTQUICK','Quicktags');
define('_LANG_EF_AD_DRAFT','Als Entwurf speichern');
define('_LANG_EF_AD_PRIVATE','Als privaten Blog speichern');
define('_LANG_EF_AD_PUBLISH','Ver&ouml;ffentlichen');
define('_LANG_EF_AD_EDITING','Erweiterte Editierung &raquo;');

/* File Name wp-admin/edit-form-advanced.php */
define('_LANG_EFA_POST_STATUS','Post Status');
define('_LANG_EFA_AD_COMMENTS','Kommentare');
define('_LANG_EFA_AD_PINGS','Pings');
define('_LANG_EFA_POST_PASSWORD','Post Password');
define('_LANG_EFA_POST_EXCERPT','Ausschnitt');
define('_LANG_EFA_POST_LATITUDE','Latitude:');
define('_LANG_EFA_POST_LONGITUDE','Longitude:');
define('_LANG_EFA_POST_GEOINFO','klicken f&uuml;r Geo Info');
define('_LANG_EFA_DEL_THISPOST','Dieses Post l&ouml;schen');
define('_LANG_EFA_SAVE_CONTINUE','Sichern und mit dem Editieren fortfahren');
define('_LANG_EFA_STATUS_OPEN','Offen');
define('_LANG_EFA_STATUS_CLOSE','Geschlossen');
define('_LANG_EFA_STATUS_UPLOAD','Datei oder Bild hochladen');
define('_LANG_EFA_STATUS_DISCUSS','Diskussion');
define('_LANG_EFA_STATUS_ALLOWC','Kommentare erlauben');
define('_LANG_EFA_STATUS_ALLOWP','Pings erlauben');
define('_LANG_EFA_STATUS_SLUG','Post Slug');
define('_LANG_EFA_STATUS_POST','Post');

/* File Name wp-admin/edit-form-comment.php */
define('_LANG_EFC_BUTTON_TEXT','Editieren!');
define('_LANG_EFC_COM_NAME','Name:');
define('_LANG_EFC_COM_MAIL','E-Mail:');
define('_LANG_EFC_COM_URI','URI:');
define('_LANG_EFC_COM_COMMENT','Kommentar:');

/* File Name wp-admin/link-add.php */
define('_LANG_WLA_MANAGE_LINK','Links verwalten');
define('_LANG_WLA_ADD_LINK','Link hinzuf&uuml;gen');
define('_LANG_WLA_LINK_CATE','Link-Kategorien');
define('_LANG_WLA_IMPORT_BLOG','Import Blogroll');
define('_LANG_WLA_LINK_TITLE','<strong>Add</strong> a link:');
define('_LANG_WLA_SUB_URI','URI:');
define('_LANG_WLA_SUB_NAME','Link Name:');
define('_LANG_WLA_SUB_IMAGE','Bild');
define('_LANG_WLA_SUB_RSS','RSS URI: ');
define('_LANG_WLA_SUB_DESC','Beschreibung');
define('_LANG_WLA_SUB_REL','rel:');
define('_LANG_WLA_SUB_XFN','XFN');
define('_LANG_WLA_SUB_NOTE','Bemerkungen:');
define('_LANG_WLA_SUB_RATE','Rating:');
define('_LANG_WLA_SUB_TARGET','Ziel');
define('_LANG_WLA_SUB_VISIBLE','Sichtbar:');
define('_LANG_WLA_SUB_CAT','Kategorie:');
define('_LANG_WLA_SUB_FRIEND','freundschaftlich');
define('_LANG_WLA_SUB_PHYSICAL','physisch');
define('_LANG_WLA_SUB_PROFESSIONAL','professionell');
define('_LANG_WLA_SUB_GEOGRAPH','geographisch');
define('_LANG_WLA_SUB_FAMILY','famili&auml;r');
define('_LANG_WLA_SUB_ROMANTIC','romantisch');
define('_LANG_WLA_CHECK_ACQUA','bekanntschaftlich');
define('_LANG_WLA_CHECK_FRIE','Freund');
define('_LANG_WLA_CHECK_NONE','keines');
define('_LANG_WLA_CHECK_MET','bittend');
define('_LANG_WLA_CHECK_WORKER','Mitarbeiter');
define('_LANG_WLA_CHECK_COLL','Kollege');
define('_LANG_WLA_CHECK_RESI','co-resident');
define('_LANG_WLA_CHECK_NEIG','Nachbar');
define('_LANG_WLA_CHECK_CHILD','Kind');
define('_LANG_WLA_CHECK_PARENT','Eltern');
define('_LANG_WLA_CHECK_SIBLING','Geschwister');
define('_LANG_WLA_CHECK_SPOUSE','Gatte');
define('_LANG_WLA_CHECK_MUSE','Muse');
define('_LANG_WLA_CHECK_CRUSH','Crush');
define('_LANG_WLA_CHECK_DATE','Date');
define('_LANG_WLA_CHECK_HEART','Sweatheart');
define('_LANG_WLA_CHECK_ZERO','0 f&uuml;r kein Rating.');
define('_LANG_WLA_CHECK_STRICT','Bitte beachten: <code>target</code> attribute ist nicht XHTML 1.1- und 1.0 Strict- konform.');
define('_LANG_WLA_TEXT_TOOLBAR','You can drag "Link This" to your toolbar and when you click it a window will pop up that will allow you to add whatever site you&#8217;re on to your links! Right now this only works on Mozilla or Netscape, but we&#8217;re working on it.');

/* File Name wp-admin/link-categories.php */
define('_LANG_WLC_DONOT_DELETE','Link Kategorie kann nicht gel&ouml;scht werden. (Default Kategorie)');
define('_LANG_WLC_TITLE_TEXT','Link Kategorie editieren &#8220;');
define('_LANG_WLC_EPAGE_TITLE','Link kategorie <strong>editieren</strong>:');
define('_LANG_WLC_ADD_TITLE','Link Kategorie hinzuf&uuml;gen:');
define('_LANG_WLC_SUBEDIT_NAME','Name:');
define('_LANG_WLC_SUBEDIT_TOGGLE','auto-umschalten?');
define('_LANG_WLC_SUBEDIT_SHOW','Zeige:');
define('_LANG_WLC_SUBEDIT_ORDER','Sortierreihenfolge:');
define('_LANG_WLC_SUBEDIT_IMAGES','Bilder');
define('_LANG_WLC_SUBEDIT_DESC','Beschreibung');
define('_LANG_WLC_SUBEDIT_RATE','Rating');
define('_LANG_WLC_SUBEDIT_UPDATE','aktualisiert');
define('_LANG_WLC_SUBEDIT_SORT','Sortieren nach:');
define('_LANG_WLC_SUBEDIT_DESCEND','Absteigend?');
define('_LANG_WLC_SUBEDIT_BEFORE','Vor:');
define('_LANG_WLC_SUBEDIT_BETWEEN','Zwischen:');
define('_LANG_WLC_SUBEDIT_AFTER','Nach:');
define('_LANG_WLC_SUBEDIT_LIMIT','Limit:');
define('_LANG_WLC_ADDBUTTON_TEXT','Kategorie hinzuf&uuml;gen!');
define('_LANG_WLC_SAVEBUTTON_TEXT','Sichern');
define('_LANG_WLC_CANCELBUTTON_TEXT','L&ouml;schen');
define('_LANG_WLC_SUBCATE_NAME','Name');
define('_LANG_WLC_SUBCATE_ATT','Auto<br />Umschalten?');
define('_LANG_WLC_SUBCATE_SHOW','Zeigen');
define('_LANG_WLC_SUBCATE_SORT','Sortierreihenfolge');
define('_LANG_WLC_SUBCATE_DESC','Ab?');
define('_LANG_WLC_SUBCATE_LIMIT','Limit');
define('_LANG_WLC_SUBCATE_IMAGES','Bilder?');
define('_LANG_WLC_SUBCATE_MINIDESC','Ab?');
define('_LANG_WLC_SUBCATE_RATE','Rating?');
define('_LANG_WLC_SUBCATE_UPDATE','aktualisiert?');
define('_LANG_WLC_SUBCATE_BEFORE','vor');
define('_LANG_WLC_SUBCATE_BETWEEN','zwischen');
define('_LANG_WLC_SUBCATE_AFTER','nach');
define('_LANG_WLC_SUBCATE_EDIT','Editieren');
define('_LANG_WLC_SUBCATE_DELETE','L&ouml;schen');
define('_LANG_WLC_SUBEDIT_EMPTY','Anzahl zu zeigender Links. Leer f&uuml;r alle.');
define('_LANG_WLC_EPAGE_EMPTY','leer lassen f&uuml;r unbegrenzt');
define('_LANG_WLC_EPAGE_NOTE','Eine Linkkategorie zu l&ouml;schen, l&ouml;scht die enthaltenen Links NICHT!<br/> Diese werden lediglich in die Default-Kategorie verschoben. :');
define('_LANG_WLC_RIGHT_PROM','Keine Berechtigung, diese Link-Kategorie zu editieren.<br>Frag doch einfach den Blogadmin um eine Promotion:)');

/* File Name wp-admin/link-import.php */
define('_LANG_WLI_ROLL_TITLE','Blogroll importieren');
define('_LANG_WLI_ROLL_DESC','Blogroll aus einem anderen System importieren');
define('_LANG_WLI_ROLL_OPMLCODE','Go to Blogrolling.com and sign in. Once you&#8217;ve done that, click on <strong>Get Code</strong>, and then look for the <strong><abbr title="Outline Processor Markup Language">OPML</abbr> code</strong>');
define('_LANG_WLI_ROLL_OPMLLINK','Or go to Blo.gs and sign in. Once you&#8217;ve done that in the &#8217;Welcome Back&#8217; box on the right, click on <strong>share</strong>, and then look for the <strong><abbr title="Outline Processor Markup Language">OPML</abbr> link</strong> (favorites.opml)');
define('_LANG_WLI_ROLL_BELOW','Select that text and copy it or copy the link/shortcut into the box below.');
define('_LANG_WLI_ROLL_YOURURL','Deine OPML URL:');
define('_LANG_WLI_ROLL_UPLOAD','<strong>or</strong> you can upload an OPML file from your desktop aggregator:');
define('_LANG_WLI_ROLL_THISFILE','Upload this file: ');
define('_LANG_WLI_ROLL_CATEGORY','Now select a category you want to put these links in.<br />Category: ');
define('_LANG_WLI_ROLL_BUTTONTEXT','Importieren!');

/* File Name wp-admin/link-manager.php */
define('_LANG_WLM_PAGE_TITLE','Links verwalten');
define('_LANG_WLM_LEVEL_ERROR','Berechtigung zum Editieren des Links verweigert.<br />Frag doch mal beim BlogAdmin nach einer Promotion. :)');
define('_LANG_WLM_SHOW_LINKS','<strong>Zeige</strong> Links in Kategorie:');
define('_LANG_WLM_ORDER_BY','<strong>Sortiere</strong> nach:');
define('_LANG_WLM_SHOW_BUTTONTEXT','Zeigen');
define('_LANG_WLM_SHOW_ACTIONTEXT','Aktion');
define('_LANG_WLM_MULTI_LINK','Mehrere Links verwalten:');
define('_LANG_WLM_CHECK_CHOOSE','Checkboxen verwenden, um mehrere Links mit einer Aktion zu belegen:');
define('_LANG_WLM_ASSIGN_TEXT','Zuweisen');
define('_LANG_WLM_OWNER_SHIP','&Uuml;bertragen auf:');
define('_LANG_WLM_TOGGLE_TEXT','Umschalten');
define('_LANG_WLM_VISIVILITY_TEXT','Sichtbarkeit');
define('_LANG_WLM_MOVE_TEXT','Verschieben');
define('_LANG_WLM_TO_CATEGORY',' zur Kategorie');
define('_LANG_WLM_TOGGLE_BOXES','Checkboxen umschalten');
define('_LANG_WLM_EDIT_LINK','Link editieren:');
define('_LANG_WLM_SAVE_CHANGES','&Auml;nderungen &uuml;bernehmen');
define('_LANG_WLM_EDIT_CANCEL','L&ouml;schen');

/* File Name wp-admin/moderation.php */
define('_LANG_WPM_USER_LEVEL','Dein Level ist nicht hoch genug um Kommentare zu moderieren. Frage den BlogAdmin f&uuml;r eine Promotion :)');
define('_LANG_WPM_LATE_POSTS','Posts');
define('_LANG_WPM_LATE_COMS','Kommentare');
define('_LANG_WPM_AWIT_MODERATION','Wartende Moderation');
define('_LANG_WPM_COM_APPROV',' Kommentar freigegeben');
define('_LANG_WPM_COMS_APPROVS',' Kommentare freigeben');
define('_LANG_WPM_COM_DEL',' Kommentar gel&ouml;scht');
define('_LANG_WPM_COMS_DELS',' Kommentar gel&ouml;scht');
define('_LANG_WPM_COM_UNCHANGE',' Kommentar unge&auml;ndert');
define('_LANG_WPM_COMS_UNCHANGES',' Kommentare unge&auml;ndert');
define('_LANG_WPM_WAIT_APPROVAL','Die folgenden Kommentare warten auf Freigabe:');
define('_LANG_WPM_CURR_COMAPP','Im Moment gibt es keine Kommentare die auf Freigabe warten.');
define('_LANG_WPM_DEL_LATER','<p>Jeder ausgew&auml;hlte Kommentar kann entweder <em>freigegeben</em>, <em>gel&ouml;scht</em> oder <em>sp&auml;ter bearbeitet</em> werden:</p>');
define('_LANG_WPM_PUBL_VISIBLE','<p><em>Freigeben</em>: Kommentare freigeben machen diese &ouml;ffentlich sichtbar');
define('_LANG_WPM_AUTHOR_NOTIFIED','der Autor dieses Posts wird &uuml;ber den neuen kommentar informiert werden.');
define('_LANG_WPM_ASKED_AGAIN','<p><em>L&ouml;schen</em>: Entfernt den Inhalt aus dem Blog (Beachte: Es gibt keine weitere Abfrage, die Entscheidung den Kommentar zu l&ouml;schen sollte also gut bedacht sein - einmal gel&ouml;scht immer gel&ouml;scht!)</p><p><em>Sp&auml;ter</em>: &Auml;ndert den Kommentar-Status nicht.</p>');
define('_LANG_WPM_MODERATE_BUTTON','Kommentare moderieren');
define('_LANG_WPM_DO_NOTHING','Nichts tun');
define('_LANG_WPM_DO_DELETE','L&ouml;schen');
define('_LANG_WPM_DO_APPROVE','Freigeben');
define('_LANG_WPM_DO_ACTION','Massenaktion:');
define('_LANG_WPM_JUST_THIS','Diesen Kommentar l&ouml;schen');
define('_LANG_WPM_JUST_EDIT','Editieren');
define('_LANG_WPM_COMPOST_NAME','Name:');
define('_LANG_WPM_COMPOST_MAIL','Email:');
define('_LANG_WPM_COMPOST_URL','URI:');

/* File Name wp-admin/options.php */
define('_LANG_WOP_USER_LEVEL','Keine berechtigung diese Optionen zu editieren.<br />Frag den BlogAdmin f&uuml;r eine Promotion:)');
define('_LANG_WOP_PERM_LINKS','Permalinks');
define('_LANG_WOP_PERM_CONFIG','Permanent Link Konfiguration');
define('_LANG_WOP_NO_HELPS',' Keine Hilfe f&uuml;r diese Einstellungen.');
define('_LANG_WOP_SUBMIT_TEXT','Einstellungen updaten');
define('_LANG_WOP_SETTING_SAVED',' Einstellung(en) sichern... ');

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
define('_LANG_WPF_ERR_NICKNAME','<strong>FEHLER</strong>: bitte Nickname eingeben (Kann dem Login entsprechen)');
define('_LANG_WPF_ERR_ICQUIN','<strong>FEHLER</strong>: die ICQ UIN kann nur eine Nummer sein und darf keine Buchstaben enthalten');
define('_LANG_WPF_ERR_TYPEMAIL','<strong>FEHLER</strong>: bitte Emailadresse eingeben');
define('_LANG_WPF_ERR_CORRECT','<strong>FEHLER</strong>: die Emailadresse ist inkorrekt');
define('_LANG_WPF_ERR_TYPETWICE','<strong>FEHLER</strong>: Passwort nur einmal eingegeben. Bitte zweimal eingeben.');
define('_LANG_WPF_ERR_DIFFERENT','<strong>FEHLER</strong>: Passw&ouml;rter stimmen nicht &uuml;berein. Bitte Vorgang wiederholen.');
define('_LANG_WPF_ERR_PROFILE','<strong>FEHLER</strong>: Profil kann nicht aktualisiert werden... bitte den Webmaster kontaktieren!');
define('_LANG_WPF_SUBT_VIEW','Profil zeigen');
define('_LANG_WPF_SUBT_FIRST','Vorname:');
define('_LANG_WPF_SUBT_LAST','Nachname:');
define('_LANG_WPF_SUBT_NICK','Nickname:');
define('_LANG_WPF_SUBT_MAIL','Email:');
define('_LANG_WPF_SUBT_URL','Website:');
define('_LANG_WPF_SUBT_ICQ','ICQ:');
define('_LANG_WPF_SUBT_AIM','AIM:');
define('_LANG_WPF_SUBT_MSN','MSN IM:');
define('_LANG_WPF_SUBT_YAHOO','Yahoo IM:');
define('_LANG_WPF_SUBT_ONE','IE Bookmark');
define('_LANG_WPF_SUBT_COPY','Um ein One-click Bookmarklet zu erhalten, kopiere dies <br />in ein neus Textfile:');
define('_LANG_WPF_SUBT_BOOK','Speichere es als wordpress.reg, und double-click die Datei im Explorer.<br />Antworte auf die Frage mit \"Ja\", und starte dann den Internet Explorer neu.<br /><br />Das ist alles! Ab jetzt kannst eine Seite durch einen Rechtsklick in Deinem IE-Fenster und die Auswahl<br />&#8242;Post to WP&#8242; in Deine Bookmarklets einf&uuml;gen. :)');
define('_LANG_WPF_SUBT_CLOSE','Fenster schliessen');
define('_LANG_WPF_SUBT_UPDATED','Profil aktualisiert.');
define('_LANG_WPF_SUBT_EDIT','Editiere Dein Profil');
define('_LANG_WPF_SUBT_USERID','Login:');
define('_LANG_WPF_SUBT_LEVEL','Level:');
define('_LANG_WPF_SUBT_POSTS','Posts:');
define('_LANG_WPF_SUBT_LOGIN','Login:');
define('_LANG_WPF_SUBT_DESC','Profil:');
define('_LANG_WPF_SUBT_IDENTITY','Identity on blog: ');
define('_LANG_WPF_SUBT_NEWPASS','Neues <strong>Passwort</strong> (Leer lassen um das Late beizubehalten.)');
define('_LANG_WPF_SUBT_MOZILLA','Sidebar nicht gefunden!  Sidebars erfordern mindestens Mozilla 0.9.4!');
define('_LANG_WPF_SUBT_SIDEBAR','SideBar');
define('_LANG_WPF_SUBT_FAVORITES','Zu den Favoriten hinzuf&uuml;gen:');
define('_LANG_WPF_SUBT_UPDATE','Update');

/* File Name wp-admin/sidebar.php */
define('_LANG_WAS_SIDE_POSTED','Gepostet !');
define('_LANG_WAS_SIDE_AGAIN','<a href="sidebar.php">Hier klicken</a> um nochmal zu posten.');

/* File Name wp-admin/templates.php */
define('_LANG_WAT_LEVEL_ERR','<p>You have no right to edit the template for this blog.<br />Ask for a promotion to your blog admin. :)</p>');
define('_LANG_WAT_SORRY_EDIT','Sorry, can&#8217;t edit files with ".." in the name. If you are trying to edit a file in your WordPress home directory, you can just type the name of the file in.');
define('_LANG_WAT_SORRY_PATH','Sorry, can&#8217;t call files with their real path.');
define('_LANG_WAT_EDITED_SUCCESS','<em>File edited successfully.</em>');
define('_LANG_WAT_FILE_CHMOD','you cannot update that file/template: must make it writable, e.g. CHMOD 766');
define('_LANG_WAT_OOPS_EXISTS','<p>Oops, no such file exists! Double check the name and try again, merci.</p>');
define('_LANG_WAT_OTHER_FILE','<p>Um eine Datei zu editieren, bitte unten den Namen der Datei eingeben. Jede Datei kann editiert werden wenn sie schreibar ist, z.B. CHMOD 766.</p>');
define('_LANG_WAT_TYPE_HERE','Dateinamen eingeben:');
define('_LANG_WAT_FTP_CLIENT','Anmerkung: Dateien/Templates k&ouml;nnen nat&uuml;rlich auch mit einem Texteditor modifiziert werden. Dieser Onlineeditor ist daf&uuml;r gedacht, wenn kein Zugriff bspw. via FTP vorhanden ist.');
define('_LANG_WAT_UPTEXT_TEMP','Datei aktualisieren!');

/* File Name wp-admin/users.php */
define('_LANG_WUS_WHOSE_LEVEL','Du kannst den Level eines Users mit einem h&ouml;heren Level als Deinen nicht ver&auml;ndern.');
define('_LANG_WUS_WHOSE_DELETE','Du kannst keinen User l&ouml;schen, der einen h&ouml;heren Level hat als Du.');
define('_LANG_WUS_CANNOT_DELU','User kann nicht gel&ouml;scht werden');
define('_LANG_WUS_CANNOT_DELUPOST','Userpost kann nicht gel&ouml;scht werden');
define('_LANG_WUS_AU_THOR','Autor(en)');
define('_LANG_WUS_AU_NICK','Nickname');
define('_LANG_WUS_AU_NAME','Name');
define('_LANG_WUS_AU_MAIL','E-mail');
define('_LANG_WUS_AU_URI','URI');
define('_LANG_WUS_AU_LEVEL','Level');
define('_LANG_WUS_AU_POSTS','Posts');
define('_LANG_WUS_AU_USERS','User');
define('_LANG_WUS_AU_WARNING','Um einen User zu l&ouml;schen muss sein Level zun&auml;chst auf 0 gesetzt werden, danach muss einfach das rote X angeklickt werden.<br /><strong>WARNUNG:</strong> Wird ein User gel&ouml;scht, werden auch alle seine Post gel&ouml;scht.');
define('_LANG_WUS_ADD_USER','User hinzuf&uuml;gen');
define('_LANG_WUS_ADD_THEMSELVES','User k&ouml;nnen sich manuell registrieren, oder Du kannst Sie hier anlegen.');
define('_LANG_WUS_ADD_FIRST','Vorname ');
define('_LANG_WUS_ADD_LAST','Nachname ');
define('_LANG_WUS_ADD_TWICE','Passwort (2x) ');

/* File Name wp-comments.php */
define('_LANG_WPCM_LOAD_DIRECTLY','Bitte diese Seite nicht direkt laden. Danke!');
define('_LANG_WPCM_ENTER_PASS','<p>Passwort eingeben um Kommentar zu schreiben.<p>');
define('_LANG_WPCM_COM_TITLE','Kommentare');
define('_LANG_WPCM_COM_RSS','<abbr title="Really Simple Syndication">RSS</abbr> Feed f¸r Kommentare zu diesem Post.');
define('_LANG_WPCM_COM_TRACK','Der <acronym title="Uniform Resource Identifier">URI</acronym> um diesen Eintrag zu verlinken lautet: ');
define('_LANG_WPCM_COM_YET','Bislang keine Kommentare.');
define('_LANG_WPCM_COM_LEAVE','Schreibe einen Kommentar');
define('_LANG_WPCM_HTML_ALLOWED','Zeilen und Paragraphen brechen automatisch um, Webseiten, Email, <acronym title="Hypertext Markup Language">HTML</acronym> erlaubt: ');
define('_LANG_WPCM_COM_YOUR','Dein Kommentar');
define('_LANG_WPCM_PLEASE_NOTE','<strong>Achtung:</strong> Zur Zeit werden Kommentare moderiert. Aufgrund dessen kann es einige Zeit dauern bis der Kommentar sichtbar wird. es besteht also kein Grund zu reposten');
define('_LANG_WPCM_COM_SAYIT','Sag es uns!');
define('_LANG_WPCM_THIS_TIME','Sorry, Kommentarformular ist zur Zeit nicht verf&uuml;gbar.');
// define('_LANG_WPCM_GO_BACK','Zur&uuml;ck');
define('_LANG_WPCM_COM_NAME','Name');

/* File Name wp-comments-post.php */
define('_LANG_WPCP_SORRY_ITEM','Sorry, Kommentare f&uuml;r dieses Item sind gesperrt.');
define('_LANG_WPCP_ERR_FILL','Fehler: bitte f&uuml;lle alle notwendigen Felder aus (Name, Email).');
define('_LANG_WPCP_ERR_TYPE','Fehler: bitte gib einen Kommentar ein.');
define('_LANG_WPCP_SORRY_SECONDS','Sorry, Du kannst nur alle 10 Sekunden einen kommentar abgeben. Slow down cowboy.');

/* File Name wp-admin/upload.php */
define('_LANG_WAU_UPLOAD_DISABLED','Diese Funktion ist deaktiviert');
define('_LANG_WAU_UPLOAD_DIRECTORY','Das angegebene Verzeichnis kann als Uploadverzeichnis nicht verwendet werden da es f&uuml;r WP nicht beschreibar ist. &uuml;berpr&uuml;fe die Permission oder die Schreibweise');

define('_LANG_WAU_UPLOAD_EXTENSION','Folgende Erweiterungen k&ouml;nnen hochgeladen werden : ');
define('_LANG_WAU_UPLOAD_BYTES','So lange diese nicht gr&ouml;sser sind als <abbr title="Kilobytes">KB</abbr> : ');
define('_LANG_WAU_UPLOAD_OPTIONS','Als Admin k&ouml;nnen die Werte unter <a href="options.php?option_group_id=4">Einstellungen</a> ge&auml;ndert werden.');
define('_LANG_WAU_UPLOAD_FILE','Datei:');
define('_LANG_WAU_UPLOAD_ALT','Beschreibung:');
define('_LANG_WAU_UPLOAD_THUMBNAIL','Thumbnail erstellen?');
define('_LANG_WAU_UPLOAD_NO','Nein danke');
define('_LANG_WAU_UPLOAD_SMALL','klein (200px l&auml;ngste Seite)');
define('_LANG_WAU_UPLOAD_LARGE','gross (400px l&auml;ngste Seite)');
define('_LANG_WAU_UPLOAD_CUSTOM','Benutzerdefinierte Gr&ouml;sse');
define('_LANG_WAU_UPLOAD_PX','px (l&auml;ngste Seite)');
define('_LANG_WAU_UPLOAD_BTN','Datei hochladen');
define('_LANG_WAU_UPLOAD_SUCCESS','Datei erfolgreich hochgeladen : ');
define('_LANG_WAU_UPLOAD_CODE','Hier ist der Code um es anzuzeigen:');
define('_LANG_WAU_UPLOAD_START','Fortfahren');
define('_LANG_WAU_UPLOAD_DUPLICATE','Datei duplizieren?');
define('_LANG_WAU_UPLOAD_EXISTS','Dateiname existiert bereits: ');
define('_LANG_WAU_UPLOAD_RENAME','Best&auml;tigen oder Umbenennen:');
define('_LANG_WAU_UPLOAD_ALTER','Alternativer Name:');
define('_LANG_WAU_UPLOAD_REBTN','Umbenennen');
define('_LANG_WAU_UPLOAD_CODEIN','It inserts in form.');
define('_LANG_WAU_UPLOAD_AMAZON','Amazon Verkn&uuml;pfung');

/* File Name wp-admin/options-general.php */
define('_LANG_WAO_GENERAL_DISABLED','Nicht gen&uuml;gend Rechte um die Einstellungen zu editieren.');
define('_LANG_WAO_GENERAL_WPTITLE','Weblog Titel: ');
define('_LANG_WAO_GENERAL_TAGLINE','Tagline:');
define('_LANG_WAO_GENERAL_URI','Webadresse (URI): ');
define('_LANG_WAO_GENERAL_MAIL','Emailadresse: ');
define('_LANG_WAO_GENERAL_MEMBER','Mitgliedschaft:');
define('_LANG_WAO_GENERAL_GMT','<acronym title="Greenwich Meridian Time">GMT</acronym> Zeit ist: ');
define('_LANG_WAO_GENERAL_DIFFER','Die Zeiten im devBlog sollten sich unterscheiden um: ');
define('_LANG_WAO_GENERAL_EXPLIAIN','In a few words, explain what this weblog is about.');
define('_LANG_WAO_GENERAL_ADMIN','Diese Adresse dient nur administrativen Zwecken.');
define('_LANG_WAO_GENERAL_REGISTER','Jeder kann sich registrieren');
define('_LANG_WAO_GENERAL_ARTICLES','Jedes registrierte Mitglied kann posten');
define('_LANG_WAO_GENERAL_UPDATE','Update Optionen');

/* File Name wp-admin/options-writing.php */
define('_LANG_WAO_WRITING_ERROR','Nicht gen&uuml;gend Rechte um die Einstellungen zu editieren.');
define('_LANG_WAO_WRITING_TITLE','Schreiboptionen');
define('_LANG_WAO_WRITING_SIMPLE','Einfache Controls');
define('_LANG_WAO_WRITING_ADVANCED','Erweiterte Controls');
define('_LANG_WAO_WRITING_LINES','Zeilen');
define('_LANG_WAO_WRITING_DISPLAY','Emoticons wie z.B. :-) und :-P in graphische umwandeln');
define('_LANG_WAO_WRITING_XHTML','WP soll nested XHTML automatisch korrigieren');
define('_LANG_WAO_WRITING_CHARACTER','Das Character Encoding im devBlog (UTF-8 empfohlen: <a href="http://developer.apple.com/documentation/macos8/TextIntlSvcs/TextEncodingConversionManager/TEC1.5/TEC.b0.html">Liste</a>)');
define('_LANG_WAO_WRITING_STYLE','Wenn ein Post begonnen wird, zeige:');
define('_LANG_WAO_WRITING_BOX','Gr&ouml;sse der Schreibbox:');
define('_LANG_WAO_WRITING_FORMAT','Formatiere:');
define('_LANG_WAO_WRITING_ENCODE','Character Encoding:');
define('_LANG_WAO_WRITING_SERVICES','Update Services');
define('_LANG_WAO_WRITING_SOMETHING','Gib die Seiten ein die benachrichtigt werden sollen wenn ein neues Post gestartet wird. Mehrere URIs durch Leerzeichen trennen.');
define('_LANG_WAO_WRITING_UPDATE','Update Optionen');

/* File Name wp-admin/options-discussion.php */
define('_LANG_WAO_DISCUSS_TITLE','Diskussions Optionen');
define('_LANG_WAO_DISCUSS_INDIVIDUAL','Standardeinstellungen f&uuml;r einen Artikel: <em>(Einstellungen k&ouml;nnen f&uuml;r einzelne Artikel anders sein.)</em>');
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
define('_LANG_WAO_READING_TITLE','Lese Optionen');
define('_LANG_WAO_READING_FRONT','Frontseite');
define('_LANG_WAO_READING_RECENT','Zeige den Neuesten:');
define('_LANG_WAO_READING_FEEDS','Syndication Feeds');
define('_LANG_WAO_READING_ARTICLE','Zeige f&uuml;r jeden Artikel:');
define('_LANG_WAO_READING_ENCODE','Encoding f&uuml;r Seiten und Feeds:');
define('_LANG_WAO_READING_CHARACTER','Das Character Encoding in dem das Blog geschrieben wird (UTF-8 empfohlen: <a href="http://developer.apple.com/documentation/macos8/TextIntlSvcs/TextEncodingConversionManager/TEC1.5/TEC.b0.html">Liste</a>)');
define('_LANG_WAO_READING_GZIP','WP soll Beitr&auml;ge komprimieren (gzip) falls der Browser dies unterst¸tzt');
define('_LANG_WAO_READING_BTNTXT','Update Optionen');

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
define('_LANG_INST_BASE_VALUE38','Mailserver Einstellungen');
define('_LANG_INST_BASE_VALUE39','Mailserver Einstellungen');
define('_LANG_INST_BASE_VALUE40','Mailserver Einstellungen');
define('_LANG_INST_BASE_VALUE41','Mailserver Einstellungen');
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
define('_LANG_INST_BASE_HELP1','Posts pro Seite etc. Original Einstellungsseite');
define('_LANG_INST_BASE_HELP2','Einige Sachen die vielleicht getweakt werden sollten.');
define('_LANG_INST_BASE_HELP3','Einstellungen f&uuml;r RSS/RDF Feeds, Track/Ping-Backs');
define('_LANG_INST_BASE_HELP4','Einstellungen f&uuml;r Dateiuploads');
define('_LANG_INST_BASE_HELP5','Einstellungen f&uuml;r Blogging via Mail');
define('_LANG_INST_BASE_HELP6','Grundeinstellungen um das Blog zu betreiben');
define('_LANG_INST_BASE_HELP7','Grundeinstellungen f&uuml;r neue Posts');
define('_LANG_INST_BASE_HELP8','Verschiedene einstellungen f&uuml;r den Linkmanager');
define('_LANG_INST_BASE_HELP9','Einstellungen die das Posten und darstellen der Geo Options steuern');
define('_LANG_INST_BASE_VALUE55','Grundstatus jedes neuen Posts');
define('_LANG_INST_BASE_VALUE56','Grundstatus f&uuml;r Kommentare zu jedem neuen Post');
define('_LANG_INST_BASE_VALUE57','Grundstatus f&uuml;r Pings zu jedem neuen Post');
define('_LANG_INST_BASE_VALUE58','Soll die \'PingBack f&uuml;r URLs in diesem Post\' Checkbox per Default angehakt sein');
define('_LANG_INST_BASE_VALUE59','Die Default Kategorie f&uuml;r jeden neuen Post');
define('_LANG_INST_BASE_VALUE83','Anzahl der Zeilen im Edit Post Forumlar (min 3, max 100)');
define('_LANG_INST_BASE_VALUE60','Minimaler Adminlevel um Links zu editieren');
define('_LANG_INST_BASE_VALUE61','hier auf false setzen um alle Links f&uuml;r jeden sichtbar und editierbar zu machen');
define('_LANG_INST_BASE_VALUE62','Set this to the type of rating indication you wish to use');
define('_LANG_INST_BASE_VALUE63','If we are set to \'char\' which char to use.');
define('_LANG_INST_BASE_VALUE64','What do we do with a value of zero? set this to true to output nothing, 0 to output as normal (number/image)');
define('_LANG_INST_BASE_VALUE65','Use the same image for each rating point? (Uses links_rating_image[0])');
define('_LANG_INST_BASE_VALUE66','Image for rating 0 (and for single image)');
define('_LANG_INST_BASE_VALUE67','Bild f&uuml;r Rating 1');
define('_LANG_INST_BASE_VALUE68','Bild f&uuml;r Rating 2');
define('_LANG_INST_BASE_VALUE69','Bild f&uuml;r Rating 3');
define('_LANG_INST_BASE_VALUE70','Bild f&uuml;r Rating 4');
define('_LANG_INST_BASE_VALUE71','Bild f&uuml;r Rating 5');
define('_LANG_INST_BASE_VALUE72','Bild f&uuml;r Rating 6');
define('_LANG_INST_BASE_VALUE73','Bild f&uuml;r Rating 7');
define('_LANG_INST_BASE_VALUE74','Bild f&uuml;r Rating 8');
define('_LANG_INST_BASE_VALUE75','Bild f&uuml;r Rating 9');
define('_LANG_INST_BASE_VALUE76','Pfad/zu/den/Cachedateien auf dem Webserver muss schreibar sein');
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
define('_LANG_INST_BASE_VALUE94','Zeitunterschied zwischen GMT und Deiner Zeitzone (in Stunden)');

/* Missing tags */
define('_WP_LIST_CAT_ALL','-----WP KAT-----');
define('_LANG_C_NAME_EDITBTN','&Uuml;bernehmen');

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