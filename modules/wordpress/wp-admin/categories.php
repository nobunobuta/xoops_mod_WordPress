<?php
$title = 'Categories';
$parent_file = 'categories.php';
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
    $_GET    = add_magic_quotes($_GET);
    $_POST   = add_magic_quotes($_POST);
    $_COOKIE = add_magic_quotes($_COOKIE);
}

$wpvarstoreset = array('action','standalone','cat');
for ($i=0; $i<count($wpvarstoreset); $i += 1) {
    $wpvar = $wpvarstoreset[$i];
    if (!isset($$wpvar)) {
        if (empty($_POST["$wpvar"])) {
            if (empty($_GET["$wpvar"])) {
                $$wpvar = '';
            } else {
                $$wpvar = $_GET["$wpvar"];
            }
        } else {
            $$wpvar = $_POST["$wpvar"];
        }
    }
}

switch($action) {

case 'addcat':

    $standalone = 1;
    require_once('admin-header.php');
   	wp_refcheck("/wp-admin");

    if ($user_level < 3)
        die (_LANG_P_CHEATING_ERROR);
    
    $cat_name= addslashes(stripslashes(stripslashes($_POST['cat_name'])));
    $category_nicename = sanitize_title($cat_name);
    $category_description = addslashes(stripslashes(stripslashes($_POST['category_description'])));
    $cat = intval($_POST['cat']);

    $wpdb->query("INSERT INTO {$wpdb->categories[$wp_id]} (cat_ID, cat_name, category_nicename, category_description, category_parent) VALUES ('0', '$cat_name', '$category_nicename', '$category_description', '$cat')");
	if ($category_nicename == "") {
		$lastID = $wpdb->get_var("SELECT LAST_INSERT_ID()");
		$category_nicename = "category-".$lastID;
		$wpdb->query("UPDATE {$wpdb->categories[$wp_id]} SET category_nicename='$category_nicename' WHERE cat_ID = $lastID");
	}
    header('Location: categories.php?message=1#addcat');

break;

case 'Delete':

    $standalone = 1;
    require_once('admin-header.php');
   	wp_refcheck("/wp-admin");

    $cat_ID = intval($_GET["cat_ID"]);
    $cat_name = get_catname($cat_ID);
    $cat_name = addslashes($cat_name);
    $category = $wpdb->get_row("SELECT * FROM {$wpdb->categories[$wp_id]} WHERE cat_ID = '$cat_ID'");
    $cat_parent = $category->category_parent;

    if (1 == $cat_ID)
        die(sprintf(_LANG_C_DEFAULT_CAT, $cat_name));

    if ($user_level < 3)
        die (_LANG_P_CHEATING_ERROR);

    $wpdb->query("DELETE FROM {$wpdb->categories[$wp_id]} WHERE cat_ID = '$cat_ID'");
    $wpdb->query("UPDATE {$wpdb->categories[$wp_id]} SET category_parent = '$cat_parent' WHERE category_parent = '$cat_ID'");
    $wpdb->query("UPDATE {$wpdb->post2cat[$wp_id]} SET category_id='1' WHERE category_id='$cat_ID'");

    header('Location: categories.php?message=2');

break;

case 'edit':

    require_once ('admin-header.php');
    $cat_ID = intval($_GET['cat_ID']);
    $category = $wpdb->get_row("SELECT * FROM {$wpdb->categories[$wp_id]} WHERE cat_ID = '$cat_ID'");
    $cat_name = stripslashes($category->cat_name);
    ?>

<div class="wrap">
    <h2><?php echo _LANG_C_EDIT_TITLECAT; ?></h2>
    <form name="editcat" action="categories.php" method="post">
        <input type="hidden" name="action" value="editedcat" />
        <input type="hidden" name="cat_ID" value="<?php echo $cat_ID; ?>" />
        <p><?php echo _LANG_C_NAME_SUBCAT; ?><br />
        <input type="text" name="cat_name" value="<?php echo $cat_name; ?>" /></p>
        <p><?php echo _LANG_C_NAME_PARENT; ?><br />
        <select name='cat' class='postform'>
        <option value='0'<?php if (!$category->category_parent) echo " selected='selected'"; ?>>None</option>
        <?php wp_dropdown_cats($category->cat_ID, $category->category_parent); ?></p>
        </select>
        </p>

        <p><?php echo _LANG_C_NAME_CATDESC; ?><br />
										     <textarea name="category_description" rows="5" cols="50" style="width: 97%;"><?php echo htmlspecialchars($category->category_description, ENT_NOQUOTES); ?></textarea></p>
        <p class="submit"><input type="submit" name="submit" value="<?php echo _LANG_C_NAME_EDITBTN; ?>" /></p>
    </form>
</div>

    <?php

break;

case 'editedcat':

    $standalone = 1;
    require_once('admin-header.php');
   	wp_refcheck("/wp-admin");

    if ($user_level < 3)
        die (_LANG_P_CHEATING_ERROR);
    
    $cat_name = $wpdb->escape(stripslashes($_POST['cat_name']));
    $cat_ID = (int) $_POST['cat_ID'];
    $category_nicename = sanitize_title($cat_name);
	if ($category_nicename == "")  $category_nicename = "category-".$cat_ID;
    $category_description = $wpdb->escape(stripslashes($_POST['category_description']));

    $wpdb->query("UPDATE {$wpdb->categories[$wp_id]} SET cat_name = '$cat_name', category_nicename = '$category_nicename', category_description = '$category_description', category_parent = '$cat' WHERE cat_ID = '$cat_ID'");
    
    header('Location: categories.php?message=3');

break;

default:

    $standalone = 0;
    require_once ('admin-header.php');
    if ($user_level < 3) {
        die(sprintf(_LANG_C_RIGHT_EDITCAT, get_settings('admin_email')));
    }
$messages[1] = _LANG_C_MESS_ADD;
$messages[2] = _LANG_C_MESS_DELE;
$messages[3] = _LANG_C_MESS_UP;
?>
<?php if (isset($_GET['message'])) : ?>
<div class="updated"><p><?php echo $messages[$_GET['message']]; ?></p></div>
<?php endif; ?>

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
    <p><?php printf(_LANG_C_NOTE_CATEGORY, get_catname(1)) ?>
  </p>
</div>

<div class="wrap">
    <h2><?php echo _LANG_C_ADD_NEWCAT; ?></h2>
    <form name="addcat" id="addcat" action="categories.php" method="post">
        
        <p><?php echo _LANG_C_NAME_SUBCAT; ?><br />
        <input type="text" name="cat_name" value="" /></p>
        <p><?php echo _LANG_C_NAME_PARENT; ?><br />
        <select name='cat' class='postform'>
        <option value='0'>None</option>
        <?php wp_dropdown_cats(); ?></p>
        </select>
        <p><?php echo _LANG_C_NAME_SUBDESC; ?> (optional) <br />
        <textarea name="category_description" rows="5" cols="50" style="width: 97%;"></textarea></p>
        <p class="submit"><input type="hidden" name="action" value="addcat" /><input type="submit" name="submit" value="<?php echo _LANG_C_NAME_ADDBTN; ?>" /></p>
    </form>
</div>

    <?php
break;
}
include('admin-footer.php');
?>