<?php
function selected($selected, $current) {
	if ($selected == $current) echo ' selected="selected"';
}

function checked($checked, $current) {
	if ($checked == $current) echo ' checked="checked"';
}

function get_nested_categories($default = 0) {
 global $post_ID, $mode, $wpdb, $wp_id;
 if ($post_ID) {
   $checked_categories = $wpdb->get_col("
     SELECT category_id
     FROM  {$wpdb->categories[$wp_id]}, {$wpdb->post2cat[$wp_id]}
     WHERE {$wpdb->post2cat[$wp_id]}.category_id = cat_ID AND {$wpdb->post2cat[$wp_id]}.post_id = '$post_ID'
     ");
 } else {
   $checked_categories[] = $default;
 }

 $categories = $wpdb->get_results("SELECT * FROM {$wpdb->categories[$wp_id]} ORDER BY category_parent DESC, cat_name ASC");
 $result = array();
 foreach($categories as $category) {
   $array_category = get_object_vars($category);
   $me = 0 + $category->cat_ID;
   $parent = 0 + $category->category_parent;
	if (isset($result[$me]))   $array_category['children'] = $result[$me];
   $array_category['checked'] = in_array($category->cat_ID, $checked_categories);
   $array_category['cat_name'] = stripslashes($category->cat_name);
   $result[$parent][] = $array_category;
 }
 return $result[0];
}

function write_nested_categories($categories) {
	$myts =& MyTextSanitizer::getInstance();

	foreach($categories as $category) {
		$cat_ID = $category['cat_ID'];
		$id = "category-$cat_ID";
		$cat_name = $myts->makeTareaData4Show($category['cat_name']);
		$checked = ($category['checked'] ? ' checked="checked"' : "");
?> 
		<label for="<?php echo $id ?>" class="selectit">
			<input value="<?php echo $cat_ID ?>" type="checkbox" name="post_category[]" id="<?php echo $id ?>"<?php echo $checked ?> /><?php echo $cat_name ?> 
		</label>
<?php
   if(isset($category['children'])) {
?>
		<span class='cat-nest'>
<?php write_nested_categories($category['children']); ?>
		</span>
<?php
   }
 }
}

function dropdown_categories($default = 0) {
 write_nested_categories(get_nested_categories($default));
} 

function wp_dropdown_cats($currentcat, $currentparent = 0, $parent = 0, $level = 0, $categories = 0) {
	global $wpdb, $wp_id, $bgcolor;
	$myts =& MyTextSanitizer::getInstance();

	if (!$categories) {
		$categories = $wpdb->get_results("SELECT * FROM {$wpdb->categories[$wp_id]} ORDER BY cat_name");
	}
	if ($categories) {
		foreach ($categories as $category) {
			if ($currentcat != $category->cat_ID && $parent == $category->category_parent) {
				$cat_ID = $category->cat_ID;
				$cat_name = $myts->makeTareaData4Show($category->cat_name);
				$pad = str_repeat('&#8211; ', $level);
?>
				<option value='<?php echo $cat_ID ?>'<?php selected($currentparent, $cat_ID) ?>><?php echo "$pad$cat_name" ?></option>
<?php
				wp_dropdown_cats($currentcat, $currentparent, $category->cat_ID, $level + 1, $categories);
			}
		}
	} else {
		return false;
	}
}

function wp_dropdown_cats_xoops(&$formSelect, $currentcat, $currentparent = 0, $parent = 0, $level = 0, $categories = 0) {
	global $wpdb, $wp_id, $bgcolor;
	if (!$categories) {
		$categories = $wpdb->get_results("SELECT * FROM {$wpdb->categories[$wp_id]} ORDER BY cat_name");
	}
	if ($categories) {
		foreach ($categories as $category) {
			if ($currentcat != $category->cat_ID && $parent == $category->category_parent) {
				$pad = str_repeat('&#8211; ', $level);
				$formSelect->addOption($category->cat_ID, "$pad$category->cat_name");
				wp_dropdown_cats_xoops($formSelect, $currentcat, $currentparent, $category->cat_ID, $level + 1, $categories);
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

function wp_dropdown_usercat($fieldname, $selected = 0, $withall=false) {
    global $wpdb,  $wp_id;
	$myts =& MyTextSanitizer::getInstance();

    $results = $wpdb->get_results("SELECT ID, user_login FROM {$wpdb->users[$wp_id]} WHERE user_level > 0 ORDER BY ID");
?>
    <select name="<?php echo $fieldname?>" size="1">
<?php
	if ($withall) {
?>
		<option value="All"<?php selected("All", $selected) ?>>All</option>?>
<?php
	}
	foreach ($results as $row) {
		$ID = $row->ID;
		$user_login = $myts->makeTareaData4Show($row->user_login);
?>
		<option value="<?php echo $ID ?>"<?php selected($ID, $selected) ?>><?php echo $user_login ?></option>
<?php
	}
?>
    </select>
<?php
}

function wp_dropdown_linkcat($fieldname, $selected = 0, $withall=false) {
    global $wpdb,  $wp_id;
	$myts =& MyTextSanitizer::getInstance();

	$results = $wpdb->get_results("SELECT cat_id, cat_name, auto_toggle FROM {$wpdb->linkcategories[$wp_id]} ORDER BY cat_id");
?>
    <select name="<?echo $fieldname?>" size="1">
<?php
	if ($withall) {
?>
		<option value="All"<?php selected("All", $selected) ?>>All</option>?>
<?php
	}
	foreach ($results as $row) {
		$cat_id = $row->cat_id;
		$cat_name = $myts->makeTareaData4Show($row->cat_name);
		$auto_toggle = ($row->auto_toggle == 'Y') ? ' (auto toggle)' : '';
?>
		<option value="<?php echo $cat_id ?>"<?php selected($cat_id, $selected) ?>><?php echo "$cat_id :  $cat_name$auto_toggle" ?></option>
<?php
	}
?>
    </select>
<?php
}

function wp_dropdown_linkcat_xoops(&$formSelect) {
    global $wpdb,  $wp_id;
	$myts =& MyTextSanitizer::getInstance();
	$results = $wpdb->get_results("SELECT cat_id, cat_name, auto_toggle FROM {$wpdb->linkcategories[$wp_id]} ORDER BY cat_id");
	foreach ($results as $row) {
		$cat_id = $row->cat_id;
		$cat_name = $myts->makeTareaData4Show($row->cat_name);
		$auto_toggle = ($row->auto_toggle == 'Y') ? ' (auto toggle)' : '';
		$formSelect->addOption($cat_id, "$cat_id :  $cat_name$auto_toggle");
	}
}

function xfn_check($class, $value = '', $type = 'check') {
	global $link_rel;
	if ('' != $value && strstr($link_rel, $value)) {
		echo ' checked="checked"';
	}
	if ('' == $value) {
		if ('family' == $class && !strstr($link_rel, 'child') && !strstr($link_rel, 'parent') && !strstr($link_rel, 'sibling') && !strstr($link_rel, 'spouse') ) echo ' checked="checked"';
		if ('friendship' == $class && !strstr($link_rel, 'friend') && !strstr($link_rel, 'acquaintance') ) echo ' checked="checked"';
		if ('geographical' == $class && !strstr($link_rel, 'co-resident') && !strstr($link_rel, 'neighbor') ) echo ' checked="checked"';
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
	global  $wpdb ,$wp_id ,$wp_mod;
	global $xoopsUser, $xoopsDB;
	if($xoopsUser){
		$sql = "select ID,user_login from {$wpdb->users[$wp_id]} where ID = ".$xoopsUser->uid();
		$r = $xoopsDB->query($sql);
		if(list($id,$user_login) = $xoopsDB->fetchRow($r)){
			if ($xoopsUser->getVar('uname') != $user_login) {
				$sql = "UPDATE {$wpdb->users[$wp_id]} SET user_login = ".$xoopsDB->quoteString($xoopsUser->getVar('uname'))." WHERE ID = ".$xoopsUser->uid();
				$xoopsDB->queryF($sql);
			}
		}else{
			$level = 0;
			$group = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
			$edit_groups = get_xoops_option($wp_mod[$wp_id],'wp_edit_authgrp');
			$admin_groups = get_xoops_option($wp_mod[$wp_id],'wp_admin_authgrp');
			if (count(array_intersect($group,$edit_groups)) > 0) {
				$level = 1;
			}
			if (count(array_intersect($group,$admin_groups)) > 0) {
				$level = 10;
			}
			$uname = $xoopsDB->quoteString($xoopsUser->getVar('uname'));
			$email = $xoopsDB->quoteString($xoopsUser->getVar('email'));
			$sql = "INSERT INTO {$wpdb->users[$wp_id]} (ID, user_login,user_nickname,user_email, user_level,user_idmode) values(".$xoopsUser->uid().", $uname , $uname , $email , $level, 'nickname' )";
			$xoopsDB->queryF($sql);
		}
		return true;
	}
	return false;
}
// Some postmeta stuff
function has_meta($postid) {
	global $wpdb,$wp_id;

	return $wpdb->get_results("
		SELECT meta_key, meta_value, meta_id, post_id
		FROM {$wpdb->postmeta[$wp_id]}
		WHERE post_id = '$postid'
		ORDER BY meta_key,meta_id",ARRAY_A);
}

function list_meta($meta) {
	global $post_ID;	
	$myts =& MyTextSanitizer::getInstance();
	// Exit if no meta
	if (!$meta) return;	
?>
<table id='meta-list' cellpadding="3">
	<tr>
		<th>Key</th>
		<th>Value</th>
		<th colspan='2'>Action</th>
	</tr>
<?php
	$style='';
	foreach ($meta as $entry) {
		$style = ('class="alternate"' == $style) ? '' : 'class="alternate"';
		$meta_id = $entry['meta_id'];
		$meta_key = $myts->makeTboxData4Edit($entry['meta_key']);
		$meta_value = $myts->makeTareaData4Edit($entry['meta_value']);
?>
	<tr <?php echo $style?> >
		<td valign='top'><input name='meta[<?php echo $meta_id ?>][key]' tabindex='6' type='text' size='20' value='<?php echo $meta_key ?>' /></td>
		<td><textarea name='meta[<?php echo $meta_id ?>][value]' tabindex='6' rows='2' cols='30'><?php echo $meta_value ?></textarea></td>
		<td align='center' width='10%'><input name='updatemeta[<?php echo $meta_id ?>]' type='submit' class='updatemeta' tabindex='6' value='UPDATE' /></td>
		<td align='center' width='10%'><input name='deletemeta[<?php echo $meta_id ?>]' type='submit' class='deletemeta' tabindex='6' value='Delete' /></td>
	</tr>
<?php
	}
?>
</table>
<?php
}

// Get a list of previously defined keys
function get_meta_keys() {
	global $wpdb,$wp_id;
	
	$keys = $wpdb->get_col("
		SELECT meta_key
		FROM {$wpdb->postmeta[$wp_id]}
		GROUP BY meta_key
		ORDER BY meta_key");
	
	return $keys;
}

function meta_form() {
	global $wpdb,$wp_id;
	$keys = $wpdb->get_col("
		SELECT meta_key
		FROM {$wpdb->postmeta[$wp_id]}
		GROUP BY meta_key
		ORDER BY meta_id DESC
		LIMIT 10");
?>
<h3><?php _e('Add a new custom field to this post:') ?></h3>
<table cellspacing="3" cellpadding="3">
	<tr>
<th colspan="2"><?php _e('Key') ?></th>
<th><?php _e('Value') ?></th>
</tr>
	<tr valign="top">
		<td align="right" width="18%">
<?php if ($keys) : ?>
<select id="metakeyselect" name="metakeyselect" tabindex="7">
<option value="#NONE#">- Select -</option>
<?php
	foreach($keys as $key) {
		echo "\n\t<option value='$key'>$key</option>";
	}
?>
</select> or 
<?php endif; ?>
</td>
<td><input type="text" id="metakeyinput" name="metakeyinput" tabindex="7" /></td>
		<td><textarea id="metavalue" name="metavalue" rows="3" cols="25" tabindex="7"></textarea></td>
	</tr>

</table>
<p class="submit"><input type="submit" name="updatemeta" tabindex="7" value="<?php _e('Add Custom Field &raquo;') ?>" /></p>
<?php
}

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

function do_trackback($post_ID, $post_title, $content, $excerpt, $useutf8, $target_charset="") {
global $wpdb, $wp_id;

	$to_ping = $wpdb->get_var("SELECT to_ping FROM {$wpdb->posts[$wp_id]} WHERE ID = $post_ID");
	$pinged = $wpdb->get_var("SELECT pinged FROM {$wpdb->posts[$wp_id]} WHERE ID = $post_ID");
	$pinged = explode("\n", $pinged);
	if ('' != $to_ping) {
		if (strlen($excerpt) > 0) {
			$the_excerpt = apply_filters('the_excerpt', $excerpt);
		} else {
			$the_excerpt = apply_filters('the_content', $content);
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
			 trackback($tb_ping, stripslashes($post_title), $excerpt, $post_ID, $ping_charset);
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
?>
