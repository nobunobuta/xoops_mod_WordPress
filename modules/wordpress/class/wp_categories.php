<?php
if( ! class_exists( 'WordPressCategory' ) ) {
class WordPressCategory  extends XoopsTableObject
{
	/**
	 * ���󥹥ȥ饯��
	 */
	function WordPressCategory() {
	////////////////////////////////////////
	// �ƥ��饹������ʬ(������)
	////////////////////////////////////////
		
		//�ƥ��饹�Υ��󥹥ȥ饯���ƽ�
		$this->XoopsTableObject();

	////////////////////////////////////////
	// �������饹��ͭ�������ʬ
	////////////////////////////////////////

		//�ƥ��֥����������Ǥ����
		$this->initVar('cat_ID', XOBJ_DTYPE_INT, NULL, true);
		$this->initVar('cat_name', XOBJ_DTYPE_TXTBOX, NULL, true, 255);
		$this->initVar('category_nicename', XOBJ_DTYPE_TXTBOX, '', false,200);
		$this->initVar('category_description', XOBJ_DTYPE_TXTAREA, NULL, false);
		$this->initVar('category_parent', XOBJ_DTYPE_INT, 0, false);

		//�ץ饤�ޥ꡼���������
		$this->setKeyFields(array('cat_ID'));
		
		//AUTO_INCREMENT°���Υե���������
		// - ��ĤΥơ��֥���ˤϡ�AUTO_INCREMENT°������ĥե�����ɤ�
		//   ��Ĥ����ʤ�����Ǥ���
		$this->setAutoIncrementField('cat_ID');
	}

	// �ƥ��֥����������Ǥθ��ڥ᥽�å�
	// - CleanVars�᥽�åɤ��ƤФ줿�Ȥ��ˡ�
	//   checkVar_����̾ �Ȥ����᥽�åɤ�������Ƥ����иƤФ�ޤ���
	function checkVar_category_parent(&$value) {
		if ($value) {
			//�ƥ��ƥ����¸�ߥ����å�
			if (!$this->_handler->get($value)) {
                $this->setErrors("No parent category ID");
                return false;
			}
		}
	}

	// ����¾�Υ桼�ƥ���ƥ���å��å�
	function getNumPosts() {
		$criteria =& new Criteria('category_id', $this->getVar('cat_ID'));
		$post2catHandler =& new WordPressPost2CatHandler($this->_handler->db, $this->_handler->prefix, $this->_handler->module);
		return $post2catHandler->getCount($criteria);
	}
	
}

class WordPressCategoryHandler  extends XoopsCachedTableObjectHandler
{
	var $prefix;
	var $module;
	var $_cache_by_nicename;
	/**
	 * ���󥹥ȥ饯��
	 */
	function WordPressCategoryHandler($db,$prefix,$module)
	{
	////////////////////////////////////////
	// �ƥ��饹������ʬ(������)
	////////////////////////////////////////

		//�ƥ��饹�Υ��󥹥ȥ饯���ƽ�
		$this->XoopsTableObjectHandler($db);
		
	////////////////////////////////////////
	// �������饹��ͭ�������ʬ
	////////////////////////////////////////
		//�ϥ�ɥ���оݥơ��֥�̾���
		$this->prefix = $prefix;
		$this->module = $module;
		$this->tableName = $this->db->prefix($prefix.'categories');
		
		$this->_cache_by_nicename = array();

	}
	
	/**
     * �쥳���ɤμ���(�ץ饤�ޥ꡼�����ˤ���ո�����
     * 
     * @param	string $key ��������
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
     * �쥳���ɤμ���(category_nicename�ˤ�븡����
     * 
     * @param	string $login ��������
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
     * �쥳���ɤ���¸
     * 
     * @param	object	&$record	{@link WordPressCategory} object
     * @param	bool	$force		POST�᥽�åɰʳ��Ƕ��������������ture
     * 
     * @return	bool    �����λ��� TRUE
     */
	function insert(&$record, $force=false, $updateOnlyChanged=false)
	{
		//cat_name��Ʊ̾�Υ��ƥ��꤬¸�ߤ���Ȥ��ϥ��顼
		if ($record->isNew() && $this->getCount(new Criteria('cat_name', $record->getVar('cat_name')))) {
			$this->setError('Duplicate category name ('.$record->getVar('cat_name').')');
			return false;
		}
		if ($result = parent::insert($record, $force, $updateOnlyChanged)) {
			if (trim($record->getVar('category_nicename'))=='') {
				$record->setVar('category_nicename', "category-".$record->getVar('cat_ID'), true);
				$record->unsetNew();
				return parent::insert($record, $force, true);
			}
		}
		$this->_cache_by_nicename = array();
		return $result;
	}

	/**
	 * �쥳���ɤκ��
	 * 
     * @param	object  &$record  {@link WordPressCategory} object
     * @param	bool	$force		POST�᥽�åɰʳ��Ƕ��������������ture
     * 
     * @return	bool    �����λ��� TRUE
	 */
	function delete(&$record,$force=false)
	{
		//cat_ID��1�Υ��ƥ���ϡ�����Ǥ��ʤ�
		if ($record->getVar('cat_ID') == 1) {
			$this->setError(sprintf(_LANG_C_DEFAULT_CAT, $record->getVar('cat_name')));
			return false;
		}
		//���ƥ���κ��
		if (!(parent::delete($record, $force))) {
			return false;
		}
		//������ƥ���λҥ��ƥ���ϡ�������ƥ���οƥ��ƥ���λҥ��ƥ�����ѹ�
		$criteria =& new Criteria('category_parent', $record->getVar('cat_ID'));
		if (!($this->updateAll('category_parent', $record->getVar('category_parent'), $criteria, $force))) {
			return false;
		}
		//������ƥ����°���뵭���ϡ�Default���ƥ���˰���ѹ�
		$criteria =& new Criteria('category_id', $record->getVar('cat_ID'));
		$post2cat_handler =& new WordPressPost2CatHandler($this->db, $this->prefix, $this->module);
		if (!($post2cat_handler->updateAll('category_id', 1, $criteria, $force))) {
			return false;
		}
		$this->_cache_by_nicename = array();
		return true;
	}
	/**
	 * �ơ��֥�ξ�︡���ˤ��ʣ���쥳���ɼ���
	 * 
	 * @param	object	$criteria 	{@link CriteriaElement} �������
	 * @param	bool $id_as_key		�ץ饤�ޥ꡼�������������Υ����ˤ������true
	 * @return	mixed Array			������̥쥳���ɤ�����
	 */
/*�ơ��֥�˸�ͭ�Υǡ���������ɬ�פʻ��ʳ�������
	function &getObjects($criteria = null, $id_as_key = false, $fieldlist="")
	{
		return parent::getObjects($criteria, $id_as_key, $fieldlist);
	}
*/
	/**
	 * �ơ��֥�ξ�︡���ˤ��ʣ���쥳���ɼ���(���ƥ��꡼�ĥ꡼����)
	 * 
	 * @param	object	$criteria 	{@link CriteriaElement} �������
	 * @param	integer	$parent		�Ƶ��ƤӽФ����Υѥ�᡼��
	 * @param	integer	$level		�Ƶ��ƤӽФ����Υѥ�᡼��
	 * @param	object	$categories	�Ƶ��ƤӽФ����Υѥ�᡼��
	 * @return	mixed Array			������̥쥳���ɤ�����
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
					$category->setVar('cat_name', $pad.$category->getVar('cat_name'), true);
					$category->setExtraVar('category_level', $level+1);
					$records[] = $category;
					$this->_getNestedObjects($criteria, $padchar, $cat_ID, $level+1, $categories, $records);
				}
			}
		}
		return $records;
	}
	
	/**
	 * ���ƥ���οƥ��ƥ�������ꥹ�����������
	 * 
	 * @param	integer	$currentcat ���ߤΥ��ƥ���ID
	 * @param	integer	$parent		�Ƶ��ƤӽФ����Υѥ�᡼��
	 * @param	integer	$level		�Ƶ��ƤӽФ����Υѥ�᡼��
	 * @param	object	$categories	�Ƶ��ƤӽФ����Υѥ�᡼��
	 * @return	mixed Array			�����������
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
}
?>