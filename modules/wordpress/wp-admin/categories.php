<?php
$title = 'Categories';
/* <Categories> */

function add_magic_quotes($array) {
	foreach ($array as $k => $v) {
		if (is_array($v)) {
			$array[$k] = add_magic_quotes($v);
		} else {
			$array[$k] = addslashes($v);
		}
	}
	return $array;
} 

if (!get_magic_quotes_gpc()) {
	$HTTP_GET_VARS    = add_magic_quotes($HTTP_GET_VARS);
	$HTTP_POST_VARS   = add_magic_quotes($HTTP_POST_VARS);
	$HTTP_COOKIE_VARS = add_magic_quotes($HTTP_COOKIE_VARS);
}

$wpvarstoreset = array('action','standalone','cat');
for ($i=0; $i<count($wpvarstoreset); $i += 1) {
	$wpvar = $wpvarstoreset[$i];
	if (!isset($$wpvar)) {
		if (empty($HTTP_POST_VARS["$wpvar"])) {
			if (empty($HTTP_GET_VARS["$wpvar"])) {
				$$wpvar = '';
			} else {
				$$wpvar = $HTTP_GET_VARS["$wpvar"];
			}
		} else {
			$$wpvar = $HTTP_POST_VARS["$wpvar"];
		}
	}
}

