<?php
// Links
// Copyright (C) 2002, 2003 Mike Little -- mike@zed1.com

require_once('../wp-config.php');

$title = 'Manage Links';
$this_file = 'link-manager.php';
$parent_file = 'link-manager.php';

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

function category_dropdown($fieldname, $selected = 0) {
	global $wpdb,  $wp_id;
	
	$results = $wpdb->get_results("SELECT cat_id, cat_name, auto_toggle FROM {$wpdb->linkcategories[$wp_id]} ORDER BY cat_id");
	echo "\n<select name='$fieldname' size='1'>";
	foreach ($results as $row) {
		echo "\n\t<option value='$row->cat_id'";
		if ($row->cat_id == $selected)
			echo " selected='selected'";
		echo ">$row->cat_id: $row->cat_name";
		if ('Y' == $row->auto_toggle)
			echo ' (auto toggle)';
		echo "</option>\n";
	}
	echo "\n</select>\n";
}

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

$wpvarstoreset = array('action','standalone','cat_id', 'linkurl', 'name', 'image',
                       'description', 'visible', 'target', 'category', 'link_id',
                       'submit', 'order_by', 'links_show_cat_id', 'rating', 'rel',
                       'notes', 'linkcheck[]');

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

$links_show_cat_id = $_COOKIE['links_show_cat_id_' . $cookiehash];
$links_show_order = $_COOKIE['links_show_order_' . $cookiehash];

if (!empty($action2)) {
    $action = $action2;
}

