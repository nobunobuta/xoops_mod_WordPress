<?php
require_once('admin.php');

$title = 'Permalink Options';
$this_file = 'options-permalink.php';
$parent_file = 'options.php';

init_param('POST', 'submit','string', '');
if ($submit) {
	wp_refcheck("/wp-admin");
	init_param('POST', 'permalink_structure','string');
	update_option('permalink_structure', $permalink_structure);
} else {
	$permalink_structure = get_settings('permalink_structure');
	if ($user_level < 9) {
		redirect_header($siteurl.'/wp-admin/',5,_LANG_PG_LEAST_LEVEL);
		exit();
	}
}
	$standalone = 0;
	include_once('admin-header.php');
?>
<?php if($submit) { ?>
<div class="updated"><p><?php echo _LANG_WPL_EDIT_UPDATED; ?></p></div>
<?php } ?>
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
$rewrite = rewrite_rules('', $permalink_structure);
$rule_text = '';
foreach ($rewrite as $match => $query) {
	if (strstr($query, 'index.php')) {
		$rule_text .= 'RewriteRule ^' . $match . ' ' . $home_root . $query . " [QSA]\n";
	} else {
    	$rule_text .= 'RewriteRule ^' . $match . ' ' . $site_root . $query . " [QSA]\n";
	}
}

?> 
<form action="">
    <p>
    	<textarea rows="5" style="width: 98%;"><?php echo "RewriteEngine On\nRewriteBase $home_root\n$rule_text"; ?></textarea>
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