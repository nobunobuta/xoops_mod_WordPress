<?php
// Links
// Copyright (C) 2002, 2003 Mike Little -- mike@zed1.com
require_once('admin.php');

$title = 'Link Categories';
$this_file='link-categories.php';
$parent_file = 'link-manager.php';

param('action', 'string','');

switch ($action) {
  case 'addcat':
		wp_refcheck("/wp-admin/link-categories.php");
		if ($user_level < get_settings('links_minadminlevel')) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
			exit();
		}
		$cat_name = $wpdb->escape(param('cat_name','string'));
		param('auto_toggle','string-yn');
		param('show_images','string-yn');
		param('show_description','string-yn');
		param('show_rating','string-yn');
		param('show_updated','string-yn');
		$sort_order = $wpdb->escape(param('sort_order','string'));
		param('sort_desc','string-yn');
		$text_before_link = $wpdb->escape(param('text_before_link','html'));
		$text_after_link = $wpdb->escape(param('text_after_link','html'));
		$text_after_all = $wpdb->escape(param('text_after_all','html'));
		param('list_limit','integer',-1);

		$wpdb->query("INSERT INTO {$wpdb->linkcategories[$wp_id]} (cat_id, cat_name, auto_toggle, show_images, show_description, \n" .
		       " show_rating, show_updated, sort_order, sort_desc, text_before_link, text_after_link, text_after_all, list_limit) \n" .
		       " VALUES ('0', '$cat_name', '$auto_toggle', '$show_images', '$show_description', \n" .
		       " '$show_rating', '$show_updated', '$sort_order', '$sort_desc', '$text_before_link', '$text_after_link', \n" .
		       " '$text_after_all', $list_limit)");

		header('Location: link-categories.php');
	    break;
