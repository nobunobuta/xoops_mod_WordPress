<?php
class WordPressCategory  extends XoopsTableObject
{
	/**
	 * コンストラクタ
	 */
	function WordPressCategory() {
	////////////////////////////////////////
	// 各クラス共通部分(書換不要)
	////////////////////////////////////////
		
		//親クラスのコンストラクタ呼出
		$this->XoopsTableObject();

	////////////////////////////////////////
	// 派生クラス固有の定義部分
	////////////////////////////////////////

		//各オブジェクト要素の定義
		$this->initVar('cat_ID', XOBJ_DTYPE_INT, NULL, true);
		$this->initVar('cat_name', XOBJ_DTYPE_TXTBOX, NULL, true, 55);
		$this->initVar('category_nicename', XOBJ_DTYPE_TXTBOX, '', false,200);
		$this->initVar('category_description', XOBJ_DTYPE_TXTAREA, NULL, false);
		$this->initVar('category_parent', XOBJ_DTYPE_INT, 0, false);

		//プライマリーキーの定義
		$this->setKeyFields(array('cat_ID'));
		
		//AUTO_INCREMENT属性のフィールド定義
		// - 一つのテーブル内には、AUTO_INCREMENT属性を持つフィールドは
		//   一つしかない前提です。
		$this->setAutoIncrementField('cat_ID');
	}

	// 各オブジェクト要素の検証メソッド
	// - CleanVarsメソッドが呼ばれたときに、
	//   checkVar_メンバ名 というメソッドを定義しておけば呼ばれます。
	function checkVar_category_parent(&$value) {
		if ($value) {
			//親カテゴリの存在チェック
			if (!$this->_handler->get($value)) {
                $this->setErrors("No parent category ID");
                return false;
			}
		}
	}

	// その他のユーティリティメッソッド
	function getNumPosts() {
		$criteria =& new Criteria('category_id', $this->getVar('cat_ID'));
		$post2catHandler =& new WordPressPost2CatHandler($this->_handler->db, $this->_handler->prefix);
		return $post2catHandler->getCount($criteria);
	}
	
}

class WordPressCategoryHandler  extends XoopsTableObjectHandler
{
	var $prefix;
	var $_cache_by_nicename;
	/**
	 * コンストラクタ
	 */
	function WordPressCategoryHandler($db,$prefix)
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
		$this->tableName = $this->db->prefix($prefix.'categories');
		
