<?php
global $blog_charset;
$blog_charset = 'euc-jp';

if (!defined('WP_LANGUAGE_FILE_READ')) {
define ('WP_LANGUAGE_FILE_READ','1');
/* This is Multilingual correspondence file */
/* 美乳 */

/* Copylight 2004 -----------------------
Author : Otsukare
URL : http://wordpress.xwd.jp/
-------------------------------------- */

/* File Name wp-settings.php */
define('_LANG_WA_SETTING_GUIDE','<p>WordPress ME はまだインストールされていません<br /><a href="wp-admin/install.php">こちらをクリック</a>してインストールを実行してください。</p>');

/* File Name wp-blog-header.php */
define('_LANG_WA_HEADER_GUIDE1','<p>サーバー上に <b>wp-config.php</b> ファイルが存在しません<br />WordPress ME のインストールにはこのファイルが必要です。<br /><br />こちらの<a href="wp-admin/install-config.php">ウィザード</a>を利用してサーバー上で <b>wp-config.php</b> ファイルを作成することができますが、この方法はすべての環境での動作を保障することができませんのでご了承下さい。<br /><br />ウィザードを実行する際は対象ディレクトリに書き込み権限を与える必要があります(707〜777) 前もってパーミッションを変更しておいてください。<br /><br />サーバー環境によりウィザードが実行できない場合は <b>wp-config-sample.php</b> を参考にローカルで <b>wp-config.php</b> を作成してサーバーにアップロードしてください。</p>');

/* File Name wp-admin/install-config.php */
define('_LANG_WA_CONFIG_GUIDE1','<p>ファイル「<b>wp-config.php</b>」は既に存在します。このファイル中の情報のうちのどれかをリセットする必要がある場合は、まずこのファイルをサーバー上から削除してください。</p>');
define('_LANG_WA_CONFIG_GUIDE2','<p>このウィザードでは <b>wp-config-sample.php</b>ファイルを必要とします。このファイルがサーバーにアップロードされているか再度確認してください。<p>');
define('_LANG_WA_CONFIG_GUIDE3','<p>対象ディレクトリに書き込み権限を与えてください。WordPress ディレクトリのパーミッションを変更出来ない場合は、wp-config-sample.php を参考に手動で <b>wp-config.php</b> を作成してください。</p>');
define('_LANG_WA_CONFIG_GUIDE4','WordPress ME へようこそ。<br />セッティングにはデータベースについての情報が必要です。<br />プロセスの進行の前にこれらの情報を準備してください。');
define('_LANG_WA_CONFIG_DATABASE','データベース名');
define('_LANG_WA_CONFIG_USERNAME','ユーザー名');
define('_LANG_WA_CONFIG_PASSWORD','パスワード');
define('_LANG_WA_CONFIG_LOCALHOST','ホスト名 (localhost)');
define('_LANG_WA_CONFIG_PREFIX','テーブル接頭語');
define('_LANG_WA_CONFIG_GUIDE5','何らかの理由でこのウィザードが機能しない場合でも心配要りません。データベース設定のすべては別ファイルにて行うことが出来ます。 <b>wp-config-sample.php</b> をテキストエディタで開き、必要情報を記述したうえで <b>wp-config.php</b> として保存後サーバーへアップロードしてください。</p><p>あなたのデータベース情報が不明な場合は、このウィザードを進める前にレンタルサーバー(ホスティング)サービスに問い合わせてください。すべて準備ができている場合は<a href="install-config.php?step=1">こちらをクリック</a>してください。');
define('_LANG_WA_CONFIG_GUIDE6','以下のフォームに、あなたのデータベース接続詳細を入力してください。不明な場合はレンタルサーバー(ホスティング)サービスにお問い合わせ下さい。');
define('_LANG_WA_CONFIG_GUIDE7','<small>WordPress ME の情報を格納するためのデータベース名</small>');
define('_LANG_WA_CONFIG_GUIDE8','<small>MySQL ユーザー名</small>');
define('_LANG_WA_CONFIG_GUIDE9','<small>MySQL パスワード</small>');
define('_LANG_WA_CONFIG_GUIDE10','<small>99% localhost のまま変更する必要はありません</small>');
define('_LANG_WA_CONFIG_GUIDE11','<small>複数の WordPress ME をインストールする場合は個々に変更してください</small>');
define('_LANG_WA_CONFIG_GUIDE12','<b>準備完了 !</b><br />インストールに必要な情報が揃いました。<br />これで WordPress ME はデータベースに接続することができます。準備ができている場合は早速<a href="install.php">インストール</a>を実行してください。');


/* File Name wp-include/wp-db.php */
define('_LANG_WA_WPDB_GUIDE1','<b>データベースに接続できません。</b><br />これは、あなたの入力情報が正しくないことを意味します。<br />これらを確認して再度接続を試みてください。');
define('_LANG_WA_WPDB_GUIDE2','ユーザー名、パスワードを正確に記入しましたか ?');
define('_LANG_WA_WPDB_GUIDE3','ホスト名を正確に記入しましたか ?');
define('_LANG_WA_WPDB_GUIDE4','データベースは作成済ですか ?');


/* File Name wp-include/functions.php */
define('_LANG_F_TIMESTAMP','タイムスタンプの修正');
define('_LANG_F_NEW_COMMENT','新しいコメントが付いています');
define('_LANG_F_ALL_COMMENTS','こちらでコメントの内容をすべて見ることが出来ます:');
define('_LANG_F_NEW_TRACKBACK','新しいトラックバックが投稿されています');
define('_LANG_F_ALL_TRACKBACKS','こちらでトラックバックの内容をすべて見ることが出来ます:');
define('_LANG_F_NEW_PINGBACK','新しいピンバックがあります');
define('_LANG_F_ALL_PINGBACKS','こちらでピンバックの内容をすべて見ることが出来ます:');
define('_LANG_F_COMMENT_POST','新しいコメントが付いています');
define('_LANG_F_WAITING_APPROVAL','は、現在承認待ちです');
define('_LANG_F_APPROVAL_VISIT','コメントの承認はこちらへ:');
define('_LANG_F_DELETE_VISIT','コメントの削除はこちらへ:');
define('_LANG_F_PLEASE_VISIT','件のコメントが承認待ちです。 モデレーションパネルにてご確認下さい:');

/* File Name wp-register.php */
define('_LANG_R_ENTER_LOGIN','<strong>ERROR</strong>: 希望ログイン名を入力してください');
define('_LANG_R_PASS_TWICE','<strong>ERROR</strong>: 2ヶ所ともパスワードを入力してください');
define('_LANG_R_SAME_PASS','<strong>ERROR</strong>: 確認用パスワードには同じものを入力してください');
define('_LANG_R_MAIL_ADDRESS','<strong>ERROR</strong>: メールアドレスを入力してください');
define('_LANG_R_ADDRESS_CORRECT','<strong>ERROR</strong>: メールアドレスの記述が不正です');
define('_LANG_R_CHOOSE_ANOTHER','<strong>ERROR</strong>: このログイン名は既に使用されています　別のものをご指定ください');
define('_LANG_R_REGISTER_CONTACT','<strong>ERROR</strong>: 都合により、あなたのメンバー登録は許可できません　詳しくは、管理人</a>迄お問い合わせください');
define('_LANG_R_USER_REGISTRATION','新しいユーザーが登録されました');
define('_LANG_R_MAIL_REGISTRATION','新規登録通知');
define('_LANG_R_R_COMPLETE','メンバー登録完了');
define('_LANG_R_R_DISABLED','メンバー登録停止中');
define('_LANG_R_R_CLOSED','メンバー登録は現在許可されていません');
define('_LANG_R_R_REGISTRATION','メンバー登録を行います');
define('_LANG_R_USER_LOGIN','ログイン名:');
define('_LANG_R_USER_PASSWORD','パスワード:');
define('_LANG_R_TWICE_PASSWORD','パスワード再入力:');
define('_LANG_R_USER_EMAIL','E-mail:');

/* File Name wp-login.php */
define('_LANG_L_LOGIN_EMPTY','ログイン名を入力してください');
define('_LANG_L_PASS_EMPTY','パスワードを入力してください');
define('_LANG_L_WRONG_LOGPASS','ログイン名かパスワードが違います');
define('_LANG_L_RECEIVE_PASSWORD','ログイン名を入力してOKをクリックしてください。 パスワードをデータベースに登録されているE-mail宛てに送信します。');
define('_LANG_L_EXIST_SORRY','入力されたログイン名は当サイトのデータベースに存在しません。 間違っていませんか ?');
define('_LANG_L_YOUR_LOGPASS','WordPressログインパスワード');
define('_LANG_L_NOT_SENT','メールが送信できませんでした');
define('_LANG_L_DISABLED_FUNC','エラーの原因: 恐らくご利用のサーバーで mail()関数がサポートされていないのだと思います。');

define('_LANG_L_SUCCESS_SEND','さん宛てのメールの送信は正常に行われました');
define('_LANG_L_CLICK_ENTER','こちらからログインしてください');
define('_LANG_L_WRONG_SESSION','Error: ログイン名かパスワードが違います');
define('_LANG_L_BACK_BLOG','トップへ戻る ?');
define('_LANG_L_WP_RESIST','メンバー登録 ?');
define('_LANG_L_WPLOST_YOURPASS','パスワード紛失 ?');

/* File Name wp-admin/post.php */
define('_LANG_P_NEWCOMER_MESS','新規登録してから間もないので、管理者があなたのレベルを上げて投稿を許可するまで待たなければなりません。　直ぐにレベルを上げてもらいたい場合は、管理者に直接メールをすることができます。　昇進した場合、このページをリロードするだけでレベルが有効になります。');
define('_LANG_P_DATARIGHT_EDIT','さんの投稿を編集することは出来ません。');
define('_LANG_P_DATARIGHT_DELETE','さんの投稿を削除する権限がありません。');
define('_LANG_P_DATARIGHT_ERROR','削除に失敗しました . . . 管理人に連絡してください。');
define('_LANG_P_OOPS_IDCOM','このIDによるコメントはありません');
define('_LANG_P_OOPS_IDPOS','このIDによる投稿はありません');
define('_LANG_P_ABOUT_FOLLOW','次のコメントを削除しようとしています:');
define('_LANG_P_SURE_THAT','実行しますが宜しいですか ?');
define('_LANG_P_NICKNAME_DELETE','さんの投稿を削除することは出来ません。');
define('_LANG_P_COMHAS_APPR','コメントが承認されました');
define('_LANG_P_YOUR_DRAFTS','草稿:');
define('_LANG_P_WP_BOOKMARKLET','「Press it」 をクリックすると、現在閲覧中であるサイトのリンク情報を備えたポップアップウィンドウが開きます。<br />これにより迅速な投稿が可能になります。');

/* File Name wp-admin/categories.php */
define('_LANG_C_DEFAULT_CAT','カテゴリーを削除することは出来ません　これはデフォルトセットです。');
define('_LANG_C_EDIT_TITLECAT','Edit Category');
define('_LANG_C_NAME_SUBCAT','カテゴリー名:');
define('_LANG_C_NAME_SUBDESC','付記:');
define('_LANG_C_RIGHT_EDITCAT','あなたにはカテゴリーを編集する権限がありません。<br />詳しくは管理人迄お問い合わせください。');
define('_LANG_C_NAME_CURRCAT','Current Categories');
define('_LANG_C_NAME_CATNAME','カテゴリー名');
define('_LANG_C_NAME_CATDESC','説明');
define('_LANG_C_NAME_CATPOSTS','# 投稿数');
define('_LANG_C_NAME_CATACTION','アクション');
define('_LANG_C_ADD_NEWCAT','Add New Category');
define('_LANG_C_NOTE_CATEGORY','カテゴリーを削除しても、そのカテゴリーの投稿自体は削除しません。<br />デフォルトカテゴリーに移動します');
define('_LANG_C_NAME_EDIT','編集');
define('_LANG_C_NAME_DELETE','削除');
define('_LANG_C_NAME_ADD','このカテゴリーを追加する');
define('_LANG_C_NAME_ADDBTN','カテゴリーを追加する &raquo;');
define('_LANG_C_NAME_EDITBTN','カテゴリーを編集する &raquo;');
define('_LANG_C_NAME_PARENT','親カテゴリー選択');
define('_LANG_C_MESS_ADD','カテゴリーが追加されました');
define('_LANG_C_MESS_DELE','カテゴリーが削除されました');
define('_LANG_C_MESS_UP','カテゴリーが更新されました');

/* File Name wp-admin/edit.php */
define('_LANG_E_LATEST_POSTS','投稿');
define('_LANG_E_LATEST_COMMENTS','コメント');
define('_LANG_E_AWAIT_MODER','承認待ちコメント');
define('_LANG_E_SHOW_POSTS','投稿の検索:');
define('_LANG_E_TITLE_COMMENTS','コメント');
define('_LANG_E_FILL_REQUIRED','Error: お名前とコメントを入力してください');
define('_LANG_E_TITLE_LEAVECOM','コメントの投稿');
define('_LANG_E_RESULTS_FOUND','検索結果 : 該当無し');

/* File Name wp-admin/edit-comments.php */
define('_LANG_EC_SHOW_COM','コメントの検索:');
define('_LANG_EC_EDIT_COM','コメントの編集');
define('_LANG_EC_DELETE_COM','コメントの削除');
define('_LANG_EC_EDIT_POST','投稿の編集 &#8220;');
define('_LANG_EC_VIEW_POST','投稿の表示');
define('_LANG_EC_SEARCH_MODE','コメント内容、メールアドレス、URL、IPアドレス等を入力しての検索');
define('_LANG_EC_VIEW_MODE','標準モード');
define('_LANG_EC_EDIT_MODE','マルチ編集モード');
define('_LANG_EC_CHECK_INVERT','チェックボックスの反転');
define('_LANG_EC_CHECK_DELETE','チェックしたコメントを削除');
define('_LANG_EC_LINK_VIEW','表示');
define('_LANG_EC_LINK_EDIT','編集');
define('_LANG_EC_LINK_DELETE','削除');

/* File Name wp-admin/edit-form.php */
define('_LANG_EF_PING_FORM','<label for="pingback"><a href="http://wordpress.xwd.jp/wiki/index.php?Reference%20Post%2FEdit#pingback" title="Help on Pingbacks"><strong>PingBack</strong> the <acronym title="Uniform Resource Locators">URL</acronym></a> この投稿のピンを飛ばす</label><br />');
define('_LANG_EF_TRACK_FORM','<p><label for="trackback"><a href="http://wordpress.xwd.jp/wiki/index.php?Reference%20Post%2FEdit#trackback" title="Help on trackbacks"><strong>TrackBack</strong> an <acronym title="Uniform Resource Locator">URL</acronym></a>:</label> (複数のURLがある場合は半角スペースで区切ってください)<br />');
define('_LANG_EF_AD_POSTTITLE','タイトル');
define('_LANG_EF_AD_CATETITLE','カテゴリー');
define('_LANG_EF_AD_POSTAREA','投稿内容');
define('_LANG_EF_AD_POSTQUICK','クイックタグ');
define('_LANG_EF_AD_DRAFT','一時保存');
define('_LANG_EF_AD_PRIVATE','プライベート');
define('_LANG_EF_AD_PUBLISH','書き出し');
define('_LANG_EF_AD_EDITING','高度な編集 &raquo;');

/* File Name wp-admin/edit-form-advanced.php */
define('_LANG_EFA_POST_STATUS','投稿ステータス');
define('_LANG_EFA_AD_COMMENTS','コメント設定');
define('_LANG_EFA_AD_PINGS','ピンの設定');
define('_LANG_EFA_POST_PASSWORD','パスワード');
define('_LANG_EFA_POST_EXCERPT','抜粋');
define('_LANG_EFA_POST_LATITUDE','緯度:');
define('_LANG_EFA_POST_LONGITUDE','経度:');
define('_LANG_EFA_POST_GEOINFO','ジオ・インフォメーション');
define('_LANG_EFA_DEL_THISPOST','この投稿を削除する');
define('_LANG_EFA_SAVE_CONTINUE','保存して編集を続ける');
define('_LANG_EFA_STATUS_OPEN','オープン');
define('_LANG_EFA_STATUS_CLOSE','クローズ');
define('_LANG_EFA_STATUS_UPLOAD','ファイルアップロード');
define('_LANG_EFA_STATUS_DISCUSS','コメントステータス');
define('_LANG_EFA_STATUS_ALLOWC','コメントを承認');
define('_LANG_EFA_STATUS_ALLOWP','ピンを許可');
define('_LANG_EFA_STATUS_SLUG','対象ポスト');
define('_LANG_EFA_STATUS_POST','投稿内容');

/* File Name wp-admin/edit-form-comment.php */
define('_LANG_EFC_BUTTON_TEXT','編集の実行');
define('_LANG_EFC_COM_NAME','投稿者名:');
define('_LANG_EFC_COM_MAIL','メールアドレス:');
define('_LANG_EFC_COM_URI','ホームページ:');
define('_LANG_EFC_COM_COMMENT','コメント内容:');

/* File Name wp-admin/link-add.php */
define('_LANG_WLA_MANAGE_LINK','リンクマネージメント');
define('_LANG_WLA_ADD_LINK','リンクの追加');
define('_LANG_WLA_LINK_CATE','リンクカテゴリー');
define('_LANG_WLA_IMPORT_BLOG','ブロッグロールインポート');
define('_LANG_WLA_LINK_TITLE','<strong>Add Link:</strong>');
define('_LANG_WLA_SUB_URI','URL:');
define('_LANG_WLA_SUB_NAME','サイト名:');
define('_LANG_WLA_SUB_IMAGE','イメージ');
define('_LANG_WLA_SUB_RSS','RSS URL: ');
define('_LANG_WLA_SUB_DESC','説明');
define('_LANG_WLA_SUB_REL','REL:');
define('_LANG_WLA_SUB_XFN','XFN');
define('_LANG_WLA_SUB_NOTE','覚書:');
define('_LANG_WLA_SUB_RATE','評価:');
define('_LANG_WLA_SUB_TARGET','ターゲット');
define('_LANG_WLA_SUB_VISIBLE','表示:');
define('_LANG_WLA_SUB_CAT','カテゴリー:');
define('_LANG_WLA_SUB_FRIEND','フレンドシップ');
define('_LANG_WLA_SUB_PHYSICAL','フィジカル');
define('_LANG_WLA_SUB_PROFESSIONAL','プロフェッショナル');
define('_LANG_WLA_SUB_GEOGRAPH','ジオグラフィカル');
define('_LANG_WLA_SUB_FAMILY','ファミリー');
define('_LANG_WLA_SUB_ROMANTIC','ロマンティック');
define('_LANG_WLA_CHECK_ACQUA','知人');
define('_LANG_WLA_CHECK_FRIE','友人');
define('_LANG_WLA_CHECK_NONE','無し');
define('_LANG_WLA_CHECK_MET','相互 ?');
define('_LANG_WLA_CHECK_WORKER','同僚');
define('_LANG_WLA_CHECK_COLL','専門職');
define('_LANG_WLA_CHECK_RESI','同居人');
define('_LANG_WLA_CHECK_NEIG','隣人');
define('_LANG_WLA_CHECK_CHILD','子供');
define('_LANG_WLA_CHECK_PARENT','親');
define('_LANG_WLA_CHECK_SIBLING','兄弟');
define('_LANG_WLA_CHECK_SPOUSE','配偶者');
define('_LANG_WLA_CHECK_MUSE','片思い');
define('_LANG_WLA_CHECK_CRUSH','失恋');
define('_LANG_WLA_CHECK_DATE','進行中');
define('_LANG_WLA_CHECK_HEART','恋人');
define('_LANG_WLA_CHECK_ZERO','0は評価の対象になりません');
define('_LANG_WLA_CHECK_STRICT','ターゲット属性は、「XHTML 1.1」「1.0 Strict」では文法エラーとなります');
define('_LANG_WLA_TEXT_TOOLBAR','MozillaとNetscapeでは作成したリンクをツールバーにドラッグすることが出来ます<br />ポップアップウィンドウを利用したこの機能は現在試験中です。');
define('_LANG_WLA_BUTTON_TEXTNAME','このリンクを追加する');

/* File Name wp-admin/link-categories.php */
define('_LANG_WLC_DONOT_DELETE','Can&#8217;t delete the link category. this is the default one');
define('_LANG_WLC_TITLE_TEXT','Edit Link Category &#8220;');
define('_LANG_WLC_EPAGE_TITLE','<strong>Edit</strong> a link category:');
define('_LANG_WLC_ADD_TITLE','Add a Link Category:');
define('_LANG_WLC_SUBEDIT_NAME','カテゴリー名:');
define('_LANG_WLC_SUBEDIT_TOGGLE','自動固定?');
define('_LANG_WLC_SUBEDIT_SHOW','表示スタイル:');
define('_LANG_WLC_SUBEDIT_ORDER','ソート順:');
define('_LANG_WLC_SUBEDIT_IMAGES','イメージ');
define('_LANG_WLC_SUBEDIT_DESC','説明');
define('_LANG_WLC_SUBEDIT_RATE','評価');
define('_LANG_WLC_SUBEDIT_UPDATE','更新');
define('_LANG_WLC_SUBEDIT_SORT','ソート順:');
define('_LANG_WLC_SUBEDIT_DESCEND','降順?');
define('_LANG_WLC_SUBEDIT_BEFORE','開始タグ:');
define('_LANG_WLC_SUBEDIT_BETWEEN','中間タグ:');
define('_LANG_WLC_SUBEDIT_AFTER','終了タグ:');
define('_LANG_WLC_SUBEDIT_LIMIT','リミット:');
define('_LANG_WLC_ADDBUTTON_TEXT','カテゴリーを追加する');
define('_LANG_WLC_SAVEBUTTON_TEXT','保存');
define('_LANG_WLC_CANCELBUTTON_TEXT','取り消し');
define('_LANG_WLC_SUBCATE_NAME','カテゴリー名');
define('_LANG_WLC_SUBCATE_ATT','自動固定?');
define('_LANG_WLC_SUBCATE_SHOW','表示方法');
define('_LANG_WLC_SUBCATE_SORT','ソート順');
define('_LANG_WLC_SUBCATE_DESC','降順?');
define('_LANG_WLC_SUBCATE_LIMIT','リミット');
define('_LANG_WLC_SUBCATE_IMAGES','イメージ?');
define('_LANG_WLC_SUBCATE_MINIDESC','降順?');
define('_LANG_WLC_SUBCATE_RATE','評価?');
define('_LANG_WLC_SUBCATE_UPDATE','更新?');
define('_LANG_WLC_SUBCATE_BEFORE','前タグ');
define('_LANG_WLC_SUBCATE_BETWEEN','中間タグ');
define('_LANG_WLC_SUBCATE_AFTER','閉タグ');
define('_LANG_WLC_SUBCATE_EDIT','編集');
define('_LANG_WLC_SUBCATE_DELETE','削除');
define('_LANG_WLC_SUBEDIT_EMPTY','幾つのリンクを表示するか : 空にすると無制限');
define('_LANG_WLC_EPAGE_EMPTY','空にすると無制限');
define('_LANG_WLC_EPAGE_NOTE','カテゴリーだけを削除しても、そのカテゴリーに登録しているリンク自体は削除されません。<br />デフォルトカテゴリーに再セットされます。  :');
define('_LANG_WLC_RIGHT_PROM','あなたにはリンクカテゴリーを編集する権限がありません<br />詳しくは管理人迄お問い合わせください');

/* File Name wp-admin/link-import.php */
define('_LANG_WLI_ROLL_TITLE','Import Blogroll');
define('_LANG_WLI_ROLL_DESC','Import your blogroll from another system ');
define('_LANG_WLI_ROLL_OPMLCODE','でサインイン後、Get CodeをクリックしてOPMLCodeを取得してください。');
define('_LANG_WLI_ROLL_OPMLLINK','でサインイン後、右側のWelcome Back BoxにあるshareをクリックしてOPMLCodeを取得してください。(favorites.opml)');
define('_LANG_WLI_ROLL_BELOW','それをコピーしてここに入力してください');
define('_LANG_WLI_ROLL_YOURURL','Your OPML URL:');
define('_LANG_WLI_ROLL_UPLOAD','デスクトップ上のOPML fileをアップロードして利用することも可能です');
define('_LANG_WLI_ROLL_THISFILE','アップロード対象ファイル: ');
define('_LANG_WLI_ROLL_CATEGORY','それらのリンクを入れたいカテゴリーを選択してください。<br />カテゴリー: ');
define('_LANG_WLI_ROLL_BUTTONTEXT','インポート !');

/* File Name wp-admin/link-manager.php */
define('_LANG_WLM_PAGE_TITLE','Manage Links');
define('_LANG_WLM_LEVEL_ERROR','あなたにはリンクを編集する権限がありません。<br />詳しくは管理人迄お問い合わせください。');
define('_LANG_WLM_SHOW_LINKS','カテゴリー内リンクの検索:');
define('_LANG_WLM_ORDER_BY','オーダーの選択:');
define('_LANG_WLM_SHOW_BUTTONTEXT','検索');
define('_LANG_WLM_SHOW_ACTIONTEXT','アクション');
define('_LANG_WLM_MULTI_LINK','Manage Multiple Links:');
define('_LANG_WLM_CHECK_CHOOSE','右のチェックボックスをまとめて選択し作業することが出来ます');
define('_LANG_WLM_ASSIGN_TEXT','割り当てる');
define('_LANG_WLM_OWNER_SHIP','権限');
define('_LANG_WLM_TOGGLE_TEXT','固定');
define('_LANG_WLM_VISIVILITY_TEXT','表示状態');
define('_LANG_WLM_MOVE_TEXT','移動');
define('_LANG_WLM_TO_CATEGORY',' 選択カテゴリーへ');
define('_LANG_WLM_TOGGLE_BOXES','選択/解除');
define('_LANG_WLM_EDIT_LINK','Edit a link:');
define('_LANG_WLM_SAVE_CHANGES','変更の保存');
define('_LANG_WLM_EDIT_CANCEL','キャンセル');

/* File Name wp-admin/moderation.php */
define('_LANG_WPM_USER_LEVEL','あなたにはコメントを承認する権限がありません。<br />詳しくは管理人迄お問い合わせください。');
define('_LANG_WPM_LATE_POSTS','投稿');
define('_LANG_WPM_LATE_COMS','コメント');
define('_LANG_WPM_AWIT_MODERATION','承認待ち');
define('_LANG_WPM_COM_APPROV','件のコメントが承認されました。');
define('_LANG_WPM_COMS_APPROVS','件のコメントが承認されました。');
define('_LANG_WPM_COM_DEL','件のコメントが削除されました。');
define('_LANG_WPM_COMS_DELS','件のコメントが削除されました。');
define('_LANG_WPM_COM_UNCHANGE','件のコメントが保留されました。');
define('_LANG_WPM_COMS_UNCHANGES','件のコメントが保留されました。');
define('_LANG_WPM_WAIT_APPROVAL','これらのコメントが承認待ちです:');
define('_LANG_WPM_CURR_COMAPP','承認待ちのコメントはありません。');
define('_LANG_WPM_DEL_LATER','<p>コメントの「承認」「削除」「保留」の選択:</p>');
define('_LANG_WPM_PUBL_VISIBLE','<p><em>承認</em>: 承認を行うと、Blog上で表示されるようになります。');
define('_LANG_WPM_AUTHOR_NOTIFIED','投稿に対してコメントがついた場合、メールにて通知されます。');
define('_LANG_WPM_ASKED_AGAIN','<p><em>削除</em>: コメントの削除を実行する前に必ず再確認してください。 (注: 一度削除してしまうとコメントの復旧は出来ません)</p><p><em>保留</em>: コメントの扱いを暫くの間保留します。</p>');
define('_LANG_WPM_MODERATE_BUTTON','コメントを承認');
define('_LANG_WPM_DO_NOTHING','保留');
define('_LANG_WPM_DO_DELETE','削除');
define('_LANG_WPM_DO_APPROVE','承認');
define('_LANG_WPM_DO_ACTION','選択:');
define('_LANG_WPM_JUST_THIS','このコメントを削除');
define('_LANG_WPM_JUST_EDIT','編集');
define('_LANG_WPM_COMPOST_NAME','投稿者:');
define('_LANG_WPM_COMPOST_MAIL','メール:');
define('_LANG_WPM_COMPOST_URL','URL:');

/* File Name wp-admin/options.php */
define('_LANG_WOP_USER_LEVEL','あなたにはオプションを編集する権限がありません。<br />詳しくは管理人迄お問い合わせください。');
define('_LANG_WOP_PERM_LINKS','Permalinks');
define('_LANG_WOP_PERM_CONFIG','パーマネントリンクの設定');
define('_LANG_WOP_NO_HELPS',' このオプションに関するヘルプはありません');
define('_LANG_WOP_SUBMIT_TEXT','設定の保存');
define('_LANG_WOP_SETTING_SAVED',' 件のセッティングを変更しました');

/* File Name wp-admin/options-permalink.php */
define('_LANG_WPL_EDIT_UPDATED','パーマリンク構造を更新しました。');
define('_LANG_WPL_EDIT_STRUCT','Edit Permalink Structure');
define('_LANG_WPL_CREATE_CUSTOM','WordPressではパーマネントリンク及びアーカイブの為のカスタムURIを作成することが出来ます。<br />利用できるタグは以下の通りです。');
define('_LANG_WPL_CODE_YEAR','年号を表示するには、「<code>2004</code>」のように4桁の数字を記入します。');
define('_LANG_WPL_CODE_MONTH','月を表示するには、「<code>05</code>」のように2桁の数字を記入します。');
define('_LANG_WPL_CODE_DAY','日を表示するには、「<code>28</code>」のように2桁の数字を記入します。');
define('_LANG_WPL_CODE_HOUR','時を表示するには、「<code>15</code>」のように2桁の数字を記入します。');
define('_LANG_WPL_CODE_MINUTE','分を表示するには、「<code>43</code>」のように2桁の数字を記入します。');
define('_LANG_WPL_CODE_SECOND','秒を表示するには、「<code>33</code>」のように2桁の数字を記入します。');
define('_LANG_WPL_CODE_POSTNAME','ポスト名を「this-is-a-great-post」のようにすれば、「This Is A Great Post!」 とサニタイズされます。');
define('_LANG_WPL_CODE_POSTID','投稿を区別するためのユニークID');
define('_LANG_WPL_USE_EXAMPLE','<p>例として</p>
<p><code>/archives/%year%/%monthnum%/%day%/%postname%/</code></p>
<p>のように書けば、パーマリンクは次のようになります</p>
<p><code>/archives/2003/05/23/my-cheese-sandwich/</code></p>
<p>通常この機能はサーバーにインストールされた mod_rewrite を利用しなくてはなりませんが、以下のようにファイル名を一番前に入れると WordPress はそのファイル名を使用して引数を渡そうと試みます。</p>
<p><code>/index.php/archives/%year%/%monthnum%/%day%/%postname%/</code> </p>
<p>この機能を利用すれば mod_rewrite のルールを無視することができます。</p>
');
define('_LANG_WPL_USE_TEMPTEXT','では、上記の見本を参考にしてタグを作成してください。');
define('_LANG_WPL_USE_BLANK','カテゴリー URI 用のカスタム接頭語を登録することが出来ます。例えば、<code>/taxonomy/categorias</code> と入力すると <code>http://example.org/taxonomy/categorias/general/</code> のようなカテゴリーリンクが作成されます。このフィールドが空の場合はデフォルトの設定が使用されます。');
define('_LANG_WPL_USE_HTACCESS','現在のパーマリンク構造の値、<code>%s</code>、を使用するには、<code>.htaccess</code> に以下の mod_rewrite ルールの記述が必要です。フィールドをクリックし、<kbd>CTRL + a</kbd> キーですべてを選択します。');
define('_LANG_WPL_ENGINE_ON','RewriteEngine On RewriteBase');
define('_LANG_WPL_EDIT_TEMPLATE','<p>WordPress による <code>.htaccess</code> への書き込みが可能な状態であれば、<a href=\"%s\">テンプレートインターフェイスを通じて編集</a>することができます。</p>');
define('_LANG_WPL_MOD_REWRITE','現在カスタマイズされたパーマリンクを使用していません。特に mod_rewrite ルールは必要ではありません。');
define('_LANG_WPL_SUBMIT_UPDATE','パーマリンク構造を更新 &raquo;');

/* File Name wp-admin/profile.php */
define('_LANG_WPF_ERR_NICKNAME','<strong>ERROR</strong>: ニックネームを入力してください (ログイン名と同じで構いません)');
define('_LANG_WPF_ERR_ICQUIN','<strong>ERROR</strong>: ICQ UIN は数字である必要があります　文字列は受け付けられません');
define('_LANG_WPF_ERR_TYPEMAIL','<strong>ERROR</strong>: メールアドレスを入力してください');
define('_LANG_WPF_ERR_CORRECT','<strong>ERROR</strong>: メールアドレスの記述が不正です');
define('_LANG_WPF_ERR_TYPETWICE','<strong>ERROR</strong>: 2ヶ所ともパスワードを入力してください');
define('_LANG_WPF_ERR_DIFFERENT','<strong>ERROR</strong>: 確認用パスワードには同じものを入力してください');
define('_LANG_WPF_ERR_PROFILE','<strong>ERROR</strong>: プロフィールの編集が出来ません . . . 管理者迄お問い合わせください。');
define('_LANG_WPF_SUBT_VIEW','View Profile');
define('_LANG_WPF_SUBT_FIRST','名:');
define('_LANG_WPF_SUBT_LAST','姓:');
define('_LANG_WPF_SUBT_NICK','ニックネーム:');
define('_LANG_WPF_SUBT_MAIL','E-Mail:');
define('_LANG_WPF_SUBT_URL','URL:');
define('_LANG_WPF_SUBT_ICQ','ICQ:');
define('_LANG_WPF_SUBT_AIM','AIM:');
define('_LANG_WPF_SUBT_MSN','MSN IM:');
define('_LANG_WPF_SUBT_YAHOO','Yahoo IM:');
define('_LANG_WPF_SUBT_ONE','ワンクリックブックマーク');
define('_LANG_WPF_SUBT_COPY','One-click bookmarkletを有効にするには、<br />
以下をテキストファイルへペーストしてください:');
define('_LANG_WPF_SUBT_BOOK','wordpress.regとしてそれを保存して、このファイルをダブルクリックしてください。<br />質問に答えてからInternet Explorerを再起動してください。<br /><br />以上で完了です。IEウィンドウの中で右クリックすると、<br />bookmarkletを作るときに選択したWordPressへの投稿フォームが現われます。');
define('_LANG_WPF_SUBT_CLOSE','このウィンドウを閉じる');
define('_LANG_WPF_SUBT_UPDATED','プロフィールが更新されました');
define('_LANG_WPF_SUBT_EDIT','Edit Your Profile');
define('_LANG_WPF_SUBT_USERID','User ID:');
define('_LANG_WPF_SUBT_LEVEL','Level:');
define('_LANG_WPF_SUBT_POSTS','Posts:');
define('_LANG_WPF_SUBT_LOGIN','Login:');
define('_LANG_WPF_SUBT_DESC','自己紹介:');
define('_LANG_WPF_SUBT_IDENTITY','このBLOG上の同一人物: ');
define('_LANG_WPF_SUBT_NEWPASS','<strong>新パスワード</strong> (変更しない場合は未記入で)');
define('_LANG_WPF_SUBT_MOZILLA','サイドバーが見つかりません これはMozilla 0.9.4以降の機能です');
define('_LANG_WPF_SUBT_SIDEBAR','サイドバー');
define('_LANG_WPF_SUBT_FAVORITES','お気に入りに登録する:');
define('_LANG_WPF_SUBT_UPDATE','アップデート');

/* File Name wp-admin/sidebar.php */
define('_LANG_WAS_SIDE_POSTED','投稿完了');
define('_LANG_WAS_SIDE_AGAIN','続けて投稿するには<a href="sidebar.php">こちら</a>をクリック');

/* File Name wp-admin/templates.php */
define('_LANG_WAT_LEVEL_ERR','<p>あなたにはテンプレートを編集する権限がありません。<br />
詳しくは管理人迄お問い合わせください。</p>');
define('_LANG_WAT_SORRY_EDIT','このファイルは編集することは出来ません<br />あなたのWordPressホームディレクトリー中のファイルを編集しようとしていれば、ファイル名を入力するだけでOKです。');
define('_LANG_WAT_SORRY_PATH','該当ファイルを呼び出すことが出来ません。');
define('_LANG_WAT_EDITED_SUCCESS','<em>ファイルの編集に成功しました</em>');
define('_LANG_WAT_FILE_CHMOD','編集する場合は該当ファイルのパーミッションを766にしてください');
define('_LANG_WAT_OOPS_EXISTS','<p>そのようなファイルは存在しません　ファイル名を再確認してください</p>');
define('_LANG_WAT_OTHER_FILE','パーミッションを[766]にすることによって、この画面にて<a href="templates.php?file=wp-comments.php">コメントテンプレート</a>や<a href="templates.php?file=wp-comments-popup.php">ポップアップ・コメントテンプレート</a>を編集することが出来ます。　さらに、他のファイルを指定して編集することも可能です。');
define('_LANG_WAT_TYPE_HERE','該当ファイル名を入力してください:');
define('_LANG_WAT_FTP_CLIENT','もちろんテキストエディターでテンプレートを編集し、それらをアップロードすることができます。<br />このオンライン・エディターはローカルでの編集が煩わしい場合や補助としてお使いください。');
define('_LANG_WAT_UPTEXT_TEMP','アップデート !');

/* File Name wp-admin/upload.php */
define('_LANG_WAU_ADMIN_DISABLED','管理人により、この機能は停止されています');
define('_LANG_WAU_FILE_UPLOAD','ファイルアップロード');
define('_LANG_WAU_CAN_TYPE','アップロード可能なファイル拡張子:');
define('_LANG_WAU_MAX_SIZE','ファイルの最大サイズ:');
define('_LANG_WAU_FILE_DESC','画像の説明(alt):');
define('_LANG_WAU_BUTTON_TEXT','アップロード !');
define('_LANG_WAU_ATTACH_ICON','添付ファイルのアイコンのみ');

/* File Name wp-admin/users.php */
define('_LANG_WUS_WHOSE_LEVEL','あなたより高いユーザーレベルのレベルを変更することはできません。');
define('_LANG_WUS_WHOSE_DELETE','あなたより高いレベルのユーザーを削除することはできません。');
define('_LANG_WUS_CANNOT_DELU','このユーザーは削除できません');
define('_LANG_WUS_CANNOT_DELUPOST','このユーザーの投稿は削除できません');
define('_LANG_WUS_AU_THOR','Authors');
define('_LANG_WUS_AU_NICK','ニックネーム');
define('_LANG_WUS_AU_NAME','ログイン名');
define('_LANG_WUS_AU_MAIL','E-Mail');
define('_LANG_WUS_AU_URI','URL');
define('_LANG_WUS_AU_LEVEL','レベル');
define('_LANG_WUS_AU_POSTS','投稿数');
define('_LANG_WUS_AU_USERS','Users');
define('_LANG_WUS_AU_WARNING','ユーザーを削除するためには、まず該当ユーザーのレベルを「0」にしてください<br />次に、赤いXマークをクリックしてください<br />※ ユーザーの削除は、このユーザーによる投稿もすべて削除されます。');
define('_LANG_WUS_ADD_USER','このユーザーを追加する');
define('_LANG_WUS_ADD_THEMSELVES','こちらのメンバー登録画面と同じく、このページでも新しいメンバーを登録することが出来ます。');
define('_LANG_WUS_ADD_FIRST','ファーストネーム ');
define('_LANG_WUS_ADD_LAST','ラストネーム ');
define('_LANG_WUS_ADD_TWICE','パスワード (2箇所) ');

/* File Name wp-comments.php */
define('_LANG_WPCM_LOAD_DIRECTLY','このディレクトリのファイルは直接ご覧いただけません');
define('_LANG_WPCM_ENTER_PASS','<p>コメントを見るためのパスワードを入力してください。<p>');
define('_LANG_WPCM_COM_TITLE','コメント');
define('_LANG_WPCM_COM_RSS','このコメントのRSS');
define('_LANG_WPCM_COM_TRACK','TrackBack URL : ');
define('_LANG_WPCM_COM_YET','この投稿には、まだコメントが付いていません');
define('_LANG_WPCM_COM_LEAVE','コメントの投稿');
define('_LANG_WPCM_HTML_ALLOWED','改行や段落は自動です<br />URLとE-mailは自動的にリンクされますので、&lt;a&gt;タグは不要です。<br /><acronym title="Hypertext Markup Language">HTML</acronym> allowed: ');
define('_LANG_WPCM_COM_YOUR','コメントをどうぞ');
define('_LANG_WPCM_PLEASE_NOTE','<strong>ご注意 : </strong>セッティングにより、コメント投稿から実際に閲覧できるようになるまで暫く時間が掛かる場合があります。 再投稿の必要はありませんので、表示されるまでお待ち下さい。');
define('_LANG_WPCM_COM_SAYIT','Say it !');
define('_LANG_WPCM_THIS_TIME','ごめんなさい、現在コメントを付けることは出来ません');
// define('_LANG_WPCM_GO_BACK','Go Back');
define('_LANG_WPCM_COM_NAME','Name');

/* File Name wp-comments-post.php */
define('_LANG_WPCP_SORRY_ITEM','ごめんなさい  この投稿に対するコメントは締め切りました');
define('_LANG_WPCP_ERR_FILL','Error: お名前とメールアドレスを記入してください');
define('_LANG_WPCP_ERR_TYPE','Error: コメントを記入してください');
define('_LANG_WPCP_SORRY_SECONDS','ごめんなさい  続けて投稿する場合は10秒以上時間を空けてください');

/* File Name wp-admin/upload.php */
define('_LANG_WAU_UPLOAD_DISABLED','管理人によりこの機能の使用が許可されていません');
define('_LANG_WAU_UPLOAD_DIRECTORY','指定されたディレクトリーが書き込み可能になっていませんので、現在アップロード機能を利用することができません。<br />ディレクトリーのパーミッション及びフルパスを再度チェックしてください');
define('_LANG_WAU_UPLOAD_EXTENSION','アップロード可能なファイルの種類 : ');
define('_LANG_WAU_UPLOAD_BYTES','アップロード可能なファイルのサイズ : ');
define('_LANG_WAU_UPLOAD_OPTIONS','Admin権限をお持ちならオプション設定でこれらの値を設定することができます');
define('_LANG_WAU_UPLOAD_FILE','ファイルの選択:');
define('_LANG_WAU_UPLOAD_ALT','説明 (ALT):');
define('_LANG_WAU_UPLOAD_THUMBNAIL','サムネイル作成オプション');
define('_LANG_WAU_UPLOAD_NO','作成しない');
define('_LANG_WAU_UPLOAD_SMALL','スモールサイズ (長辺側 200px)');
define('_LANG_WAU_UPLOAD_LARGE','ラージサイズ (長辺側 400px)');
define('_LANG_WAU_UPLOAD_CUSTOM','カスタムサイズ');
define('_LANG_WAU_UPLOAD_PX','px (長辺側)');
define('_LANG_WAU_UPLOAD_BTN','ファイルアップロード');
define('_LANG_WAU_UPLOAD_SUCCESS','指定されたファイルのアップロードが完了しました : ');
define('_LANG_WAU_UPLOAD_CODE','こちらの表示用コードをお使い下さい :');
define('_LANG_WAU_UPLOAD_START','アップロードを続ける');
define('_LANG_WAU_UPLOAD_DUPLICATE','ファイル名が重複していませんか ?');
define('_LANG_WAU_UPLOAD_EXISTS','この名前のファイルは既に存在します : ');
define('_LANG_WAU_UPLOAD_RENAME','確認するか改名してください:');
define('_LANG_WAU_UPLOAD_ALTER','代替名:');
define('_LANG_WAU_UPLOAD_REBTN','リネーム');
define('_LANG_WAU_UPLOAD_CODEIN','このコードを投稿フォームに挿入');
define('_LANG_WAU_UPLOAD_AMAZON','アマゾンアソシエイト');

/* File Name wp-admin/options-general.php */
define('_LANG_WAO_GENERAL_DISABLED','あなたは、このBlogを編集する権限を持っていません。');
define('_LANG_WAO_GENERAL_WPTITLE','ウェブログタイトル:');
define('_LANG_WAO_GENERAL_TAGLINE','タグライン:');
define('_LANG_WAO_GENERAL_URI','アドレス(URI):');
define('_LANG_WAO_GENERAL_MAIL','アドレス(E-Mail):');
define('_LANG_WAO_GENERAL_MEMBER','メンバーシップ:');
define('_LANG_WAO_GENERAL_GMT','グリニッジ標準時:');
define('_LANG_WAO_GENERAL_DIFFER','時差(GMT+):');
define('_LANG_WAO_GENERAL_EXPLIAIN','何に関するWeblogか (description)');
define('_LANG_WAO_GENERAL_ADMIN','このアドレスは管理のためにのみ使用されます。');
define('_LANG_WAO_GENERAL_REGISTER','メンバー登録を許可する');
define('_LANG_WAO_GENERAL_ARTICLES','メンバーも記事を公表することができる');
define('_LANG_WAO_GENERAL_UPDATE','アップデート');

/* File Name wp-admin/options-writing.php */
define('_LANG_WAO_WRITING_ERROR','あなたには、このオプションを編集する権限がありません');
define('_LANG_WAO_WRITING_TITLE','Writing Options');
define('_LANG_WAO_WRITING_SIMPLE','シンプルスタイル');
define('_LANG_WAO_WRITING_ADVANCED','拡張スタイル');
define('_LANG_WAO_WRITING_LINES','行');
define('_LANG_WAO_WRITING_DISPLAY',':-) や :-P をグラフィックに置き換えて表示する');
define('_LANG_WAO_WRITING_XHTML','XHTMLの構文エラーを自動的に修正する');
define('_LANG_WAO_WRITING_CHARACTER','文字コードの指定 (UTF-8 を推奨)');
define('_LANG_WAO_WRITING_STYLE','投稿フォームの表示スタイル:');
define('_LANG_WAO_WRITING_BOX','投稿フォームのサイズ:');
define('_LANG_WAO_WRITING_FORMAT','フォーマット:');
define('_LANG_WAO_WRITING_ENCODE','エンコード:');
define('_LANG_WAO_WRITING_SERVICES','アップデートサービス');
define('_LANG_WAO_WRITING_SOMETHING','新規投稿時にピンを飛ばすURLをリストにしておくと便利です。<br />改行を入れることで複数のサイトを指定することが出来ます。');
define('_LANG_WAO_WRITING_UPDATE','オプションを更新');

/* File Name wp-admin/options-discussion.php */
define('_LANG_WAO_DISCUSS_TITLE','Discussion Options');
define('_LANG_WAO_DISCUSS_INDIVIDUAL','投稿のための標準セッティング: (これらのセッティングによりオーバーライドされます)');
define('_LANG_WAO_DISCUSS_NOTIFY','投稿記事中からリンクしたすべてのWeblogに通知する (実行に時間が掛かります)');
define('_LANG_WAO_DISCUSS_PINGTRACK','他のWeblogsからのリンク通知を許可する (Pingback と Trackback)');
define('_LANG_WAO_DISCUSS_PEOPLE','投稿に対して誰でもコメントをつけることが出来るようにする');
define('_LANG_WAO_DISCUSS_EMAIL','メール通知に関して:');
define('_LANG_WAO_DISCUSS_ANYONE','すべてのコメントに対して通知する');
define('_LANG_WAO_DISCUSS_DECLINED','コメントが承認されるか却下されたときに通知する');
define('_LANG_WAO_DISCUSS_APPEARS','コメント表示の方法:');
define('_LANG_WAO_DISCUSS_ADMIN','コメントの表示には管理者の許可が必要 (以下の設定に左右されず)');
define('_LANG_WAO_DISCUSS_MODERATION','指定した名前、URLあるいはメールアドレスや以下の単語のうちの何れかを含んでいるコメント場合、管理人の承認待ちにすることが出来ます:(改行により幾つでも指定することが出来ます)');

/* File Name wp-admin/options-reading.php */
define('_LANG_WAO_READING_TITLE','Reading Options');
define('_LANG_WAO_READING_FRONT','フロントページ');
define('_LANG_WAO_READING_RECENT','最新投稿表示数:');
define('_LANG_WAO_READING_FEEDS','管理画面フィード');
define('_LANG_WAO_READING_ARTICLE','表示方法:');
define('_LANG_WAO_READING_ENCODE','使用文字コード:');
define('_LANG_WAO_READING_CHARACTER','文字コードの指定 (<a href="http://developer.apple.com/documentation/macos8/TextIntlSvcs/TextEncodingConversionManager/TEC1.5/TEC.b0.html">UTF-8 を推奨</a>)');
define('_LANG_WAO_READING_GZIP','gzipを利用する');
define('_LANG_WAO_READING_BTNTXT','オプションを更新');

/* Cheatin&#8217; uh? */
define('_LANG_P_CHEATING_ERROR','現在のレベルではご利用いただけません');


/* Start Install ************************************************/
/* File Name wp-admin/install.php */
define('_LANG_INST_GUIDE_WPCONFIG','<p>サーバー上に <b>wp-config.php</b> ファイルが存在しません<br />WordPress ME のインストールにはこのファイルが必要です。<br /><br />こちらの<a href="install-config.php">ウィザード</a>を利用してサーバー上で <b>wp-config.php</b> ファイルを作成することができますが、この方法はすべての環境での動作を保障することができませんのでご了承下さい。<br /><br />最も確実な方法は <b>wp-config-sample.php</b> を参考に手動でファイルを作成することです。</p>');
define('_LANG_INST_GUIDE_INSTALLED','<p>既にWordPress ME はインストールされています。<br />再インストールする場合はデータベースからテーブルを削除してください。</p></body></html>');
define('_LANG_INST_GUIDE_WEL','<br />ここでは、インストールの為の幾つかのステップをご案内します。<br />インストールを始める前に、少なくとも 4.0.6 のPHPバージョンが必要です。<br />
現在ご利用中のサーバーにインストールされているバージョンはこちらです : ');
define('_LANG_INST_GUIDE_COM','<p>次のステップに進む前に wp-config.php でデータベース接続情報を記入する必要があります(ウィザード実行中の方は不要です) また、weblogs.com.changes.cache というファイルのパーミッションを[666]にする必要があります。<br /><br />Readmeを再確認するには<a href="../wp-readme/">こちら</a>　すべて準備ができている場合は <a href="install.php?step=1">Step 1</a> へ進んでください。</p>');
define('_LANG_INST_STEP1_FIRST','<p>リンクデータベースをセットアップします<br />Weblogs.com に登録することで、blogroll を利用することが可能です。</p>');
define('_LANG_INST_STEP1_LINKS','<p>WP-Links をインストール中です。</p><p>データベーステーブルをチェック中</p>');
define('_LANG_INST_STEP1_ALLDONE','すばらしい !　見事難関を突破しましたね。 このまま <a href="install.php?step=2">Step 2</a> へ進んでください。');
define('_LANG_INST_STEP2_INFO','データベースの中で必要なBlogテーブルを作成します。');
/* base options from b2cofig */
define('_LANG_INST_BASE_VALUE1','あなたのBlogのURLです(最後にスラッシュはつけないで下さい)');
define('_LANG_INST_BASE_VALUE2','デフォルトのファイル名を指定してください');
define('_LANG_INST_BASE_VALUE3','このBlogの名前を指定してください(サイト名)');
define('_LANG_INST_BASE_VALUE4','あなたのBlogの説明(description)');
define('_LANG_INST_BASE_VALUE7','新規ユーザーがすぐに記事を投稿することが出来るようにする');
define('_LANG_INST_BASE_VALUE8','新規ユーザーの登録を許可する');
define('_LANG_INST_BASE_VALUE54','管理人のメールアドレス (正確に)');
// general blog setup
define('_LANG_INST_BASE_VALUE9','週の始めの曜日指定');
define('_LANG_INST_BASE_VALUE11','[b]bold[/b]のようなBBCodeを使用する');
define('_LANG_INST_BASE_VALUE12','**bold** \\\\italic\\\\ __underline__のようなGreyMatter-styleを使用する');
define('_LANG_INST_BASE_VALUE13','ボタンによるクイックタグを使用する (Mac IEでは利用できません)');
define('_LANG_INST_BASE_VALUE14','重要! 中国語、日本語、韓国語その他のマルチバイト言語での使用時には必ず[false]にしてください');
define('_LANG_INST_BASE_VALUE15','タグを許可した場合、それが悪い結果を招く場合があります。利用状況にもよりますが[false]にすることをお勧めします');
define('_LANG_INST_BASE_VALUE16','投稿時にスマイリーアイコンの使用を許可することで、微妙なニュアンスを伝えることが可能となります');
define('_LANG_INST_BASE_VALUE17','スマイリーアイコンのあるディレクトリを指定 (最後のスラッシュは不要)');
define('_LANG_INST_BASE_VALUE18','コメント投稿時に名前とメールアドレスの入力を必須にする。[false]にすると、それらが未記入でもコメントを投稿することが出来ます');
define('_LANG_INST_BASE_VALUE20','コメントが投稿された際メール通知する');
/* rss/rdf feeds */
define('_LANG_INST_BASE_VALUE21','RSSに出力する記事数');
define('_LANG_INST_BASE_VALUE22','RSSに出力する言語 ( 参考 : <a href="http://backend.userland.com/stories/storyReader$16" target="_blank">http://backend.userland.com/stories/storyReader$16</a>');
define('_LANG_INST_BASE_VALUE23','b2rss.phpにて&lt;description>中にHTMLタグを許可しますか ?');
define('_LANG_INST_BASE_VALUE24','RSSで出力する抜粋記事の長さ(0=無制限) 注 : b2rss.phpではコード化されたHTMLを使用すれば0にセットされます。');
define('_LANG_INST_BASE_VALUE25','RSS出力用に抜粋フィールドを使用する');
define('_LANG_INST_BASE_VALUE26','投稿記事をhttp://weblogs.com/にてリスト化されることを許可する');
define('_LANG_INST_BASE_VALUE27','投稿記事をhttp://blo.gs/にてリスト化されることを許可する');
define('_LANG_INST_BASE_VALUE28','これを変更する必要はありません');
define('_LANG_INST_BASE_VALUE29','Trackbackの使用を許可するかしないかを設定してください　[false]にすると利用できなくなります。');
define('_LANG_INST_BASE_VALUE30','Pingbackの使用を許可するかしないかを設定してください　[false]にすると利用できなくなります。');
define('_LANG_INST_BASE_VALUE31','[true]でファイルのアップロードを許可、[false]で禁止');
define('_LANG_INST_BASE_VALUE32','画像をアップロードするディレクトリを絶対パスで指定してください(最後のスラッシュは不要)　サーバーがUNIX環境の場合は、該当ディレクトリのパーミッションを[766]以上にしてください');
define('_LANG_INST_BASE_VALUE33','そのディレクトリーのURLを入力します(アップロードされたファイルへのリンクを生成するために使用されます)　こちらも最後のスラッシュは不要です');
define('_LANG_INST_BASE_VALUE34','許可するファイルタイプを指定します　このリストは増すことができます(各ファイルタイプは半角スペースで区切ってください)');
define('_LANG_INST_BASE_VALUE35','アップロード可能なファイルサイズを指定してください。 ほとんどのサーバーでは2048KBに制限されています(サーバーの限界値より高い値をセットしても意味がありません)');
define('_LANG_INST_BASE_VALUE36','ファイルのアップロードを許可するユーザーレベルを設定してください');
define('_LANG_INST_BASE_VALUE37','上の設定とは関係なく、管理人が設定した特定のユーザーだけファイルのアップロードを許可することも出来ます　その場合はこちらでユーザー名を指定します。 複数の場合は半角スペースで区切ってください。');
/* email settings */
define('_LANG_INST_BASE_VALUE38','メールサーバー名');
define('_LANG_INST_BASE_VALUE39','ログイン名');
define('_LANG_INST_BASE_VALUE40','パスワード');
define('_LANG_INST_BASE_VALUE41','ポート番号');
define('_LANG_INST_BASE_VALUE42','投稿するデフォルトカテゴリーの指定');
define('_LANG_INST_BASE_VALUE43','題名につける接頭語');
define('_LANG_INST_BASE_VALUE44','ターミネーターストリング(本文からこの文字列で始まる部分を削除する)');
define('_LANG_INST_BASE_VALUE45','[true]にするとテストモードになります');
define('_LANG_INST_BASE_VALUE46','ここを[true]にすることで、携帯電話のメールサービスなどからの分割した内容でも一つの本文として調整されます');
define('_LANG_INST_BASE_VALUE47','メッセージを送信する際はログイン名に続けてパスワードを入れます。 分割送信した文章を繋げるためのセパレーターストリングをここで指定してください。');
define('_LANG_INST_BASE_VALUE48','インデックスに表示する投稿数');
define('_LANG_INST_BASE_VALUE49','投稿別、日付別などの表示スタイルの選択');
define('_LANG_INST_BASE_VALUE50','アーカイブ化する単位の選択');
define('_LANG_INST_BASE_VALUE51','サーバータイムゾーンの調整');
define('_LANG_INST_BASE_VALUE52','日付のフォーマット : <a href="http://php.planetmirror.com/manual/ja/function.date.php" target="_blank">参考</a>');
define('_LANG_INST_BASE_VALUE53','時間のフォーマット : <a href="http://php.planetmirror.com/manual/ja/function.date.php" target="_blank">参考</a>');
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
define('_LANG_INST_BASE_VALUE55','新規投稿のデフォルトセット');
define('_LANG_INST_BASE_VALUE56','コメントのデフォルトセット');
define('_LANG_INST_BASE_VALUE57','新規投稿に対するPingのデフォルトセット');
define('_LANG_INST_BASE_VALUE58','PingBackによる投稿をデフォルトでチェックする');
define('_LANG_INST_BASE_VALUE59','新規投稿のデフォルトカテゴリー');
define('_LANG_INST_BASE_VALUE83','編集フォームに表示する記事の数 (min 3, max 100)');
define('_LANG_INST_BASE_VALUE60','リンクを編集できるユーザーレベルの設定');
define('_LANG_INST_BASE_VALUE61','ここを[false]にすることですべてのリンクが表示され、誰でもリンクマネージャーを編集することが出来るようになります');
define('_LANG_INST_BASE_VALUE62','評価表示に使用するタイプを指定します');
define('_LANG_INST_BASE_VALUE63','記号を使う場合ここで指定します');
define('_LANG_INST_BASE_VALUE64','0の価値を指定します。 ここを[true]にした場合、0は評価の基準になりません');
define('_LANG_INST_BASE_VALUE65','同じ評価ポイントには同じイメージを使用する');
define('_LANG_INST_BASE_VALUE66','評価0のイメージ');
define('_LANG_INST_BASE_VALUE67','評価1のイメージ');
define('_LANG_INST_BASE_VALUE68','評価2のイメージ');
define('_LANG_INST_BASE_VALUE69','評価3のイメージ');
define('_LANG_INST_BASE_VALUE70','評価4のイメージ');
define('_LANG_INST_BASE_VALUE71','評価5のイメージ');
define('_LANG_INST_BASE_VALUE72','評価6のイメージ');
define('_LANG_INST_BASE_VALUE73','評価7のイメージ');
define('_LANG_INST_BASE_VALUE74','評価8のイメージ');
define('_LANG_INST_BASE_VALUE75','評価9のイメージ');
define('_LANG_INST_BASE_VALUE76','書き込み可能なキャッシュファイル');
define('_LANG_INST_BASE_VALUE77','weblogs.comから受け取るファイル');
define('_LANG_INST_BASE_VALUE78','キャッシュを利用する時間(分)');
define('_LANG_INST_BASE_VALUE79','日付のフォーマット');
define('_LANG_INST_BASE_VALUE80','最新リンクへのテキスト記号(Next)');
define('_LANG_INST_BASE_VALUE81','最新リンクへのテキスト記号(Back)');
define('_LANG_INST_BASE_VALUE82','新規・更新リンクとして扱う時間(分)');
define('_LANG_INST_BASE_VALUE84','WordPressをGeoURLで使えるようにする');
define('_LANG_INST_BASE_VALUE85','デフォルトで GeoURL ICBM から利用できるようにする');
define('_LANG_INST_BASE_VALUE86','ICBMのデフォルト緯度 - <a href="http://www.geourl.org/resources.html" target="_blank">see here</a>');
define('_LANG_INST_BASE_VALUE87','ICBMのデフォルト経度');
/* Last Question */
define('_LANG_INST_STEP2_LAST','データのインサートはほぼ完了しました。 <br />後はこの質問に答えるだけです。');
define('_LANG_INST_STEP2_URL','このBlogを設置するURL（最後のスラッシュは不要)');
define('_LANG_INST_STEP3_SET','<p>早速、こちらから<a href="../wp-login.php">ログイン</a>してみてください。 ログイン名は"<strong>admin</strong>" 、パスワードはこちらです。 "');
define('_LANG_INST_STEP3_UP','".</p><p><strong>パスワードは忘れないよう必ずメモしてください。</strong> これはあなたの為にランダムに生成された任意のパスワードです。これを紛失するとデータベースからテーブルを削除し、WordPressを再インストールしなければならなくなりますのでご注意ください。</p>');
define('_LANG_INST_STEP3_DONE','より多くの難関を期待していましたか ?<br />残念ながらこれですべて完了です。 では WordPress をお楽しみください。');
define('_LANG_INST_CAUTIONS','ウィザードを利用してインストールされた場合は、WordPress ME の対象ディレクトリと <b>wp-config.php</b> を必ずセーフティパーミッションに戻してください。<ul><li>ディレクトリ : [755]</li><li>wp-config.php : [604〜644]</li></ul>');

/* Start Upgrade ************************************************/
/* File Name wp-admin/upgrade.php */
define('_LANG_UPG_STEP_INFO','サーバー上にwp-config.phpファイルが存在しません<br />適切なデータベース接続情報を備えたwp-config.phpファイルを用意してください。');
define('_LANG_UPG_STEP_INFO2','<p>WordPressを旧バージョンからアップグレードします<br />少々時間が掛かりますが、最後までよろしくお付き合い下さい。</p><p>準備ができましたら<a href="upgrade.php?step=1">こちら</a>へ進んでください。</p>');
define('_LANG_UPG_STEP_INFO3','<p>このプロセスだけですべての作業が完了しました。 では<a href="../">お楽しみ下さい</a></p>');

/* File Name wp-admin/upgrade-functions.php */
define('_LANG_INST_BASE_VALUE88','承認されたコメントのみ表示されるようにする。');
define('_LANG_INST_BASE_VALUE89','ここを[true]にしておくことで、承認待ちコメントがあることをメールで通知可能になります。');
define('_LANG_INST_BASE_VALUE90','パーマネントリンクオプションについての詳しい説明は<a href="options-permalink.php">こちらのページ</a>でご覧いただけます。');
define('_LANG_INST_BASE_VALUE91','ファイル出力時にgzipを有効にするかどうかを選択してください。 お使いのウェブサーバーApacheにmod_gzipというモジュールが組み込まれていない場合は、ここを[true]にしてください。');
define('_LANG_INST_BASE_VALUE92','Hackファイルを使用する場合はここを[true]にしてください。 HackファイルはWordPressのルート上に置いて、my-hacks.phpのように呼び出します。 これはアップグレード時に上書きされないようにするためのものです。');
define('_LANG_INST_BASE_VALUE93','Blogのキャラクターセット (<a href="http://developer.apple.com/documentation/macos8/TextIntlSvcs/TextEncodingConversionManager/TEC1.5/TEC.b0.html">文字コードリスト</a>');
define('_LANG_INST_BASE_VALUE94','グリニッジ標準時(GMT)からの時差');

/* File Name wp-admin/plugins.php */
define('_LANG_PG_LEAST_LEVEL','プラグインの設定にはユーザーレベル8以上が必要です。');
define('_LANG_PG_ACTIVATED_OK','プラグイン機能 <strong>有効</strong>');
define('_LANG_PG_DEACTIVATED_OK','プラグイン機能 <strong>無効</strong>');
define('_LANG_PG_PAGE_TITLE','Plugin Management');
define('_LANG_PG_NEED_PUT','プラグインとは、通常 WordPress とは別途にダウンロードする "機能を追加する" ためのファイルです。プラグインをインストールするには、<code>wp-content/plugins</code> ディレクトリーにプラグインファイルを入れるだけです。一旦プラグインがインストールされれば、このページでそのプラグインを有効化させたり無効化させたりすることができます。');
define('_LANG_PG_OPEN_ERROR','plugins ディレクトリーを開くことができないか、利用可能なプラグインが存在しません。');
define('_LANG_PG_SUB_PLUGIN','プラグイン');
define('_LANG_PG_SUB_VERSION','バージョン');
define('_LANG_PG_SUB_AUTHOR','作者');
define('_LANG_PG_SUB_DESCR','概要');
define('_LANG_PG_SUB_ACTION','アクション');
define('_LANG_PG_SUB_DEACTIVATE','無効にする');
define('_LANG_PG_SUB_ACTIVATE','有効にする');
define('_LANG_PG_GOOGLE_HILITE','Google、Yahoo 等の検索エンジン、あるいは WordPress 自身でブログを検索した時に、このプラグインによって検索語句がハイライトされます。<a href="http://photomatt.net/">Matt</a> によるパッケージング。');
define('_LANG_PG_MARK_DOWN','Markdown はウェブで書き物をする人のための、テキストから HTML への変換ツールです。<a href="http://daringfireball.net/projects/markdown/syntax">Markdown syntax</a> によって、読みやすく書きやすいプレインテキスト・フォーマットを使用して書くことができ、そしてそれを構造的に適合した XHTML に変換します。このプラグインは投稿とコメントに対して Markdown を有効にします。Markdown は <a href="http://daringfireball.net/">John Gruber</a> によって Perl で作成され、<a href="http://www.michelf.com/">Michel Fortin</a> によって PHP に移植され、<a href="http://photomatt.net/">Matt</a> によって WP のプラグインが作られました。このプラグインを使用する場合は、コンフリクトが起こるので Textile 1 と 2 を無効にしてください。');
define('_LANG_PG_TEXTILE_2','これは Textile として知られる <a href="http://textism.com/?wp">Dean Allen</a> の Humane Web Text Generator の単純なラッパーです。このバージョン２では、ほとんど HTML メタ言語となるくらいの多くの柔軟性が加わりました。その代償として遅くなっています。このプラグインを使用する場合は、一緒にはうまく作動しないので Textile 1 と Markdown を無効にしてください。');
define('_LANG_PG_HELLO_DOLLY','これはただのプラグインではありません。Louis Armstrong によって歌われた最も有名な二つの単語に要約される、同一世代のすべての人々の希望と情熱を象徴するものです。ところで、これは世界で最初の WordPress 公式プラグインです。このプラグインが有効にされると、プラグイン管理画面以外の Admin 画面の右上に "Hello, Dolly" からの歌詞がランダムに表示されます。');
define('_LANG_PG_TEXTILE_1','これは <a href="http://www.textism.com/tools/textile/">Textile</a> として知られる <a href="http://textism.com/?wp">Dean Allen</a> の Humane Web Text Generator の単純なラッパーです。このプラグインを使用する場合は、一緒にはうまく作動しないので Textile 2 と Markdown を無効にしてください。');


}
?>