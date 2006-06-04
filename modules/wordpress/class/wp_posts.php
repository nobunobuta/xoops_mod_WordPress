<?php
if( ! class_exists( 'WordPressPost' ) ) {
class WordPressPost  extends XoopsTableObject
{
	var $prefix;
	/**
	 * ���󥹥ȥ饯��
	 */
	function WordPressPost() {
	////////////////////////////////////////
	// �ƥ��饹������ʬ(������)
	////////////////////////////////////////
		
		//�ƥ��饹�Υ��󥹥ȥ饯���ƽ�
		$this->XoopsTableObject();

	////////////////////////////////////////
	// �������饹��ͭ�������ʬ
	////////////////////////////////////////

		//�ƥ��֥����������Ǥ����
		$this->initVar('ID', XOBJ_DTYPE_INT, NULL, true);
		$this->initVar('post_author', XOBJ_DTYPE_INT, 0, true);
		$this->initVar('post_date', XOBJ_DTYPE_TXTBOX, '0000-00-00 00:00:00', false,20);
		$this->initVar('post_content', XOBJ_DTYPE_TXTAREA, NULL, false);
		$this->initVar('post_title', XOBJ_DTYPE_TXTAREA, NULL, false);
		$this->initVar('post_category', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('post_excerpt', XOBJ_DTYPE_TXTAREA, NULL);
		$this->initVar('post_lat', XOBJ_DTYPE_FLOAT, NULL, false);
		$this->initVar('post_lon', XOBJ_DTYPE_FLOAT, NULL, false);
		$this->initVar('post_status', XOBJ_DTYPE_TXTBOX, 'publish', false,10);
		$this->initVar('comment_status', XOBJ_DTYPE_TXTBOX, 'open', false,10);
		$this->initVar('ping_status', XOBJ_DTYPE_TXTBOX, 'open', false,10);
		$this->initVar('post_password', XOBJ_DTYPE_TXTBOX, '', false,20);
		$this->initVar('post_name', XOBJ_DTYPE_TXTBOX, '', false,200);
		$this->initVar('to_ping', XOBJ_DTYPE_TXTBOX, NULL, false);
		$this->initVar('pinged', XOBJ_DTYPE_SOURCE, NULL, false);
		$this->initVar('post_modified', XOBJ_DTYPE_TXTBOX, NULL, false,100);
		$this->initVar('post_content_filtered', XOBJ_DTYPE_SOURCE, NULL, false);
		
		$this->setAttribute('dohtml', 1);
		$this->setAttribute('doxcode', 0);
		$this->setAttribute('dosmiley', 0);
		$this->setAttribute('doimage', 0);
		$this->setAttribute('dobr', 0);

		//�ץ饤�ޥ꡼���������
		$this->setKeyFields(array('ID'));

		//AUTO_INCREMENT°���Υե���������
		// - ��ĤΥơ��֥���ˤϡ�AUTO_INCREMENT°������ĥե�����ɤ�
		//   ��Ĥ����ʤ�����Ǥ���
		$this->setAutoIncrementField('ID');
	}
	function assignCategories($categories, $force=false)
	{
		$post2catHandler =& new WordPressPost2CatHandler($this->_handler->db, $this->_handler->prefix, $this->_handler->module);
		$criteria = new Criteria('post_id', $this->getVar('ID'));
		$oldCategories =& $post2catHandler->getObjects($criteria);
		$oldCategoryArray = array();
		foreach($oldCategories as $oldCategory) {
			if (!in_array($oldCategory->getVar('category_id'), $categories)) {
				$post2catHandler->delete($oldCategory, $force);
			} else {
				$oldCategoryArray[] = $oldCategory->getVar('category_id');
			}
		}
		// Add any?
		foreach ($categories as $category) {
			if (!in_array($category, $oldCategoryArray)) {
				$post2cat =&  $post2catHandler->create();
				$post2cat->setVar('post_id', $this->getVar('ID'), true);
				$post2cat->setVar('category_id', $category, true);
				$post2catHandler->insert($post2cat, $force);
				unset($post2cat);
			}
		}
	}
	
	function &getCategories()
	{
		$post2catHandler =& new WordPressPost2CatHandler($this->_handler->db, $this->_handler->prefix, $this->_handler->module);
		$criteria = new Criteria('post_id', $this->getVar('ID'));
		$categoryObjects =& $post2catHandler->getObjects($criteria);
		return $categoryObjects;
	}
}

class WordPressPostHandler  extends XoopsTableObjectHandler
{
	var $prefix;
	var $module;
	/**
	 * ���󥹥ȥ饯��
	 */
	function WordPressPostHandler($db,$prefix,$module)
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
		$this->tableName = $this->db->prefix($prefix.'posts');
//		$this->useFullCache = false;
//		$this->cacheLimit = 50;
	}
	
	/**
     * �쥳���ɤμ���(�ץ饤�ޥ꡼�����ˤ���ո�����
     * 
     * @param	string $key ��������
	 *
     * @return	object  {@link WordPressPost}, FALSE on fail
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
     * @param	object	&$record	{@link WordPressPost} object
     * @param	bool	$force		POST�᥽�åɰʳ��Ƕ��������������ture
     * 
     * @return	bool    �����λ��� TRUE
     */
	function insert(&$record,$force=false,$updateOnlyChanged=false)
	{
		$record->setVar('post_modified', current_time('mysql'), true);
		if (trim($record->getVar('post_name'))!='') {
		    $post_name = strtolower($record->getVar('post_name'));
    		$criteria =& new CriteriaCompo(new Criteria('post_name', $record->getVar('post_name')));
    		$criteria->add(new Criteria('ID', $record->getVar('ID'),'!='),'AND');
    		$objects =& $this->getObjects($criteria);
    		$suffix = 2;
    		while (count($objects)) {
    		    $post_name = strtolower($record->getVar('post_name')).'_'.$suffix;
        		$criteria =& new CriteriaCompo(new Criteria('post_name', $post_name));
        		$criteria->add(new Criteria('ID', $record->getVar('ID'),'!='),'AND');
        		$objects =& $this->getObjects($criteria);
        		$suffix++;
    		}
    		$record->setVar('post_name', $post_name, true);
		}
		if ($result = parent::insert($record, $force, $updateOnlyChanged)) {
			if (trim($record->getVar('post_name'))=='') {
				$record->setVar('post_name', "post-".$record->getVar('ID'), true);
				$record->unsetNew();
				return parent::insert($record, $force, true);
			}
		}
		return $result;
	}

	/**
	 * �쥳���ɤκ��
	 * 
     * @param	object  &$record  {@link WordPressPost} object
     * @param	bool	$force		POST�᥽�åɰʳ��Ƕ��������������ture
     * 
     * @return	bool    �����λ��� TRUE
	 */
	function delete(&$record,$force=false)
	{
		//�����κ��
		if (!(parent::delete($record, $force))) {
			return false;
		}
		//�������Ф��륳���Ȥκ��
		$criteria =& new Criteria('comment_post_ID', $record->getVar('ID'));
		$comment_handler =& new WordPressCommentHandler($this->db, $this->prefix, $this->module);
		if (!($comment_handler->deleteAll($criteria, $force))) {
			return false;
		}
		//�������Ф��륳���Ȥκ��(XOOPS������)
		if ($xoopsOption['wp_use_xoops_comments']) {
			$criteria =& new CriteriaCompo(new Criteria('com_modid', $xoopsModule->getVar('mid')));
			$criteria->add(new Criteria('com_itemid', $record->getVar('ID')));
			$xcommentHandler = xoops_gethandler('comment');
			if (!($xcommentHandler->deleteAll($criteria))) {
				return false;
			}
		}
		//�����˴�Ϣ���륫�ƥ��꡼����κ��
		$criteria =& new Criteria('post_id', $record->getVar('ID'));
		$post2cat_handler =& new WordPressPost2CatHandler($this->db, $this->prefix, $this->module);
		if (!($post2cat_handler->deleteAll($criteria, $force))) {
			return false;
		}

		//�����˴�Ϣ����᥿����κ��
		$criteria =& new Criteria('post_id', $record->getVar('ID'));
		$postmeta_handler =& new WordPressPostMetaHandler($this->db, $this->prefix, $this->module);
		if (!($postmeta_handler->deleteAll($criteria, $force))) {
			return false;
		}
		
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
	 * �ơ��֥�ξ�︡���ˤ��ʣ���쥳���ɺ��
	 * 
	 * @param	object	$criteria 	{@link CriteriaElement} �������
     * @param	bool	$force		POST�᥽�åɰʳ��Ƕ��������������ture
     * 
     * @return	bool    �����λ��� TRUE
	 */
	function deleteAll($criteria = null, $force = false)
	{
		//���˹��פ��뵭��ID�����μ���
		$posts =& $this->getObjects($criteria);
		$IDs = array();
		foreach($posts as $post) {
			$IDs[] = $post->getVar('ID');
		}
		
		if (!(parent::deleteAll($criteria, $id_as_key))) {
			return false;
		}
		if ($IDs) {
			$IDs = "(".implode(',', $IDs).")";
			//�������Ф��륳���Ȥκ��
			$criteria =& new Criteria('comment_post_ID', $IDs, 'IN');
			$comment_handler =& new WordPressCommentHandler($this->db, $this->prefix, $this->module);
			if (!($comment_handler->deleteAll($criteria, $force))) {
				return false;
			}
			//�����˴�Ϣ���륫�ƥ��꡼����κ��
			$criteria =& new Criteria('post_id', $IDs, 'IN');
			$post2cat_handler =& new WordPressPost2CatHandler($this->db, $this->prefix, $this->module);
			if (!($post2cat_handler->deleteAll($criteria, $force))) {
				return false;
			}

			//�����˴�Ϣ����᥿����κ��
			$criteria =& new Criteria('post_id', $IDs, 'IN');
			$postmeta_handler =& new WordPressPostMetaHandler($this->db, $this->prefix, $this->module);
			if (!($postmeta_handler->deleteAll($criteria, $force))) {
				return false;
			}
			return true;
		}
	}
}
}
?>