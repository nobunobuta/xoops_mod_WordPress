<?php
require_once('admin.php');

$title = 'Categories';
$this_file = 'categories.php';
$parent_file = 'categories.php';

param( 'action', 'string', '');

switch($action) {
case 'addcat':
	   	wp_refcheck("/wp-admin/categories.php");
		if ($user_level < 3) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
			exit();
		}
		param('cat_name',             'string',  true);
		param('category_description', 'string');
		param('cat',                  'integer');

		$cat_name = $wpdb->escape($cat_name);
    	$category_nicename = sanitize_title($cat_name);
		$category_description = $wpdb->escape($category_description);
		$wpdb->hide_errors();
		$query ="INSERT INTO {$wpdb->categories[$wp_id]} (cat_ID, cat_name, category_nicename, category_description, category_parent) VALUES ('0', '$cat_name', '$category_nicename', '$category_description', '$cat')";
		if (!$wpdb->query($query)) {
	    	redirect_header($siteurl.'/wp-admin/categories.php#addcat',5,mysql_error());
	    	exit();
		}
		$wpdb->show_errors();
		if ($category_nicename == "") {
			$lastID = $wpdb->get_var("SELECT LAST_INSERT_ID()");
			$category_nicename = "category-".$lastID;
			$wpdb->query("UPDATE {$wpdb->categories[$wp_id]} SET category_nicename='$category_nicename' WHERE cat_ID = $lastID");
		}

	    header('Location: categories.php?message=1#addcat');
		break;

	case 'Delete':
		wp_refcheck("/wp-admin/categories.php");
		if ($user_level < 3) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
			exit();
		}

		param('cat_ID', 'integer',  true);

		$cat_name = addslashes(get_catname($cat_ID));
    	$category = $wpdb->get_row("SELECT * FROM {$wpdb->categories[$wp_id]} WHERE cat_ID = '$cat_ID'");
    	$cat_parent = $category->category_parent;

		if ($cat_ID == 1) {
			redirect_header($siteurl.'/wp-admin/categories.php',2,sprintf(_LANG_C_DEFAULT_CAT, $cat_name));
			exit();
		}

 	   	$wpdb->query("DELETE FROM {$wpdb->categories[$wp_id]} WHERE cat_ID = '$cat_ID'");
	   	$wpdb->query("UPDATE {$wpdb->categories[$wp_id]} SET category_parent = '$cat_parent' WHERE category_parent = '$cat_ID'");
	   	$wpdb->query("UPDATE {$wpdb->post2cat[$wp_id]} SET category_id='1' WHERE category_id='$cat_ID'");

    	header('Location: categories.php?message=2');
		break;

    case 'edit':
	    $standalone = 0;
        require_once ('admin-header.php');
	    param('cat_ID', 'integer',  true);
    
		$myts =& MyTextSanitizer::getInstance();

		$category = $wpdb->get_row("SELECT * FROM {$wpdb->categories[$wp_id]} WHERE cat_ID = '$cat_ID'");

		$form_id = "editcat";
		$form_title = _LANG_C_EDIT_TITLECAT;
		$cat_ID = $category->cat_ID;
		$cat_name = $myts->makeTboxData4Edit($category->cat_name);
		$category_parent = $category->category_parent;
		$category_description = $myts->makeTareaData4Edit($category->category_description);
		include('include/categories-form.php');
	break;

	case 'editedcat':
		wp_refcheck("/wp-admin/categories.php");
		if ($user_level < 3) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
			exit();
		}

		param('cat_ID',               'integer',  true);
		param('cat_name',             'string',  true);
		param('category_description', 'string');
		param('cat',                  'integer');
    
		$cat_name = $wpdb->escape($cat_name);
    	$category_nicename = sanitize_title($cat_name);
		if ($category_nicename == "")  $category_nicename = "category-".$cat_ID;
		$category_description = $wpdb->escape($category_description);
    
		$query = "UPDATE {$wpdb->categories[$wp_id]} SET cat_name = '$cat_name', category_nicename = '$category_nicename', category_description = '$category_description', category_parent = '$cat' WHERE cat_ID = '$cat_ID'";
		$wpdb->hide_errors();
		if (!$wpdb->query($query)) {
			redirect_header($siteurl.'/wp-admin/categories.php?action=edit&cat_ID='.$cat_ID,5,mysql_error());
			exit();
		}
		$wpdb->show_errors();
	    header('Location: categories.php?message=3');
		break;

