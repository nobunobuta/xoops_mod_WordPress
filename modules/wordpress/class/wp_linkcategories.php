<?php
if( ! class_exists( 'WordPressLinkCategory' ) ) {
class WordPressLinkCategory  extends XoopsTableObject
{
	/**
	 * コンストラクタ
	 */
	function WordPressLinkCategory() {
	////////////////////////////////////////
	// 各クラス共通部分(書換不要)
	////////////////////////////////////////
		
		//親クラスのコンストラクタ呼出
		$this->XoopsTableObject();

	////////////////////////////////////////
	// 派生クラス固有の定義部分
	////////////////////////////////////////

		//各オブジェクト要素の定義
		$this->initVar('cat_id', XOBJ_DTYPE_INT, NULL, true);
		$this->initVar('cat_name', XOBJ_DTYPE_TXTBOX, NULL, true, 255);
		$this->initVar('auto_toggle', XOBJ_DTYPE_TXTBOX, 'N', false,2);
		$this->initVar('show_images', XOBJ_DTYPE_TXTBOX, 'Y', false, 2);
		$this->initVar('show_description', XOBJ_DTYPE_TXTBOX, 'N', false, 2);
		$this->initVar('show_rating', XOBJ_DTYPE_TXTBOX, 'Y', false, 2);
		$this->initVar('show_updated', XOBJ_DTYPE_TXTBOX, 'Y', false, 2);
		$this->initVar('sort_order', XOBJ_DTYPE_TXTBOX, 'name', false, 64);
		$this->initVar('sort_desc', XOBJ_DTYPE_TXTBOX, 'N', false, 2);
		$this->initVar('text_before_link', XOBJ_DTYPE_TXTBOX, '<li>', false, 128);
		$this->initVar('text_after_link', XOBJ_DTYPE_TXTBOX, '<br />', false, 128);
		$this->initVar('text_after_all', XOBJ_DTYPE_TXTBOX, '</li>', false, 128);
		$this->initVar('list_limit', XOBJ_DTYPE_INT, -1, false);
		
		//プライマリーキーの定義
		$this->setKeyFields(array('cat_id'));
		
		//AUTO_INCREMENT属性のフィールド定義
		// - 一つのテーブル内には、AUTO_INCREMENT属性を持つフィールドは
		//   一つしかない前提です。
		$this->setAutoIncrementField('cat_id');
	}
}

class WordPressLinkCategoryHandler  extends XoopsTableObjectHandler
{
	var $prefix;
	/**
	 * コンストラクタ
	 */
	function WordPressLinkCategoryHandler($db,$prefix)
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
		$this->tableName = $this->db->prefix($prefix.'linkcategories');
	}
	
	/**
     * レコードの取得(プライマリーキーによる一意検索）
     * 
     * @param	string $key 検索キー
	 *
     * @return	object  {@link WordPressLinkCategory}, FALSE on fail
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
     * @param	object	&$record	{@link WordPressLinkCategory} object
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
     * @param	object  &$record  {@link WordPressLinkCategory} object
     * @param	bool	$force		POSTメソッド以外で強制更新する場合はture
     * 
     * @return	bool    成功の時は TRUE
	 */
	function delete(&$record,$force=false)
	{
		//cat_IDが1のカテゴリは、削除できない
		if ($record->getVar('cat_id') == 1) {
			$this->setError(sprintf(_LANG_WLC_DONOT_DELETE, $record->getVar('cat_name')));
			return false;
		}
		//カテゴリの削除
		if (!(parent::delete($record, $force))) {
			return false;
		}
		//削除カテゴリに属するリンクは、Defaultカテゴリに一括変更
		$criteria =& new Criteria('link_category', $record->getVar('cat_id'));
		$link_handler =& new WordPressLinkHandler($this->db, $this->prefix);
		if (!($link_handler->updateAll('link_category', 1, $criteria, $force))) {
			return false;
		}
		return true;

	}
	/**
	 * テーブルの条件検索による複数レコード取得
	 * 
	 * @param	object	$criteria 	{@link WordPressLinkCategory} 検索条件
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
		$criteria->setSort('cat_id');
		$categories =& $this->getObjects($criteria);
		if ($categories) {
			foreach ($categories as $category) {
				$cat_id = $category->getVar('cat_id');
				$cat_name =  $category->getVar('cat_name');
				$auto_toggle = ($category->getVar('auto_toggle') == 'Y') ? ' (auto toggle)' : '';
				$optionArray["$cat_id"] = "$cat_id :  $cat_name$auto_toggle";
			}
		}
		return $optionArray;
	}
	/**
	 * リンクカテゴリのソート順選択リスト用配列取得
	 * 
	 * @return	mixed Array			検索結果配列
	 */
	function getSortOptionArray()
	{
		return array(
			'link_id' => 'Link ID',
			'link_name' => 'Name',
			'link_url' => 'URI',
			'link_desc' => 'Description',
			'link_owner' => 'Owner',
			'link_rating' => 'Rating',
		);
	}
}
}
?>