<?php
if( ! defined( 'WP_ADMIN_FUNCTIONS_INCLUDED' ) ) {
	define( 'WP_ADMIN_FUNCTIONS_INCLUDED' , 1 ) ;
function selected($selected, $current, $echo=true) {
	if ($selected == $current) {
		if ($echo) echo ' selected="selected"';
		else return ' selected="selected"';
	}
}

function checked($checked, $current, $echo=true) {
	if ($checked == $current) {
		if ($echo) echo ' checked="checked"';
		else return ' checked="checked"';
	}
}

function gethelp_link($this_file, $helptag) {
    $url = 'http://wordpress.org/docs/reference/links/#'.$helptag;
    $s = ' <a href="'.$url.'" title="Click here for help">?</a>';
    return $s;
}

function categories_nested_select($sel_categories) {
	$categoryHandler =& wp_handler('Category');
	$categoryObjects =& $categoryHandler->getNestedObjects(null,'');
	$prev_level = 1;
	$output = "";
	foreach ($categoryObjects as $categoryObject) {
		if ($prev_level < $categoryObject->getExtraVar('category_level')) {
			$output .= "<span class='cat-nest'>";
		} elseif  ($prev_level > $categoryObject->getExtraVar('category_level')) {
		    $output .= "</span>";
		}
		$prev_level = $categoryObject->getExtraVar('category_level');
		$cat_ID = $categoryObject->getVar('cat_ID');
		$id = "category-$cat_ID";
		$cat_name = $categoryObject->getVar('cat_name');
		$checked = (in_array($cat_ID, $sel_categories)) ? ' checked="checked"' : "";
		$output .= "<label for='$id' class='selectit'>";
		$output .= "<input value='$cat_ID' type='checkbox' name='post_category[]' id='$id' $checked/>$cat_name";
		$output .= "</label>";
	}
	return $output;
}

function wp_dropdown_cats($currentcat, $currentparent = 0, $parent = 0, $level = 0, $categories = 0) {
	$myts =& MyTextSanitizer::getInstance();

	if (!$categories) {
		$categoryHandler =& wp_handler('Category');
 		$categories =& $categoryHandler->getObjects();
	}
	if ($categories) {
		foreach ($categories as $category) {
				$cat_ID = $category->getVar('cat_ID');
			if ($currentcat != $cat_ID && $parent == $category->getVar('category_parent')) {
				$cat_name = $myts->makeTareaData4Show($category->getVar('cat_name'));
				$pad = str_repeat('&#8211; ', $level);
?>
				<option value='<?php echo $cat_ID ?>'<?php selected($currentparent, $cat_ID) ?>><?php echo "$pad$cat_name" ?></option>
<?php
				wp_dropdown_cats($currentcat, $currentparent, $cat_ID, $level + 1, $categories);
			}
		}
	} else {
		return false;
	}
}

function wp_dropdown_month($current) {
	global $wpdb, $wp_id;
	global $wp_month_format, $month;
	$arc_result=$wpdb->get_results("SELECT DISTINCT YEAR(post_date), MONTH(post_date) FROM {$wpdb->posts[$wp_id]} ORDER BY post_date DESC",ARRAY_A);
	foreach ($arc_result as $arc_row) {
		$arc_year  = $arc_row["YEAR(post_date)"];
		$arc_month = $arc_row["MONTH(post_date)"];
		$arc_ym = $arc_year.zeroise($arc_month,2);
   		$month_str = ereg_replace('%MONTH',$month[zeroise($arc_month,2)],$wp_month_format);
		$month_str = ereg_replace('%YEAR',$arc_year,$month_str);
?> 
		<option value="<?php echo $arc_ym ?>"<?php selected($current, $arc_ym)?>><?php echo $month_str ?></option>
<?php
	}
}

function wp_dropdown_daily($current) {
	global $wpdb, $wp_id;

	$archive_day_date_format = "Y/m/d";
	$arc_result=$wpdb->get_results("SELECT DISTINCT YEAR(post_date), MONTH(post_date), DAYOFMONTH(post_date) FROM {$wpdb->posts[$wp_id]} ORDER BY post_date DESC", ARRAY_A);
	foreach ($arc_result as $arc_row) {
		$arc_year  = $arc_row["YEAR(post_date)"];
		$arc_month = $arc_row["MONTH(post_date)"];
		$arc_dayofmonth = $arc_row["DAYOFMONTH(post_date)"];
		$arc_ymd = $arc_year.zeroise($arc_month,2).zeroise($arc_dayofmonth,2);
		$date_str = "$arc_year/".zeroise($arc_month,2)."/".zeroise($arc_dayofmonth,2);
?>
		<option value="<?php echo $arc_ymd ?>"<?php selected($current, $arc_ymd)?>><?php echo $date_str ?></option>
<?php
	}
}
function wp_dropdown_weekly($current) {
	global $wpdb, $wp_id;

		$archive_week_start_date_format = "Y/m/d";
		$archive_week_end_date_format   = "Y/m/d";
		$archive_week_separator = " - ";
		$arc_result=$wpdb->geT_results("SELECT DISTINCT YEAR(post_date), MONTH(post_date), DAYOFMONTH(post_date), WEEK(post_date) FROM {$wpdb->posts[$wp_id]} ORDER BY post_date DESC", ARRAY_A);
		$arc_w_last = '';
        foreach ($arc_result as $arc_row) {
			$arc_year = $arc_row["YEAR(post_date)"];
			$arc_w = $arc_row["WEEK(post_date)"];
			if ($arc_w != $arc_w_last) {
				$arc_w_last = $arc_w;
				$arc_ymd = $arc_year."-".zeroise($arc_row["MONTH(post_date)"],2)."-" .zeroise($arc_row["DAYOFMONTH(post_date)"],2);
				$arc_week = get_weekstartend($arc_ymd, get_settings('start_of_week'));
				$arc_week_start = date($archive_week_start_date_format, $arc_week['start']);
				$arc_week_end = date($archive_week_end_date_format, $arc_week['end']);
				$week_str = $arc_week_start.$archive_week_separator.$arc_week_end;
?>
				<option value="<?php echo $arc_w?>"<?php selected($current, $arc_w)?>><?php echo $week_str ?></option>
<?php
			}
		}
}

function wp_dropdown_postbypost($current) {
	global $wpdb, $wp_id;
	$resultarc = $wpdb->get_results("SELECT ID,post_date,post_title FROM {$wpdb->posts[$wp_id]} ORDER BY post_date DESC");
	foreach ($resultarc as $row) {
		if ($row->post_date != "0000-00-00 00:00:00") {
			$title = (strip_tags($row->post_title)) ? strip_tags(stripslashes($row->post_title)) : $row->ID;
?>
			<option value="<?php echo $row->ID ?>"<?php selected($current, $row->ID)?>><?php echo $title ?></option>
<?php
		}
	}
}

function user_level_check() {
	global $siteurl;
	if (!user_can_access_admin_page()) {
    	redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
	}
}

function user_can_access_admin_page() {
	global $parent_file;
	global $pagenow;
	global $menu;
	global $submenu;
	global $user_level;

	if (! isset($parent_file)) {
		$parent = $pagenow;
	} else {
		$parent = $parent_file;
	}

	foreach ($menu as $menu_array) {
		//echo "parent array: " . $menu_array[2];
		if ($menu_array[2] == $parent) {
			if ($user_level < $menu_array[1]) {
				return false;
			} else {
				break;
			}
		}
	}

	if (isset($submenu[$parent])) {
		foreach ($submenu[$parent] as $submenu_array) {
			if ($submenu_array[2] == $pagenow) {
				if ($user_level < $submenu_array[1]) {
					return false;
				} else {
					return true;
				}
			}
		}
	}
	
	return true;
}

function get_admin_page_title() {
	global $title;
	global $submenu;
	global $pagenow;
	global $plugin_page;

	if (isset($title) && ! empty($title)) {
		return $title;
	}

	foreach (array_keys($submenu) as $parent) {
		foreach ($submenu[$parent] as $submenu_array) {
			if (isset($submenu_array[3])) {
				if ($submenu_array[2] == $pagenow) {
					$title = $submenu_array[3];
					return $submenu_array[3];
				} else if (isset($plugin_page) && ($plugin_page == $submenu_array[2])) {
					$title = $submenu_array[3];
					return $submenu_array[3];
				}
			}
		}
	}

	return '';
}

function get_admin_page_parent() {
	global $parent_file;
	global $submenu;
	global $pagenow;
	global $plugin_page;

	if (isset($parent_file) && ! empty($parent_file)) {
		return $parent_file;
	}

	foreach (array_keys($submenu) as $parent) {
		foreach ($submenu[$parent] as $submenu_array) {
			if ($submenu_array[2] == $pagenow) {
				$parent_file = $parent;
				return $parent;
			} else if (isset($plugin_page) && ($plugin_page == $submenu_array[2])) {
				$parent_file = $parent;
				return $parent;
			}
		}
	}

	$parent_file = '';
	return '';
}

function add_options_page($page_title, $menu_title, $access_level, $file) {
	global $submenu;

	$file = basename($file);

	$submenu['options-general.php'][] = array($menu_title, $access_level, $file, $page_title);
}

/* checking login & pass in the database */
function veriflog() {
	if($GLOBALS['xoopsUser']){
		$userHandler =& wp_handler('User');
		$userObject =& $userHandler->get($GLOBALS['xoopsUser']->uid());
		if ($userObject) {
			$userHandler->insert($userObject, true, true);
		} else {
			$userObject =& $userHandler->create();
			$userObject->setVar('ID', $GLOBALS['xoopsUser']->uid());
			$userHandler->insert($userObject, true, true, wp_mod());
		}
		return true;
	}
	return false;
}
// Some postmeta stuff
function add_meta($post_ID) {
	global $wpdb,$wp_id;
	
	$metakeyselect = $wpdb->escape( stripslashes( trim($_POST['metakeyselect']) ) );
	$metakeyinput  = $wpdb->escape( stripslashes( trim($_POST['metakeyinput']) ) );
	$metavalue     = $wpdb->escape( stripslashes( trim($_POST['metavalue']) ) );

	if (!empty($metavalue) && ((('#NONE#' != $metakeyselect) && !empty($metakeyselect)) || !empty($metakeyinput))) {
		// We have a key/value pair. If both the select and the 
		// input for the key have data, the input takes precedence:

		if ('#NONE#' != $metakeyselect)
			$metakey = $metakeyselect;
				
		if ($metakeyinput)
			$metakey = $metakeyinput; // default

		$result = $wpdb->query("
				INSERT INTO {$wpdb->postmeta[$wp_id]} 
				(post_id,meta_key,meta_value) 
				VALUES ('$post_ID','$metakey','$metavalue')
			");
	}
} // add_meta

function delete_meta($mid) {
	global $wpdb,$wp_id;

	$result = $wpdb->query("DELETE FROM {$wpdb->postmeta[$wp_id]} WHERE meta_id = '$mid'");
}

function update_meta($mid, $mkey, $mvalue) {
	global $wpdb,$wp_id;

	return $wpdb->query("UPDATE {$wpdb->postmeta[$wp_id]} SET meta_key = '$mkey', meta_value = '$mvalue' WHERE meta_id = '$mid'");
}

function draft_list($user_ID) {
	global $wpdb, $wp_id;
	$drafts = $wpdb->get_results("SELECT ID, post_title FROM {$wpdb->posts[$wp_id]} WHERE post_status = 'draft' AND post_author = $user_ID");
	if ($drafts) {
?>
<div class="wrap">
	<p><strong><?php echo _LANG_P_YOUR_DRAFTS; ?></strong>
<?php
		$i = 0;
		foreach ($drafts as $draft) {
			$delim =  (0 != $i) ? ', ' : '';
			$draft->post_title = stripslashes($draft->post_title);
			if ($draft->post_title == '') {
				$draft->post_title = 'Post #'.$draft->ID;
			}
			++$i;
?> 
		<?php echo $delim ?><a href='post.php?action=edit&amp;post=<?echo $draft->ID ?>' title='Edit this draft'><?php echo $draft->post_title ?></a>
<?php
		}
?>
	.</p>
</div>
<?php
	}
}

function do_trackback($postObject, $useutf8, $target_charset="") {
global $wpdb, $wp_id;

	$pinged = explode("\n", $postObject->getVar('pinged'));
	$to_ping = $postObject->getVar('to_ping');
	if ('' != $to_ping) {
		if (strlen($postObject->getVar('post_excerpt')) > 0) {
			$the_excerpt = apply_filters('the_excerpt', $postObject->getVar('post_excerpt'));
		} else {
			$the_excerpt = apply_filters('the_content', $postObject->getVar('post_content'));
		}
		$the_excerpt = (strlen(strip_tags($the_excerpt)) > 255) ? substr(strip_tags($the_excerpt), 0, 252) . '...' : strip_tags($the_excerpt);
		$excerpt = stripslashes($the_excerpt);
		$to_pings = explode("\n", $to_ping);
		if ($useutf8=="1") {
			$target_charset = 'UTF-8';
		}
		$ping_charset = $target_charset;
		foreach ($to_pings as $tb_ping) {
			$tb_ping = trim($tb_ping);
			if (!in_array($tb_ping, $pinged)) {
			 trackback($tb_ping, $postObject->getVar('post_title'), $excerpt, $postObject->getVar('ID'), $ping_charset);
			}
		}
	}
}

function show_bookmarklet_link() {
	global $is_NS4, $is_gecko, $is_winIE, $is_opera, $is_macIE;
	global $siteurl, $wp_use_spaw;
?>
<div class="wrap">
	<h2>WordPress bookmarklet</h2>
	<p><?php echo _LANG_P_WP_BOOKMARKLET; ?></p>
	<p>
<?php
	$bookmarklet_height= (get_settings('use_trackback')) ? 540 : 480;
	$bookmarklet_tbpb  = (get_settings('use_trackback')) ? '&trackback=1' : '';
	$bookmarklet_tbpb .= (get_settings('use_pingback'))  ? '&pingback=1'  : '';

	if ($is_NS4 || $is_gecko) {
?>
		<a href="javascript:if(navigator.userAgent.indexOf('Safari') >= 0){Q=getSelection();}else{Q=document.selection?document.selection.createRange().text:document.getSelection();}void(window.open('<?php echo $siteurl ?>/wp-admin/bookmarklet.php?text='+escape(Q)+'<?php echo $bookmarklet_tbpb ?>&popupurl='+escape(location.href)+'&popuptitle='+escape(document.title),'WordPress bookmarklet','scrollbars=yes,width=600,height=<?php echo $bookmarklet_height ?>,left=100,top=150,status=yes'));">Press It - <?php echo get_settings('blogname') ?></a>
<?php
	} else if ($is_winIE) {
		if ($wp_use_spaw) {
			$range_text = "htmlText";
		} else {
			$range_text = "text";
		}
?>
		<a href="javascript:Q='';if(top.frames.length==0)Q=document.selection.createRange().<?php echo $range_text ?>;void(btw=window.open('<?php echo $siteurl ?>/wp-admin/bookmarklet.php?text='+escape(Q)+'<?php echo $bookmarklet_tbpb ?>&popupurl='+escape(location.href)+'&popuptitle='+escape(document.title),'bookmarklet','scrollbars=yes,width=600,height=<?php echo $bookmarklet_height ?>,left=100,top=50,status=yes'));btw.focus();">Press it - <?php echo get_settings('blogname') ?></a>
		<script type="text/javascript" language="JavaScript">
		<!--
		function oneclickbookmarklet(blah) {
			window.open ("profile.php?action=IErightclick", "oneclickbookmarklet", "width=680, height=450, location=0, menubar=0, resizable=0, scrollbars=1, status=1, titlebar=0, toolbar=0, screenX=120, left=120, screenY=120, top=120");
		}
		// -->
		</script>
		<br /><br />One-click bookmarklet:<br />
		<a href="javascript:oneclickbookmarklet(0);">click here</a>
<?php
	} else if ($is_opera) {
?>
		<a href="javascript:void(window.open('<?php echo $siteurl ?>/wp-admin/bookmarklet.php?popupurl='+escape(location.href)+'&popuptitle='+escape(document.title)+'<?php echo $bookmarklet_tbpb ?>','bookmarklet','scrollbars=yes,width=600,height=<?php echo $bookmarklet_height ?>,left=100,top=150,status=yes'));">Press it - <?php echo get_settings('blogname') ?></a> 
<?php
	} else if ($is_macIE) {
?>
		<a href="javascript:Q='';if(top.frames.length==0);void(btw=window.open('<?php echo $siteurl ?>/wp-admin/bookmarklet.php?text='+escape(document.getSelection())+'&popupurl='+escape(location.href)+'&popuptitle='+escape(document.title)+'<?php echo $bookmarklet_tbpb ?>','bookmarklet','scrollbars=yes,width=600,height=<?php echo $bookmarklet_height ?>,left=100,top=150,status=yes'));btw.focus();">Press it - <?php echo get_settings('blogname') ?></a>
<?php
	}
?>
	</p>
</div>
<?php
}
}
?>
