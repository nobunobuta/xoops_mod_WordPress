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
	$_GET    = add_magic_quotes($_GET);
	$_POST   = add_magic_quotes($_POST);
	$_COOKIE = add_magic_quotes($_COOKIE);
}

$wpvarstoreset = array('action','standalone', 'option_group_id');
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

require_once('./optionhandler.php');

if (isset($_POST['submit'])) {
	wp_refcheck("/wp-admin");
	update_option('permalink_structure', $_POST['permalink_structure']);
	$permalink_structure = $_POST['permalink_structure'];
} else {
	$permalink_structure = get_settings('permalink_structure');
}


	$standalone = 0;
	include_once('admin-header.php');
	if ($user_level <= 6) {
		die("You have do not have sufficient permissions to edit the options for this blog.");
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
  <li class="last"><a class="current" href="options-permalink.php"><?php echo _LANG_WOP_PERM_LINKS; ?></a></li> 
</ul> 
<br clear="all" /> 
<?php if (isset($_POST['submit'])) : ?>
<div class="updated"><p><?php echo _LANG_WPL_EDIT_UPDATED; ?></p></div>
<?php endif; ?>
<div class="wrap"> 
  <h2><?php echo _LANG_WPL_EDIT_STRUCT; ?></h2> 
  <p><?php echo _LANG_WPL_CREATE_CUSTOM; ?></p>

<dl>
	<dt><code>%year%</code></dt>
	<dd>
		<?php echo _LANG_WPL_CODE_YEAR; ?>
	</dd>
	<dt><code>%monthnum%</code></dt>
	<dd>
		<?php echo _LANG_WPL_CODE_MONTH; ?>
	</dd>
	<dt><code>%day%</code></dt>
	<dd>
		<?php echo _LANG_WPL_CODE_DAY; ?>
	</dd>
	<dt><code>%hour%</code></dt>
	<dd>
		<?php echo _LANG_WPL_CODE_HOUR; ?>
	</dd>
	<dt><code>%minute%</code></dt>
	<dd>
		<?php echo _LANG_WPL_CODE_MINUTE; ?>
	</dd>
	<dt><code>%second%</code></dt>
	<dd>
		<?php echo _LANG_WPL_CODE_SECOND; ?>
	</dd>
	<dt><code>%postname%</code></dt>
	<dd>
		<?php echo _LANG_WPL_CODE_POSTNAME; ?>
	</dd>
	<dt><code>%post_id%</code></dt>
	<dd>
		<?php echo _LANG_WPL_CODE_POSTID; ?>
	</dd>
</dl>
<?php echo _LANG_WPL_USE_EXAMPLE; ?>
  <form name="form" action="options-permalink.php" method="post"> 
    <p><?php echo _LANG_WPL_USE_TEMPTEXT; ?></p>
    <p> 
      <input name="permalink_structure" type="text" style="width: 98%;" value="<?php echo $permalink_structure; ?>" /> 
    </p> 
	<p><?php echo _LANG_WPL_USE_BLANK; ?></p>
    <p class="submit"> 
      <input type="submit" name="submit" value="<?php echo _LANG_WPL_SUBMIT_UPDATE; ?>"> 
    </p> 
  </form> 
<?php
 if ($permalink_structure) {
?>
  <p><?php printf(_LANG_WPL_USE_HTACCESS, $permalink_structure) ?></p>
  <?php
$site_root = str_replace('http://', '', trim($siteurl));
$site_root = preg_replace('|([^/]*)(.*)|i', '$2', $site_root);
if ('/' != substr($site_root, -1)) $site_root = $site_root . '/';

$home_root = str_replace('http://', '', trim($siteurl));
$home_root = preg_replace('|([^/]*)(.*)|i', '$2', $home_root);
if ('/' != substr($home_root, -1)) $home_root = $home_root . '/';

?> 
<form action="">
    <p>
    	<textarea rows="5" style="width: 98%;"><?php echo "RewriteEngine On\nRewriteBase" ?> <?php echo $home_root; ?> 
<?php
$rewrite = rewrite_rules('', $permalink_structure);
foreach ($rewrite as $match => $query) {
	if (strstr($query, 'index.php')) echo 'RewriteRule ^' . $match . ' ' . $home_root . $query . " [QSA]\n";
    else echo 'RewriteRule ^' . $match . ' ' . $site_root . $query . " [QSA]\n";
}
?>
    </textarea>
    </p>
    <?php printf(_LANG_WPL_EDIT_TEMPLATE, 'templates.php?file=.htaccess') ?>
</form>
</div> 
<?php
} else {
?>
<p>
<?php echo _LANG_WPL_MOD_REWRITE; ?>
</p>
<?php } ?>
</div>

<?php
require('./admin-footer.php');
?>