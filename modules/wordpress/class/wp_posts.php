<?php
class WordPressPost  extends XoopsTableObject
{
	var $prefix;
	/**
	 * コンストラクタ
	 */
	function WordPressPost() {
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
		$this->initVar('post_author', XOBJ_DTYPE_INT, 0, true);
		$this->initVar('post_date', XOBJ_DTYPE_TXTBOX, '0000-00-00 00:00:00', false,20);
		$this->initVar('post_content', XOBJ_DTYPE_TXTAREA, NULL, false);
		$this->initVar('post_title', XOBJ_DTYPE_TXTAREA, NULL, false);
		$this->initVar('post_category', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('post_excerpt', XOBJ_DTYPE_TXTAREA, NULL);
		$this->initVar('post_lat', XOBJ_DTYPE_FLOAT, NULL, false);
		$this->initVar('post_lon', XOBJ_DTYPE_FLOAT, NULL, false);
		$this->initVar('post_status', XOBJ_DTYPE_TXTBOX, 'publish', false,10);
		$this->initVar('comment_status', XOBJ_DTYPE_TXTBOX, 'open', false,10);
		$this->initVar('ping_status', XOBJ_DTYPE_TXTBOX, 'open', false,10);
		$this->initVar('post_password', XOBJ_DTYPE_TXTBOX, '', false,20);
		$this->initVar('post_name', XOBJ_DTYPE_TXTBOX, '', false,200);
		$this->initVar('to_ping', XOBJ_DTYPE_TXTBOX, NULL, false);
		$this->initVar('pinged', XOBJ_DTYPE_SOURCE, NULL, false);
		$this->initVar('post_modified', XOBJ_DTYPE_TXTBOX, NULL, false,100);
		$this->initVar('post_content_filtered', XOBJ_DTYPE_SOURCE, NULL, false);
		
		$this->setAttribute('dohtml', 1);
		$this->setAttribute('doxcode', 0);
		$this->setAttribute('dosmiley', 0);
		$this->setAttribute('doimage', 0);
		$this->setAttribute('dobr', 0);

		//プライマリーキーの定義
		$this->setKeyFields(array('ID'));

		//AUTO_INCREMENT属性のフィールド定義
		// - 一つのテーブル内には、AUTO_INCREMENT属性を持つフィールドは
		//   一つしかない前提です。
		$this->setAutoIncrementField('ID');
	}
	function assignCategories($categories, $force=false)
	{
		$post2catHandler =& new WordPressPost2CatHandler($this->_handler->db, $this->_handler->prefix);
		$criteria = new Criteria('post_id', $this->getVar('ID'));
		$oldCategories =& $post2catHandler->getObjects($criteria);
		$oldCategoryArray = array();
		foreach($oldCategories as $oldCategory) {
			if (!in_array($oldCategory->getVar('category_id'), $categories)) {
				$post2catHandler->delete($oldCategory, $force);
			} else {
				$oldCategoryArray[] = $oldCategory->getVar('category_id');
			}
		}
		// Add any?
		foreach ($categories as $category) {
			if (!in_array($category, $oldCategoryArray)) {
				$post2cat =&  $post2catHandler->create();
				$post2cat->setVar('post_id', $this->getVar('ID'));
				$post2cat->setVar('category_id', $category);
				$post2catHandler->insert($post2cat, $force);
				unset($post2cat);
			}
		}
	}
	
	function &getCategories()
	{
		$post2catHandler =& new WordPressPost2CatHandler($this->_handler->db, $this->_handler->prefix);
		$criteria = new Criteria('post_id', $this->getVar('ID'));
		$categoryObjects =& $post2catHandler->getObjects($criteria);
		return $categoryObjects;
	}
}

class WordPressPostHandler  extends XoopsTableObjectHandler
{
	var $prefix;
	/**
	 * コンストラクタ
	 */
	function WordPressPostHandler($db,$prefix)
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
		$this->tableName = $this->db->prefix($prefix.'posts');
	}
	
	/**
     * レコードの取得(プライマリーキーによる一意検索）
     * 
     * @param	string $key 検索キー
	 *
     * @return	object  {@link WordPressPost}, FALSE on fail
     */
/*テーブルに固有のデータ処理が必要な時以外は不要
	function &get($key)
	{
		return parent::get($key);
	}
*/

