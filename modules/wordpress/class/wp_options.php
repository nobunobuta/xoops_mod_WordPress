<?php
class WordPressOption  extends XoopsTableObject
{
	var $prefix;
	/**
	 * ���󥹥ȥ饯��
	 */
	function WordPressOption() {
	////////////////////////////////////////
	// �ƥ��饹������ʬ(������)
	////////////////////////////////////////
		
		//�ƥ��饹�Υ��󥹥ȥ饯���ƽ�
		$this->XoopsTableObject();

	////////////////////////////////////////
	// �������饹��ͭ�������ʬ
	////////////////////////////////////////

		//�ƥ��֥����������Ǥ����
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

		//�ץ饤�ޥ꡼���������
		$this->setKeyFields(array('option_id', 'blog_id', 'option_name'));
		
		//AUTO_INCREMENT°���Υե���������
		// - ��ĤΥơ��֥���ˤϡ�AUTO_INCREMENT°������ĥե�����ɤ�
		//   ��Ĥ����ʤ�����Ǥ���
		$this->setAutoIncrementField('option_id');
	}
}

class WordPressOptionHandler  extends XoopsTableObjectHandler
{
	var $prefix;
	/**
	 * ���󥹥ȥ饯��
	 */
	function WordPressOptionHandler($db,$prefix)
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
		$this->tableName = $this->db->prefix($prefix.'options');
	}
	
	/**
     * �쥳���ɤμ���(�ץ饤�ޥ꡼�����ˤ���ո�����
     * 
     * @param	string $key ��������
	 *
     * @return	object  {@link WordPressOption}, FALSE on fail
     */
/*�ơ��֥�˸�ͭ�Υǡ���������ɬ�פʻ��ʳ�������
	function &get($key)
	{
		return parent::get($key);
	}
*/
	/**
     * �쥳���ɤμ���(option_name�ˤ�븡����
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
     * �쥳���ɤ���¸
     * 
     * @param	object	&$record	{@link WordPressOption} object
     * @param	bool	$force		POST�᥽�åɰʳ��Ƕ��������������ture
     * 
     * @return	bool    �����λ��� TRUE
     */
/*�ơ��֥�˸�ͭ�Υǡ���������ɬ�פʻ��ʳ�������
	function insert(&$record,$force=false,$updateOnlyChanged=false)
	{
		return parent::insert($record, $force, $updateOnlyChanged);
	}
*/
	/**
	 * �쥳���ɤκ��
	 * 
     * @param	object  &$record  {@link WordPressOption} object
     * @param	bool	$force		POST�᥽�åɰʳ��Ƕ��������������ture
     * 
     * @return	bool    �����λ��� TRUE
	 */
/*�ơ��֥�˸�ͭ�Υǡ���������ɬ�פʻ��ʳ�������
	function delete(&$record,$force=false)
	{
		return parent::delete($record,$force);
	}
*/
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
}
?>