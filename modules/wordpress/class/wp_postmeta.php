<?php
if( ! class_exists( 'WordPressPostMeta' ) ) {
class WordPressPostMeta  extends XoopsTableObject
{
	var $prefix;
	/**
	 * ���󥹥ȥ饯��
	 */
	function WordPressPostMeta() {
	////////////////////////////////////////
	// �ƥ��饹������ʬ(������)
	////////////////////////////////////////

		//�ƥ��饹�Υ��󥹥ȥ饯���ƽ�
		$this->XoopsTableObject();

	////////////////////////////////////////
	// �������饹��ͭ�������ʬ
	////////////////////////////////////////

		//�ƥ��֥����������Ǥ����
		$this->initVar('meta_id', XOBJ_DTYPE_INT, NULL, true);
		$this->initVar('post_id', XOBJ_DTYPE_INT, 0, true);
		$this->initVar('meta_key', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('meta_value', XOBJ_DTYPE_TXTAREA, null, false);

		//�ץ饤�ޥ꡼���������
		$this->setKeyFields(array('meta_id'));

		//AUTO_INCREMENT°���Υե���������
		// - ��ĤΥơ��֥���ˤϡ�AUTO_INCREMENT°������ĥե�����ɤ�
		//   ��Ĥ����ʤ�����Ǥ���
		$this->setAutoIncrementField('meta_id');
	}
}

class WordPressPostMetaHandler  extends XoopsTableObjectHandler
{
	var $prefix;
	/**
	 * ���󥹥ȥ饯��
	 */
	function WordPressPostMetaHandler($db,$prefix)
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
		$this->tableName = $this->db->prefix($prefix.'postmeta');
	}
	
	/**
     * �쥳���ɤμ���(�ץ饤�ޥ꡼�����ˤ���ո�����
     * 
     * @param	string $key ��������
	 *
     * @return	object  {@link WordPressPost2Cat}, FALSE on fail
     */
/*�ơ��֥�˸�ͭ�Υǡ���������ɬ�פʻ��ʳ�������
	function &get($key)
	{
		return parent::get($key);
	}
*/
	/**
     * �쥳���ɤμ���(post_id��meta_key�ˤ���ո�����
     * 
     * @param	string $post_id ��������
     * @param	string $meta_key ��������
	 *
     * @return	object  {@link WordPressPost2Cat}, FALSE on fail
     */
	function &getByKey($post_id, $meta_key) {
		$criteria =& new CriteriaCompo(new Criteria('post_id', $post_id));
		$criteria->add(new Criteria('meta_key', $meta_key));
		$results =& $this->handler->getObjects($criteria);
		return $results;
	}
    /**
     * �쥳���ɤ���¸
     * 
     * @param	object	&$record	{@link WordPressPost2Cat} object
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