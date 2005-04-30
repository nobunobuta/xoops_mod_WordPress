<?php
if( ! class_exists( 'WordPressUser' ) ) {
class WordPressUser  extends XoopsTableObject
{
	/**
	 * コンストラクタ
	 */
	function WordPressUser() {
	////////////////////////////////////////
	// 各クラス共通部分(書換不要)
	////////////////////////////////////////
		
		//親クラスのコンストラクタ呼出
		$this->XoopsTableObject();

	////////////////////////////////////////
	// 派生クラス固有の定義部分
	////////////////////////////////////////

		//各オブジェクト要素の定義
		$this->initVar('ID', XOBJ_DTYPE_INT, NULL, true);
		$this->initVar('user_login', XOBJ_DTYPE_TXTBOX, NULL, true, 20);
		$this->initVar('user_pass', XOBJ_DTYPE_TXTBOX, NULL, false,20);
		$this->initVar('user_firstname', XOBJ_DTYPE_TXTBOX, NULL, false,50);
		$this->initVar('user_lastname', XOBJ_DTYPE_TXTBOX, NULL, false,50);
		$this->initVar('user_nickname', XOBJ_DTYPE_TXTBOX, NULL, false,50);
		$this->initVar('user_icq', XOBJ_DTYPE_INT, NULL, false);
		$this->initVar('user_email', XOBJ_DTYPE_EMAIL, NULL, false,100);
		$this->initVar('user_url', XOBJ_DTYPE_URL, NULL, false,100);
		$this->initVar('user_ip', XOBJ_DTYPE_TXTBOX, NULL, false,15);
		$this->initVar('user_domain', XOBJ_DTYPE_TXTBOX, NULL, false,200);
		$this->initVar('user_browser', XOBJ_DTYPE_TXTBOX, NULL, false,200);
		$this->initVar('dateYMDhour', XOBJ_DTYPE_TXTBOX, NULL, false,50);
		$this->initVar('user_level', XOBJ_DTYPE_INT, NULL, false);
		$this->initVar('user_aim', XOBJ_DTYPE_TXTBOX, NULL, false,50);
		$this->initVar('user_msn', XOBJ_DTYPE_TXTBOX, NULL, false,100);
		$this->initVar('user_yim', XOBJ_DTYPE_TXTBOX, NULL, false,50);
		$this->initVar('user_idmode', XOBJ_DTYPE_TXTBOX, NULL, false,20);
		$this->initVar('user_description', XOBJ_DTYPE_TXTAREA, NULL, false);

		//プライマリーキーの定義
		$this->setKeyFields(array('ID'));
	}
	
	// 各オブジェクト要素の検証メソッド
	// - CleanVarsメソッドが呼ばれたときに、
	//   checkVar_メンバ名 というメソッドを定義しておけば呼ばれます。
	function checkVar_user_email(&$value) {
		if ($value) {
			//メール形式のチェックは既に行っているが、メッセージを判りやすく
			if (!checkEmail($value)) {
				$this->setErrors(_LANG_WPF_ERR_CORRECT);
                return false;
			}
		}
	}
	function checkVar_user_icq(&$value) {
		if ($value) {
			//ICQ IDはすべて数字
			if ((ereg("^[0-9]+$",$value))==false) {
				$this->setErrors(_LANG_WPF_ERR_ICQUIN);
                return false;
			}
		}
	}

	// その他のユーティリティメッソッド
	function get_uniqname($format = 's') {
		switch($this->getVar('user_idmode')) {
			case 'nickname':	return($this->getVar('user_nickname',$format));	break;
			case 'login':		return($this->getVar('user_login',$format));		break;
			case 'firstname':	return($this->getVar('user_firstname',$format));	break;
			case 'lastname':	return($this->getVar('user_lastname',$format));	break;
			case 'namefl':		return($this->getVar('user_firstname',$format).' '.$this->getVar('user_lastname',$format));	break;
	 		case 'namelf':		return($this->getVar('user_lastname',$format).' '.$this->getVar('user_firstname',$format));	break;
	 		default:			return($this->getVar('user_nickname',$format));	break;
		}
	}

	function getNumPosts() {
		$criteria =& new CriteriaCompo(new Criteria('post_author', $this->getVar('ID')));
		$criteria->add(new Criteria('post_status', 'publish'));
		$postHandler =& new WordPressPostHandler($this->_handler->db, $this->_handler->prefix);
		return $postHandler->getCount($criteria);
	}

	function getPostIDs($status='') {
		$criteria =& new CriteriaCompo(new Criteria('post_author', $this->getVar('ID')));
		if ($status) {
			$criteria->add(new Criteria('post_status', $status));
		}
		$postHandler =& new WordPressPostHandler($this->_handler->db, $this->_handler->prefix);
		$posts =& $postHandler->getObjects($criteria);
		$IDs = array();
		foreach($posts as $post) {
			$IDs[] = $post->getVar('ID');
		}
		return $IDs;
	}

	function upUserLevel() {
		if ($this->getVar('user_level') < 10) {
	        return $this->_handler->updateByField($this, 'user_level', $this->getVar('user_level') + 1);
        } else {
        	return false;
        }
	}

	function downUserLevel() {
		if ($this->getVar('user_level') > 0) {
        	return $this->_handler->updateByField($this, 'user_level', $this->getVar('user_level') - 1);
        } else {
        	return false;
        }
	}
}

class WordPressUserHandler  extends XoopsTableObjectHandler
{
	var $prefix;
	/**
	 * コンストラクタ
	 */
	function WordPressUserHandler($db,$prefix)
	{
	////////////////////////////////////////
	// 各クラス共通部分(書換不要)
	////////////////////////////////////////

		//親クラスのコンストラクタ呼出
		$this->XoopsTableObjectHandler($db);
		
	////////////////////////////////////////
	// 派生クラス固有の定義部分
	////////////////////////////////////////
		//ハンドラの対象テーブル名定義
		$this->prefix = $prefix;
		$this->tableName = $this->db->prefix($prefix.'users');
	}
	
	/**
     * レコードの取得(プライマリーキーによる一意検索）
     * 
     * @param	string $key 検索キー
	 *
     * @return	object  {@link WordPressUser}, FALSE on fail
     */
	function &get($key)
	{
		if ($userObject =& parent::get($key)) {
			$member_handler =& xoops_gethandler('member');
			$member =& $member_handler->getUser($userObject->getVar('ID'));
			$userObject->assignVar('user_pass', $member->getVar('pass'));
			return $userObject;
		} else {
			return false;
		}
	}
	/**
     * レコードの取得(ログイン名による検索）
     * 
     * @param	string $login 検索キー
	 *
     * @return	object  {@link WordPressUser}, FALSE on fail
     */
	function &getByLogin($login)
	{
		$criteria = new Criteria('user_login', $login);
		$userObjects =& $this->getObjects($criteria);
		if (count($userObjects) == 1) {
			$userObject =& $userObjects[0];
			$member_handler =& xoops_gethandler('member');
			$member =& $member_handler->getUser($userObject->getVar('ID'));
			$userObject->assignVar('user_pass', $member->getVar('pass'));
			return $userObject;
		}
		return false;
	}
    /**
     * レコードの保存
     * 
     * @param	object	&$record	{@link WordPressUser} object
     * @param	bool	$force		POSTメソッド以外で強制更新する場合はture
     * 
     * @return	bool    成功の時は TRUE
     */
	function insert(&$record, $force=false, $updateOnlyChanged=false, $mod_name='')
	{
		$member_handler =& xoops_gethandler('member');
		$member =& $member_handler->getUser($record->getVar('ID'));
		if ($record->isNew()) {
			if (!$mod_name) {
				return false;
			}
			$user_level = 0;
			$group = $member->getGroups();
			$edit_groups = get_xoops_option($mod_name, 'wp_edit_authgrp');
			$admin_groups = get_xoops_option($mod_name, 'wp_admin_authgrp');
			if (count(array_intersect($group,$edit_groups)) > 0) {
				$user_level = 1;
			}
			if (count(array_intersect($group,$admin_groups)) > 0) {
				$user_level = 10;
			}
			$record->setVar('user_login', $member->getVar('uname'));
			$record->setVar('user_email', $member->getVar('email'));
			$record->setVar('user_url', $member->getVar('url'));
			$record->setVar('user_level', $user_level);
			$record->setVar('user_icq', intval($member->getVar('user_icq')));
			$record->setVar('user_aim', $member->getVar('user_aim'));
			$record->setVar('user_yim', $member->getVar('user_yim'));
			$record->setVar('user_msn', $member->getVar('user_msnm'));
		} else {
			if ($member->getVar('uname') != $record->getVar('user_login')) {
				$record->setVar('user_login', $member->getVar('uname'));
			}
		}
		return parent::insert($record,$force,$updateOnlyChanged);
	}
	/**
	 * レコードの削除
	 * 
     * @param	object  &$record  {@link WordPressUser} object
     * @param	bool	$force		POSTメソッド以外で強制更新する場合はture
     * 
     * @return	bool    成功の時は TRUE
	 */
	function delete(&$record,$force=false)
	{
		//ユーザーの削除
		if (!(parent::delete($record,$force))) {
			return false;
		}
		//ユーザが投稿した記事及び関連情報の削除
		$criteria =& new Criteria('post_author', $record->getVar('ID'));
		$post_handler =& new WordPressPostHandler($this->db, $this->prefix);
		if (!($post_handler->deleteAll($criteria))) {
			return false;
		}
		//ユーザが作成したリンク情報の削除
		$criteria =& new Criteria('link_owner', $record->getVar('ID'));
		$link_handler =& new WordPressLinkHandler($this->db, $this->prefix);
		if (!($link_handler->deleteAll($criteria))) {
			return false;
		}

	    return true;
	}
	/**
	 * テーブルの条件検索による複数レコード取得
	 * 
	 * @param	object	$criteria 	{@link CriteriaElement} 検索条件
	 * @param	bool $id_as_key		プライマリーキーを、戻り配列のキーにする場合はtrue
	 * @return	mixed Array			検索結果レコードの配列
	 */
/*テーブルに固有のデータ処理が必要な時以外は不要
	function &getObjects($criteria = null, $id_as_key = false, $fieldlist="")
	{
		return parent::getObjects($criteria, $id_as_key, $fieldlist);
	}
*/
	/**
	 * リンクカテゴリの選択リスト用配列取得
	 * 
	 * @return	mixed Array			検索結果配列
	 */
	function getOptionArray()
	{
		$optionArray=array();
		
		$criteria =& new CriteriaElement();
		$criteria->setSort('ID');
		$users =& $this->getObjects($criteria);
		if ($users) {
			foreach ($users as $user) {
				$ID = $user->getVar('ID');
				$user_login =  $user->getVar('user_login');
				$optionArray["$ID"] = "$user_login";
			}
		}
		return $optionArray;
	}
}
}
?>