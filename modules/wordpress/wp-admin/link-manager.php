<?php
// Links
// Copyright (C) 2002, 2003 Mike Little -- mike@zed1.com

require_once('admin.php');

$title = 'Manage Links';
$this_file = 'link-manager.php';
$parent_file = 'link-manager.php';

param('action','string','');
param('action2','string');
param('cat_id', 'integer', '');
param('order_by', 'string');
$links_show_cat_id = param($wp_prefix[$wp_id].'links_show_cat_id', 'integer','');
$links_show_order = param($wp_prefix[$wp_id].'links_show_order', 'string','');
if (!empty($action2)) {
    $action = $action2;
}

switch ($action) {
	case _LANG_WLM_ASSIGN_TEXT:
		wp_refcheck("/wp-admin/link-manager.php");
		if ($user_level < get_settings('links_minadminlevel')) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
			exit();
		}
		param('linkcheck','array-int');
		param('newowner','integer');
		
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

	case _LANG_WLM_VISIVILITY_TEXT:
		wp_refcheck("/wp-admin/link-manager.php");
		if ($user_level < get_settings('links_minadminlevel')) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
			exit();
		}
		param('linkcheck','array-int');

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
	case _LANG_WLM_MOVE_TEXT:
		wp_refcheck("/wp-admin/link-manager.php");
		if ($user_level < get_settings('links_minadminlevel')) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
			exit();
		}
		param('linkcheck','array-int');
		param('category','integer');

		if (count($linkcheck) == 0) {
		    header('Location: ' . $this_file);
		    exit;
		}
		$all_links = join(',', $linkcheck);
		// should now have an array of links we can change
		$q = $wpdb->query("update {$wpdb->links[$wp_id]} SET link_category='$category' WHERE link_id IN ($all_links)");

		header('Location: ' . $this_file);
		break;
 case 'Add':
		wp_refcheck("/wp-admin/link-add.php");
		if ($user_level < get_settings('links_minadminlevel')) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
			exit();
		}

		$link_url = $wpdb->escape(param('linkurl','string',true));
		$link_name = $wpdb->escape(param('name','string',true));
		$link_image = $wpdb->escape(param('image','string',''));
		$link_target = $wpdb->escape(param('target','string',''));
		$link_category = param('category','integer', 1);
		$link_description = $wpdb->escape(param('description','string',''));
		$link_visible = $wpdb->escape(param('visible','string-yn','Y'));
		$link_rating = param('rating','integer', 0);
		$link_rel = $wpdb->escape(param('rel','string',''));
		$link_notes = $wpdb->escape(param('notes','html',''));
		$link_rss_uri = $wpdb->escape(param('rss_uri','string',''));

	    $auto_toggle = get_autotoggle($link_category);

		// if we are in an auto toggle category and this one is visible then we
		// need to make the others invisible before we add this new one.
		if (($auto_toggle == 'Y') && ($link_visible == 'Y')) {
			 $wpdb->query("UPDATE {$wpdb->links[$wp_id]} set link_visible = 'N' WHERE link_category = $link_category");
		}
		$wpdb->query("INSERT INTO {$wpdb->links[$wp_id]} (link_url, link_name, link_image, link_target, link_category, link_description, link_visible, link_owner, link_rating, link_rel, link_notes, link_rss) " .
		  " VALUES('$link_url','$link_name', '$link_image', '$link_target', $link_category, '$link_description', '$link_visible', $user_ID, $link_rating, '$link_rel', '$link_notes', '$link_rss_uri')");
		header('Location: ' . $this_file);
		break;
  	case 'editlink':
		wp_refcheck("/wp-admin/link-manager.php");
		if ($user_level < get_settings('links_minadminlevel')) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
			exit();
		}
		param('submit','string', '');
		if ($submit == _LANG_WLM_SAVE_CHANGES) {
			param('link_id','integer',true);
			$link_url = $wpdb->escape(param('linkurl','string',true));
			$link_name = $wpdb->escape(param('name','string',true));
			$link_image = $wpdb->escape(param('image','string',''));
			$link_target = $wpdb->escape(param('target','string',''));
			$link_category = param('category','integer', 1);
			$link_description = $wpdb->escape(param('description','string',''));
			$link_visible = $wpdb->escape(param('visible','string-yn','Y'));
			$link_rating = param('rating','integer', 0);
			$link_rel = $wpdb->escape(param('rel','string',''));
			$link_notes = $wpdb->escape(param('notes','html',''));
			$link_rss_uri = $wpdb->escape(param('rss_uri','string',''));
			$auto_toggle = get_autotoggle($link_category);

			// if we are in an auto toggle category and this one is visible then we
			// need to make the others invisible before we update this one.
			if (($auto_toggle == 'Y') && ($link_visible == 'Y')) {
				$wpdb->query("UPDATE {$wpdb->links[$wp_id]} set link_visible = 'N' WHERE link_category = $link_category");
			}

			$wpdb->query("UPDATE {$wpdb->links[$wp_id]} 
			SET link_url='$link_url',
				link_name='$link_name',
				link_image='$link_image',
				link_target='$link_target',
				link_category=$link_category,
				link_visible='$link_visible',
				link_description='$link_description',
				link_rating=$link_rating,
				link_rel='$link_rel',
				link_notes='$link_notes',
				link_rss = '$link_rss_uri'
			WHERE link_id=$link_id");
		}
		header('Location: ' . $this_file);
		break;
  case 'Delete':
		wp_refcheck("/wp-admin/link-manager.php");
		if ($user_level < get_settings('links_minadminlevel')) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
			exit();
		}
		param('link_id','integer',true);

		$wpdb->query("DELETE FROM {$wpdb->links[$wp_id]} WHERE link_id = $link_id");
		header('Location: '.$this_file);
		break;
	case 'linkedit':
	    $standalone=0;
		$xfn = true;
	    include_once ('admin-header.php');
		if ($user_level < get_settings('links_minadminlevel')) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_WLC_RIGHT_PROM);
			exit();
		}
		param('link_id', 'integer', true);
		$myts =& MyTextSanitizer::getInstance();

		$row = $wpdb->get_row("SELECT * FROM {$wpdb->links[$wp_id]} WHERE link_id = $link_id");

	    if ($row) {
			$form_title = _LANG_WLM_EDIT_LINK;
			$form_id = "editlink";
			
			$link_url = $myts->makeTboxData4Edit($row->link_url);
			$link_name = $myts->makeTboxData4Edit($row->link_name);
			$link_rss_uri = $myts->makeTboxData4Edit($row->link_rss);
			$link_image = $myts->makeTboxData4Edit($row->link_image);
			$link_description = $myts->makeTboxData4Edit($row->link_description);
			$link_rel = $myts->makeTboxData4Show($row->link_rel);
			$link_rels = explode(" ",$link_rel);

			$friendship = array_intersect($link_rels,array('acquaintance','friend'));
			sort($friendship);
			$friendship = (count($friendship)==0) ? '': $friendship[0];

			$physical = array_intersect($link_rels,array('met'));
			
			$professional = array_intersect($link_rels,array('co-worker','colleague'));

			$geographical = array_intersect($link_rels,array('co-resident','neighbor'));
			sort($geographical);
			$geographical = (count($geographical)==0) ? '': $geographical[0];

			$family = array_intersect($link_rels,array('child','parent','sibling','spouse'));
			sort($family);
			$family = (count($family)==0) ? '': $family[0];

			$romantic = array_intersect($link_rels,array('muse','crush','date','sweetheart'));

			$link_notes = $myts->makeTareaData4Edit($row->link_notes);
		    $link_rating = $row->link_rating;
			$link_target = $myts->makeTboxData4Edit($row->link_target);
			$link_visible = $myts->makeTboxData4Edit($row->link_visible);
			$link_category = $row->link_category;

			include('include/link-manager-form.php');
    }
    break;
	case _LANG_WLM_SHOW_BUTTONTEXT:
	    if (!isset($cat_id) || ($cat_id == '')) {
	        if (!isset($links_show_cat_id) || ($links_show_cat_id == ''))
	        $cat_id = 'All';
	    }
	    $links_show_cat_id = $cat_id;
		$_SESSION[$wp_prefix[$wp_id].'links_show_cat_id'] = intval($cat_id);
	    if (!isset($order_by) || ($order_by == '')) {
	        if (!isset($links_show_order) || ($links_show_order == ''))
	        $order_by = 'order_name';
	    }
	    $links_show_order = $order_by;
		$_SESSION[$wp_prefix[$wp_id].'links_show_order'] = $links_show_order;
 	   //break; fall through
  case "popup":
 		$link_url  = param('linkurl','string');
  		$link_name = param('name','string');
  	  //break; fall through
  default:
    if (isset($links_show_cat_id) && ($links_show_cat_id != ''))
        $cat_id = intval($links_show_cat_id);

    if (!isset($cat_id) || ($cat_id == '')) {
        if (!isset($links_show_cat_id) || ($links_show_cat_id == ''))
        $cat_id = 'All';
    }
    if (isset($links_show_order) && ($links_show_order != ''))
        $order_by = $links_show_order;

    if (!isset($order_by) || ($order_by == ''))
        $order_by = 'order_name';

    $standalone=0;
    include_once ("./admin-header.php");
    if ($user_level < get_settings('links_minadminlevel')) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_WLC_RIGHT_PROM);
			exit();
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
		<?php wp_dropdown_linkcat('cat_id', $cat_id, true) ?>
        </td>
        <td>
          <select name="order_by">
            <option value="order_id" <?php selected($order_by, 'order_id')?>>Link ID</option>
            <option value="order_name" <?php selected($order_by, 'order_name')?>>Name</option>
            <option value="order_url" <?php selected($order_by, 'order_url')?>>URI</option>
            <option value="order_desc" <?php selected($order_by, 'order_desc')?>>Description</option>
            <option value="order_owner" <?php selected($order_by, 'order_owner')?>>Owner</option>
            <option value="order_rating" <?php selected($order_by, 'order_rating')?>>Rating</option>
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
    		$sql .= " WHERE link_category = $cat_id ";
    	}
    	$sql .= ' ORDER BY link_' . $sqlorderby;
    	$links = $wpdb->get_results($sql);

    	if ($links) {
        	foreach ($links as $link) {
				$link_url = $myts->makeTboxData4Show($link->link_url);
				$short_url = str_replace('http://', '', stripslashes($link_url));
        	    $short_url = str_replace('www.', '', $short_url);
				if ('/' == substr($short_url, -1)) {
                $short_url = substr($short_url, 0, -1);
				}
				if (strlen($short_url) > 35) {
                $short_url =  substr($short_url, 0, 32).'...';
				}
				$link_id = $link->link_id;
				$link_name = $myts->makeTboxData4Show($link->link_name);
				$category = $myts->makeTboxData4Show($link->category);
				$link_rel = $myts->makeTboxData4Show($link->link_rel);
				$link_description = $myts->makeTboxData4Show($link->link_description);
        	    $image = ($link->link_image != null) ? 'Yes' : 'No';
        	    $visible = ($link->link_visible == 'Y') ? 'Yes' : 'No';
        	    if (get_settings('links_use_adminlevels') && ($link->user_level > $user_level)) {
        	    	$show_buttons = 0;
            	} else {
					$show_buttons = 1;
            	}
				++$i;
				$style = ($i % 2) ? ' class="alternate"' : '';
?>
    <tr valign="middle" <?php echo $style ?>>
      <td><strong><?php echo $link_name?></strong><br />
      Description: <?php $link_description?></td>
      <td><a href="<?php echo $link_url?>" title="Visit <?php echo $link_name?>"><?php echo $short_url?></a></td>
      <td><?php echo $category?></td>
      <td><?php echo $link_rel?></td>
      <td align='center'><?php echo $image?></td>
      <td align='center'><?php echo $visible?></td>
<?php if ($show_buttons) { ?>
      <td><a href="link-manager.php?link_id=<?php echo $link_id?>&amp;action=linkedit" class="edit">Edit</a></td>
      <td><a href="link-manager.php?link_id=<?php $link_id?>&amp;action=Delete" onclick="return confirm('You are about to delete this link.\\n  \'Cancel\' to stop, \'OK\' to delete.');" class="delete">Delete</a></td>
      <td><input type="checkbox" name="linkcheck[]" value="<?php echo $link_id?>" /></td>
<?php } else { ?>
      <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
<?php } ?>
	</tr>
<?php
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
          <?php wp_dropdown_usercat('newowner') ?>
        </td>
        <td>
          <?php echo _LANG_WLM_TOGGLE_TEXT; ?><input type="submit" name="action2" value="<?php echo _LANG_WLM_VISIVILITY_TEXT; ?>" />
        </td>
        <td>
          <input type="submit" name="action2" value="<?php echo _LANG_WLM_MOVE_TEXT; ?>" /><?php echo _LANG_WLM_TO_CATEGORY; ?>
          <?php wp_dropdown_linkcat('category'); ?>
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
} // end case
?>
<?php include('admin-footer.php'); ?>
