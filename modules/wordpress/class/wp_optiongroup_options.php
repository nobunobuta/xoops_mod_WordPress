<?php
if( ! class_exists( 'WordPressOptionGroup2Option' ) ) {
class WordPressOptionGroup2Option  extends XoopsTableObject
{
	var $prefix;
	/**
	 * コンストラクタ
	 */
	function WordPressOptionGroup2Option() {
	////////////////////////////////////////
	// 各クラス共通部分(書換不要)
	////////////////////////////////////////
		
		//親クラスのコンストラクタ呼出
		$this->XoopsTableObject();

	////////////////////////////////////////
	// 派生クラス固有の定義部分
	////////////////////////////////////////

		//各オブジェクト要素の定義
		$this->initVar('group_id', XOBJ_DTYPE_INT, NULL, true);
		$this->initVar('option_id', XOBJ_DTYPE_INT, 0, true);
		$this->initVar('seq', XOBJ_DTYPE_INT, 0, true);

		//プライマリーキーの定義
		$this->setKeyFields(array('group_id', 'option_id'));
	}
}

class WordPressOptionGroup2OptionHandler  extends XoopsTableObjectHandler
{
	var $prefix;
	/**
	 * コンストラクタ
	 */
	function WordPressOptionGroup2OptionHandler($db,$prefix)
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
		$this->tableName = $this->db->prefix($prefix.'optiongroup_options');
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
}
}
?>