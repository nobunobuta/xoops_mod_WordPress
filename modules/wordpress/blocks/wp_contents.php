<?php
if( ! defined( 'WP_CONTENTS_INCLUDED' ) ) {

	define( 'WP_CONTENTS_INCLUDED' , 1 ) ;

	function b_wp_contents_edit($options)
	{
		$form = "";
		$form .= "Number of posts to show: ";
		$form .= "<input type='text' name='options[]' value='".$options[0]."' /><br />";
		return $form;

	}
	function b_wp_contents_show($options,$wp_num="") {
		$no_posts = (empty($options[0]))? 10 : $options[0];

		global $wpdb, $siteurl, $post, $use_cache;
		global $smilies_directory,  $wp_smiliessearch, $wp_smiliesreplace;
		global $wp_bbcode,  $wp_gmcode,   $wp_htmltrans, $wp_htmltranswinuni;
		global $wp_id, $wp_inblock, $xoopsConfig, $previousday, $time_difference ;
		
		$id=1;
		$use_cache = 1;

		if ($wp_num == "") {
			$wp_id = $wp_num;
			$wp_inblock = 1;
			require(dirname(__FILE__).'/../wp-config.php');
			$wp_inblock = 0;
		}

		global $dateformat,$timeformat;
		
		$dateformat = stripslashes(get_settings('date_format'));
		$timeformat = stripslashes(get_settings('time_format'));
		
		$now = date('Y-m-d H:i:s',(time() + (get_settings('time_difference') * 3600)));
		$request = "SELECT DISTINCT * FROM {$wpdb->posts[$wp_id]} ";
		$request .= " LEFT JOIN {$wpdb->post2cat[$wp_id]} ON ({$wpdb->posts[$wp_id]}.ID = {$wpdb->post2cat[$wp_id]}.post_id) ";
		$request .= "WHERE post_status = 'publish' ";
		$request .= " AND post_date <= '".$now."'";
		$request .= " GROUP BY {$wpdb->posts[$wp_id]}.ID ORDER BY post_date DESC LIMIT 0, $no_posts";
		$lposts = $wpdb->get_results($request);
		
		$blog = 1;
		$block = array();
		$block['use_theme_template'] = get_xoops_option('wordpress'.$wp_num,'use_theme_template');
		
//		if (file_exists(XOOPS_ROOT_PATH.'/modules/wordpress'. (($wp_id=='-')?'':$wp_id) .'/themes/'.$xoopsConfig['theme_set'].'/wp-blocks.css.php')) {
//			$themes = $xoopsConfig['theme_set'];
//		} else {
//			$themes = "default";
//		}
//		include_once(XOOPS_ROOT_PATH."/modules/wordpress". (($wp_id=='-')?'':$wp_id) ."/themes/".$themes."/wp-blocks.css.php");
//		
		if (file_exists(XOOPS_ROOT_PATH.'/modules/wordpress'. (($wp_id=='-')?'':$wp_id) .'/themes/'.$xoopsConfig['theme_set'].'/content_block-template.php')) {
			$themes = $xoopsConfig['theme_set'];
		} else {
			$themes = "default";
		}
		$template_fname = XOOPS_ROOT_PATH."/modules/wordpress". (($wp_id=='-')?'':$wp_id) ."/themes/".$themes."/content_block-template.php";
		
		$block['style'] =block_style_get($wp_num,false);
		$block['divid'] = 'wpBlockContent'.$wp_num;
		$block['template_content'] = "";
		$i = 0;
		$previousday = 0;
		foreach ($lposts as $post) {
			if ($block['use_theme_template'] == 0) {
				$content = array();
				start_wp();
				$content['date'] = the_date($dateformat,'','', false);
				$content['time'] = the_time('', false);
				$content['title'] = the_title('','', false);
				$content['permlink'] = get_permalink();
		//
				ob_start();
				the_author();
				$content['author'] = ob_get_contents();
				ob_end_clean();
		//
				ob_start();
				the_category();
				$content['category'] = ob_get_contents();
				ob_end_clean();
		//	
				ob_start();
				the_content();
				$content['body'] = ob_get_contents();
				ob_end_clean();
		//
				ob_start();
				link_pages('<br />Pages: ', '<br />', 'number');
				$content['linkpage'] = ob_get_contents();
				ob_end_clean();
		//
				ob_start();
				comments_popup_link(_WP_TPL_COMMENT0, _WP_TPL_COMMENT1, _WP_TPL_COMMENTS);
				$content['comments'] = ob_get_contents();
				ob_end_clean();
		//
				ob_start();
				trackback_rdf();
				$content['trackback'] = ob_get_contents();
				ob_end_clean();
		//
				$block['contents'][] = $content;
			} else {
				ob_start();
				include $template_fname;
				$block['template_content'] .= ob_get_contents();
				ob_end_clean();
			}
		}
		$previousday = 0;
		return $block;
	}

	for ($i = 0; $i < 10; $i++) {
		eval ('
		function b_wp'.$i.'_contents_edit($options) {
			return (b_wp_contents_edit($options));
		}

		function b_wp'.$i.'_contents_show($options) {
			global $smilies_directory,  $wp_smiliessearch, $wp_smiliesreplace;
			global $wp_bbcode,  $wp_gmcode,   $wp_htmltrans, $wp_htmltranswinuni;
			global $wp_id, $wp_inblock, $previousday, $xoopsConfig, $use_cache;
			$wp_id = "'.$i.'";
			$wp_inblock = 1;
			require(XOOPS_ROOT_PATH."/modules/wordpress'.$i.'/wp-config.php");
			$wp_inblock = 0;
			return (b_wp_contents_show($options,"'.$i.'"));
		}
	');
	}
}
?>