    /**
     * レコードの保存
     * 
     * @param	object	&$record	{@link WordPressPost} object
     * @param	bool	$force		POSTメソッド以外で強制更新する場合はture
     * 
     * @return	bool    成功の時は TRUE
     */
	function insert(&$record,$force=false,$updateOnlyChanged=false)
	{
		if ($result = parent::insert($record, $force, $updateOnlyChanged)) {
			if (trim($record->getVar('post_name'))=='') {
				$record->setVar('post_name', "post-".$record->getVar('ID'));
				$record->unsetNew();
				return parent::insert($record, $force, true);
			}
		}
		return $result;
	}

	/**
	 * レコードの削除
	 * 
     * @param	object  &$record  {@link WordPressPost} object
     * @param	bool	$force		POSTメソッド以外で強制更新する場合はture
     * 
     * @return	bool    成功の時は TRUE
	 */
	function delete(&$record,$force=false)
	{
		//記事のの削除
		if (!(parent::delete($record, $force))) {
			return false;
		}
		//記事に対するコメントの削除
		$criteria =& new Criteria('comment_post_ID', $record->getVar('ID'));
		$comment_handler =& new WordPressCommentHandler($this->db, $this->prefix);
		if (!($comment_handler->deleteAll($criteria, $force))) {
			return false;
		}
		//記事に対するコメントの削除(XOOPSコメント)
		if ($xoopsOption['wp_use_xoops_comments']) {
			$criteria =& new CriteriaCompo(new Criteria('com_modid', $xoopsModule->getVar('mid')));
			$criteria->add(new Criteria('com_itemid', $record->getVar('ID')));
			$xcommentHandler = xoops_gethandler('comment');
			if (!($xcommentHandler->deleteAll($criteria))) {
				return false;
			}
		}
		//記事に関連するカテゴリー情報の削除
		$criteria =& new Criteria('post_id', $record->getVar('ID'));
		$post2cat_handler =& new WordPressPost2CatHandler($this->db, $this->prefix);
		if (!($post2cat_handler->deleteAll($criteria, $force))) {
			return false;
		}

		//記事に関連するメタ情報の削除
		$criteria =& new Criteria('post_id', $record->getVar('ID'));
		$postmeta_handler =& new WordPressPostMetaHandler($this->db, $this->prefix);
		if (!($postmeta_handler->deleteAll($criteria, $force))) {
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
	 * テーブルの条件検索による複数レコード削除
	 * 
	 * @param	object	$criteria 	{@link CriteriaElement} 検索条件
     * @param	bool	$force		POSTメソッド以外で強制更新する場合はture
     * 
     * @return	bool    成功の時は TRUE
	 */
	function &deleteAll($criteria = null, $force = false)
	{
		//条件に合致する記事ID一覧の取得
		$posts =& $this->getObjects($criteria);
		$IDs = array();
		foreach($posts as $post) {
			$IDs[] = $post->getVar('ID');
		}
		
		if (!(parent::deleteAll($criteria, $id_as_key))) {
			return false;
		}
		if ($IDs) {
			$IDs = "(".implode(',', $IDs).")";
			//記事に対するコメントの削除
			$criteria =& new Criteria('comment_post_ID', $IDs, 'IN');
			$comment_handler =& new WordPressCommentHandler($this->db, $this->prefix);
			if (!($comment_handler->deleteAll($criteria, $force))) {
				return false;
			}
			//記事に関連するカテゴリー情報の削除
			$criteria =& new Criteria('post_id', $IDs, 'IN');
			$post2cat_handler =& new WordPressPost2CatHandler($this->db, $this->prefix);
			if (!($post2cat_handler->deleteAll($criteria, $force))) {
				return false;
			}

			//記事に関連するメタ情報の削除
			$criteria =& new Criteria('post_id', $IDs, 'IN');
			$postmeta_handler =& new WordPressPostMetaHandler($this->db, $this->prefix);
			if (!($postmeta_handler->deleteAll($criteria, $force))) {
				return false;
			}
		}
	}
}
?>