case 'Delete':
		wp_refcheck("/wp-admin/link-categories.php");
		if ($user_level < get_settings('links_minadminlevel')) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
			exit();
		}
		param('cat_id','integer');
		$cat_name=get_linkcatname($cat_id);
		$cat_name=addslashes($cat_name);
		if ($cat_id=="1") {
			redirect_header($siteurl.'/wp-admin/link-categories.php',5,_LANG_WLC_DONOT_DELETE);
			exit();
		}
		$wpdb->query("DELETE FROM {$wpdb->linkcategories[$wp_id]} WHERE cat_id='$cat_id'");
		$wpdb->query("UPDATE {$wpdb->links[$wp_id]} SET link_category=1 WHERE link_category='$cat_id'");

		header('Location: link-categories.php');
		break;
	case 'Edit':
        include_once ('admin-header.php');
	    param('cat_id','integer');

		include('include/link-categories-navi.php');
		
        $row = $wpdb->get_row("SELECT cat_id, cat_name, auto_toggle, show_images, show_description, "
             . " show_rating, show_updated, sort_order, sort_desc, text_before_link, text_after_link, "
             . " text_after_all, list_limit FROM {$wpdb->linkcategories[$wp_id]} WHERE cat_id=$cat_id");
        if ($row) {
            if ($row->list_limit == -1) {
                $row->list_limit = '';
            }
			$form_title = _LANG_WLC_TITLE_TEXT.$myts->makeTboxData4Show($row->cat_name)."&#8221;";
			$form_id = "editcat";
			$cat_name = $myts->makeTboxData4Edit($row->cat_name);
			$auto_toggle = $row->auto_toggle;
			$show_images = $row->show_images;
			$show_description = $row->show_description;
			$show_rating = $row->show_rating;
			$show_updated = $row->show_updated;
			$sort_order = $row->sort_order;
			$sort_desc = $row->sort_desc;
			$text_before_link = $myts->makeTboxData4Edit($row->text_before_link);
			$text_after_link = $myts->makeTboxData4Edit($row->text_after_link);
			$text_after_all = $myts->makeTboxData4Edit($row->text_after_all);
			$list_limit = $row->list_limit;

			include('include/link-categories-form.php');

    } // end if row
    break;
  case "editedcat":
 		wp_refcheck("/wp-admin/link-categories.php");
		if ($user_level < get_settings('links_minadminlevel')) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
			exit();
		}
		param('submit','string', '');
		if ($submit == _LANG_WLC_SAVEBUTTON_TEXT) {
			param('cat_id','integer');
			$cat_name = $wpdb->escape(param('cat_name','string'));
			param('auto_toggle','string-yn');
			param('show_images','string-yn');
			param('show_description','string-yn');
			param('show_rating','string-yn');
			param('show_updated','string-yn');
			$sort_order = $wpdb->escape(param('sort_order','string'));
			param('sort_desc','string-yn');
			$text_before_link = $wpdb->escape(param('text_before_link','html'));
			$text_after_link = $wpdb->escape(param('text_after_link','html'));
			$text_after_all = $wpdb->escape(param('text_after_all','html'));
			param('list_limit','integer',-1);
			$wpdb->query("UPDATE {$wpdb->linkcategories[$wp_id]} set
			        cat_name='$cat_name',
			        auto_toggle='$auto_toggle',
			        show_images='$show_images',
			        show_description='$show_description',
			        show_rating='$show_rating',
			        show_updated='$show_updated',
			        sort_order='$sort_order',
			        sort_desc='$sort_desc',
			        text_before_link='$text_before_link',
			        text_after_link='$text_after_link',
			        text_after_all='$text_after_all',
			        list_limit=$list_limit
			        WHERE cat_id=$cat_id
			        ");
		}
	    header("Location: link-categories.php");
	    break;
	default:
        $standalone=0;
        include_once ("./admin-header.php");
        if ($user_level < get_settings('links_minadminlevel')) {
			    redirect_header($siteurl.'/wp-admin/',5,_LANG_WLC_RIGHT_PROM);
			    exit();
        }
		include('include/link-categories-navi.php');
?>
<div class="wrap">
<h2><?php echo _LANG_WLC_EPAGE_TITLE; ?></h2>
          <form name="cats" method="post" action="link-categories.php">
            <table width="100%" cellpadding="5" cellspacing="0" border="0">
              <tr>
			  <th rowspan="2" valign="bottom"><?php echo _LANG_WLC_SUBCATE_NAME; ?></th>
                <th rowspan="2" valign="bottom">Id</th>
                <th rowspan="2" valign="bottom"><?php echo _LANG_WLC_SUBCATE_ATT; ?></th>
                <th colspan="4" valign="bottom"><?php echo _LANG_WLC_SUBCATE_SHOW; ?></th>
                <th rowspan="2" valign="bottom"><?php echo _LANG_WLC_SUBCATE_SORT; ?></th>
                <th rowspan="2" valign="bottom"><?php echo _LANG_WLC_SUBCATE_DESC; ?></th>
                <th colspan="3" valign="bottom">Text/HTML</th>
                <th rowspan="2" valign="bottom"><?php echo _LANG_WLC_SUBCATE_LIMIT; ?></th>
                <th rowspan="2" colspan="2">&nbsp;</th>
              </tr>
              <tr>
                <th valign="top"><?php echo _LANG_WLC_SUBCATE_IMAGES; ?></th>
                <th valign="top"><?php echo _LANG_WLC_SUBCATE_MINIDESC; ?></th>
                <th valign="top"><?php echo _LANG_WLC_SUBCATE_RATE; ?></th>
                <th valign="top"><?php echo _LANG_WLC_SUBCATE_UPDATE; ?></th>
                <th valign="top"><?php echo _LANG_WLC_SUBCATE_BEFORE; ?></th>
                <th valign="top"><?php echo _LANG_WLC_SUBCATE_BETWEEN; ?></th>
                <th valign="top"><?php echo _LANG_WLC_SUBCATE_AFTER; ?></th>
              </tr>
                <input type="hidden" name="cat_id" value="" />
                <input type="hidden" name="action" value="" />
<?php
		$results = $wpdb->get_results("SELECT cat_id, cat_name, auto_toggle, show_images, show_description, "
		         . " show_rating, show_updated, sort_order, sort_desc, text_before_link, text_after_link, "
		         . " text_after_all, list_limit FROM {$wpdb->linkcategories[$wp_id]} ORDER BY cat_id");
		foreach ($results as $row) {
		    if ($row->list_limit == -1) {
	        $row->list_limit = 'none';
			}
		    $style = ($i % 2) ? ' class="alternate"' : '';
			$cat_name = $myts->makeTboxData4Show($row->cat_name);
			$cat_id = $row->cat_id;
			$auto_toggle = $row->auto_toggle;
			$show_images = $row->show_images;
			$show_description = $row->show_description;
			$show_rating = $row->show_rating;
			$show_updated = $row->show_updated;
			$sort_order = $row->sort_order;
			$sort_desc = $row->sort_desc;
			$show_updated = $row->show_updated;
			$text_before_link = $myts->makeTboxData4Show($row->text_before_link);
			$text_after_link = $myts->makeTboxData4Show($row->text_after_link);
			$text_after_all = $myts->makeTboxData4Show($row->text_after_all);
			$list_limit = $row->list_limit;
?>
              <tr valign="middle" align="center" <?php echo $style ?> style="border-bottom: 1px dotted #9C9A9C;">
				<td><?php echo $cat_name?></td>
				<td ><?php echo $cat_id?></td>
				<td><?php echo $auto_toggle?></td>
				<td><?php echo $show_images?></td>
				<td><?php echo $show_description?></td>
				<td><?php echo $show_rating?></td>
				<td><?php echo $show_updated?></td>
				<td><?php echo $sort_order?></td>
				<td><?php echo $sort_desc?></td>
				<td nowrap="nowrap"><?php echo $text_before_link?>&nbsp;</td>
				<td nowrap="nowrap"><?php echo $text_after_link?>&nbsp;</td>
				<td nowrap="nowrap"><?php echo $text_after_all?></td>
				<td><?php echo $list_limit?></td>
                <td><a href="link-categories.php?cat_id=<?php echo $row->cat_id?>&amp;action=Edit" class="edit"><?php echo _LANG_WLC_SUBCATE_EDIT; ?></a></td>
                <td><a href="link-categories.php?cat_id=<?php echo $row->cat_id?>&amp;action=Delete" onclick="return confirm('You are about to delete this category.\n  \'Cancel\' to stop, \'OK\' to delete.');" class="delete"><?php echo _LANG_WLC_SUBCATE_DELETE; ?></a></td>
              </tr>
<?php
        ++$i;
    }
?>
        </table>
    </form>
</div>
<?php
		$form_title = _LANG_WLC_ADD_TITLE;
		$form_id = "addcat";
		$cat_name = "";
		$auto_toggle = "";
		$show_images = "";
		$show_description = "";
		$show_rating = "";
		$show_updated = "";
		$sort_order = "name";
		$sort_desc = "";
		$text_before_link = "&lt;li&gt;";
		$text_after_link = "&lt;br /&gt;";
		$text_after_all = "&lt;/li&gt;";
		$list_limit = "";
		include('include/link-categories-form.php');
?>
<div class="wrap">
    <h2>Note:</h2>
	<p><?php echo _LANG_WLC_EPAGE_NOTE; ?><b><?php echo get_linkcatname(1) ?></b>.</p>
</div>
<?php
	    break;
}
?>
<?php include('admin-footer.php'); ?>