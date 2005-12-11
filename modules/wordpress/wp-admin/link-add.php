<?php
require_once('admin.php');

$title = 'Add Link';
$this_file = 'link-add.php';
$parent_file = 'link-manager.php';

$xfn = true;
$standalone = 0;
require('admin-header.php');
$myts =& MyTextSanitizer::getInstance();

if ($user_level < get_settings('links_minadminlevel')) {
	redirect_header(wp_siteurl().'/wp-admin/',5,"You have no right to add the links for this blog.<br />Ask for a promotion to your <a href='mailto:".get_settings('admin_email')."'>blog admin</a>. :)");
	exit();
}
init_param('GET', 'action','string', '');
$link_url = init_param('GET', 'linkurl', 'string', '');
$link_name = init_param('GET', 'name', 'string', '');
$link_name = fix_js_param($link_name);
?>
<?php
$form_title = _LANG_WLA_LINK_TITLE;
$form_id = "addlink";
$link_url = $myts->makeTboxData4Edit($link_url);
$link_name = $myts->makeTboxData4Edit($link_name);
$link_rss = "";
$link_image = "";
$link_description = "";
$link_rel = "";
$friendship = "";
$physical = "";
$professional = "";
$geographical = "";
$family = "";
$romantic = "";
$link_notes = "";
$link_rating = 0;
$link_target = "";
$link_visible = "Y";
$link_category = 1;
$linkCategoryHandler =& wp_handler('LinkCategory');
$category_options = $linkCategoryHandler->getOptionArray();

include('include/link-manager-form.php');
?>
<div class="wrap">
<p><a href="javascript:void(linkmanpopup=window.open('<?php echo wp_siteurl(); ?>/wp-admin/link-add.php?action=popup&linkurl='+escape(location.href)+'&name='+escape(document.title),'LinkManager','scrollbars=yes,width=750,height=550,left=15,top=15,status=yes,resizable=yes'));linkmanpopup.focus();window.focus();linkmanpopup.focus();" title="Link add bookmarklet"><b>Link This: </b></a><?php echo _LANG_WLA_TEXT_TOOLBAR; ?></p>
</div>

<?php
require('admin-footer.php');
?>