<?php
class WordPressOption  extends XoopsTableObject
{
	var $prefix;
	/**
	 * コンストラクタ
	 */
	function WordPressOption() {
	////////////////////////////////////////
	// 各クラス共通部分(書換不要)
	////////////////////////////////////////
		
		//親クラスのコンストラクタ呼出
		$this->XoopsTableObject();

	////////////////////////////////////////
	// 派生クラス固有の定義部分
	////////////////////////////////////////

		//各オブジェクト要素の定義
		$this->initVar('option_id', XOBJ_DTYPE_INT, NULL, true);
		$this->initVar('blog_id', XOBJ_DTYPE_INT, 0, true);
		$this->initVar('option_name', XOBJ_DTYPE_TXTBOX, '', true, 64);
		$this->initVar('option_can_override', XOBJ_DTYPE_TXTBOX, 'Y', true, 2);
		$this->initVar('option_type', XOBJ_DTYPE_INT, 1, true);
		$this->initVar('option_value', XOBJ_DTYPE_TXTBOX, ' ', false, 255);
		$this->initVar('option_width', XOBJ_DTYPE_INT, 20, true);
		$this->initVar('option_height', XOBJ_DTYPE_INT, 8, true);
		$this->initVar('option_description', XOBJ_DTYPE_TXTAREA, ' ', false);
		$this->initVar('option_admin_level', XOBJ_DTYPE_INT, 1, true);

		//プライマリーキーの定義
		$this->setKeyFields(array('option_id', 'blog_id', 'option_name'));
		
		//AUTO_INCREMENT属性のフィールド定義
		// - 一つのテーブル内には、AUTO_INCREMENT属性を持つフィールドは
		//   一つしかない前提です。
		$this->setAutoIncrementField('option_id');
	}
}

class WordPressOptionHandler  extends XoopsTableObjectHandler
{
	var $prefix;
	/**
	 * コンストラクタ
	 */
	function WordPressOptionHandler($db,$prefix)
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
		$this->tableName = $this->db->prefix($prefix.'options');
	}
	
	/**
     * レコードの取得(プライマリーキーによる一意検索）
     * 
     * @param	string $key 検索キー
	 *
     * @return	object  {@link WordPressOption}, FALSE on fail
     */
/*テーブルに固有のデータ処理が必要な時以外は不要
	function &get($key)
	{
		return parent::get($key);
	}
*/
	/**
     * レコードの取得(option_nameによる検索）
     * 
     * @param	string $option_name option_name
	 *
     * @return	object  {@link WordPressOption}, FALSE on fail
     */
	function &getByName($option_name)
	{
		$criteria =& new Criteria('option_name', $option_name);
		$optionObjects =& $this->getObjects($criteria);
		if ($optionObjects) {
			return $optionObjects[0];
		} else {
			return false;
		}
	}

    /**
     * レコードの保存
     * 
     * @param	object	&$record	{@link WordPressOption} object
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
     * @param	object  &$record  {@link WordPressOption} object
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
?>