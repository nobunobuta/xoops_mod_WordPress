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
define('_LANG_WA_SETTING_GUIDE','<p>Sembra che WP non sia ancora installato. Prova questo link <a href=\'wp-admin/install.php\'>install.php</a>.</p>');

/* File Name wp-blog-header.php */
define('_LANG_WA_HEADER_GUIDE1','<p>Sembra manchi il file <code>wp-config.php</code> . Lo script necessita di questo settaggio. Hai bisogno di aiuto ? <a href=\'http://wordpress.org/docs/faq/#wp-config\'>Noi ti aiutiamo</a>. Puoi <a href=\'wp-admin/install-config.php\'>creare <code>wp-config.php</code> attraverso un interfaccia web</a>, ma questo sistema non funziona per tutte le configurazioni di server. Il modo pi˘ sicuro Ë creare manualmente il file.</p>');

/* File Name wp-admin/install-config.php */
define('_LANG_WA_CONFIG_GUIDE1','<p>Il file \'wp-config.php\' esiste gi‡. Se hai bisogno di resettare la configurazione, per favore, cancella prima il file stesso.</p>');
define('_LANG_WA_CONFIG_GUIDE2','<p>Scusa, Ho bisogno del file wp-config-sample.php per funzionare. Per favore ricarica questo file dall installazione di WordPress.<p>');
define('_LANG_WA_CONFIG_GUIDE3','<p>Scusa, Non posso scrivere nella directory. Dovrai cambiare i premessi di WordPress o creare wp-config.php manualmente.</p>');
define('_LANG_WA_CONFIG_GUIDE4','Benvenuto al Blog. Prima che tu possa iniziare, abbiamo bisogno di qualche informazione. Necessitiamo di conoscere i seguenti dati prima di procedere.');
define('_LANG_WA_CONFIG_DATABASE','Nome del Database');
define('_LANG_WA_CONFIG_USERNAME','Username Database');
define('_LANG_WA_CONFIG_PASSWORD','Password Database');
define('_LANG_WA_CONFIG_LOCALHOST','Host Database');
define('_LANG_WA_CONFIG_PREFIX','Prefisso Tabelle');
define('_LANG_WA_CONFIG_GUIDE5','<strong>Se per qualche ragione questo file di creazione automatica non funziona, non ti preoccupare. Questo programma si limita a copiare queste informazioni nei nostri file di configurazione. Tu puoi anche semplicemente aprire il file <code>wp-config-sample.php</code> con un editor di testo, compila tutte le informazioni, e salvale di conseguenza <code>wp-config.php</code>. </strong></p>
<p>In ogni caso le informazioni necessarie ti saranno fornite dal tuo Server Provider. Se non disponi di queste informazioni, allora contatta il tuo Provider prima di continuare. Se non ci sono problemi prosegui <a href="install-config.php?step=1">let&#8217;s go</a>! ');
define('_LANG_WA_CONFIG_GUIDE6','Sotto devi inserire i dati di connessione del database. Se non sei sicuro, contatta il tuo Provider. ');
define('_LANG_WA_CONFIG_GUIDE7','<small>Il nome del Database che vuoi utilizzare. </small>');
define('_LANG_WA_CONFIG_GUIDE8','<small>Il tuo Username MySQL</small>');
define('_LANG_WA_CONFIG_GUIDE9','<small>...e la Password MySQL.</small>');
define('_LANG_WA_CONFIG_GUIDE10','<small>scegli solo se hai bisogno di cambiare il dato.</small>');
define('_LANG_WA_CONFIG_GUIDE11','<small>Se vuoi far andare installazioni multiple del Blog in un singolo database, cambia questo dato.</small>');
define('_LANG_WA_CONFIG_GUIDE12','Tutto bene! Questa parte di installazione Ë terminata. WordPress puÚ ora comunicare con il tuo database. Se sei pronto vai a <a href="install.php"> e continua la nostra installazione</a>');


/* File Name wp-include/wp-db.php */
define('_LANG_WA_WPDB_GUIDE1','<strong>Errore nella connessione al database!</strong> Questo significa che le informazioni nel file<code>wp-config.php</code> non sono corrette. Controlla di nuovo e fai un altro tentativo.');
define('_LANG_WA_WPDB_GUIDE2','Sei sicuro di aver inserito la corretta user/password?');
define('_LANG_WA_WPDB_GUIDE3','Sei sicuro di aver inserito il corretto hostname?');
define('_LANG_WA_WPDB_GUIDE4','Sei sicuro che il server di database stia funzionando correttamente?');

/* File Name wp-include/functions.php */
define('_LANG_F_TIMESTAMP','Edita timestamp');
define('_LANG_F_NEW_COMMENT','Nuovi commenti al tuo messaggio');
define('_LANG_F_ALL_COMMENTS','Puoi vedere tutti i commenti postati qui:');
define('_LANG_F_NEW_TRACKBACK','Nuova Comunicazione sul tuo post');
define('_LANG_F_ALL_TRACKBACKS','Puoi vedere tutte le comunicazioni sul tuo post qui:');
define('_LANG_F_NEW_PINGBACK','Nuovo ping sul tuo messaggio');
define('_LANG_F_ALL_PINGBACKS','Puoi vedere tutti i ping sul tuo messaggio qui:');
define('_LANG_F_COMMENT_POST','Un nuovo commento al tuo messaggio');
define('_LANG_F_WAITING_APPROVAL','sta aspettando di essere approvato');
define('_LANG_F_APPROVAL_VISIT','Per approvare il commento, visita:');
define('_LANG_F_DELETE_VISIT','Per cancellare il commento, visita:');
define('_LANG_F_PLEASE_VISIT','Alcuni commenti necessitano di essere approvati. Prego visita il Pannello di Moderazione:');

/* File Name wp-register.php */
define('_LANG_R_ENTER_LOGIN','<strong>ERRORE</strong>: Prego inserire i dati di login.');
define('_LANG_R_PASS_TWICE','<strong>ERRORE</strong>: Prego inserire la password 2 volte.');
define('_LANG_R_SAME_PASS','<strong>ERRORE</strong>: Prego inserire la stessa password nel secondo campo.');
define('_LANG_R_MAIL_ADDRESS','<strong>ERRORE</strong>: Prego inserire indirizzo di email.');
define('_LANG_R_ADDRESS_CORRECT','<strong>ERRORE</strong>: Indirizzo di email non corretto.');
define('_LANG_R_CHOOSE_ANOTHER','<strong>ERRORE</strong>: Questi dati utente sono gi‡ registrati, prego sceglierne di diversi.');
define('_LANG_R_REGISTER_CONTACT','<strong>ERRORE</strong>: Abbiamo problemi nella tua registrazione... per favore contatta il webmaster !');
define('_LANG_R_USER_REGISTRATION','Nuovo utente registrato sul tuo blog');
define('_LANG_R_MAIL_REGISTRATION','Nuova Registrazione Utente');
define('_LANG_R_R_COMPLETE','Registrazione Completa');
define('_LANG_R_R_DISABLED','Registratione Disabilitata');
define('_LANG_R_R_CLOSED','Registrazione Utente correntemente non permessa.');
define('_LANG_R_R_REGISTRATION','Registrazione');
define('_LANG_R_USER_LOGIN','Login:');
define('_LANG_R_USER_PASSWORD','Password:');
define('_LANG_R_TWICE_PASSWORD','Due volte:');
define('_LANG_R_USER_EMAIL','E-mail');

/* File Name wp-login.php */
define('_LANG_L_LOGIN_EMPTY','il campo di login Ë vuoto');
define('_LANG_L_PASS_EMPTY','il campo di password Ë vuoto');
define('_LANG_L_WRONG_LOGPASS','errata login o password');
define('_LANG_L_RECEIVE_PASSWORD','Prego inserisci le tue informazioni qui. Ti invieremo la nuova password. ');
define('_LANG_L_EXIST_SORRY','Spiacenti, l utente sembra non sistere nel nostro database. Forse hai sbagliato username o indirizzo email? <a href="wp-login.php?action=lostpassword">Prova di nuovo</a>.');
define('_LANG_L_YOUR_LOGPASS','La tua login/password');
define('_LANG_L_NOT_SENT','L email non puÚ essere spedita.');
define('_LANG_L_DISABLED_FUNC','Possibili ragioni: il tuo provider ha disabilitato la funzione email...');
define('_LANG_L_SUCCESS_SEND',' : Email spedita con successo.');
define('_LANG_L_CLICK_ENTER','Clicca qui per il login!');
define('_LANG_L_WRONG_SESSION','Errore: sbagliata login/password');
define('_LANG_L_BACK_BLOG','Torna al Blog?');
define('_LANG_L_WP_RESIST','Registrati?');
define('_LANG_L_WPLOST_YOURPASS','Hai perso la password?');

/* File Name wp-admin/post.php */
define('_LANG_P_NEWCOMER_MESS','Visto che sei nuovo necessiti che il nostro amministratore setti il tuo livello utente a 1, per essere autorizzato a postare.<br />Puoi anche spedire una email all amministratore per chiedere la promozione.<br />Una volta promosso, ricarica la pagina e sarai abilitato a postare. :)');
define('_LANG_P_DATARIGHT_EDIT',' : Non hai il diritto di editare messaggi.');
define('_LANG_P_DATARIGHT_DELETE',' : Non hai diritto di cancellare messaggi.');
define('_LANG_P_DATARIGHT_ERROR','Errore nella cancellazione... contatta il webmaster.');
define('_LANG_P_OOPS_IDCOM','Oops, nessun commento con questo ID.');
define('_LANG_P_OOPS_IDPOS','Oops, nessun post con questo ID.');
define('_LANG_P_ABOUT_FOLLOW','Stai per cancellare i seguenti commenti:');
define('_LANG_P_SURE_THAT','Sei sicuro di volerlo fare?');
define('_LANG_P_NICKNAME_DELETE','Non hai il diritto di cancellare i commenti.');
define('_LANG_P_COMHAS_APPR','Il Commento Ë stato approvato.');
define('_LANG_P_YOUR_DRAFTS','Il tuo Cestino:');
define('_LANG_P_WP_BOOKMARKLET','Puoi salvare il seguente link o metterlo tra i tuoi favoriti e quando lo cliccherai si aprir‡ una finestra di popup con le relative informazioni e un collegamento al sito di modo che sia pi˘ facile postare messaggi. Prova:');
define('_LANG_P_CONFIRM_DELETE', 'Are you sure you want to delete this?');

/* File Name wp-admin/categories.php */
define('_LANG_C_DEFAULT_CAT','Non puoi cancellare questa categoria <strong>%s</strong> categoria: si tratta di una categoria di default');
define('_LANG_C_EDIT_TITLECAT','Edita Categoria');
define('_LANG_C_NAME_SUBCAT','Nome della Categoria:');
define('_LANG_C_NAME_SUBDESC','Descrizione:');
define('_LANG_C_RIGHT_EDITCAT','Non hai diritto di editare le categorie di questo blog.<br />Chiedi una promozione qui <a href="mailto:%s">blog admin</a>. :)');
define('_LANG_C_NAME_CURRCAT','Categorie Correnti');
define('_LANG_C_NAME_CATNAME','Nome');
define('_LANG_C_NAME_CATDESC','Descrizione:');
define('_LANG_C_NAME_CATPOSTS','# Messaggi');
define('_LANG_C_NAME_CATACTION','Azione');
define('_LANG_C_ADD_NEWCAT','Aggiungi una nuova categoria');
define('_LANG_C_NOTE_CATEGORY','<strong>Nota:</strong><br />La Cancellazione della categoria non eliminer‡ i messaggi postati, che saranno inseriti nella categoria di default <strong>%s</strong>.');
define('_LANG_C_NAME_EDIT','EDITA');
define('_LANG_C_NAME_DELETE','CANCELLA');
define('_LANG_C_NAME_ADDBTN','Aggiungi Categoria');
define('_LANG_C_NAME_EDITBTN','Edita categoria');
define('_LANG_C_NAME_PARENT','Categoria superiore:');
define('_LANG_C_MESS_ADD','Categoria aggiunta.');
define('_LANG_C_MESS_DELE','Categoria cancellata.');
define('_LANG_C_MESS_UP','Categoria aggiornata.');

/* File Name wp-admin/edit.php */
define('_LANG_E_LATEST_POSTS','Ultimi messaggi');
define('_LANG_E_LATEST_COMMENTS','Ultimi Commenti');
define('_LANG_E_AWAIT_MODER','Commenti che attendono moderazione');
define('_LANG_E_SHOW_POSTS','Mostra messaggi:');
define('_LANG_E_TITLE_COMMENTS','Commenti');
define('_LANG_E_FILL_REQUIRED','Errore: prego compilare i campi richiesti (nome & commento)');
define('_LANG_E_TITLE_LEAVECOM','Lascia Commento');
define('_LANG_E_RESULTS_FOUND','Nessun Risultato Trovato.');

/* File Name wp-admin/edit-comments.php */
define('_LANG_EC_SHOW_COM','Mostra commenti:');
define('_LANG_EC_EDIT_COM','Edita Commenti');
define('_LANG_EC_DELETE_COM','Cancella Commenti');
define('_LANG_EC_EDIT_POST','Edita Messaggi');
define('_LANG_EC_VIEW_POST','Vedi Messaggi');
define('_LANG_EC_SEARCH_MODE','Cerca nei commenti di testo, nelle email, URI, e negli indirizzi IP.');
define('_LANG_EC_VIEW_MODE','Vedi Modalit‡');
define('_LANG_EC_EDIT_MODE','Edita in massa Modalit‡');
define('_LANG_EC_CHECK_INVERT','Inverti Selezione');
define('_LANG_EC_CHECK_DELETE','Cancella Commenti');
define('_LANG_EC_LINK_VIEW','Vedi');
define('_LANG_EC_LINK_EDIT','Edita');
define('_LANG_EC_LINK_DELETE','Cancella');

/* File Name wp-admin/edit-form.php */
define('_LANG_EF_PING_FORM','<etichetta per="pingback"><strong>PingBack</strong> il titolo "Indirizzi Utili">URL</acronym> in questo messaggio </label> <a href="http://wordpress.org/docs/reference/post/#pingback" title="Aiuto sul Pingback">?</a><br />');
define('_LANG_EF_TRACK_FORM','<p><etichetta per="trackback"><a href="http://wordpress.org/docs/reference/post/#trackback" titolo="Aiuto sul trackbacks"><strong>TrackBack</strong> an <acronym titolo="Indirizzi Utili">URL</acronym>');
define('_LANG_EF_AD_POSTTITLE','Titolo');
define('_LANG_EF_AD_CATETITLE','Categorie');
define('_LANG_EF_AD_POSTAREA','Messaggio');
define('_LANG_EF_AD_POSTQUICK','Post semplificato');
define('_LANG_EF_AD_DRAFT','Salva nel Cestino');
define('_LANG_EF_AD_PRIVATE','Salva come Privato');
define('_LANG_EF_AD_PUBLISH','Pubblica');
define('_LANG_EF_AD_EDITING','Aditazione Avanzata');

/* File Name wp-admin/edit-form-advanced.php */
define('_LANG_EFA_POST_STATUS','Stato Messaggi');
define('_LANG_EFA_AD_COMMENTS','Commenti');
define('_LANG_EFA_AD_PINGS','Ping');
define('_LANG_EFA_POST_PASSWORD','Password Messaggi');
define('_LANG_EFA_POST_CUSTOM','Custom Field');
define('_LANG_EFA_POST_EXCERPT','Brano');
define('_LANG_EFA_POST_LATITUDE','Latitudine:');
define('_LANG_EFA_POST_LONGITUDE','Longitudine:');
define('_LANG_EFA_POST_GEOINFO','clicca per informazioni Geografiche');
define('_LANG_EFA_DEL_THISPOST','Cancella questo messaggio');
define('_LANG_EFA_SAVE_CONTINUE','Salva e continua ad editare');
define('_LANG_EFA_STATUS_OPEN','Aperto');
define('_LANG_EFA_STATUS_CLOSE','Chiuso');
define('_LANG_EFA_STATUS_UPLOAD','Carica un file o un immagine');
define('_LANG_EFA_STATUS_DISCUSS','Discussione');
define('_LANG_EFA_STATUS_ALLOWC','Permetti Commenti');
define('_LANG_EFA_STATUS_ALLOWP','Permetti Ping');
define('_LANG_EFA_STATUS_SLUG','Messaggio Slug');
define('_LANG_EFA_STATUS_POST','Messaggio');

/* File Name wp-admin/edit-form-comment.php */
define('_LANG_EFC_BUTTON_TEXT','Edita questo!');
define('_LANG_EFC_COM_NAME','Nome:');
define('_LANG_EFC_COM_MAIL','EMail:');
define('_LANG_EFC_COM_URI','URI:');
define('_LANG_EFC_COM_COMMENT','Commenti:');

/* File Name wp-admin/link-add.php */
define('_LANG_WLA_MANAGE_LINK','Amministra i Link');
define('_LANG_WLA_ADD_LINK','Aggiungi Link');
define('_LANG_WLA_LINK_CATE','Categorie Link');
define('_LANG_WLA_IMPORT_BLOG','Importa Blogroll');
define('_LANG_WLA_LINK_TITLE','<strong>Aggiungi</strong> un link:');
define('_LANG_WLA_SUB_URI','URI:');
define('_LANG_WLA_SUB_NAME','Nome del Link:');
define('_LANG_WLA_SUB_IMAGE','Immagine');
define('_LANG_WLA_SUB_RSS','RSS URI: ');
define('_LANG_WLA_SUB_DESC','Descrizione');
define('_LANG_WLA_SUB_REL','rel:');
define('_LANG_WLA_SUB_XFN','XFN');
define('_LANG_WLA_SUB_NOTE','Note:');
define('_LANG_WLA_SUB_RATE','Punteggio:');
define('_LANG_WLA_SUB_TARGET','Obiettivo');
define('_LANG_WLA_SUB_VISIBLE','Visibile:');
define('_LANG_WLA_SUB_CAT','Categoria:');
define('_LANG_WLA_SUB_FRIEND','alleanza');
define('_LANG_WLA_SUB_PHYSICAL','fisica');
define('_LANG_WLA_SUB_PROFESSIONAL','professionale');
define('_LANG_WLA_SUB_GEOGRAPH','geografico');
define('_LANG_WLA_SUB_FAMILY','famiglia');
define('_LANG_WLA_SUB_ROMANTIC','romantica');
define('_LANG_WLA_CHECK_ACQUA','acquatico');
define('_LANG_WLA_CHECK_FRIE','amicizia');
define('_LANG_WLA_CHECK_NONE','nome');
define('_LANG_WLA_CHECK_MET','incontro');
define('_LANG_WLA_CHECK_WORKER','cooperante');
define('_LANG_WLA_CHECK_COLL','collega');
define('_LANG_WLA_CHECK_RESI','coresidente');
define('_LANG_WLA_CHECK_NEIG','vicino');
define('_LANG_WLA_CHECK_CHILD','bambino');
define('_LANG_WLA_CHECK_PARENT','genitore');
define('_LANG_WLA_CHECK_SIBLING','fratello');
define('_LANG_WLA_CHECK_SPOUSE','sposo');
define('_LANG_WLA_CHECK_MUSE','ispiratrice');
define('_LANG_WLA_CHECK_CRUSH','rottura');
define('_LANG_WLA_CHECK_DATE','data');
define('_LANG_WLA_CHECK_HEART','innamorato');
define('_LANG_WLA_CHECK_ZERO','Lascia a 0 per non scegliere.');
define('_LANG_WLA_CHECK_STRICT','Nota che l <code> attributo target /code> Ë illegale in XHTML 1.1 e 1.0 Stretto.');
define('_LANG_WLA_TEXT_TOOLBAR','Puoi mettere un "Linka questo oggetto" e quando lo cliccherai si aprir‡ una finestra di popup che ti consentir‡ di aggiungere qualsiasi sito ai tuoi link! Veramente per ora funziona solo con Mozilla o Netscape, ma stiamo lavorando per migliorarlo.');

/* File Name wp-admin/link-categories.php */
define('_LANG_WLC_DONOT_DELETE','Non puoi cancellare questa categoria di link, Ë una categoria di default');
define('_LANG_WLC_TITLE_TEXT','Edita Categoria di Link');
define('_LANG_WLC_EPAGE_TITLE','<strong> Edita </strong> una categoria di link:');
define('_LANG_WLC_ADD_TITLE','Aggiungi una categoria di link:');
define('_LANG_WLC_SUBEDIT_NAME','Nome:');
define('_LANG_WLC_SUBEDIT_TOGGLE','auto toggle?');
define('_LANG_WLC_SUBEDIT_SHOW','Mostra:');
define('_LANG_WLC_SUBEDIT_ORDER','Ordina:');
define('_LANG_WLC_SUBEDIT_IMAGES','immagine');
define('_LANG_WLC_SUBEDIT_DESC','descrizione');
define('_LANG_WLC_SUBEDIT_RATE','voto');
define('_LANG_WLC_SUBEDIT_UPDATE','aggiornato');
define('_LANG_WLC_SUBEDIT_SORT','Ordina:');
define('_LANG_WLC_SUBEDIT_DESCEND','Scorri?');
define('_LANG_WLC_SUBEDIT_BEFORE','Prima:');
define('_LANG_WLC_SUBEDIT_BETWEEN','Tra:');
define('_LANG_WLC_SUBEDIT_AFTER','Dopo:');
define('_LANG_WLC_SUBEDIT_LIMIT','Limite:');
define('_LANG_WLC_ADDBUTTON_TEXT','Aggiungi Categoria!');
define('_LANG_WLC_SAVEBUTTON_TEXT','Salva');
define('_LANG_WLC_CANCELBUTTON_TEXT','Cancella');
define('_LANG_WLC_SUBCATE_NAME','Nome');
define('_LANG_WLC_SUBCATE_ATT','Auto <br /> Toggle?');
define('_LANG_WLC_SUBCATE_SHOW','Mostra');
define('_LANG_WLC_SUBCATE_SORT','Ordina');
define('_LANG_WLC_SUBCATE_DESC','Descrizione?');
define('_LANG_WLC_SUBCATE_LIMIT','Limite');
define('_LANG_WLC_SUBCATE_IMAGES','immagini?');
define('_LANG_WLC_SUBCATE_MINIDESC','descrizione?');
define('_LANG_WLC_SUBCATE_RATE','voto?');
define('_LANG_WLC_SUBCATE_UPDATE','aggiornato?');
define('_LANG_WLC_SUBCATE_BEFORE','prima');
define('_LANG_WLC_SUBCATE_BETWEEN','tra');
define('_LANG_WLC_SUBCATE_AFTER','dopo');
define('_LANG_WLC_SUBCATE_EDIT','Edita');
define('_LANG_WLC_SUBCATE_DELETE','Cancella');
define('_LANG_WLC_SUBEDIT_EMPTY','Quanti link vanno mostrati. Lascia vuoto per illimitati.');
define('_LANG_WLC_EPAGE_EMPTY','lascia vuoto per nessun limite');
define('_LANG_WLC_EPAGE_NOTE','La cancellazione di una categoria di link non canceller‡ i link della categoria stessa.<br />Torneranno tutti alla categoria di default  :');
define('_LANG_WLC_RIGHT_PROM','Non hai diritti per editare le categorie di link per il tuo blog.<br>Chiedi una promozione all amminitratore del blog :)');

/* File Name wp-admin/link-import.php */
define('_LANG_WLI_ROLL_TITLE','Importa Blogroll');
define('_LANG_WLI_ROLL_DESC','Importa il blogroll da un altro sistema ');
define('_LANG_WLI_ROLL_OPMLCODE','Vai al Blogrolling.com e registrati. Una volta fatto, Prendi il Codice cercando <strong><abbr title="Outline Processor Markup Language">OPML</abbr> </strong>');
define('_LANG_WLI_ROLL_OPMLLINK','Oppure vai sul Blogs e registrati. Una volta fatto clicca il box sulla destra <strong> share </strong>, e poi cerca il <strong><abbr title="Outline Processor Markup Language">OPML</abbr> link</strong> (favorites.opml)');
define('_LANG_WLI_ROLL_BELOW','Seleziona il testo e copialo o copia il link nel box sottostante.');
define('_LANG_WLI_ROLL_YOURURL','Tuo indirizzo OPML:');
define('_LANG_WLI_ROLL_UPLOAD','<strong> or </strong> puoi caricare un file OPML dal tuo aggregatore sul desktop:');
define('_LANG_WLI_ROLL_THISFILE','Carica questo file: ');
define('_LANG_WLI_ROLL_CATEGORY','Ora seleziona la categoria che desideri e metti il link in.<br />Categoria: ');
define('_LANG_WLI_ROLL_BUTTONTEXT','Importa!');

/* File Name wp-admin/link-manager.php */
define('_LANG_WLM_PAGE_TITLE','Amministra Link');
define('_LANG_WLM_LEVEL_ERROR','Non hai diritto di editare il link del blog.<br />Chiedi una promozione all amministratore del blog. :)');
define('_LANG_WLM_SHOW_LINKS','<strong>Mostra</strong> i link nelle categorie:');
define('_LANG_WLM_ORDER_BY','<strong> Ordina </strong> da:');
define('_LANG_WLM_SHOW_BUTTONTEXT','Mostra');
define('_LANG_WLM_SHOW_ACTIONTEXT','Azione');
define('_LANG_WLM_MULTI_LINK','Amministra Link Multipli:');
define('_LANG_WLM_CHECK_CHOOSE','Usa il box sulla destra per selezionare pi˘ link e scegli un azione nel men˘ sottostante:');
define('_LANG_WLM_ASSIGN_TEXT','Assegna');
define('_LANG_WLM_OWNER_SHIP','posseduto da:');
define('_LANG_WLM_TOGGLE_TEXT','Toggle ');
define('_LANG_WLM_VISIVILITY_TEXT','Visibilit‡');
define('_LANG_WLM_MOVE_TEXT','Muovi');
define('_LANG_WLM_TO_CATEGORY',' alla categoria');
define('_LANG_WLM_TOGGLE_BOXES','Box Toggle');
define('_LANG_WLM_EDIT_LINK','Edita un link:');
define('_LANG_WLM_SAVE_CHANGES','Salva Modifiche');
define('_LANG_WLM_EDIT_CANCEL','Cancella');

/* File Name wp-admin/menu.php */
define('_LANG_ADMIN_MENU_WRITE','Write');
define('_LANG_ADMIN_MENU_EDIT','Edit');
define('_LANG_ADMIN_MENU_CATE','Categories');
define('_LANG_ADMIN_MENU_LINK','Links');
define('_LANG_ADMIN_MENU_USER','Users');
define('_LANG_ADMIN_MENU_OPTION','Options');
define('_LANG_ADMIN_MENU_PLUG','Plugins');
define('_LANG_ADMIN_MENU_TEMP','Templates');
define('_LANG_ADMIN_MENU_UPLOAD','Upload');
define('_LANG_ADMIN_MENU_PROFILE','Profile');
define('_LANG_ADMIN_MENU_VIEW','View site &raquo;');
define('_LANG_ADMIN_MENU_LOGOUT','Logout (%s)');

/* File Name wp-admin/moderation.php */
define('_LANG_WPM_USER_LEVEL','Il Tuo livello non Ë abbastanza alto per moderare i commenti. Chiedi una promozione all Amministratore del Blog. :)');
define('_LANG_WPM_LATE_POSTS','Messaggi');
define('_LANG_WPM_LATE_COMS','Commenti');
define('_LANG_WPM_AWIT_MODERATION','In Attesa di Moderazione');
define('_LANG_WPM_COM_APPROV',' commento approvato ');
define('_LANG_WPM_COMS_APPROVS',' commenti approvati ');
define('_LANG_WPM_COM_DEL',' commento cancellato ');
define('_LANG_WPM_COMS_DELS',' commento cancellato ');
define('_LANG_WPM_COM_UNCHANGE',' commento non modificato ');
define('_LANG_WPM_COMS_UNCHANGES',' commenti non modificati ');
define('_LANG_WPM_WAIT_APPROVAL','I seguenti commenti attendono approvazione:');
define('_LANG_WPM_CURR_COMAPP','Al momento non ci sono commenti da approvare.');
define('_LANG_WPM_DEL_LATER','<p>Per ciascun commento devi scegliere tra <em> approvare </em>, <em> cancellare </em> o <em> decidere in seguito </em>:</p>');
define('_LANG_WPM_PUBL_VISIBLE','<p><em> approvare </em>: approvare commento, di modo che sia pubblicamente visibile');
define('_LANG_WPM_AUTHOR_NOTIFIED','l autore del messaggio ricever‡ notificazione circa i nuovi commenti al suo post.');
define('_LANG_WPM_ASKED_AGAIN','<p><em> cancella </em>: rimuovi il contenuto dal tuo blog (nota che la domanda non sar‡ rinnovata quindi dovresti scegliere qui se realmente vuoi cancellare i commenti, i quali, poi non saranno recuperabili!)</p><p><em>dopo</em>: non cambiare lo stato dei commenti per il momento.</p>');
define('_LANG_WPM_MODERATE_BUTTON','Moderare Commenti');
define('_LANG_WPM_DO_NOTHING','Fare nulla');
define('_LANG_WPM_DO_DELETE','Cancella');
define('_LANG_WPM_DO_APPROVE','Approva');
define('_LANG_WPM_DO_ACTION','Azione di Massa:');
define('_LANG_WPM_JUST_THIS','Cancella questo messaggio');
define('_LANG_WPM_JUST_EDIT','Edita');
define('_LANG_WPM_COMPOST_NAME','Nome:');
define('_LANG_WPM_COMPOST_MAIL','Email:');
define('_LANG_WPM_COMPOST_URL','URI:');

/* File Name wp-admin/options.php */
define('_LANG_WOP_USER_LEVEL','Non hai il diritto di modificare le opzioni di questo blog.<br />Chiedi una promozione al tuo amministratore del blog :)');
define('_LANG_WOP_PERM_LINKS','Permalinks');
define('_LANG_WOP_PERM_CONFIG','Configurazione link permanenti');
define('_LANG_WOP_NO_HELPS',' Nessun aiuto per questo gruppo di opzioni.');
define('_LANG_WOP_SUBMIT_TEXT','Aggiorna Configurazione');
define('_LANG_WOP_SETTING_SAVED',' configurazione salvata... ');

/* File Name wp-admin/permalink.php */
define('_LANG_WPL_EDIT_UPDATED','Struttura Permalink aggiornata.');
define('_LANG_WPL_EDIT_STRUCT','Edit Struttura Permalink');
define('_LANG_WPL_CREATE_CUSTOM','WordPress ti offre la possibilit‡ di creare una struttura URI personalizzata per i tuoi permalink ed archivi. I seguenti Tag sono disponibili:');
define('_LANG_WPL_CODE_YEAR','Anno del messaggio, 4 numeri, per esempio <code>2004</code>');
define('_LANG_WPL_CODE_MONTH','Mese dell anno, per esempio <code>05</code>');
define('_LANG_WPL_CODE_DAY','Giorno del mese, per esempio <code>28</code>');
define('_LANG_WPL_CODE_HOUR','Ora del giorno, per esempio <code>15</code>');
define('_LANG_WPL_CODE_MINUTE','Minuti, per esempio <code>43</code>');
define('_LANG_WPL_CODE_SECOND','Secondi, per esempio <code>33</code>');
define('_LANG_WPL_CODE_POSTNAME','Una sintetica versione del titolo del messaggio.  Tipo : Questo Ë un grande post! Diventa <code>questo-e-un-grande-post</code> nel codice URI');
define('_LANG_WPL_CODE_POSTID','Definisci l ID unico del post, per esempio <code>423</code>');
define('_LANG_WPL_USE_EXAMPLE','<p>CosÏ per esempio un valore tipo:</p>
<p><code>/%archives/%year%/%monthnum%/%day%/%postname%/</code> </p>
<p>dovrebbe avere un permalink tipo:</p>
<p><code>/archives/2003/05/23/my-cheese-sandwich/</code></p>
<p> In generale Ë consigliato usare mod_rewrite di Apache, comunque se metti un nome del file all inizio, WordPress tenter‡ di tradurre l argomento, per esempio:</p>
<p><code>/index.php/archives/%year%/%monthnum%/%day%/%postname%/</code> </p>
<p>Se usi questa opzione puoi ignorare le regole mod_rewrite. </p>');
define('_LANG_WPL_USE_TEMPTEXT','Usa il Tag sopra per creare una struttura di sito virtuale:');
define('_LANG_WPL_USE_BLANK','Se ti fa piacere, puoi inserire un prefisso standard per la tua categoria URI qui. Per esempio, <code>/taxonomy/categorias</code> diventer‡ nella categoria di link <code>http://example.org/taxonomy/categorias/general/</code>. Se lasci questo spazio bianco, sar‡ usato un elemento di default.');
define('_LANG_WPL_USE_HTACCESS','Attraverso la struttura Permalink correntemente, <code>%s</code>, ci sono le regole mod_rewrite che tu dovresti avere nel file<code>.htaccess</code>. Clicca sul campo e premi <kbd>CTRL + a</kbd> per fare la selezione.');
define('_LANG_WPL_ENGINE_ON','RewriteEngine On RewriteBase');
define('_LANG_WPL_EDIT_TEMPLATE','<p>Se il file <code>.htaccess</code> Ë riscrivibile dallo script tu puoi editarlo <a href="%s"> attraverso una interfaccia Template</a>.</p>');
define('_LANG_WPL_MOD_REWRITE','Non stai correntemente usando alcun Permalinks customizato. Nessuna speciale regola mod_rewrite Ë necessaria.');
define('_LANG_WPL_SUBMIT_UPDATE','Aggiorna Struttura Permalink');

/* File Name wp-admin/profile.php */
define('_LANG_WPF_ERR_NICKNAME','<strong>ERRORE</strong>: Prego inserire il tuo Nome Utente (il medesimo che usi per il login)');
define('_LANG_WPF_ERR_ICQUIN','<strong>ERRORE</strong>: Il Dato ICQ UIN puÚ solo essere un numero, non Ë permessa alcuna lettera');
define('_LANG_WPF_ERR_TYPEMAIL','<strong>ERRORE</strong>: Prego, inserire il tuo indirizzo email');
define('_LANG_WPF_ERR_CORRECT','<strong>ERRORE</strong>: indirizzo email non corretto');
define('_LANG_WPF_ERR_TYPETWICE','<strong>ERRORE</strong>: devi inserire correttamente la password 2 volte. Torna indietro e battila 2 volte.');
define('_LANG_WPF_ERR_DIFFERENT','<strong>ERRORE</strong>: hai inserito 2 password differenti. Torna indietro e correggi il tuo errore.');
define('_LANG_WPF_ERR_PROFILE','<strong>ERRORE</strong>: il tuo profilo non puÚ essere aggiornato... prego contattare il webmaster !');
define('_LANG_WPF_SUBT_VIEW','Vedi Profilo');
define('_LANG_WPF_SUBT_FIRST','Primo Nome:');
define('_LANG_WPF_SUBT_LAST','Cognome:');
define('_LANG_WPF_SUBT_NICK','Username:');
define('_LANG_WPF_SUBT_MAIL','Email:');
define('_LANG_WPF_SUBT_URL','Website:');
define('_LANG_WPF_SUBT_ICQ','ICQ:');
define('_LANG_WPF_SUBT_AIM','AIM:');
define('_LANG_WPF_SUBT_MSN','MSN IM:');
define('_LANG_WPF_SUBT_YAHOO','Yahoo IM:');
define('_LANG_WPF_SUBT_ONE','Preferiti IE');
define('_LANG_WPF_SUBT_COPY','Hai un Click Preferito, copia e incolla questo<br /> nel nuovo file di testo:');
define('_LANG_WPF_SUBT_BOOK','Salvalo come wordpress.reg, e clicca 2 volte sul file in una finestra del Browser<br /> Poi rispondi SÏ alla domanda e fai ripartire Internet Explorer.<br /><br />Ora, puoi cliccare in una finestra IE window e selezionare <br />&#8242; Il Messaggio che&#8242; comparir‡ nei Preferiti. :)');
define('_LANG_WPF_SUBT_CLOSE','Chiudi la finestra');
define('_LANG_WPF_SUBT_UPDATED','Profile updated.');
define('_LANG_WPF_SUBT_EDIT','Edita Il Tuo Profilo');
define('_LANG_WPF_SUBT_USERID','Login:');
define('_LANG_WPF_SUBT_LEVEL','Livello:');
define('_LANG_WPF_SUBT_POSTS','Messaggi:');
define('_LANG_WPF_SUBT_LOGIN','Login:');
define('_LANG_WPF_SUBT_DESC','Profilo:');
define('_LANG_WPF_SUBT_IDENTITY','Identit‡ sul blog: ');
define('_LANG_WPF_SUBT_NEWPASS','Nuova <strong>Password</strong> (Lasciare vuoto per non modificarla.)');
define('_LANG_WPF_SUBT_MOZILLA','Nessun Sidebar trovato!  Devi usare Mozilla 0.9.4 o successivi!');
define('_LANG_WPF_SUBT_SIDEBAR','SideBar');
define('_LANG_WPF_SUBT_FAVORITES','Aggiungi il link ai favoriti:');
define('_LANG_WPF_SUBT_UPDATE','Aggiorna');

/* File Name wp-admin/sidebar.php */
define('_LANG_WAS_SIDE_POSTED','Postato !');
define('_LANG_WAS_SIDE_AGAIN','<a href="sidebar.php">Clicca qui</a> per postare di nuovo.');

/* File Name wp-admin/templates.php */
define('_LANG_WAT_LEVEL_ERR','<p>Se hai problemi ad editare il Template questo puÚ essere dovuto alla mancanza di privilegi adeguati.<br />Chiedi una promozione al tuo amministratore. :)</p>');
define('_LANG_WAT_SORRY_EDIT','Spiacente, non puoi editare il file con ".." nel nome. Se stai tentando di editare il file direttamente nella directory del Blog puoi specificare il nome del file da inserire.');
define('_LANG_WAT_SORRY_PATH','Spiacenti, non si puÚ richiamare il file con questo indirizzo');
define('_LANG_WAT_EDITED_SUCCESS','<em>File editato con successo.</em>');
define('_LANG_WAT_FILE_CHMOD','non puoi aggiornare il Template: devono essere cambiati i permessi per renderlo riscrivibile, e.g. CHMOD 766');
define('_LANG_WAT_OOPS_EXISTS','<p>Oops, il file non esiste! Clicca 2 volte sul nome e tenta di nuovo, grazie.</p>');
define('_LANG_WAT_OTHER_FILE','<p>Per editare un file, batti il nome qui. Puoi editare ogni file riscrivibile sul server, e.g. CHMOD 766.</p>');
// define('_LANG_WAT_TYPE_HERE','Per editare un file, batti il suo nome qui:');
define('_LANG_WAT_FTP_CLIENT','Nota: naturalmente, puoi anche editare il files/template nel tuo editor di testo e caricarlo sul server. Questo editor online Ë inteso per essere usato quando non si ha accesso a un editor di testo o a un Client FTP.');
define('_LANG_WAT_UPTEXT_TEMP','Aggiorna file !');

/* File Name wp-admin/users.php */
define('_LANG_WUS_WHOSE_LEVEL','Non puoi cambiare il livello di un utente che dispone di un livello pi˘ alto del tuo.');
define('_LANG_WUS_WHOSE_DELETE','Non puoi cancellare un utente che dispone di un livello pi˘ alto del tuo.');
define('_LANG_WUS_CANNOT_DELU','L Utente non puÚ essere cancellato');
define('_LANG_WUS_CANNOT_DELUPOST','Il Post di questo utente non puÚ essere cancellato');
define('_LANG_WUS_AU_THOR','Autori');
define('_LANG_WUS_AU_NICK','Username');
define('_LANG_WUS_AU_NAME','Nome');
define('_LANG_WUS_AU_MAIL','Email');
define('_LANG_WUS_AU_URI','URI');
define('_LANG_WUS_AU_LEVEL','Levello');
define('_LANG_WUS_AU_POSTS','Messaggi');
define('_LANG_WUS_AU_USERS','Utenti');
define('_LANG_WUS_AU_WARNING','Per cancellare un Utente, porta il suo livello a 0, poi clicca sul simbolo X Rosso.<br /><strong>Attenzione:</strong> cancellando l utente saranno anche cancellati tutti i suoi messaggi.');
define('_LANG_WUS_ADD_USER','Aggiungi Utente');
define('_LANG_WUS_ADD_THEMSELVES','Gli Utenti possono registrarsi da soli o tu puoi manualmente crearli qui.');
define('_LANG_WUS_ADD_FIRST','Primo Nome ');
define('_LANG_WUS_ADD_LAST','Cognome ');
define('_LANG_WUS_ADD_TWICE','Password (2 volte) ');

/* File Name wp-comments.php */
define('_LANG_WPCM_LOAD_DIRECTLY','Prego non caricare la pagina direttamente. Grazie!');
define('_LANG_WPCM_ENTER_PASS','<p>Inserisci la password per vedere i commenti.<p>');
define('_LANG_WPCM_COM_TITLE','Commenti');
define('_LANG_WPCM_COM_RSS','<abbr title="Uso dei Feed semplificato">RSS</abbr> feed per commenti a questo messaggio.');
define('_LANG_WPCM_COM_TRACK','<acronym title="Sistema di Comunicazione tra Blog">URI</acronym> TrackBack : ');
define('_LANG_WPCM_COM_YET','Nessun commento ancora.');
define('_LANG_WPCM_COM_LEAVE','Lascia un Commento');
define('_LANG_WPCM_HTML_ALLOWED','Interruzioni di linea e paragrafo automatiche,  format email, <acronym title="Hypertext Markup Language">HTML</acronym> permessi: ');
define('_LANG_WPCM_COM_YOUR','Tuoi Commenti');
define('_LANG_WPCM_PLEASE_NOTE','<strong>Prego notare che:</strong> La Moderazione dei Commenti Ë correntemente abilitata quindi puÚ trascorrere del tempo prima della pubblicazione. La Pazienza Ë una virt˘, quindi non hai bisogno di postare di nuovo i tuoi commenti.');
define('_LANG_WPCM_COM_SAYIT','Dimmi!');
define('_LANG_WPCM_THIS_TIME','Spiacenti, il formulario dei commenti Ë chiuso in questo momento.');
// define('_LANG_WPCM_GO_BACK','Torna indietro');
define('_LANG_WPCM_COM_NAME','Nome');
define('_LANG_WPCM_CONF_TITLE','Comment (Confirm)');
define('_LANG_WPCM_CONF_MSG','Please press "Confirm" button');
define('_LANG_WPCM_CONF_BTN','Confirm');
define('_LANG_WPCM_EDIT_TITLE','Edit Comment');
define('_LANG_WPCM_EDIT_BTN','Update');

/* File Name wp-comments-post.php */
define('_LANG_WPCP_SORRY_ITEM','Spiacenti, i commenti sono chiusi per questo oggetto.');
define('_LANG_WPCP_ERR_FILL','Errore: prego compilare i seguenti campi (nome, email).');
define('_LANG_WPCP_ERR_TYPE','Errore: prego inserire un commento.');
define('_LANG_WPCP_SORRY_SECONDS','Spiacenti, puoi solo postare un nuovo commento ogni 10 secondi. Postare con minore rapidit‡. Grazie');

/* File Name wp-admin/upload.php */
define('_LANG_WAU_UPLOAD_DISABLED','L Amministratore ha disabilitato questa funzione');
define('_LANG_WAU_UPLOAD_DIRECTORY','Sembra che esista un errore dovuto al fatto che la directory del file specificato non Ë riscrivibile da WordPress. Controlla i permessi sulla directory e sui file.');
define('_LANG_WAU_UPLOAD_EXTENSION','Puoi caricare file con le estensioni : ');
define('_LANG_WAU_UPLOAD_BYTES','Solo se non sono pi˘ grandi di <abbr title="Kilobytes">KB</abbr> : ');
define('_LANG_WAU_UPLOAD_OPTIONS','Se sei un amministratore puoi configurare questi valori sotto <a href="options.php?option_group_id=4">opzioni</a>.');
define('_LANG_WAU_UPLOAD_FILE','File:');
define('_LANG_WAU_UPLOAD_ALT','Descrizione:');
define('_LANG_WAU_UPLOAD_THUMBNAIL','Crea una Galleria?');
define('_LANG_WAU_UPLOAD_NO','No Grazie');
define('_LANG_WAU_UPLOAD_SMALL','Piccola (200px o pi˘ grande)');
define('_LANG_WAU_UPLOAD_LARGE','Grande (400px o pi˘ grande)');
define('_LANG_WAU_UPLOAD_CUSTOM','Grandezza Customizabile');
define('_LANG_WAU_UPLOAD_PX','px (la pi˘ grande)');
define('_LANG_WAU_UPLOAD_BTN','Carica File');
define('_LANG_WAU_UPLOAD_SUCCESS','Il file Ë stato caricato con successo : ');
define('_LANG_WAU_UPLOAD_CODE','Qui Ë il codice da visualizzare:');
define('_LANG_WAU_UPLOAD_START','Inizia');
define('_LANG_WAU_UPLOAD_DUPLICATE','Duplica File ?');
define('_LANG_WAU_UPLOAD_EXISTS','Il Nome del file esiste gi‡ : ');
define('_LANG_WAU_UPLOAD_RENAME','Conferma o rinomina:');
define('_LANG_WAU_UPLOAD_ALTER','Nome Alternativo:');
define('_LANG_WAU_UPLOAD_REBTN','Renomina');
define('_LANG_WAU_UPLOAD_CODEIN','Inserisce nella forma.');
define('_LANG_WAU_UPLOAD_AMAZON','Affiliazione Amazon');
define('_LANG_WAU_ATTACH_ICON','Icona file allegato soltanto');

/* File Name wp-admin/options-general.php */
define('_LANG_WAO_GENERAL_DISABLED','Non hai permessi sufficienti per editare le opzioni di questo Blog.');
define('_LANG_WAO_GENERAL_WPTITLE','Titolo Weblog: ');
define('_LANG_WAO_GENERAL_TAGLINE','Tagline:');
define('_LANG_WAO_GENERAL_URI','Indirizzo Web (URI): ');
define('_LANG_WAO_GENERAL_MAIL','Indirizzo Email: ');
define('_LANG_WAO_GENERAL_MEMBER','Membership:');
define('_LANG_WAO_GENERAL_GMT','<acronym title="Ora Meridiano di Greenwich">GMT</acronym> : ');
define('_LANG_WAO_GENERAL_DIFFER','Il Tempo nel Blog dovrebbe differire da: ');
define('_LANG_WAO_GENERAL_EXPLIAIN','In Poche parole, descrivi il tuo Blog.');
define('_LANG_WAO_GENERAL_ADMIN','Questo indirizzo puÚ essere usato solo dagli amministratori.');
define('_LANG_WAO_GENERAL_REGISTER','Tutti possono registrarsi');
define('_LANG_WAO_GENERAL_ARTICLES','Tutti i membri registrati possono pubblicare articoli');
define('_LANG_WAO_GENERAL_UPDATE','Opzioni Aggiornate');

/* File Name wp-admin/options-writing.php */
define('_LANG_WAO_WRITING_ERROR','Non hai sufficienti permessi per editare le opzioni di questo Blog.');
define('_LANG_WAO_WRITING_TITLE','Opzioni Scrittura');
define('_LANG_WAO_WRITING_SIMPLE','Controlli Semplificati');
define('_LANG_WAO_WRITING_ADVANCED','Controlli Avanzati');
define('_LANG_WAO_WRITING_LINES','linee');
define('_LANG_WAO_WRITING_DISPLAY','Converti le faccine tipo :-) e :-P in grafica da mostrare');
define('_LANG_WAO_WRITING_XHTML','WordPress dovrebbe non convalidare automaticamente il non corretto codice XHTML');
define('_LANG_WAO_WRITING_CHARACTER','La codifica dei caratteri con cui scrivere  nel Blog (UTF-8 raccomandata)');
define('_LANG_WAO_WRITING_STYLE','Quando inizia un post, mostra:');
define('_LANG_WAO_WRITING_BOX','Grandezza del box scrittura:');
define('_LANG_WAO_WRITING_FORMAT','Formattazione:');
define('_LANG_WAO_WRITING_ENCODE','Codifica Carattere:');
define('_LANG_WAO_WRITING_SERVICES','Servizi Aggiornati');
define('_LANG_WAO_WRITING_SOMETHING','Introduci i siti ai quali desideri notificare la pubblicazione dei nuovi messaggi. Per una lista di siti raccomandati prego vedere qui [LINK TO SOMETHING]. Gli indirizzi devono essere separati da interruzioni di linea.');
define('_LANG_WAO_WRITING_UPDATE','Aggiorna Opzioni');

/* File Name wp-admin/options-discussion.php */
define('_LANG_WAO_DISCUSS_TITLE','Opzioni Discussione');
define('_LANG_WAO_DISCUSS_INDIVIDUAL','Configurazione standard per un articolo: <em>(Questa configurazione potr‡ essere modificata per gli articoli individuali.)</em>');
define('_LANG_WAO_DISCUSS_NOTIFY','Tenta la notifica diretta ai Weblogs indicati (Procedura lenta.)');
define('_LANG_WAO_DISCUSS_PINGTRACK','Consenti la notificazione da Weblog esterni. (Pingbacks e trackbacks.)');
define('_LANG_WAO_DISCUSS_PEOPLE','Permetti ai visitatori di postare commenti agli articoli');
define('_LANG_WAO_DISCUSS_EMAIL','Manda Email ognivolta:');
define('_LANG_WAO_DISCUSS_ANYONE','Tutti postano commenti');
define('_LANG_WAO_DISCUSS_DECLINED','Un commento Ë approvato o declinato');
define('_LANG_WAO_DISCUSS_APPEARS','Prima di mostrare il commento:');
define('_LANG_WAO_DISCUSS_ADMIN','Un Amministratore deve approvare il commento (non violi le prescrizioni)');
define('_LANG_WAO_DISCUSS_MODERATION','Se un commento contiene una di queste parole nel contenuto, nome, URI, o email, caricalo automaticamente per la moderazione: (Separa le parole multiple con linee.)');

/* File Name wp-admin/options-reading.php */
define('_LANG_WAO_READING_TITLE','Opzioni Lettura');
define('_LANG_WAO_READING_FRONT','Front Page');
define('_LANG_WAO_READING_RECENT','Mostra i pi˘ recenti:');
define('_LANG_WAO_READING_FEEDS','Feed nel Blog');
define('_LANG_WAO_READING_ARTICLE','Per ciascun articolo, mostra:');
define('_LANG_WAO_READING_ENCODE','Codifica per pagina e per feed:');
define('_LANG_WAO_READING_CHARACTER','La Codifica carattere per scrivere nel Blog (UTF-8 raccomandata<a href="http://developer.apple.com/documentation/macos8/TextIntlSvcs/TextEncodingConversionManager/TEC1.5/TEC.b0.html"></a>)');
define('_LANG_WAO_READING_GZIP','WordPress dovrebbe comprimere gli articoli (gzip) se il browsers lo consente');
define('_LANG_WAO_READING_BTNTXT','Aggiorna Opzioni');

/* Cheatin&#8217; uh? */
define('_LANG_P_CHEATING_ERROR','ERRORE');


/* Start Install ************************************************/
/* File Name install.php */
define('_LANG_INST_GUIDE_WPCONFIG','Sembra mancare il file wp-config.php. Devi crearne uno prima di iniziare.');
define('_LANG_INST_GUIDE_INSTALLED','<p>Sembra esista gi‡ una versione WordPress installata. Se la vuoi reistallare prego elimina i campi del database prima.</p></body></html>');
define('_LANG_INST_GUIDE_WEL','<br />Benvenuto in WordPress. Stiamo per iniziare l installazione. Prima di iniziare ricorda che Ë richiesta una versione PHP almeno 4.0.6,');
define('_LANG_INST_GUIDE_COM','Tutto bene? Hai anche bisogno di settare le informazioni del database in <code>wp-config.php</code>. Hai visto <a href="../wp-readme/">leggimi</a>? Se va tutto bene, <a href="install.php?step=1"> Andiamo!</a> ');
define('_LANG_INST_STEP1_FIRST','<p>Prima di tutto dobbiamo andare a settare i link del database. Questo ti consentir‡ di far partire il tuo blogroll, completo con gli aggiornamenti di Weblogs.com.</p>');
define('_LANG_INST_STEP1_LINKS','<p>Installazione WP-Links.</p><p>Controlla le tabelle...</p>');
define('_LANG_INST_STEP1_ALLDONE','Hai sconfitto il mostro finale? Grande! Ora sei pronto per la fase 2 dell installazione <a href="install.php?step=2"> </a>.');
define('_LANG_INST_STEP2_INFO','Primo dobbiamo creare le tabelle necessarie al database...');
/* base options from b2cofig */
define('_LANG_INST_BASE_VALUE1','siteurl Ë il tuo indirizzo blog: \'http://example.com/wordpress\' (non mettere la barra finale !)');
define('_LANG_INST_BASE_VALUE2','blogfilename Ë il nome del file di default per il tuo blog');
define('_LANG_INST_BASE_VALUE3','blogname Ë il nome del blog');
define('_LANG_INST_BASE_VALUE4','blogdescription Ë la descrizione del blog');
define('_LANG_INST_BASE_VALUE7','se vuoi che gli utenti siano abilitati a postare una volta registrati');
define('_LANG_INST_BASE_VALUE8','se vuoi permettere agli utenti di registarrsi al tuo blog');
define('_LANG_INST_BASE_VALUE54','La tua email (ovvio)');
// general blog setup
define('_LANG_INST_BASE_VALUE9','giorno di inizio della settimana');
define('_LANG_INST_BASE_VALUE11','usa BBCode, tipo [b]bold[/b]');
define('_LANG_INST_BASE_VALUE12','usa stile GreyMatter: **bold** \\\\italic\\\\ __underline__');
define('_LANG_INST_BASE_VALUE13','bottoni per tag HTML (non funzioneranno su IE Mac per ora)');
define('_LANG_INST_BASE_VALUE14','IMPORTANTE! setta falso se vuoi usare il Cinese, Giapponese, Coreano e altri lunguaggi similari a doppio byte');
define('_LANG_INST_BASE_VALUE15','questo settaggio ti aiuta a bilanciare il codice HTML. se hai errori setta falso');
define('_LANG_INST_BASE_VALUE16','setta questo ad 1 per abilitare la conversione delle faccine nei post (nota: questo convertir‡ le faccine in tutti i messaggi)');
define('_LANG_INST_BASE_VALUE17','la directory dove stanno le faccine (non mettere la barra finale)');
define('_LANG_INST_BASE_VALUE18','settalo a vero per richiedere email e nome o falso per consentire commenti senza email/nome');
define('_LANG_INST_BASE_VALUE20','settalo a vero per consentire la notifica agli autori dei commenti ai loro messaggi');
/* rss/rdf feeds */
define('_LANG_INST_BASE_VALUE21','numero di ultimi post da introdurre nei feed');
define('_LANG_INST_BASE_VALUE22','la lingua del tuo blog ( vedi qui: http://backend.userland.com/stories/storyReader$16 )');
define('_LANG_INST_BASE_VALUE23','per b2rss.php: consenti la codifica HTML nei tag di descrizione?');
define('_LANG_INST_BASE_VALUE24','lunghezza (in parole) dei feed relativi ai brani? 0=illimitata: b2rss.php, sar‡ comunque settato a 0 se usi la codifica HTML');
define('_LANG_INST_BASE_VALUE25','usa il campo brano per i feed rss.');
define('_LANG_INST_BASE_VALUE26','settalo a vero se vuoi che il tuo sito sia listato in http://weblogs.com quando aggiungi un nuovo messaggio');
define('_LANG_INST_BASE_VALUE27','settalo a vero se vuoi che il tuo sito sia listato su http://blo.gs quando aggiungi un nuovo post');
define('_LANG_INST_BASE_VALUE28','Non Dovresti aver bisogno di cambiare questo dato.');
define('_LANG_INST_BASE_VALUE29','settalo a 0 o 1, se vuoi permettere o meno per i messaggi il trackbacke: lo 0 significa disabilitare il trackbacks');
define('_LANG_INST_BASE_VALUE30','settalo a 0 o 1, se vuoi consentire il pingback  nei tuoi post o meno: lo 0 equivale a disabilitare il pingbacks');
define('_LANG_INST_BASE_VALUE31','settalo a falso per disabilitare il caricamento dei file, o a 1 per abilitarlo');
define('_LANG_INST_BASE_VALUE32','inserisci l indirizzo o la directory dove intendi caricare le immagini. La directory deve essere riscrivibile dal server (chmod 766)');
define('_LANG_INST_BASE_VALUE33','inserisci l indirizzo URL della directory (Ë usato per generare i link nel caricamento dei file)');
define('_LANG_INST_BASE_VALUE34','tipi di file accettati, separati da spazi. esempio: \'jpg gif png\'');
define('_LANG_INST_BASE_VALUE35','per default, molti server limitano la grandezza dei caricamenti a 2048 KB, qui puoi settare un valore pi˘ basso (non un valore pi˘ alto di quello settato dal server)');
define('_LANG_INST_BASE_VALUE36','puoi non volere che tutti gli utenti carichino le immagini, quindi puoi settare un livello minimo qui');
define('_LANG_INST_BASE_VALUE37','...oppure puoi autorizzare solo alcuni utenti. Inserisci i loro dati di login qui, separati da spazi. se lasci la variabile vuota tutti i tuoi utenti che hanno un livello minimo sono autorizzati al caricamento. esempio: \'barbara anne george\'');
/* email settings */
define('_LANG_INST_BASE_VALUE38','mailserver settings');
define('_LANG_INST_BASE_VALUE39','mailserver settings');
define('_LANG_INST_BASE_VALUE40','mailserver settings');
define('_LANG_INST_BASE_VALUE41','mailserver settings');
define('_LANG_INST_BASE_VALUE42','per default i messaggi avranno questa categoria');
define('_LANG_INST_BASE_VALUE43','prefisso soggetto');
define('_LANG_INST_BASE_VALUE44','stringa di terminazione del corpo (a partire dalla stringa sar‡ tutto ignorato)');
define('_LANG_INST_BASE_VALUE45','settala a vero per andare in test mode');
define('_LANG_INST_BASE_VALUE46','alcuni telefoni mobili spediranno identico soggetto e contenuto sulla stessa linea se lo usi come servizio, setta use_phoneemail a vero per indicare un separatore di stringa');
define('_LANG_INST_BASE_VALUE47','quando sar‡ composto il messaggio verr‡ spedito il soggetto, poi il separatore di stringa e poi i dati di login con la password, quindi il separatore, e il contenuto');
define('_LANG_INST_BASE_VALUE48','Quanti messaggi/giorni mostrare nella pagina di indice.');
define('_LANG_INST_BASE_VALUE49','Messaggi, giorni, o messaggi impaginati');
define('_LANG_INST_BASE_VALUE50','Quali unit‡ usare negli archivi.');
define('_LANG_INST_BASE_VALUE51','se non hai una zona temporale di riferimento orario sul tuo server');
define('_LANG_INST_BASE_VALUE52','vedi note sui formati caratteri');
define('_LANG_INST_BASE_VALUE53','vedi note sui formati caratteri');
/* 'pages' of options */
define('_LANG_INST_BASE_HELP1','Messaggi per pagina etc. Opzioni pagine originali');
define('_LANG_INST_BASE_HELP2','Cose che probabilmennte vuoi controllare');
define('_LANG_INST_BASE_HELP3','Configurazione dei Feed RSS/RDF, Track/ping-backs');
define('_LANG_INST_BASE_HELP4','Configurazione del caricamento file');
define('_LANG_INST_BASE_HELP5','Configurazione dell Invio del Blog via email');
define('_LANG_INST_BASE_HELP6','Configurazione Base richiesta per il funzionamento del Blog');
define('_LANG_INST_BASE_HELP7','Configurazione di Default per i nuovi messaggi');
define('_LANG_INST_BASE_HELP8','Vari settaggi per amministrare i link');
define('_LANG_INST_BASE_HELP9','Configura i controlli per i messaggi e visualizza le Opzioni Geografiche');
define('_LANG_INST_BASE_VALUE55','Stato di Default per ciascun nuovo messaggio');
define('_LANG_INST_BASE_VALUE56','Stato di Default per i commenti di ciascun nuovo messaggio');
define('_LANG_INST_BASE_VALUE57','Stato di Default per i Ping di ciascun nuovo messaggio');
define('_LANG_INST_BASE_VALUE58','Se l indirizzo di PingBack dovrebbe essere aggiunto di default');
define('_LANG_INST_BASE_VALUE59','La Categoria di Default per ciascun nuovo post');
define('_LANG_INST_BASE_VALUE83','Il Numero di righe nell editazione dei messaggi (da 3 a 100)');
define('_LANG_INST_BASE_VALUE60','Il livello minimo di amministrazione per editare link');
define('_LANG_INST_BASE_VALUE61','setta questo come falso per avere tutti i link editabili in ciascuno dei link manager');
define('_LANG_INST_BASE_VALUE62','Setta il tipo di votazione sondaggio che intendi usare');
define('_LANG_INST_BASE_VALUE63','Se hai settato \'char\' quali caratteri intendi usare.');
define('_LANG_INST_BASE_VALUE64','Come deve essere gestito lo zero? Settare vero come output di niente, oppure apparir‡ come normale (numero/immagine)');
define('_LANG_INST_BASE_VALUE65','Usa la stessa immagine per ciascuna votazione ? (Usa links_rating_image[0])');
define('_LANG_INST_BASE_VALUE66','Immagine per votazione 0 (e per singole immagini)');
define('_LANG_INST_BASE_VALUE67','Immagine per votazione 1');
define('_LANG_INST_BASE_VALUE68','Immagine per votazione 2');
define('_LANG_INST_BASE_VALUE69','Immagine per votazione 3');
define('_LANG_INST_BASE_VALUE70','Immagine per votazione 4');
define('_LANG_INST_BASE_VALUE71','Immagine per votazione 5');
define('_LANG_INST_BASE_VALUE72','Immagine per votazione 6');
define('_LANG_INST_BASE_VALUE73','Immagine per votazione 7');
define('_LANG_INST_BASE_VALUE74','Immagine per votazione 8');
define('_LANG_INST_BASE_VALUE75','Immagine per votazione 9');
define('_LANG_INST_BASE_VALUE76','path/to/cachefile, deve essere riscrivibile dal server');
define('_LANG_INST_BASE_VALUE77','Quale file prendere da weblogs.com');
define('_LANG_INST_BASE_VALUE78','Tempo di Cache in minuti (prima di rinnovare il dato)');
define('_LANG_INST_BASE_VALUE79','Il formato data per il caricamento del tooltip');
define('_LANG_INST_BASE_VALUE80','Il testo da inserire per un link aggiornato di recente');
define('_LANG_INST_BASE_VALUE81','Il testo da inserire per un link aggiornato di recente');
define('_LANG_INST_BASE_VALUE82','Il tempo in minuti da considerare per i link aggiornati');
define('_LANG_INST_BASE_VALUE84','Attiva l opzione Indirizzi Geografici di  WordPress');
define('_LANG_INST_BASE_VALUE85','Abilita posizionamento di default GeoURL ICBM quando non Ë specificato altro');
define('_LANG_INST_BASE_VALUE86','Latitudine di Default di valore ICBM - <a href="http://www.geourl.org/resources.html" target="_blank">vedi qui</a>');
define('_LANG_INST_BASE_VALUE87','Latitudine di Default di valore ICBM');
/* Last Question */
define('_LANG_INST_STEP2_LAST','OK. Quasi fatto. Abbiamo solo bisogno di chiederti un paio di cose:');
define('_LANG_INST_STEP2_URL','Utente settato con successo!');
define('_LANG_INST_STEP3_SET','<p>Ora puoi entrare <a href="../wp-login.php"> </a> con <strong>login</strong> "admin" and <strong>password</strong> "');
define('_LANG_INST_STEP3_UP','".</p><p><strong><em>Nota che la password</em></strong> attento! Si tratta di una password generata solo per te. Se la perdi dovrai cancellare le tabelle dal database, e reistallare WordPress.</p>');
define('_LANG_INST_STEP3_DONE','Ti aspetti altro lavoro ? No ! Tutto fatto!');
define('_LANG_INST_CAUTIONS','<ul><li>Directory : [755]</li><li>wp-config.php : [604Å`644]</li></ul>');

/* Start Upgrade ************************************************/
/* File Name wp-admin/upgrade.php */
define('_LANG_UPG_STEP_INFO','Sembra manchi il file wp-config.php. Clicca 2 volte per aggiornare wp-config.sample.php con la esatta connessione al database e rinominala in wp-config.php.');
define('_LANG_UPG_STEP_INFO2','<p>Questo file aggiorna da una versione precedente di WordPress alla successiva. L operazione puÚ prendere un certo tempo. </p><p>Se tutto va bene, <a href="upgrade.php?step=1">Vai</a>! </p>');
define('_LANG_UPG_STEP_INFO3','<p>Se vedi questo messaggio il passaggio Ë terminato. <a href="../"> </a>! </p>');

/* File Name wp-admin/upgrade-functions.php */
define('_LANG_INST_BASE_VALUE88','Se abilitato, i commenti saranno mostrati solo dopo essere stati approvati.');
define('_LANG_INST_BASE_VALUE89','Setta questo dato come vero se vuoi ti siano notificati i commenti che necessitano approvazione');
define('_LANG_INST_BASE_VALUE90','Come sono costruiti i permalinks per il tuo sito. Vedi la pagina di opzione permalink <a href=\"options-permalink.php\"> </a> per le necessarie regole mod_rewrite e per maggiori informazioni.');
define('_LANG_INST_BASE_VALUE91','A seconda che desideri la pubblicazione gzippata o meno. Abilita o meno questo dato.');
define('_LANG_INST_BASE_VALUE92','Settalo questo dato a vero se pensi di usare un file di hack. Questo Ë il luogo per salvare il codice di hack che desideri sovrascrivere con l aggiornamento. Il file deve essere in root e si deve chiamare  <code>my-hacks.php</code>');
define('_LANG_INST_BASE_VALUE93','blog_charset');
define('_LANG_INST_BASE_VALUE94','La differenza di orario tra il GMT e la tua zona temporale');
define('_LANG_INST_BASE_VALUE95','Check if Trackback sending site contains my URL');

/* File Name wp-admin/plugins.php */
define('_LANG_PG_LEAST_LEVEL','Spiacente, devi avere almeno un livello utente 8 per modificare il plugin.');
define('_LANG_PG_ACTIVATED_OK','Plugin <strong>attivato</strong>');
define('_LANG_PG_DEACTIVATED_OK','Plugin <strong>disattivato</strong>');
define('_LANG_PG_PAGE_TITLE','Amministrazione PlugIn');
define('_LANG_PG_NEED_PUT','I Plugin sono file usualmente scaricabili separatamente da WordPress che aggiungono funzionalit‡. Per installare un plugin necessiti di mettere il file nella directory <code>wp-content/plugins</code>. Una volta installati, puoi attivarli o disattivarli direttamente qui.');
define('_LANG_PG_OPEN_ERROR','La directory di Plugin non puÚ essere aperta o non ci sono plugin disponibili.');
define('_LANG_PG_SUB_PLUGIN','Plugin');
define('_LANG_PG_SUB_VERSION','Versione');
define('_LANG_PG_SUB_AUTHOR','Autore');
define('_LANG_PG_SUB_DESCR','Descrizione');
define('_LANG_PG_SUB_ACTION','Azione');
define('_LANG_PG_SUB_DEACTIVATE','Disattivare');
define('_LANG_PG_SUB_ACTIVATE','Attivare');
define('_LANG_PG_GOOGLE_HILITE','Quando qualcuno Ë riferito da un motore di ricerca come Google, Yahoo, o lo stesso di WordPress il termine cercato sar‡ sottolineato con questo plugin. Fornito da <a href="http://photomatt.net/">Matt</a>.');
define('_LANG_PG_MARK_DOWN','Markdown Ë un sistema di conversione testo a codice html per webmaster. <a href="http://daringfireball.net/projects/markdown/syntax">La sintassi Markdown </a> ti permette di scrivere usando un sistema facile da leggere, facile da scrivere in formato testo, per poi convertirlo in una forma XHTML. Questo plugin abilita <strong>Markdown per i tuoi messaggi e commenti</strong>. Scritto da <a href="http://daringfireball.net/">John Gruber</a> in Perl, tradotto in PHP da <a href="http://www.michelf.com/">Michel Fortin</a>, e portato a plugin da <a href="http://photomatt.net/">Matt</a>. Se lo usi dovrebbero  essere disabilitati Textile 1 and 2 per evitare conflitti di sintassi.');
define('_LANG_PG_TEXTILE_2','Questo Ë un semplice wrapper per <a href="http://textism.com/?wp">Dean Allen\'s</a> Generatore di testo web umano anche conosciuto come <a href="http://www.textism.com/tools/textile/">Textile</a>.  La Version 2 aggiunge nuove funzionalit‡ che la rendono quasi un meta linguaggio  HTML. In compenso Ë pi˘ lento. Se usi questo plugin dovresti disabilitare Textile 1 and Markdown, perchË non funzionano correttamente insieme.');
define('_LANG_PG_HELLO_DOLLY','Questo non Ë un plugin, ma simbolizza la speranza e l entusiasmo di un intera generazione. Ciao, Dolly. Questo Ë il primo plugin ufficiale per WordPress. Una volta abilitato ti consentir‡ di vedere una lirica da <cite>Ciao, Dolly</cite> nella parte alta a destra dello schermo di admin.');
define('_LANG_PG_TEXTILE_1','Questo Ë un semplice wrapper per <a href="http://textism.com/?wp">Dean Allen\'s</a> Generatore di Testo Web Umano, anche conosciuto come <a href="http://www.textism.com/tools/textile/">Textile</a>. Se usi questo plugin dovresti disabilitare Textile 2 e Markdown, perchË non funzionano bene insieme.');

/* File Name nkarchives.php */
define('_LANG_NKA_ARCHIVE', 'Sort By');
define('_LANG_NKA_ALL_YEAR', 'All Years');
define('_LANG_NKA_ALL_AUTHOR', 'All Authors');
define('_LANG_NKA_ORDER_DATE', 'Date');
define('_LANG_NKA_ORDER_TITLE', 'Title');
define('_LANG_NKA_ORDER_CATEGORY', 'Category');
define('_LANG_NKA_ORDER_AUTHOR', 'Author');
define('_LANG_NKA_SORT_ASC', 'ASC');
define('_LANG_NKA_SORT_DSC', 'DESC');
define('_LANG_NKA_ACTION_SORT', 'Sort');
define('_LANG_NKA_YEAR_SUFFIX', '');
define('_LANG_NKA_EXCEEDS_COUNT', 'Number of results exceeds limit count(=%d).');
}
?>