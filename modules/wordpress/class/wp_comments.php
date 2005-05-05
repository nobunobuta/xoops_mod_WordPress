<?php
if( ! class_exists( 'WordPressComment' ) ) {
class WordPressComment extends XoopsTableObject
{
	var $prefix;
	/**
	 * コンストラクタ
	 */
	function WordPressComment() {
	////////////////////////////////////////
	// 各クラス共通部分(書換不要)
	////////////////////////////////////////

		//親クラスのコンストラクタ呼出
		$this->XoopsTableObject();

	////////////////////////////////////////
	// 派生クラス固有の定義部分
	////////////////////////////////////////

		//各オブジェクト要素の定義
		$this->initVar('comment_ID', XOBJ_DTYPE_INT, NULL, true);
		$this->initVar('comment_post_ID', XOBJ_DTYPE_INT, 0, true);
		$this->initVar('comment_author', XOBJ_DTYPE_TXTBOX, '', false, 255);
		$this->initVar('comment_author_email', XOBJ_DTYPE_EMAIL, '', false, 100);
		$this->initVar('comment_author_url', XOBJ_DTYPE_URL, '', false, 100);
		$this->initVar('comment_author_IP', XOBJ_DTYPE_TXTBOX, '', false,100);
		$this->initVar('comment_date', XOBJ_DTYPE_TXTBOX, '0000-00-00 00:00:00', false, 20);
		$this->initVar('comment_content', XOBJ_DTYPE_TXTAREA, null, false);
		$this->initVar('comment_karma', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('comment_approved', XOBJ_DTYPE_TXTBOX, '1', false, 5);
		$this->initVar('comment_agent', XOBJ_DTYPE_TXTBOX, '', false, 255);
		$this->initVar('comment_type', XOBJ_DTYPE_TXTBOX, '', false, 20);
		$this->initVar('comment_parent', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('user_id', XOBJ_DTYPE_INT, 0, false);

		$this->setAttribute('dohtml', 1);
		$this->setAttribute('doxcode', 0);
		$this->setAttribute('dosmiley', 0);
		$this->setAttribute('doimage', 0);
		$this->setAttribute('dobr', 0);
		//プライマリーキーの定義
		$this->setKeyFields(array('comment_ID'));

		//AUTO_INCREMENT属性のフィールド定義
		// - 一つのテーブル内には、AUTO_INCREMENT属性を持つフィールドは
		//   一つしかない前提です。
		$this->setAutoIncrementField('comment_ID');
	}

	function approve($force=false) {
		return $this->_handler->approve($this->getVar('comment_ID'),$force);
	}
	
	function unapprove($force=false) {
		return $this->_handler->unapprove($this->getVar('comment_ID'),$force);
	}
}

class WordPressCommentHandler  extends XoopsTableObjectHandler
{
	var $prefix;
	var $module;
	/**
	 * コンストラクタ
	 */
	function WordPressCommentHandler($db,$prefix,$module)
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
		$this->module = $module;
		$this->tableName = $this->db->prefix($prefix.'comments');
	}
	
	/**
     * レコードの取得(プライマリーキーによる一意検索）
     * 
     * @param	string $key 検索キー
	 *
     * @return	object  {@link WordPressPost2Cat}, FALSE on fail
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
     * @param	object	&$record	{@link WordPressPost2Cat} object
     * @param	bool	$force		POSTメソッド以外で強制更新する場合はture
     * 
     * @return	bool    成功の時は TRUE
     */
/*テーブルに固有のデータ処理が必要な時以外は不要
	function insert(&$record,$force=false,$updateOnlyChanged=false)
	{
		return parent::insert($record, $force, $updateOnlyChanged);
	}
*/
	/**
	 * レコードの削除
	 * 
     * @param	object  &$record  {@link WordPressPost2Cat} object
     * @param	bool	$force		POSTメソッド以外で強制更新する場合はture
     * 
     * @return	bool    成功の時は TRUE
	 */
/*テーブルに固有のデータ処理が必要な時以外は不要
	function delete(&$record,$force=false)
	{
		return parent::delete($record,$force);
	}
*/
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

	function approve($comment_ID, $force=false) {
		$criteria = new Criteria('comment_ID', $comment_ID);
		return $this->updateAll('comment_approved', '1', $criteria, $force);
	}
	function unapprove($comment_ID, $force=false) {
		$criteria = new Criteria('comment_ID', $comment_ID);
		return $this->updateAll('comment_approved', '0', $criteria, $force);
	}
}
}
?>