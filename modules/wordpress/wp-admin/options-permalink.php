<?php
$title = 'Permalink Options';
$this_file = 'options.php';

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

$wpvarstoreset = array('action','standalone', 'option_group_id');
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

require_once('optionhandler.php');

if ($HTTP_POST_VARS['Submit'] == _LANG_WPL_SUBMIT_UPDATE) {
	update_option('permalink_structure', $HTTP_POST_VARS['permalink_structure']);
	$permalink_structure = $HTTP_POST_VARS['permalink_structure'];
} else {
	$permalink_structure = get_settings('permalink_structure');
}


switch($action) {

default:
	$standalone = 0;
	include_once('admin-header.php');
	if ($user_level <= 3) {
		die("You have no right to edit the options for this blog.<br>Ask for a promotion to your <a href=\"mailto:".get_settings('admin_email')."\">blog admin</a> :)");
	}
?>
 <ul id="adminmenu2"> 
  <?php
    //we need to iterate through the available option groups.
    $option_groups = $wpdb->get_results("SELECT group_id, group_name, group_desc, group_longdesc FROM {$wpdb->optiongroups[$wp_id]} ORDER BY group_id");
    foreach ($option_groups as $option_group) {
        if ($option_group->group_id == $option_group_id) {
            $current_desc=$option_group->group_desc;
            $current_long_desc = $option_group->group_longdesc;
            echo("  <li><a id=\"current2\" href=\"$this_file?option_group_id={$option_group->group_id}\" title=\"".replace_constant($option_group->group_desc)."\">{$option_group->group_name}</a></li>\n");
        } else {
            echo("  <li><a href=\"$this_file?option_group_id={$option_group->group_id}\" title=\"".replace_constant($option_group->group_desc)."\">{$option_group->group_name}</a></li>\n");
        }
    } // end for each group
?> 
  <li class="last"><a href="options-permalink.php"><?php echo _LANG_WOP_PERM_LINKS; ?></a></li> 
</ul> 
<br clear="all" /> 
<div class="wrap"> 
  <h2><?php echo _LANG_WPL_EDIT_STRUCT; ?></h2> 
  <p><?php echo _LANG_WPL_CREATE_CUSTOM; ?></p>
  <ul> 
    <li><code>%year%</code> --- <?php echo _LANG_WPL_CODE_YEAR; ?></li> 
    <li><code>%monthnum%</code> --- <?php echo _LANG_WPL_CODE_MONTH; ?></li> 
    <li><code>%day% </code>--- <?php echo _LANG_WPL_CODE_DAY; ?></li> 
    <li><code>%postname%</code> --- <?php echo _LANG_WPL_CODE_POSTNAME; ?></li> 
    <li><code>%post_id%</code> --- <?php echo _LANG_WPL_CODE_POSTID; ?></li> 
  </ul>
  <p><?php echo _LANG_WPL_USE_EXAMPLE; ?></p> 
  <form name="form" action="options-permalink.php" method="post"> 
    <p><?php echo _LANG_WPL_USE_TEMPTEXT; ?></p> 
    <p> 
      <input name="permalink_structure" type="text" style="width: 100%;" value="<?php echo $permalink_structure; ?>" /> 
    </p> 
    <p> 
      <input type="submit" name="Submit" value="<?php echo _LANG_WPL_SUBMIT_UPDATE; ?>"> 
    </p> 
  </form> 
<?php
 if ($permalink_structure) {
?>
  <p><?php echo _LANG_WPL_BEFORE_HTACCESS; ?><code><?php echo $permalink_structure; ?></code><?php echo _LANG_WPL_AFTER_HTACCESS; ?></p>
  <?php
$site_root = str_replace('http://', '', trim($siteurl));
$site_root = preg_replace('|([^/]*)(.*)|i', '$2', $site_root);
if ('/' != substr($site_root, -1)) $site_root = $site_root . '/';

$rewritecode = array(
	'%year%',
	'%monthnum%',
	'%day%',
	'%postname%',
	'%post_id%'
);
$rewritereplace = array(
	'([0-9]{4})?',
	'([0-9]{1,2})?',
	'([0-9]{1,2})?',
	'([0-9a-z-]+)?',
	'([0-9]+)?'
);
$queryreplace = array (
	'year=',
	'monthnum=',
	'day=',
	'name=',
	'p='
);



$match = str_replace('/', '/?', $permalink_structure);
$match = preg_replace('|/[?]|', '', $match, 1);

$match = str_replace($rewritecode, $rewritereplace, $match);
$match = preg_replace('|[?]|', '', $match, 1);
preg_match_all('/%.+?%/', $permalink_structure, $tokens);

$query = 'index.php?';
for ($i = 0; $i < count($tokens[0]); ++$i) {
	if (0 < $i) $query .= '&';
	$query .= str_replace($rewritecode, $queryreplace, $tokens[0][$i]) . '$'. ($i + 1);
}
++$i;
// Add post paged stuff
$match .= '([0-9]+)?/?';
$query .= "&page=$$i";

// Code for nice categories, currently not very flexible
$front = substr($permalink_structure, 0, strpos($permalink_structure, '%'));
		$catmatch = $front . 'category/';
		$catmatch = preg_replace('|^/+|', '', $catmatch);

?> 
<form action"">
  <textarea rows="5" style="width: 100%;">RewriteEngine On
RewriteBase <?php echo $site_root; ?> 
RewriteRule ^<?php echo $match; echo '$ ' . $site_root . $query ?> [QSA]
RewriteRule ^<?php echo $catmatch; ?>?(.*) <?php echo $site_root; ?>index.php?category_name=$1 [QSA]</textarea> 
	</form>
</div> 
<?php
} else {
?>
<p>
<?php echo _LANG_WPL_MOD_REWRITE; ?>
</p>
<?php
}
echo "</div>\n";

break;
}

include("admin-footer.php") ?> 