default:
    $standalone = 0;
    require_once ('admin-header.php');
    if ($user_level < 3) {
		redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
		exit();
	}

	param('message', 'integer','');
	$messages = array('', _LANG_C_MESS_ADD, _LANG_C_MESS_DELE, _LANG_C_MESS_UP);
	if ($message) {
?>
<div class="updated"><p><?php echo $messages[$message]; ?></p></div>
<?php
		}
?>
<div class="wrap">
     <h2><?php printf(_LANG_C_NAME_CURRCAT, '#addcat'); ?></h2>
<table width="100%" cellpadding="3" cellspacing="3">
	<tr>
		<th scope="col">ID</th>
        <th scope="col"><?php echo _LANG_C_NAME_CATNAME; ?></th>
        <th scope="col"><?php echo _LANG_C_NAME_CATDESC; ?></th>
        <th scope="col"><?php echo _LANG_C_NAME_CATPOSTS; ?></th>
        <th colspan="2"><?php echo _LANG_C_NAME_CATACTION; ?></th>
	</tr>
<?php
cat_rows();
?>
</table>
</div>

<div class="wrap">
    <p><?php printf(_LANG_C_NOTE_CATEGORY, get_catname(1)) ?></p>
</div>

<?php
		$form_id = "addcat";
		$form_title = _LANG_C_ADD_NEWCAT;
		$cat_ID = 0;
		$cat_name = "";
		$category_parent = 0;
		$category_description = "";
		include('include/categories-form.php');

break;
}
include('admin-footer.php');

function cat_rows($parent = 0, $level = 0, $categories = 0) {
	global $wpdb, $wp_id;
	$myts =& MyTextSanitizer::getInstance();

	if (!$categories) {
		$categories = $wpdb->get_results("SELECT * FROM {$wpdb->categories[$wp_id]} ORDER BY cat_name");
	}
	if ($categories) {
		$i = 0;
		foreach ($categories as $category) {
			if ($category->category_parent == $parent) {
				$count = $wpdb->get_var("SELECT COUNT(post_id) FROM {$wpdb->post2cat[$wp_id]} WHERE category_id = $category->cat_ID");
				$pad = str_repeat('&#8212; ', $level);
	            $i++;
    	        $style = ($i % 2) ? ' class="alternate"' : '';
    	        $confirm_msg = sprintf('You are about to delete the category\\\'%s\\\'\nAll of its posts will go to the default category.\n\\\'OK\\\' to delete, \\\'Cancel\\\' to stop.', $myts->htmlSpecialChars(addslashes($category->cat_name)));
?>
<tr <?php echo $style?>>
	<th scope='row'><?php echo $category->cat_ID ?></th>
	<td><?php echo "$pad $category->cat_name"; ?></td>
	<td><?php echo $category->category_description ?></td>
	<td><?php echo $count ?></td>
	<td><a href='categories.php?action=edit&amp;cat_ID=<?php echo $category->cat_ID ?>' class='edit'><?php echo _LANG_C_NAME_EDIT ?></a></td>
	<td><a href='categories.php?action=Delete&amp;cat_ID=<?php echo $category->cat_ID ?>' onclick="return confirm('<?php echo $confirm_msg ?>')" class='delete'><?php echo _LANG_C_NAME_DELETE ?></a></td>
</tr>
<?php
				cat_rows($category->cat_ID, $level + 1);
			}
		}
	} else {
		return false;
	}
}
?>