switch($action) {

case 'addcat':

	$standalone = 1;
	require_once('admin-header.php');
	
	if ($user_level < 3)
		die ('Cheatin&#8217; uh?');
	
	$cat_name= addslashes(stripslashes(stripslashes($HTTP_POST_VARS['cat_name'])));
	$category_nicename = sanitize_title($cat_name);
	$category_description = addslashes(stripslashes(stripslashes($HTTP_POST_VARS['category_description'])));
	
	$wpdb->query("INSERT INTO {$wpdb->categories[$wp_id]} (cat_ID, cat_name, category_nicename, category_description) VALUES ('0', '$cat_name', '$category_nicename', '$category_description')");
	if ($category_nicename == "") {
		$lastID = $wpdb->get_var("SELECT LAST_INSERT_ID()");
		$category_nicename = "category-".$lastID;
		$wpdb->query("UPDATE {$wpdb->categories[$wp_id]} SET category_nicename='$category_nicename' WHERE cat_ID = $lastID");
	}
	header('Location: categories.php');

break;

case 'Delete':

	$standalone = 1;
	require_once('admin-header.php');

	$cat_ID = intval($HTTP_GET_VARS["cat_ID"]);
	$cat_name = get_catname($cat_ID);
	$cat_name = addslashes($cat_name);

	if (1 == $cat_ID)
		die("Can't delete the <strong>$cat_name</strong> category: this is the default one");

	if ($user_level < 3)
		die ('Cheatin&#8217; uh?');

	$wpdb->query("DELETE FROM {$wpdb->categories[$wp_id]} WHERE cat_ID = $cat_ID");
	$wpdb->query("UPDATE {$wpdb->post2cat[$wp_id]} SET category_id='1' WHERE category_id='$cat_ID'");

	header('Location: categories.php');

break;

case 'edit':

	require_once ('admin-header.php');
	$category = $wpdb->get_row("SELECT * FROM {$wpdb->categories[$wp_id]} WHERE cat_ID = " . $HTTP_GET_VARS['cat_ID']);
	$cat_name = stripslashes($category->cat_name);
	?>

<div class="wrap">
	<h2><?php echo _LANG_C_EDIT_TITLECAT; ?></h2>
	<form name="editcat" action="categories.php" method="post">
		<input type="hidden" name="action" value="editedcat" />
		<input type="hidden" name="cat_ID" value="<?php echo $HTTP_GET_VARS['cat_ID'] ?>" />
		<p><?php echo _LANG_C_NAME_SUBCAT; ?><br />
		<input type="text" name="cat_name" value="<?php echo $cat_name; ?>" /></p>
		<p><? echo _LANG_C_NAME_SUBDESC; ?><br />
		<textarea name="category_description" rows="5" cols="50" style="width: 97%;"><?php echo htmlentities($category->category_description); ?></textarea></p>
		<p><input type="submit" name="submit" value="<?php echo _LANG_C_NAME_EDITBTN; ?>" /></p>
	</form>
</div>

	<?php

break;

case 'editedcat':

	$standalone = 1;
	require_once('admin-header.php');

	if ($user_level < 3)
		die ('Cheatin&#8217; uh?');
	
	$cat_name = addslashes(stripslashes(stripslashes($HTTP_POST_VARS['cat_name'])));
	$cat_ID = addslashes($HTTP_POST_VARS['cat_ID']);
	$category_nicename = sanitize_title($cat_name);
	if ($category_nicename == "")  $category_nicename = "category-".$cat_ID;
	$category_description = $HTTP_POST_VARS['category_description'];

	$wpdb->query("UPDATE {$wpdb->categories[$wp_id]} SET cat_name = '$cat_name', category_nicename = '$category_nicename', category_description = '$category_description' WHERE cat_ID = $cat_ID");
	
	header('Location: categories.php');

break;

default:

	$standalone = 0;
	require_once ('admin-header.php');
	if ($user_level < 3) {
		die("You have no right to edit the categories for this blog.<br />Ask for a promotion to your <a href='mailto:".get_settings('admin_email')."'>blog admin</a>. :)");
	}
	?>

<div class="wrap">
	<h2><?php echo _LANG_C_NAME_CURRCAT; ?></h2>
	<table width="100%" cellpadding="3" cellspacing="3">
	<tr>
		<th scope="col"><?php echo _LANG_C_NAME_CATNAME; ?></th>
		<th scope="col"><?php echo _LANG_C_NAME_CATDESC; ?></th>
		<th scope="col"><?php echo _LANG_C_NAME_CATPOSTS; ?></th>
		<th colspan="2"><?php echo _LANG_C_NAME_CATACTION; ?></th>
	</tr>
	<?php
	$categories = $wpdb->get_results("SELECT * FROM {$wpdb->categories[$wp_id]} ORDER BY cat_name");
	foreach ($categories as $category) {
		$count = $wpdb->get_var("SELECT COUNT(post_id) FROM {$wpdb->post2cat[$wp_id]} WHERE category_id = $category->cat_ID");
		$bgcolor = ('#eee' == $bgcolor) ? 'none' : '#eee';
		echo "<tr style='background-color: $bgcolor'><td>$category->cat_name</td>
		<td>$category->category_description</td>
		<td>$count</td>
		<td><a href='categories.php?action=edit&amp;cat_ID=$category->cat_ID' class='edit'>"._LANG_C_NAME_EDIT."</a></td><td><a href='categories.php?action=Delete&amp;cat_ID=$category->cat_ID' onclick=\"return confirm('You are about to delete the category \'". addslashes($category->cat_name) ."\' and all its posts will go to the default category.\\n  \'OK\' to delete, \'Cancel\' to stop.')\" class='delete'>"._LANG_C_NAME_DELETE."</a></td>
		</tr>";
	}
	?>
	</table>

</div>
<div class="wrap">
	<h2><?php echo _LANG_C_ADD_NEWCAT; ?></h2>
	<form name="addcat" action="categories.php" method="post">
		
		<p><?php echo _LANG_C_NAME_CATNAME; ?><br />
		<input type="text" name="cat_name" value="" /></p>
		<p><?php echo _LANG_C_NAME_CATDESC; ?> (optional) <br />
		<textarea name="category_description" rows="5" cols="50" style="width: 97%;"></textarea></p>
		<p><input type="hidden" name="action" value="addcat" /><input type="submit" name="submit" value="<?php echo _LANG_C_NAME_ADD; ?>" /></p>
	</form>
</div>


<div class="wrap">
<h2>Note : </h2>
  <p><?php echo _LANG_C_NOTE_CATEGORY; ?> &rsaquo;&rsaquo; <strong><?php echo get_catname(1) ?></strong></p>
</div>

	<?php
break;
}

/* </Categories> */
include('admin-footer.php');
?>