switch ($action) {
  case _LANG_WLM_ASSIGN_TEXT:
  {
    $standalone = 1;
    include_once('admin-header.php');

    // check the current user's level first.
    if ($user_level < get_settings('links_minadminlevel'))
      die ("Cheatin' uh ?");

    //for each link id (in $linkcheck[]): if the current user level >= the
    //userlevel of the owner of the link then we can proceed.

    if (count($linkcheck) == 0) {
        header('Location: ' . $this_file);
        exit;
    }
    $all_links = join(',', $linkcheck);
    $results = $wpdb->get_results("SELECT link_id, link_owner, user_level FROM {$wpdb->links[$wp_id]} LEFT JOIN {$wpdb->users[$wp_id]} ON link_owner = ID WHERE link_id in ($all_links)");
    foreach ($results as $row) {
      if (!get_settings('links_use_adminlevels') || ($user_level >= $row->user_level)) { // ok to proceed
        $ids_to_change[] = $row->link_id;
      }
    }

    // should now have an array of links we can change
    $all_links = join(',', $ids_to_change);
    $q = $wpdb->query("update {$wpdb->links[$wp_id]} SET link_owner='$newowner' WHERE link_id IN ($all_links)");

    header('Location: ' . $this_file);
    break;
  }
  case _LANG_WLM_VISIVILITY_TEXT:
  {
    $standalone = 1;
    include_once('admin-header.php');

    // check the current user's level first.
    if ($user_level < get_settings('links_minadminlevel'))
      die ("Cheatin' uh ?");

    //for each link id (in $linkcheck[]): toggle the visibility
    if (count($linkcheck) == 0) {
        header('Location: ' . $this_file);
        exit;
    }
    $all_links = join(',', $linkcheck);
    $results = $wpdb->get_results("SELECT link_id, link_visible FROM {$wpdb->links[$wp_id]} WHERE link_id in ($all_links)");
    foreach ($results as $row) {
        if ($row->link_visible == 'Y') { // ok to proceed
            $ids_to_turnoff[] = $row->link_id;
        } else {
            $ids_to_turnon[] = $row->link_id;
        }
    }

    // should now have two arrays of links to change
    if (count($ids_to_turnoff)) {
        $all_linksoff = join(',', $ids_to_turnoff);
        $q = $wpdb->query("update {$wpdb->links[$wp_id]} SET link_visible='N' WHERE link_id IN ($all_linksoff)");
    }

    if (count($ids_to_turnon)) {
        $all_linkson = join(',', $ids_to_turnon);
        $q = $wpdb->query("update {$wpdb->links[$wp_id]} SET link_visible='Y' WHERE link_id IN ($all_linkson)");
    }

    header('Location: ' . $this_file);
    break;
  }
  case _LANG_WLM_MOVE_TEXT:
  {
    $standalone = 1;
    include_once('admin-header.php');
    // check the current user's level first.
    if ($user_level < get_settings('links_minadminlevel'))
      die ("Cheatin' uh ?");

    //for each link id (in $linkcheck[]) change category to selected value
    if (count($linkcheck) == 0) {
        header('Location: ' . $this_file);
        exit;
    }
    $all_links = join(',', $linkcheck);
    // should now have an array of links we can change
    $q = $wpdb->query("update {$wpdb->links[$wp_id]} SET link_category='$category' WHERE link_id IN ($all_links)");

    header('Location: ' . $this_file);
    break;
  }

  case 'Add':
  {
    $standalone = 1;
    include_once('admin-header.php');
	wp_refcheck("/wp-admin");

    $link_url = $_POST['linkurl'];
    $link_name = $_POST['name'];
    $link_image = $_POST['image'];
    $link_target = $_POST['target'];
    $link_category = $_POST['category'];
    $link_category = intval($link_category);
    $link_description = $_POST['description'];
    $link_visible = $_POST['visible'];
    $link_rating = $_POST['rating'];
    $link_rating = intval($link_rating);
    $link_rel = $_POST['rel'];
    $link_notes = $_POST['notes'];
	$link_rss_uri =  $_POST['rss_uri'];
    $auto_toggle = get_autotoggle($link_category);

    if ($user_level < get_settings('links_minadminlevel'))
      die ("Cheatin' uh ?");

    // if we are in an auto toggle category and this one is visible then we
    // need to make the others invisible before we add this new one.
    if (($auto_toggle == 'Y') && ($link_visible == 'Y')) {
      $wpdb->query("UPDATE {$wpdb->links[$wp_id]} set link_visible = 'N' WHERE link_category = $link_category");
    }
    $wpdb->query("INSERT INTO {$wpdb->links[$wp_id]} (link_url, link_name, link_image, link_target, link_category, link_description, link_visible, link_owner, link_rating, link_rel, link_notes, link_rss) " .
      " VALUES('" . addslashes($link_url) . "','"
           . addslashes($link_name) . "', '"
           . addslashes($link_image) . "', '$link_target', $link_category, '"
           . addslashes($link_description) . "', '$link_visible', $user_ID, $link_rating, '" . addslashes($link_rel) . "', '" . addslashes($link_notes) . "', '$link_rss_uri')");

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    break;
  } // end Add

  case 'editlink':
  {
    if (isset($submit)) {

      if (isset($links_show_cat_id) && ($links_show_cat_id != ''))
        $cat_id = $links_show_cat_id;

      if (!isset($cat_id) || ($cat_id == '')) {
        if (!isset($links_show_cat_id) || ($links_show_cat_id == ''))
          $cat_id = 'All';
      }
      $links_show_cat_id = $cat_id;

      $standalone = 1;
      include_once('admin-header.php');
	  wp_refcheck("/wp-admin");

      $link_id = $_POST['link_id'];
      $link_id = intval($link_id);
      $link_url = $_POST['linkurl'];
      $link_name = $_POST['name'];
      $link_image = $_POST['image'];
      $link_target = $_POST['target'];
      $link_category = $_POST['category'];
      $link_category = intval($link_category);
      $link_description = $_POST['description'];
      $link_visible = $_POST['visible'];
      $link_rating = $_POST['rating'];
      $link_rating = intval($link_rating);
      $link_rel = $_POST['rel'];
      $link_notes = $_POST['notes'];
	  $link_rss_uri =  $_POST['rss_uri'];
      $auto_toggle = get_autotoggle($link_category);

      if ($user_level < get_settings('links_minadminlevel'))
        die ("Cheatin' uh ?");

      // if we are in an auto toggle category and this one is visible then we
      // need to make the others invisible before we update this one.
      if (($auto_toggle == 'Y') && ($link_visible == 'Y')) {
        $wpdb->query("UPDATE {$wpdb->links[$wp_id]} set link_visible = 'N' WHERE link_category = $link_category");
      }

      $wpdb->query("UPDATE {$wpdb->links[$wp_id]} SET link_url='" . addslashes($link_url) . "',
	  link_name='" . addslashes($link_name) . "',\n link_image='" . addslashes($link_image) . "',
	  link_target='$link_target',\n link_category=$link_category,
	  link_visible='$link_visible',\n link_description='" . addslashes($link_description) . "',
	  link_rating=$link_rating,
	  link_rel='" . addslashes($link_rel) . "',
	  link_notes='" . addslashes($link_notes) . "',
	  link_rss = '$link_rss_uri'
	  WHERE link_id=$link_id");
    } // end if save
    setcookie('links_show_cat_id_' . $cookiehash, $links_show_cat_id, time()+600);
    header('Location: ' . $this_file);
    break;
  } // end Save

  case 'Delete':
  {
    $standalone = 1;
    include_once('admin-header.php');
	wp_refcheck("/wp-admin");

    $link_id = $_GET["link_id"];
	$link_id = intval($link_id);
    if ($user_level < get_settings('links_minadminlevel'))
      die ("Cheatin' uh ?");

    $wpdb->query("DELETE FROM {$wpdb->links[$wp_id]} WHERE link_id = $link_id");

    if (isset($links_show_cat_id) && ($links_show_cat_id != ''))
        $cat_id = $links_show_cat_id;

    if (!isset($cat_id) || ($cat_id == '')) {
        if (!isset($links_show_cat_id) || ($links_show_cat_id == ''))
        $cat_id = 'All';
    }
    $links_show_cat_id = $cat_id;
    setcookie("links_show_cat_id_".$cookiehash, $links_show_cat_id, time()+600);
    header('Location: '.$this_file);
    break;
  } // end Delete

  case 'linkedit':
  {
    $standalone=0;
	$xfn = true;
    include_once ('admin-header.php');
    if ($user_level < get_settings('links_minadminlevel')) {
      die("You have no right to edit the links for this blog.<br />Ask for a promotion to your <a href='mailto:".get_settings('admin_email')."'>blog admin</a>. :)");
    }

    $link_id = $_GET["link_id"];
	$link_id = intval($link_id);

    $row = $wpdb->get_row("SELECT * 
	FROM {$wpdb->links[$wp_id]} 
	WHERE link_id = $link_id");

    if ($row) {
      $link_url = stripslashes($row->link_url);
      $link_name = stripslashes($row->link_name);
      $link_image = $row->link_image;
      $link_target = $row->link_target;
      $link_category = $row->link_category;
      $link_description = stripslashes($row->link_description);
      $link_visible = $row->link_visible;
      $link_rating = $row->link_rating;
      $link_rel = stripslashes($row->link_rel);
      $link_notes = stripslashes($row->link_notes);
	  $link_rss_uri = $row->link_rss;
    }

?>
<ul id="adminmenu2"> 
  <li><a href="link-manager.php" class="current"><?php echo _LANG_WLA_MANAGE_LINK; ?></a></li> 
  <li><a href="link-add.php"><?php echo _LANG_WLA_ADD_LINK; ?></a></li> 
  <li><a href="link-categories.php"><?php echo _LANG_WLA_LINK_CATE; ?></a></li> 
  <li class="last"><a href="link-import.php"><?php echo _LANG_WLA_IMPORT_BLOG; ?></a></li> 
</ul> 
<style media="screen" type="text/css">
th { text-align: right; }
</style>
<div class="wrap"> 
  <form action="" method="post" name="editlink" id="editlink"> 
  <h3><?php echo _LANG_WLM_EDIT_LINK; ?></h3>
    <table width="100%"  border="0" cellspacing="5" cellpadding="3">
      <tr>
        <th scope="row"><?php echo _LANG_WLA_SUB_URI; ?></th>
        <td><input type="text" name="linkurl" size="80" value="<?php echo $link_url; ?>" /></td>
      </tr>
      <tr>
        <th scope="row"><?php echo _LANG_WLA_SUB_NAME; ?></th>
        <td><input type="text" name="name" size="80" value="<?php echo $link_name; ?>" /></td>
      </tr>
      <tr>
        <th scope="row"><?php echo _LANG_WLA_SUB_RSS; ?></th>
        <td><input name="rss_uri" type="text" id="rss_uri" value="<?php echo $link_rss_uri; ?>" size="80"></td>
      </tr>
      <tr>
        <th scope="row"><?php echo _LANG_WLA_SUB_IMAGE; ?></th>
        <td><input type="text" name="image" size="80" value="<?php echo $link_image; ?>" /></td>
      </tr>
      <tr>
        <th scope="row"><?php echo _LANG_WLA_SUB_DESC; ?></th>
        <td><input type="text" name="description" size="80" value="<?php echo $link_description; ?>" /></td>
      </tr>
      <tr>
        <th scope="row"><?php echo _LANG_WLA_SUB_REL; ?></th>
        <td><input type="text" name="rel" id="rel" size="80" value="<?php echo $link_rel; ?>" /></td>
      </tr>
      <tr>
        <th scope="row"><a href="http://gmpg.org/xfn/">XFN</a>:</th>
        <td><table cellpadding="3" cellspacing="5">
            <tr>
              <th scope="row"> <?php echo _LANG_WLA_SUB_FRIEND; ?> </th>
              <td>
                <label for="label">
                <input class="valinp" type="radio" name="friendship" value="acquaintance" id="label" <?php xfn_check('friendship', 'acquaintance', 'radio'); ?> />  <?php echo _LANG_WLA_CHECK_ACQUA; ?></label>
                <label for="label2">
                <input class="valinp" type="radio" name="friendship" value="friend" id="label2" <?php xfn_check('friendship', 'friend', 'radio'); ?> /> <?php echo _LANG_WLA_CHECK_FRIE; ?></label>
                <label for="label3">
                <input name="friendship" type="radio" class="valinp" id="label3" value="" <?php xfn_check('friendship', '', 'radio'); ?> />
          <?php echo _LANG_WLA_CHECK_NONE; ?></label>
              </td>
            </tr>
            <tr>
              <th scope="row"> <?php echo _LANG_WLA_SUB_PHYSICAL; ?> </th>
              <td>
                <label for="label4">
                <input class="valinp" type="checkbox" name="physical" value="met" id="label4" <?php xfn_check('physical', 'met'); ?> />
          <?php echo _LANG_WLA_CHECK_MET; ?></label>
              </td>
            </tr>
            <tr>
              <th scope="row"> <?php echo _LANG_WLA_SUB_PROFESSIONAL; ?> </th>
              <td>
                <label for="label5">
                <input class="valinp" type="checkbox" name="professional" value="co-worker" id="label5" <?php xfn_check('professional', 'co-worker'); ?> />
          <?php echo _LANG_WLA_CHECK_WORKER; ?></label>
                <label for="label6">
                <input class="valinp" type="checkbox" name="professional" value="colleague" id="label6" <?php xfn_check('professional', 'colleague'); ?> />
          <?php echo _LANG_WLA_CHECK_COLL; ?></label>
              </td>
            </tr>
            <tr>
              <th scope="row"> <?php echo _LANG_WLA_SUB_GEOGRAPH; ?> </th>
              <td>
                <label for="label7">
                <input class="valinp" type="radio" name="geographical" value="co-resident" id="label7" <?php xfn_check('geographical', 'co-resident', 'radio'); ?> />
          <?php echo _LANG_WLA_CHECK_RESI; ?></label>
                <label for="label8">
                <input class="valinp" type="radio" name="geographical" value="neighbor" id="label8" <?php xfn_check('geographical', 'neighbor', 'radio'); ?> />
          <?php echo _LANG_WLA_CHECK_NEIG; ?></label>
                <label for="label9">
                <input class="valinp" type="radio" name="geographical" value="" id="label9" <?php xfn_check('geographical', '', 'radio'); ?> />
          <?php echo _LANG_WLA_CHECK_NONE; ?></label>
              </td>
            </tr>
            <tr>
              <th scope="row"> <?php echo _LANG_WLA_SUB_FAMILY; ?> </th>
              <td>
                <label for="label10">
                <input class="valinp" type="radio" name="family" value="child" id="label10" <?php xfn_check('family', 'child', 'radio'); ?>  />
          <?php echo _LANG_WLA_CHECK_CHILD; ?></label>
                <label for="label11">
                <input class="valinp" type="radio" name="family" value="parent" id="label11" <?php xfn_check('family', 'parent', 'radio'); ?> />
          <?php echo _LANG_WLA_CHECK_PARENT; ?></label>
                <label for="label12">
                <input class="valinp" type="radio" name="family" value="sibling" id="label12" <?php xfn_check('family', 'sibling', 'radio'); ?> />
          <?php echo _LANG_WLA_CHECK_SIBLING; ?></label>
                <label for="label13">
                <input class="valinp" type="radio" name="family" value="spouse" id="label13" <?php xfn_check('family', 'spouse', 'radio'); ?> />
          <?php echo _LANG_WLA_CHECK_SPOUSE; ?></label>
                <label for="label14">
                <input class="valinp" type="radio" name="family" value="" id="label14" <?php xfn_check('family', '', 'radio'); ?> />
          <?php echo _LANG_WLA_CHECK_NONE; ?></label>
              </td>
            </tr>
            <tr>
              <th scope="row"> <?php echo _LANG_WLA_SUB_ROMANTIC; ?> </th>
              <td>
                <label for="label15">
                <input class="valinp" type="checkbox" name="romantic" value="muse" id="label15" <?php xfn_check('romantic', 'muse'); ?> />
          <?php echo _LANG_WLA_CHECK_MUSE; ?></label>
                <label for="label16">
                <input class="valinp" type="checkbox" name="romantic" value="crush" id="label16" <?php xfn_check('romantic', 'crush'); ?> />
          <?php echo _LANG_WLA_CHECK_CRUSH; ?></label>
                <label for="label17">
                <input class="valinp" type="checkbox" name="romantic" value="date" id="label17" <?php xfn_check('romantic', 'date'); ?> />
          <?php echo _LANG_WLA_CHECK_DATE; ?></label>
                <label for="label18">
                <input class="valinp" type="checkbox" name="romantic" value="sweetheart" id="label18" <?php xfn_check('romantic', 'sweetheart'); ?> />
          <?php echo _LANG_WLA_CHECK_HEART; ?></label>
              </td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <th scope="row"><?php echo _LANG_WLA_SUB_NOTE; ?></th>
        <td><textarea name="notes" cols="80" rows="10"><?php echo $link_notes; ?></textarea></td>
      </tr>
      <tr>
        <th scope="row"><?php echo _LANG_WLA_SUB_RATE; ?></th>
        <td><select name="rating" size="1">
          <?php
    for ($r = 0; $r < 10; $r++) {
      echo('            <option value="'.$r.'" ');
      if ($link_rating == $r)
        echo 'selected="selected"';
      echo('>'.$r.'</option>');
    }
?>
        </select> (<?php echo _LANG_WLA_CHECK_ZERO; ?>) </td>
      </tr>
      <tr>
        <th scope="row"><?php echo _LANG_WLA_SUB_TARGET; ?></th>
        <td><label>
          <input type="radio" name="target" value="_blank"   <?php echo(($link_target == '_blank') ? 'checked="checked"' : ''); ?> />
          <code>_blank</code></label>
&nbsp;<label>
<input type="radio" name="target" value="_top" <?php echo(($link_target == '_top') ? 'checked="checked"' : ''); ?> />
<code>_top</code></label>
&nbsp;
<label>
<input type="radio" name="target" value=""     <?php echo(($link_target == '') ? 'checked="checked"' : ''); ?> />
none (<?php echo _LANG_WLA_CHECK_STRICT; ?>)</label></td>
      </tr>
      <tr>
        <th scope="row"><?php echo _LANG_WLA_SUB_VISIBLE; ?></th>
        <td><label>
          <input type="radio" name="visible" <?php if ($link_visible == 'Y') echo "checked"; ?> value="Y" />
Yes</label>
&nbsp;
<label>
<input type="radio" name="visible" <?php if ($link_visible == 'N') echo "checked"; ?> value="N" />
No</label></td>
      </tr>
      <tr>
        <th scope="row"><?php echo _LANG_WLA_SUB_CAT; ?></th>
        <td><?php category_dropdown('category', $link_category); ?></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><input type="submit" name="submit" value="<?php echo _LANG_WLM_SAVE_CHANGES; ?>" />
          &nbsp;
          <input type="submit" name="submit" value="<?php echo _LANG_WLM_EDIT_CANCEL; ?>" />
          <input type="hidden" name="action" value="editlink" />
          <input type="hidden" name="link_id" value="<?php echo $link_id; ?>" />
          <input type="hidden" name="order_by" value="<?php echo $order_by ?>" />
          <input type="hidden" name="cat_id" value="<?php echo $cat_id ?>" /></td>
      </tr>
    </table>
  </form> 
</div>
<?php
    break;
  } // end linkedit
  case "Show":
  {
    if (!isset($cat_id) || ($cat_id == '')) {
        if (!isset($links_show_cat_id) || ($links_show_cat_id == ''))
        $cat_id = 'All';
    }
    $links_show_cat_id = $cat_id;
    if (!isset($order_by) || ($order_by == '')) {
        if (!isset($links_show_order) || ($links_show_order == ''))
        $order_by = 'order_name';
    }
    $links_show_order = $order_by;
    //break; fall through
  } // end Show
  case "popup":
  {
    $link_url = stripslashes($_GET["linkurl"]);
    $link_name = stripslashes($_GET["name"]);
    //break; fall through
  }
  default:
  {
    if (isset($links_show_cat_id) && ($links_show_cat_id != ''))
        $cat_id = intval($links_show_cat_id);

    if (!isset($cat_id) || ($cat_id == '')) {
        if (!isset($links_show_cat_id) || ($links_show_cat_id == ''))
        $cat_id = 'All';
    }
    $links_show_cat_id = intval($cat_id);
    if (isset($links_show_order) && ($links_show_order != ''))
        $order_by = $links_show_order;

    if (!isset($order_by) || ($order_by == ''))
        $order_by = 'order_name';
    $links_show_order = $order_by;

    setcookie('links_show_cat_id_'.$cookiehash, $links_show_cat_id, time()+600);
    setcookie('links_show_order_'.$cookiehash, $links_show_order, time()+600);
    $standalone=0;
    include_once ("./admin-header.php");
    if ($user_level < get_settings('links_minadminlevel')) {
      die("You have no right to edit the links for this blog.<br>Ask for a promotion to your <a href=\"mailto:get_settings('admin_email')\">blog admin</a> :)");
    }

    switch ($order_by)
    {
        case 'order_id':     $sqlorderby = 'id';          break;
        case 'order_url':    $sqlorderby = 'url';         break;
        case 'order_desc':   $sqlorderby = 'description'; break;
        case 'order_owner':  $sqlorderby = 'owner';       break;
        case 'order_rating': $sqlorderby = 'rating';      break;
        case 'order_name':
        default:             $sqlorderby = 'name';        break;
    }

  if ($action != "popup") {
?>
<script type="text/javascript">
<!--
function checkAll(form)
{
	for (i = 0, n = form.elements.length; i < n; i++) {
		if(form.elements[i].type == "checkbox") {
			if(form.elements[i].checked == true)
				form.elements[i].checked = false;
			else
				form.elements[i].checked = true;
		}
	}
}
//-->
</script>
<ul id="adminmenu2">
	<li><a href="link-manager.php" class="current"><?php echo _LANG_WLA_MANAGE_LINK; ?></a></li>
	<li><a href="link-add.php"><?php echo _LANG_WLA_ADD_LINK; ?></a></li>
	<li><a href="link-categories.php"><?php echo _LANG_WLA_LINK_CATE; ?></a></li>
	<li class="last"><a href="link-import.php"><?php echo _LANG_WLA_IMPORT_BLOG; ?></a></li>
</ul>
<div class="wrap">
    <form name="cats" method="post" action="">
    <table width="75%" cellpadding="3" cellspacing="3">
      <tr>
        <td>
          <?php echo _LANG_WLM_SHOW_LINKS; ?><br />
        </td>
        <td>
          <?php echo _LANG_WLM_ORDER_BY; ?>
        </td>
		<td>&nbsp;</td>
      </tr>
      <tr>
        <td>
<?php
    $results = $wpdb->get_results("SELECT cat_id, cat_name, auto_toggle FROM {$wpdb->linkcategories[$wp_id]} ORDER BY cat_id");
    echo "        <select name=\"cat_id\">\n";
    echo "          <option value=\"All\"";
    if ($cat_id == 'All')
      echo " selected='selected'";
    echo "> All</option>\n";
    foreach ($results as $row) {
      echo "          <option value=\"".$row->cat_id."\"";
      if ($row->cat_id == $cat_id)
        echo " selected='selected'";
        echo ">".$row->cat_id.": ".$row->cat_name;
        if ($row->auto_toggle == 'Y')
            echo ' (auto toggle)';
        echo "</option>\n";
    }
    echo "        </select>\n";
?>
        </td>
        <td>
          <select name="order_by">
            <option value="order_id"     <?php if ($order_by == 'order_id')     echo " selected='selected'";?>>Link ID</option>
            <option value="order_name"   <?php if ($order_by == 'order_name')   echo " selected='selected'";?>>Name</option>
            <option value="order_url"    <?php if ($order_by == 'order_url')    echo " selected='selected'";?>>URI</option>
            <option value="order_desc"   <?php if ($order_by == 'order_desc')   echo " selected='selected'";?>>Description</option>
            <option value="order_owner"  <?php if ($order_by == 'order_owner')  echo " selected='selected'";?>>Owner</option>
            <option value="order_rating" <?php if ($order_by == 'order_rating') echo " selected='selected'";?>>Rating</option>
          </select>
        </td>
        <td>
          <input type="submit" name="action" value="<?php echo _LANG_WLM_SHOW_BUTTONTEXT; ?>" />
        </td>
      </tr>
    </table>
    </form>

</div>

<div class="wrap">

    <form name="links" id="links" method="post" action="">
    <input type="hidden" name="link_id" value="" />
    <input type="hidden" name="action" value="" />
    <input type="hidden" name="order_by" value="<?php echo $order_by ?>" />
    <input type="hidden" name="cat_id" value="<?php echo $cat_id ?>" />
  <table width="100%" cellpadding="3" cellspacing="3">
    <tr>
      <th width="15%"><?php echo gethelp_link($this_file,'list_o_links');?> <?php echo _LANG_WLA_SUB_NAME; ?></th>
      <th><?php echo _LANG_WLA_SUB_URI; ?></th>
      <th><?php echo _LANG_WLA_SUB_CAT; ?></th>
      <th><?php echo _LANG_WLA_SUB_REL; ?></th>
      <th><?php echo _LANG_WLA_SUB_IMAGE; ?></th>
      <th><?php echo _LANG_WLA_SUB_VISIBLE; ?></th>
      <th colspan="2"><?php echo _LANG_WLM_SHOW_ACTIONTEXT; ?></th>
      <th>&nbsp;</th>
  </tr>
<?php
    $sql = "SELECT link_url, link_name, link_image, link_description, link_visible,
            link_category AS cat_id, cat_name AS category, {$wpdb->users[$wp_id]}.user_login, link_id,
            link_rating, link_rel, {$wpdb->users[$wp_id]}.user_level
            FROM {$wpdb->links[$wp_id]}
            LEFT JOIN {$wpdb->linkcategories[$wp_id]} ON {$wpdb->links[$wp_id]}.link_category = {$wpdb->linkcategories[$wp_id]}.cat_id
            LEFT JOIN {$wpdb->users[$wp_id]} ON {$wpdb->users[$wp_id]}.ID = {$wpdb->links[$wp_id]}.link_owner ";

    if (isset($cat_id) && ($cat_id != 'All')) {
      $cat_id = intval($cat_id);
      $sql .= " WHERE link_category = $cat_id ";
    }
    $sql .= ' ORDER BY link_' . $sqlorderby;

    // echo "$sql";
    $links = $wpdb->get_results($sql);
    if ($links) {
        foreach ($links as $link) {
            $short_url = str_replace('http://', '', stripslashes($link->link_url));
            $short_url = str_replace('www.', '', $short_url);
            if ('/' == substr($short_url, -1))
                $short_url = substr($short_url, 0, -1);
            if (strlen($short_url) > 35)
                $short_url =  substr($short_url, 0, 32).'...';

            $link->link_name = stripslashes($link->link_name);
            $link->category = stripslashes($link->category);
            $link->link_rel = stripslashes($link->link_rel);
            $link->link_description = stripslashes($link->link_description);
            $image = ($link->link_image != null) ? 'Yes' : 'No';
            $visible = ($link->link_visible == 'Y') ? 'Yes' : 'No';
            ++$i;
            $style = ($i % 2) ? ' class="alternate"' : '';
            echo <<<LINKS
 
 
    <tr valign="middle" $style>
        <td><strong>$link->link_name</strong><br />
        Description: $link->link_description</td>
        <td><a href="$link->link_url" title="Visit $link->link_name">$short_url</a></td>
        <td>$link->category</td>
        <td>$link->link_rel</td>
        <td align='center'>$image</td>
        <td align='center'>$visible</td>
LINKS;
            $show_buttons = 1; // default

            if (get_settings('links_use_adminlevels') && ($link->user_level > $user_level)) {
              $show_buttons = 0;
            }

            if ($show_buttons) {
              echo <<<LINKS
        <td><a href="link-manager.php?link_id=$link->link_id&amp;action=linkedit" class="edit">Edit</a></td>
        <td><a href="link-manager.php?link_id=$link->link_id&amp;action=Delete" onclick="return confirm('You are about to delete this link.\\n  \'Cancel\' to stop, \'OK\' to delete.');" class="delete">Delete</a></td>
        <td><input type="checkbox" name="linkcheck[]" value="$link->link_id" /></td>
LINKS;
            } else {
              echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>\n";
            }
		echo "\n\t</tr>";
        }
    }
?>
</table>

</div>

<div class="wrap">
<h2><?php echo _LANG_WLM_MULTI_LINK; ?></h2>
  <table width="100%" cellpadding="3" cellspacing="3">
    <tr><td colspan="4"><?php echo _LANG_WLM_CHECK_CHOOSE; ?></td></tr>
    <tr>
        <td>
          <input type="submit" name="action2" value="<?php echo _LANG_WLM_ASSIGN_TEXT; ?>" /> <?php echo _LANG_WLM_OWNER_SHIP; ?>
<?php
    $results = $wpdb->get_results("SELECT ID, user_login FROM {$wpdb->users[$wp_id]} WHERE user_level > 0 ORDER BY ID");
    echo "          <select name=\"newowner\" size=\"1\">\n";
    foreach ($results as $row) {
      echo "            <option value=\"".$row->ID."\"";
      echo ">".$row->user_login;
      echo "</option>\n";
    }
    echo "          </select>\n";
?>
        </td>
        <td>
          <?php echo _LANG_WLM_TOGGLE_TEXT; ?><input type="submit" name="action2" value="<?php echo _LANG_WLM_VISIVILITY_TEXT; ?>" />
        </td>
        <td>
          <input type="submit" name="action2" value="<?php echo _LANG_WLM_MOVE_TEXT; ?>" /><?php echo _LANG_WLM_TO_CATEGORY; ?>
<?php category_dropdown('category'); ?>
        </td>
        <td align="right">
          <a href="#" onclick="checkAll(document.getElementById('links')); return false; "><?php echo _LANG_WLM_TOGGLE_BOXES; ?></a>
        </td>
    </tr>
</table>

<?php
  } // end if !popup
?>
</form>
</div>


<?php
    break;
  } // end default
} // end case
?>



<?php include('admin-footer.php'); ?>
