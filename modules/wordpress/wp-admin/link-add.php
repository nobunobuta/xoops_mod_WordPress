<?php

$title = 'Add Link';
$this_file = 'link-manager.php';
$parent_file = 'link-manager.php';
function category_dropdown($fieldname, $selected = 0) {
    global $wpdb,  $wp_id;

    $results = $wpdb->get_results("SELECT cat_id, cat_name, auto_toggle FROM {$wpdb->linkcategories[$wp_id]} ORDER BY cat_id");
    echo '        <select name="'.$fieldname.'" size="1">'."\n";
    foreach ($results as $row) {
      echo "          <option value=\"".$row->cat_id."\"";
      if ($row->cat_id == $selected)
        echo " selected";
        echo ">".$row->cat_id.": ".$row->cat_name;
        if ($row->auto_toggle == 'Y')
            echo ' (auto toggle)';
        echo "</option>\n";
    }
    echo "        </select>\n";
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
$xfn = true;
require('admin-header.php');
@$link_url = sanitize_text($_GET['linkurl']);
@$link_name = sanitize_text(urldecode($_GET['name']));

?>
<ul id="adminmenu2">
	<li><a href="link-manager.php"><?php echo _LANG_WLA_MANAGE_LINK; ?></a></li>
	<li><a href="link-add.php" class="current"><?php echo _LANG_WLA_ADD_LINK; ?></a></li>
	<li><a href="link-categories.php"><?php echo _LANG_WLA_LINK_CATE; ?></a></li>
	<li class="last"><a href="link-import.php"><?php echo _LANG_WLA_IMPORT_BLOG; ?></a></li>
</ul>
<style type="text/css" media="screen">
th { text-align: right; }
</style>
<div class="wrap">
<h2><?php echo _LANG_WLA_LINK_TITLE; ?></h2>
     <form name="addlink" method="post" action="link-manager.php">
       <table width="100%"  border="0" cellspacing="0" cellpadding="4">
         <tr>
           <th scope="row"><?php echo _LANG_WLA_SUB_URI; ?></th>
           <td><input type="text" name="linkurl" size="80" value="<?php echo $link_url; ?>"></td>
         </tr>
         <tr>
           <th scope="row"><?php echo _LANG_WLA_SUB_NAME; ?></th>
           <td><input type="text" name="name" size="80" value="<?php echo $link_name; ?>"></td>
         </tr>
         <tr>
           <th scope="row"><?php echo _LANG_WLA_SUB_IMAGE; ?></th>
           <td><input type="text" name="image" size="80" value=""></td>
         </tr>
         <tr>
           <th scope="row"><?php echo _LANG_WLA_SUB_RSS; ?></th>
           <td><input name="rss_uri" type="text" id="rss_uri" value="" size="80"></td>
         </tr>
         <tr>
           <th scope="row"><?php echo _LANG_WLA_SUB_DESC; ?></th>
           <td><input type="text" name="description" size="80" value=""></td>
         </tr>
         <tr>
           <th scope="row"><?php echo _LANG_WLA_SUB_REL; ?></th>
           <td><input type="text" name="rel" id="rel" size="80" value=""></td>
         </tr>
         <tr>
           <th scope="row"><a href="http://gmpg.org/xfn/">XFN</a>:</th>
           <td><table cellpadding="3" cellspacing="5">
             <tr>
               <th scope="row"> <?php echo _LANG_WLA_SUB_FRIEND; ?> </th>
               <td>
                 <label for="label">
                 <input class="valinp" type="radio" name="friendship" value="acquaintance" id="label"  />
      <?php echo _LANG_WLA_CHECK_ACQUA; ?></label>
                 <label for="label2">
                 <input class="valinp" type="radio" name="friendship" value="friend" id="label2" />
      <?php echo _LANG_WLA_CHECK_FRIE; ?></label>
                 <label for="label3">
                 <input class="valinp" type="radio" name="friendship" value="" id="label3" />
      <?php echo _LANG_WLA_CHECK_NONE; ?></label>
               </td>
             </tr>
             <tr>
               <th scope="row"> <?php echo _LANG_WLA_SUB_PHYSICAL; ?> </th>
               <td>
                 <label for="label4">
                 <input class="valinp" type="checkbox" name="physical" value="met" id="label4" />
      <?php echo _LANG_WLA_CHECK_MET; ?></label>
               </td>
             </tr>
             <tr>
               <th scope="row"> <?php echo _LANG_WLA_SUB_PROFESSIONAL; ?> </th>
               <td>
                 <label for="label5">
                 <input class="valinp" type="checkbox" name="professional" value="co-worker" id="label5" />
      <?php echo _LANG_WLA_CHECK_WORKER; ?></label>
                 <label for="label6">
                 <input class="valinp" type="checkbox" name="professional" value="colleague" id="label6" />
      <?php echo _LANG_WLA_CHECK_COLL; ?></label>
               </td>
             </tr>
             <tr>
               <th scope="row"> <?php echo _LANG_WLA_SUB_GEOGRAPH; ?> </th>
               <td>
                 <label for="label7">
                 <input class="valinp" type="radio" name="geographical" value="co-resident" id="label7" />
      <?php echo _LANG_WLA_CHECK_RESI; ?></label>
                 <label for="label8">
                 <input class="valinp" type="radio" name="geographical" value="neighbor" id="label8" />
      <?php echo _LANG_WLA_CHECK_NEIG; ?></label>
                 <label for="label9">
                 <input class="valinp" type="radio" name="geographical" value="" id="label9" />
      <?php echo _LANG_WLA_CHECK_NONE; ?></label>
               </td>
             </tr>
             <tr>
               <th scope="row"> <?php echo _LANG_WLA_SUB_FAMILY; ?> </th>
               <td>
                 <label for="label10">
                 <input class="valinp" type="radio" name="family" value="child" id="label10" />
      <?php echo _LANG_WLA_CHECK_CHILD; ?></label>
                 <label for="label11">
                 <input class="valinp" type="radio" name="family" value="parent" id="label11" />
      <?php echo _LANG_WLA_CHECK_PARENT; ?></label>
                 <label for="label12">
                 <input class="valinp" type="radio" name="family" value="sibling" id="label12" />
      <?php echo _LANG_WLA_CHECK_SIBLING; ?></label>
                 <label for="label13">
                 <input class="valinp" type="radio" name="family" value="spouse" id="label13" />
      <?php echo _LANG_WLA_CHECK_SPOUSE; ?></label>
                 <label for="label14">
                 <input class="valinp" type="radio" name="family" value="" id="label14" />
      <?php echo _LANG_WLA_CHECK_NONE; ?></label>
               </td>
             </tr>
             <tr>
               <th scope="row"> <?php echo _LANG_WLA_SUB_ROMANTIC; ?> </th>
               <td>
                 <label for="label15">
                 <input class="valinp" type="checkbox" name="romantic" value="muse" id="label15" />
      <?php echo _LANG_WLA_CHECK_MUSE; ?></label>
                 <label for="label16">
                 <input class="valinp" type="checkbox" name="romantic" value="crush" id="label16" />
      <?php echo _LANG_WLA_CHECK_CRUSH; ?></label>
                 <label for="label17">
                 <input class="valinp" type="checkbox" name="romantic" value="date" id="label17" />
      <?php echo _LANG_WLA_CHECK_DATE; ?></label>
                 <label for="label18">
                 <input class="valinp" type="checkbox" name="romantic" value="sweetheart" id="label18" />
      <?php echo _LANG_WLA_CHECK_HEART; ?></label>
               </td>
             </tr>
           </table></td>
         </tr>
         <tr>
           <th scope="row"><?php echo _LANG_WLA_SUB_NOTE; ?></th>
           <td><textarea name="notes" cols="80" rows="10"></textarea></td>
         </tr>
         <tr>
           <th scope="row"><?php echo _LANG_WLA_SUB_RATE; ?></th>
           <td><select name="rating" size="1">
             <?php
    for ($r = 0; $r < 10; $r++) {
      echo('            <option value="'.$r.'">'.$r.'</option>');
    }
?>
           </select>
           &nbsp;(<?php echo _LANG_WLA_CHECK_ZERO; ?>) </td>
         </tr>
         <tr>
           <th scope="row"><?php echo _LANG_WLA_SUB_TARGET; ?></th>
           <td><label>
             <input type="radio" name="target" value="_blank">
             <code>_blank</code></label>
&nbsp;
<label>
<input type="radio" name="target" value="_top">
<code>_top</code></label>
&nbsp;
<label>
<input type="radio" name="target" value="" checked="checked">
none</label>
(<?php echo _LANG_WLA_CHECK_STRICT; ?>)</td>
         </tr>
         <tr>
           <th scope="row"><?php echo _LANG_WLA_SUB_VISIBLE; ?></th>
           <td><label>
             <input type="radio" name="visible" checked="checked" value="Y">
Yes</label>
&nbsp;
<label>
<input type="radio" name="visible" value="N">
No</label></td>
         </tr>
         <tr>
           <th scope="row"><?php echo _LANG_WLA_SUB_CAT; ?></th>
           <td><?php category_dropdown('category'); ?></td>
         </tr>
       </table>
       <p style="text-align: center;">
         <input type="submit" name="submit" value="<?php echo _LANG_WLA_BUTTON_TEXTNAME; ?>" /> <input type="hidden" name="action" value="Add" /> 
       </p>
  </form>
</div>

<div class="wrap">
<p><a href="javascript:void(linkmanpopup=window.open('<?php echo $siteurl; ?>/wp-admin/link-add.php?action=popup&linkurl='+escape(location.href)+'&name='+escape(document.title),'LinkManager','scrollbars=yes,width=750,height=550,left=15,top=15,status=yes,resizable=yes'));linkmanpopup.focus();window.focus();linkmanpopup.focus();" title="Link add bookmarklet"><b>Link This: </b></a><?php echo _LANG_WLA_TEXT_TOOLBAR; ?></p>
</div>

<?php
require('admin-footer.php');
?>