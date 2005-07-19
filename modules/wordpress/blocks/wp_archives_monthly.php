<?php
$_wp_base_prefix = 'wp';
$_wp_my_dirname = basename( dirname(dirname( __FILE__ ) ) );
if (!preg_match('/\D+(\d*)/', $_wp_my_dirname, $_wp_regs )) {
	echo ('Invalid dirname for WordPress Module: '. htmlspecialchars($_wp_my_dirname));
}
$_wp_my_dirnumber = $_wp_regs[1] ;
$_wp_my_prefix = $_wp_base_prefix.$_wp_my_dirnumber.'_';

if( ! defined( 'WP_ARCHIVES_MONTHLY_BLOCK_INCLUDED' ) ) {
	define( 'WP_ARCHIVES_MONTHLY_BLOCK_INCLUDED' , 1 ) ;

	function _b_wp_archives_monthly_edit($options)
	{
		require_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
		$optForm = new XoopsSimpleForm('Block Option Dummy Form', 'optionform', '');

		$optFormType = new XoopsFormRadio('Month List Style:',  'options[0]', $options[0]);
		$optFormType->addOption(0, 'Simple List');
		$optFormType->addOption(1, 'Dropdown List');
		$optForm->addElement($optFormType);
		$optForm->addElement(new XoopsFormRadioYN('Listing with count:', 'options[1]', $options[1]));
		$optForm->addElement(new XoopsFormText('Custom Block Template File<br />(Default: wp_archives_monthly.html):', 'options[2]', 25, 50, $options[2]));

		$_wpTpl =& new WordPresTpl('theme');
		$optForm->assign($_wpTpl);
		return $_wpTpl->fetch('wp_block_edit.html');
	}

	function _b_wp_archives_monthly_show($options, $wp_num='')
	{
		$block_style = ($options[0])?$options[0]:0;
		$with_count = ($options[1]==0)?false:true;
		$tpl_file = (empty($options[2]))? 'wp_archives_monthly.html' : $options[2];

		$sel_value = '';
		if (current_wp()) {
			if ( !empty( $_SERVER['PATH_INFO'] ) ) {
				permlink_to_param();
			}
			init_param('GET', 'm','string','');
			init_param('GET', 'year','integer', '');
			init_param('GET', 'monthnum','integer','');
			init_param('GET', 'day','integer','');
			if (strlen(get_param('m')) == 6 ) {
				$sel_value = get_param('m');
			} else if (test_param('year') && test_param('monthnum') && !test_param('day')) {
				$sel_value = get_param('year').zeroise(get_param('monthnum'),2);
			}
		}
		$block['wp_num'] = $wp_num;
		$block['divid'] = 'wpArchive'.$wp_num;
		$block['siteurl'] = wp_siteurl();
		$block['style'] = block_style_get(false);
		$block['block_style'] = $block_style;
		$block['with_count'] = $with_count;
		
		$now = current_time('mysql');
		$postHandler =& wp_handler('Post');
		$criteria =& new CriteriaCompo(new Criteria('post_date', $now, '<'));
		$criteria->add(new Criteria('post_status', 'publish'));
		$criteria->setSort('post_date');
		$criteria->setOrder('DESC');
		$criteria->setGroupby('YEAR(post_date), MONTH(post_date)');
		$postObjects =& $postHandler->getObjects($criteria, false, 'DISTINCT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts');
		$block['records'] = array();
		if ($postObjects) {
			foreach($postObjects as $postObject) {
				$this_year = $postObject->getExtraVar('year');
				$this_month = $postObject->getExtraVar('month');
				$_record['url'] = get_month_link($this_year, $this_month);
				$_record['text'] = format_month($this_year, $GLOBALS['month'][zeroise($this_month, 2)]);
				if ($with_count) {
					$_record['count'] = '&nbsp;('.$postObject->getExtraVar('posts').')';
				} else {
					$_record['count'] = '';
				}
				$_record['select'] = ($sel_value == $this_year.zeroise($this_month,2)) ?  'selected="selected"' : '' ;
				$block['records'][] = $_record;
			}
		}
		$_wpTpl =& new WordPresTpl('theme');
		$_wpTpl->assign('block', $block);
		if (!$_wpTpl->tpl_exists($tpl_file)) $tpl_file = 'wp_archives_monthly.html';
		$block['content'] = $_wpTpl->fetch($tpl_file);
		return $block;
	}
}
eval ('
	function b_'.$_wp_my_prefix.'archives_monthly_edit($options) {
		$GLOBALS["wp_inblock"] = 1;
		require(XOOPS_ROOT_PATH."/modules/'.$_wp_my_dirname.'/wp-config.php");
		$GLOBALS["wp_inblock"] = 0;
		return (_b_wp_archives_monthly_edit($options));
	}
	function b_'.$_wp_my_prefix.'archives_monthly_show($options) {
		$GLOBALS["wp_inblock"] = 1;
		require(XOOPS_ROOT_PATH."/modules/'.$_wp_my_dirname.'/wp-config.php");
		$GLOBALS["wp_inblock"] = 0;
		return (_b_wp_archives_monthly_show($options,"'.$_wp_my_dirnumber.'"));
	}
');
?>