		$this->_cache_by_nicename = array();

	}
	
	/**
     * レコードの取得(プライマリーキーによる一意検索）
     * 
     * @param	string $key 検索キー
	 *
     * @return	object  {@link WordPressCategory}, FALSE on fail
     */
	function &get($key)
	{
		if ($categoryObject =& parent::get($key)) {
			$this->_cache_by_nicename[$categoryObject->getVar('category_nicename')] = $categoryObject;
		}
		return $categoryObject;
	}
	/**
     * レコードの取得(category_nicenameによる検索）
     * 
     * @param	string $login 検索キー
	 *
     * @return	object  {@link WordPressUser}, FALSE on fail
     */
	function &getByNiceName($category_nicename)
	{
		if (!empty($this->_cache_by_nicename[$category_nicename])) {
			return $this->_cache_by_nicename[$category_nicename];
		} else {
			$criteria = new Criteria('category_nicename', $category_nicename);
			$categoryObjects =& $this->getObjects($criteria);
			if (count($categoryObjects) == 1) {
				$categoryObject =& $categoryObjects[0];
				$this->_cache_by_nicename[$category_nicename] = $categoryObject;
				return $categoryObject;
			}
			return false;
		}
	}
	
    /**
     * レコードの保存
     * 
     * @param	object	&$record	{@link WordPressCategory} object
     * @param	bool	$force		POSTメソッド以外で強制更新する場合はture
     * 
     * @return	bool    成功の時は TRUE
     */
	function insert(&$record, $force=false, $updateOnlyChanged=false)
	{
		//cat_nameが同名のカテゴリが存在するときはエラー
		if ($record->isNew() && $this->getCount(new Criteria('cat_name', $record->getVar('cat_name')))) {
			$this->setError('Duplicate category name ('.$record->getVar('cat_name').')');
			return false;
		}
		if ($result = parent::insert($record, $force, $updateOnlyChanged)) {
			if (trim($record->getVar('category_nicename'))=='') {
				$record->setVar('category_nicename', "category-".$record->getVar('cat_ID'));
				$record->unsetNew();
				return parent::insert($record, $force, true);
			}
		}
		$this->_cache_by_nicename = array();
		return $result;
	}

	/**
	 * レコードの削除
	 * 
     * @param	object  &$record  {@link WordPressCategory} object
     * @param	bool	$force		POSTメソッド以外で強制更新する場合はture
     * 
     * @return	bool    成功の時は TRUE
	 */
	function delete(&$record,$force=false)
	{
		//cat_IDが1のカテゴリは、削除できない
		if ($record->getVar('cat_ID') == 1) {
			$this->setError(sprintf(_LANG_C_DEFAULT_CAT, $record->getVar('cat_name')));
			return false;
		}
		//カテゴリの削除
		if (!(parent::delete($record, $force))) {
			return false;
		}
		//削除カテゴリの子カテゴリは、削除カテゴリの親カテゴリの子カテゴリに変更
		$criteria =& new Criteria('category_parent', $record->getVar('cat_ID'));
		if (!($this->updateAll('category_parent', $record->getVar('category_parent'), $criteria, $force))) {
			return false;
		}
		//削除カテゴリに属する記事は、Defaultカテゴリに一括変更
		$criteria =& new Criteria('category_id', $record->getVar('cat_ID'));
		$post2cat_handler =& new WordPressPost2CatHandler($this->db, $this->prefix);
		if (!($post2cat_handler->updateAll('category_id', 1, $criteria, $force))) {
			return false;
		}
		$this->_cache_by_nicename = array();
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
	 * テーブルの条件検索による複数レコード取得(カテゴリーツリー階層)
	 * 
	 * @param	object	$criteria 	{@link CriteriaElement} 検索条件
	 * @param	integer	$parent		再帰呼び出し時のパラメータ
	 * @param	integer	$level		再帰呼び出し時のパラメータ
	 * @param	object	$categories	再帰呼び出し時のパラメータ
	 * @return	mixed Array			検索結果レコードの配列
	 */
	function &getNestedObjects($criteria = null, $padchar='&#8211;')
	{
		$categories = null;
		$records = null;
		return $this->_getNestedObjects($criteria, $padchar, 0, 0, $categories, $records);
	}
	function &_getNestedObjects($criteria = null, $padchar='&#8211;', $parent = 0, $level = 0, &$categories, &$records)
	{
		if ($level == 0) {
			$records=array();
		}
		$pad = str_repeat($padchar, $level)." ";
		if (!$categories) {
			$categories =& $this->getObjects($criteria);
		}
		if ($categories) {
			for ($i=0; $i < count($categories); $i++) {
				$category =& $categories[$i];
				if ($parent == $category->getVar('category_parent')) {
					$cat_ID = $category->getVar('cat_ID');
					$category->setVar('cat_name', $pad.$category->getVar('cat_name'));
					$category->setExtraVar('category_level', $level+1);
					$records[] = $category;
					$this->_getNestedObjects($criteria, $padchar, $cat_ID, $level+1, $categories, $records);
				}
			}
		}
		return $records;
	}
	
	/**
	 * カテゴリの親カテゴリ選択リスト用配列取得
	 * 
	 * @param	integer	$currentcat 現在のカテゴリID
	 * @param	integer	$parent		再帰呼び出し時のパラメータ
	 * @param	integer	$level		再帰呼び出し時のパラメータ
	 * @param	object	$categories	再帰呼び出し時のパラメータ
	 * @return	mixed Array			検索結果配列
	 */
	function getParentOptionArray($currentcat = 0, $parent = 0, $level = 0, $categories = false)
	{
		$optionArray=array();
		$pad = str_repeat('&#8211;', $level)." ";
		
		if (!$categories) {
			$criteria =& new CriteriaElement();
			$criteria->setSort('cat_name');
			$categories =& $this->getObjects($criteria);
		}
		if ($categories) {
			foreach ($categories as $category) {
				$cat_ID = $category->getVar('cat_ID');
				if ($currentcat != $cat_ID && $parent == $category->getVar('category_parent')) {
					$optionArray["$cat_ID"] = $pad.$category->getVar('cat_name');
					$optionArray += $this->getParentOptionArray($currentcat, $cat_ID, $level + 1, $categories);
				}
			}
		}
		return $optionArray;
	}
}
?>