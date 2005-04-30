<?php
if( ! class_exists( 'WordPressLink' ) ) {
class WordPressLink  extends XoopsTableObject
{
	/**
	 * コンストラクタ
	 */
	function WordPressLink() {
	////////////////////////////////////////
	// 各クラス共通部分(書換不要)
	////////////////////////////////////////
		
		//親クラスのコンストラクタ呼出
		$this->XoopsTableObject();

	////////////////////////////////////////
	// 派生クラス固有の定義部分
	////////////////////////////////////////

		//各オブジェクト要素の定義
		$this->initVar('link_id', XOBJ_DTYPE_INT, NULL, true);
		$this->initVar('link_url', XOBJ_DTYPE_URL, '', false, 255);
		$this->initVar('link_name', XOBJ_DTYPE_TXTBOX, '', false, 255);
		$this->initVar('link_image', XOBJ_DTYPE_TXTBOX, '', false, 255);
		$this->initVar('link_target', XOBJ_DTYPE_TXTBOX, '', false, 255);
		$this->initVar('link_category', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('link_description', XOBJ_DTYPE_TXTBOX, '', false,255);
		$this->initVar('link_visible', XOBJ_DTYPE_TXTBOX, 'Y', false, 2);
		$this->initVar('link_owner', XOBJ_DTYPE_INT, 1, false);
		$this->initVar('link_rating', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('link_updated', XOBJ_DTYPE_TXTBOX, '0000-00-00 00:00:00', false, 20);
		$this->initVar('link_rel', XOBJ_DTYPE_TXTBOX, NULL, false, 200);
		$this->initVar('link_notes', XOBJ_DTYPE_TXTAREA, NULL, false);
		$this->initVar('link_rss', XOBJ_DTYPE_URL, '', false, 255);

		//プライマリーキーの定義
		$this->setKeyFields(array('link_id'));

		//AUTO_INCREMENT属性のフィールド定義
		// - 一つのテーブル内には、AUTO_INCREMENT属性を持つフィールドは
		//   一つしかない前提です。
		$this->setAutoIncrementField('link_id');
	}
	
}

class WordPressLinkHandler  extends XoopsTableObjectHandler
{
	var $prefix;
	/**
	 * コンストラクタ
	 */
	function WordPressLinkHandler($db,$prefix)
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
		$this->tableName = $this->db->prefix($prefix.'links');
	}
	
	/**
     * レコードの取得(プライマリーキーによる一意検索）
     * 
     * @param	string $key 検索キー
	 *
     * @return	object  {@link WordPressUser}, FALSE on fail
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
     * @param	object	&$record	{@link WordPressUser} object
     * @param	bool	$force		POSTメソッド以外で強制更新する場合はture
     * 
     * @return	bool    成功の時は TRUE
     */
/*テーブルに固有のデータ処理が必要な時以外は不要
	function insert(&$record,$force=false,$updateOnlyChanged=false)
	{
		return parent::insert($record,$force,$updateOnlyChanged);
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
}
}
?>