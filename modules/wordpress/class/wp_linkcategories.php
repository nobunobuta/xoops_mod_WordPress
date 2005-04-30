<?php
if( ! class_exists( 'WordPressLinkCategory' ) ) {
class WordPressLinkCategory  extends XoopsTableObject
{
	/**
	 * ���󥹥ȥ饯��
	 */
	function WordPressLinkCategory() {
	////////////////////////////////////////
	// �ƥ��饹������ʬ(������)
	////////////////////////////////////////
		
		//�ƥ��饹�Υ��󥹥ȥ饯���ƽ�
		$this->XoopsTableObject();

	////////////////////////////////////////
	// �������饹��ͭ�������ʬ
	////////////////////////////////////////

		//�ƥ��֥����������Ǥ����
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
		
		//�ץ饤�ޥ꡼���������
		$this->setKeyFields(array('cat_id'));
		
		//AUTO_INCREMENT°���Υե���������
		// - ��ĤΥơ��֥���ˤϡ�AUTO_INCREMENT°������ĥե�����ɤ�
		//   ��Ĥ����ʤ�����Ǥ���
		$this->setAutoIncrementField('cat_id');
	}
}

class WordPressLinkCategoryHandler  extends XoopsTableObjectHandler
{
	var $prefix;
	/**
	 * ���󥹥ȥ饯��
	 */
	function WordPressLinkCategoryHandler($db,$prefix)
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
		$this->tableName = $this->db->prefix($prefix.'linkcategories');
	}
	
	/**
     * �쥳���ɤμ���(�ץ饤�ޥ꡼�����ˤ���ո�����
     * 
     * @param	string $key ��������
	 *
     * @return	object  {@link WordPressLinkCategory}, FALSE on fail
     */
/*�ơ��֥�˸�ͭ�Υǡ���������ɬ�פʻ��ʳ�������
	function &get($key)
	{
		return parent::get($key);
	}
*/
    /**
     * �쥳���ɤ���¸
     * 
     * @param	object	&$record	{@link WordPressLinkCategory} object
     * @param	bool	$force		POST�᥽�åɰʳ��Ƕ��������������ture
     * 
     * @return	bool    �����λ��� TRUE
     */
/*�ơ��֥�˸�ͭ�Υǡ���������ɬ�פʻ��ʳ�������
	function insert(&$record,$force=false,$updateOnlyChanged=false)
	{
		return parent::insert($record,$force,$updateOnlyChanged);
	}
*/
	/**
	 * �쥳���ɤκ��
	 * 
     * @param	object  &$record  {@link WordPressLinkCategory} object
     * @param	bool	$force		POST�᥽�åɰʳ��Ƕ��������������ture
     * 
     * @return	bool    �����λ��� TRUE
	 */
	function delete(&$record,$force=false)
	{
		//cat_ID��1�Υ��ƥ���ϡ�����Ǥ��ʤ�
		if ($record->getVar('cat_id') == 1) {
			$this->setError(sprintf(_LANG_WLC_DONOT_DELETE, $record->getVar('cat_name')));
			return false;
		}
		//���ƥ���κ��
		if (!(parent::delete($record, $force))) {
			return false;
		}
		//������ƥ����°�����󥯤ϡ�Default���ƥ���˰���ѹ�
		$criteria =& new Criteria('link_category', $record->getVar('cat_id'));
		$link_handler =& new WordPressLinkHandler($this->db, $this->prefix);
		if (!($link_handler->updateAll('link_category', 1, $criteria, $force))) {
			return false;
		}
		return true;

	}
	/**
	 * �ơ��֥�ξ�︡���ˤ��ʣ���쥳���ɼ���
	 * 
	 * @param	object	$criteria 	{@link WordPressLinkCategory} �������
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
	 * ��󥯥��ƥ��������ꥹ�����������
	 * 
	 * @return	mixed Array			�����������
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
	 * ��󥯥��ƥ���Υ����Ƚ�����ꥹ�����������
	 * 
	 * @return	mixed Array			�����������
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