<?php
if( ! class_exists( 'WordPressLink' ) ) {
class WordPressLink  extends XoopsTableObject
{
	/**
	 * ���󥹥ȥ饯��
	 */
	function WordPressLink() {
	////////////////////////////////////////
	// �ƥ��饹������ʬ(������)
	////////////////////////////////////////
		
		//�ƥ��饹�Υ��󥹥ȥ饯���ƽ�
		$this->XoopsTableObject();

	////////////////////////////////////////
	// �������饹��ͭ�������ʬ
	////////////////////////////////////////

		//�ƥ��֥����������Ǥ����
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

		//�ץ饤�ޥ꡼���������
		$this->setKeyFields(array('link_id'));

		//AUTO_INCREMENT°���Υե���������
		// - ��ĤΥơ��֥���ˤϡ�AUTO_INCREMENT°������ĥե�����ɤ�
		//   ��Ĥ����ʤ�����Ǥ���
		$this->setAutoIncrementField('link_id');
	}
	
}

class WordPressLinkHandler  extends XoopsTableObjectHandler
{
	var $prefix;
	/**
	 * ���󥹥ȥ饯��
	 */
	function WordPressLinkHandler($db,$prefix)
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
		$this->tableName = $this->db->prefix($prefix.'links');
	}
	
	/**
     * �쥳���ɤμ���(�ץ饤�ޥ꡼�����ˤ���ո�����
     * 
     * @param	string $key ��������
	 *
     * @return	object  {@link WordPressUser}, FALSE on fail
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
     * @param	object	&$record	{@link WordPressUser} object
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
     * @param	object  &$record  {@link WordPressPost2Cat} object
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
}
?>