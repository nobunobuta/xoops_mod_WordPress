<?php
if( ! class_exists( 'WordPressComment' ) ) {
class WordPressComment extends XoopsTableObject
{
	var $prefix;
	/**
	 * ���󥹥ȥ饯��
	 */
	function WordPressComment() {
	////////////////////////////////////////
	// �ƥ��饹������ʬ(������)
	////////////////////////////////////////

		//�ƥ��饹�Υ��󥹥ȥ饯���ƽ�
		$this->XoopsTableObject();

	////////////////////////////////////////
	// �������饹��ͭ�������ʬ
	////////////////////////////////////////

		//�ƥ��֥����������Ǥ����
		$this->initVar('comment_ID', XOBJ_DTYPE_INT, NULL, true);
		$this->initVar('comment_post_ID', XOBJ_DTYPE_INT, 0, true);
		$this->initVar('comment_author', XOBJ_DTYPE_TXTBOX, '', false, 255);
		$this->initVar('comment_author_email', XOBJ_DTYPE_EMAIL, '', false, 100);
		$this->initVar('comment_author_url', XOBJ_DTYPE_URL, '', false, 100);
		$this->initVar('comment_author_IP', XOBJ_DTYPE_TXTBOX, '', false,100);
		$this->initVar('comment_date', XOBJ_DTYPE_TXTBOX, '0000-00-00 00:00:00', false, 20);
		$this->initVar('comment_content', XOBJ_DTYPE_TXTAREA, null, false);
		$this->initVar('comment_karma', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('comment_approved', XOBJ_DTYPE_TXTBOX, '1', false, 5);
		$this->initVar('comment_agent', XOBJ_DTYPE_TXTBOX, '', false, 255);
		$this->initVar('comment_type', XOBJ_DTYPE_TXTBOX, '', false, 20);
		$this->initVar('comment_parent', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('user_id', XOBJ_DTYPE_INT, 0, false);

		$this->setAttribute('dohtml', 1);
		$this->setAttribute('doxcode', 0);
		$this->setAttribute('dosmiley', 0);
		$this->setAttribute('doimage', 0);
		$this->setAttribute('dobr', 0);
		//�ץ饤�ޥ꡼���������
		$this->setKeyFields(array('comment_ID'));

		//AUTO_INCREMENT°���Υե���������
		// - ��ĤΥơ��֥���ˤϡ�AUTO_INCREMENT°������ĥե�����ɤ�
		//   ��Ĥ����ʤ�����Ǥ���
		$this->setAutoIncrementField('comment_ID');
	}

	function approve($force=false) {
		return $this->_handler->approve($this->getVar('comment_ID'),$force);
	}
	
	function unapprove($force=false) {
		return $this->_handler->unapprove($this->getVar('comment_ID'),$force);
	}
}

class WordPressCommentHandler  extends XoopsTableObjectHandler
{
	var $prefix;
	var $module;
	/**
	 * ���󥹥ȥ饯��
	 */
	function WordPressCommentHandler($db,$prefix,$module)
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
		$this->tableName = $this->db->prefix($prefix.'comments');
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

	function approve($comment_ID, $force=false) {
		$criteria = new Criteria('comment_ID', $comment_ID);
		return $this->updateAll('comment_approved', '1', $criteria, $force);
	}
	function unapprove($comment_ID, $force=false) {
		$criteria = new Criteria('comment_ID', $comment_ID);
		return $this->updateAll('comment_approved', '0', $criteria, $force);
	}
}
}
?>