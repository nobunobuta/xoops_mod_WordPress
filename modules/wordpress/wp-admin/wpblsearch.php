<?php
require_once('../wp-config.php');
require_once('auth.php');

require_once('../wp-includes/wpblfunctions.php');
$title = _('WPBlacklist - Search');
$parent_file = 'wpblacklist.php';

init_param('', 'action', 'string', '');
init_param('POST', 'rb_search', 'integer', 0);
init_param('POST', 'search', 'string', '');
init_param('POST', 'delete_comments', 'array', '');
init_param('POST', 'deladd', 'string', '');

$GLOBALS['standalone'] = 0;
require_once('admin-header.php');

$tableblacklist = $xoopsDB->prefix("wp_blacklist");
$tablecomments = wp_table('comments');
$tableposts =  wp_table('posts');

//Check User_Level
user_level_check();
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
<p>
<?php _e('You can search your existing comments using multiple options and delete any of the results of your searches. In addition, you can also use the "Delete & Add" button to add the search expression you specified, as well as any information harvested from the selected comments, to your blacklist while deleting the selected comments. Please note that searching all comments using the blacklist might take a longtime and so it is better to specify the number of comments to search.') ?>
</p>
<form name="searchform" action="wpblsearch.php?action=search" method="post">
	<fieldset>
		<legend><strong><?php _e('Search ...') ?></strong></legend>
		<label>
			<input name="rb_search" type="radio" value="0" <?php echo ($rb_search==0 ? 'checked' : '') ?> />
			<?php _e('Using blacklist (specify number of comments to search or blank for all)') ?>
		</label><br />
		<label>
			<input name="rb_search" type="radio" value="1" <?php echo ($rb_search==1 ? 'checked' : '') ?> />
			<?php _e('For given IP') ?>
		</label><br />
		<label>
			<input name="rb_search" type="radio" value="2" <?php echo ($rb_search==2 ? 'checked' : '') ?> />
			<?php _e('For given expression') ?>
		</label><br />
		<input type="text" name="search" value="<?php echo $search; ?>" size="17" />
		<input type="submit" name="submit" value="<?php _e('Search') ?>"  />
	</fieldset>
</form>
<?php
if (($action == 'delete') && !empty($delete_comments)) {
	// check permissions on each comment before deleting
	$del_comments = '';
	$safe_delete_commeents = '';
	$i = 0;
	foreach ($delete_comments as $comment) { // Check the permissions on each
		$comment = intval($comment);
		$post_id = $wpdb->get_var("SELECT comment_post_ID FROM $tablecomments WHERE comment_ID = $comment");
		$authordata = get_userdata($wpdb->get_var("SELECT post_author FROM $tableposts WHERE ID = $post_id"));
		if (($user_level > $authordata->user_level) or ($user_login == $authordata->user_login)) {
			// harvest information before deleting if this is a delete & add operation
            if (!empty($deladd)) {
				if (!empty($info)) {
					$info .= '<br />';
				}
				$info .= harvest($comment);
			}
			// delete the comment
			$wpdb->query("DELETE FROM $tablecomments WHERE comment_ID = $comment");
			++$i;
		}
	}
	echo "<p><strong>" . sprintf(_('%s comments deleted.'), $i);
	// was this an add & delete operation - if so, add search item & harvested items to blacklist
	if ($deladd <> '') {
		// the search item is only added for IP or regex searches
        if (($rb_search > 0) && (!empty($search))) {
			if ($rb_search == 1) {
				$answer = "IP : $search ";
				$search = sanctify($search);
				$sql = "INSERT INTO $tableblacklist (regex,regex_type) VALUES ('$search','ip')";
			} else if ($rb_search == 2) {
				$search = sanctify($search);
				$answer = "Expression : $search";
				$sql = "INSERT INTO $tableblacklist (regex,regex_type) VALUES ('$search','url')";
			}
			$request = $wpdb->get_row("SELECT id FROM $tableblacklist WHERE regex='$search'");
			if (!$request) {
				$request = $wpdb->query($sql);
				if (!$request) {
					$answer = $answer . " could not be added!";
				} else {
					$answer = $answer . " successfully added!";
				}
			} else {
				$answer = $answer . " already exists in blacklist!";
			}
		}
		if (!empty($info)) {
			$answer .= '<br />Harvested the following information: <br />' . $info;
		}
		echo "<br />$answer";
    }
	echo "</strong></p>";
}
if (($action == 'search') || ($action == 'delete')) {
	$search = $wpdb->escape($search);
	$sql = '';
	$valid = True;
	$s_results = array();
	// do the search based on type
    switch ($rb_search) {
		case 0:
			// search blacklist
            $sql = "SELECT * FROM $tablecomments ORDER BY comment_date DESC";
			if (!empty($search)) {
				if (is_numeric($search)) {
					$sql = $sql . " LIMIT $search";
				} else {
					$valid = False;
					$sql = '';
				}
			}
			// if it's a valid query, then build the final query based on blacklist
            if (!empty($sql)) {
				$comments = $wpdb->get_results($sql);
				$sql = '';
				if ($comments) {
					foreach ($comments as $comment) {
						$next = False;$reason=0;
						// IP check
						$sites = $wpdb->get_results("SELECT regex FROM $tableblacklist WHERE regex_type='ip'");
						if ($sites) {
							foreach ($sites as $site)  {
								$regex = "/^$site->regex/";
								if (preg_match($regex, $comment->comment_author_IP)) {
									$s_result = array();
								    $s_result['record'] = $comment;
								    $s_result['reason'] = 'IP';
								    $s_result['pattern'] = $site->regex;
								    $s_results[] = $s_result;
									$next = True;
									break;
								}
							}
						}
						// RBL check
						if (!$next) {
							$sites = $wpdb->get_results("SELECT regex FROM $tableblacklist WHERE regex_type='rbl'");
							if ($sites) {
								foreach ($sites as $site)  {
									$regex = $site->regex;
									if (preg_match("/([0-9]+)\.([0-9]+)\.([0-9]+)\.([0-9]+)/", $comment->comment_author_IP, $matches)) {
										$rblhost = $matches[4] . "." . $matches[3] . "." . $matches[2] . "." . $matches[1] . "." . $regex;
										$resolved = gethostbyname($rblhost);
										if ($resolved != $rblhost) {
											$s_result = array();
										    $s_result['record'] = $comment;
										    $s_result['reason'] = 'RBL IP';
										    $s_result['pattern'] = $site->regex;
										    $s_results[] = $s_result;
											$next = True;
											break;
										}
									}
								}
							}
						}
						// RBL check
						if (!$next) {
							$sites = $wpdb->get_results("SELECT regex FROM $tableblacklist WHERE regex_type='rbld'");
							if ($sites) {
								foreach ($sites as $site)  {
					                $regex = $site->regex;;
							        $str = $comment->comment_content;
							        $str .= ' '.$comment->comment_url;
							        if ($domains = wpbl_get_domain($str)) {
										foreach($domains as $domain) {
											$rblhost = $domain .".". $regex;
											$resolved = gethostbyname($rblhost);
											if ($resolved != $rblhost) {
												$s_result = array();
											    $s_result['record'] = $comment;
											    $s_result['reason'] = 'RBL DOMAIN';
											    $s_result['pattern'] = $domain;
											    $s_results[] = $s_result;
												$next = True;
											    break;
											}
										}
							        }
								}
							}
						}
						// expression check
						if (!$next) {
							$sites = $wpdb->get_results("SELECT regex FROM $tableblacklist WHERE regex_type='url'");
							if ($sites) {
								foreach ($sites as $site)  {
									$regex = "/$site->regex/i";
									if (preg_match($regex, $comment->comment_author_url)) {
										$s_result = array();
									    $s_result['record'] = $comment;
									    $s_result['reason'] = 'URL';
									    $s_result['pattern'] = $site->regex;
									    $s_results[] = $s_result;
										$next = True;
										break;
									}
									if (preg_match($regex, $comment->comment_author_email)) {
										$s_result = array();
									    $s_result['record'] = $comment;
									    $s_result['reason'] = 'EMAIL';
									    $s_result['pattern'] = $site->regex;
									    $s_results[] = $s_result;
										$next = True;
										break;
									}
									if (preg_match($regex, $comment->comment_content)) {
										$s_result = array();
									    $s_result['record'] = $comment;
									    $s_result['reason'] = 'CONTENT';
									    $s_result['pattern'] = $site->regex;
									    $s_results[] = $s_result;
										$next = True;
										break;
									}
								}
							}
						}
					} // foreach
				}
			}
			break;
		case 1:
			// search by IP
            if (!empty($search)) {
				$sql = "SELECT * FROM $tablecomments WHERE comment_author_IP LIKE ('$search%') " .
					"ORDER BY comment_date DESC";
				$comments = $wpdb->get_results($sql);
				if ($comments) {
					foreach ($comments as $comment) {
						$s_result = array();
					    $s_result['record'] = $comment;
					    $s_result['pattern'] = '';
					    $s_result['reason'] = '';
					    $s_results[] = $s_result;
					}
				}
			} else {
				$valid = False;
			}
			break;

		case 2:
			// search by expression
			if (!empty($search)) {
				$search = sanctify($search, False);
				$sql = "SELECT * FROM $tablecomments ORDER BY comment_date DESC";
				$comments = $wpdb->get_results($sql);
				$sql = '';
				if ($comments) {
					foreach ($comments as $comment) {
						$next = False;
						// regular expression/URL check
						$regex = "/$search/i";
						if (preg_match($regex, $comment->comment_author_url)) {
						    $s_result['record'] = $comment;
						    $s_result['reason'] = '';
						    $s_result['pattern'] = '';
						    $s_results[] = $s_result;
							$next = True;
						}
						if (preg_match($regex, $comment->comment_author_email)) {
						    $s_result['record'] = $comment;
						    $s_result['reason'] = '';
						    $s_result['pattern'] = '';
						    $s_results[] = $s_result;
							$next = True;
						}
						if (preg_match($regex, $comment->comment_content)) {
						    $s_result['record'] = $comment;
						    $s_result['reason'] = '';
						    $s_result['pattern'] = '';
						    $s_results[] = $s_result;
							$next = True;
						}
					} // foreach
				}
			} else {
				$valid = False;
			}
			break;
	}
    // catch errors on blank search condition
    if ($s_results) {
		echo '<form name="deletecomments" id="deletecomments" action="wpblsearch.php?action=delete" method="post">
				<input name="search" type="hidden" value="' . $search . '">
				<input name="rb_search" type="hidden" value="' . $rb_search . '">
				<table width="100%" cellpadding="3" cellspacing="3">
					<tr>
					  <th scope="col">*</th>
					  <th scope="col">' .  _('Name') . '</th>
					  <th scope="col">' .  _('Email') . '</th>
					  <th scope="col">' . _('IP') . '</th>
					  <th scope="col">' . _('Comment Excerpt') . '</th>
					  <th scope="col">' . _('Reason') . '</th>
					  <th scope="col" colspan="3">' .  _('Actions') . '</th>
					</tr>';
		$_style = "";
		foreach ($s_results as $s_result) {
		    $comment = $s_result['record'];
			$authordata = get_userdata($wpdb->get_var("SELECT post_author FROM $tableposts WHERE ID = $comment->comment_post_ID"));
			$_style = ('class="odd"' == $_style) ? 'class="even"' : 'class="odd"';
?>
			<tr <?php echo $_style; ?>>
			  <td><?php if (($user_level > $authordata->user_level) or ($user_login == $authordata->user_login)) { ?><input type="checkbox" name="delete_comments[]" value="<?php echo $comment->comment_ID; ?>" /><?php } ?></td>
			  <td><?php comment_author_link() ?></td>
			  <td><?php comment_author_email_link() ?></td>
			  <td><a href="http://ws.arin.net/cgi-bin/whois.pl?queryinput=<?php comment_author_IP() ?>"><?php comment_author_IP() ?></a></td>
			  <td><?php comment_excerpt(); ?></td>
			  <td><?php echo $s_result['reason'].'('.$s_result['pattern'].')'; ?></td>
			  <td><a href="<?php echo get_permalink($comment->comment_post_ID); ?>#comment-<?php comment_ID() ?>" class="edit"><?php _e('View') ?></a></td>
			  <td><?php if (($user_level > $authordata->user_level) or ($user_login == $authordata->user_login)) {
			  echo "<a href='post.php?action=editcomment&amp;comment=$comment->comment_ID' class='edit'>" .  _('Edit') . "</a>"; } ?></td>
			  <td><?php if (($user_level > $authordata->user_level) or ($user_login == $authordata->user_login)) {
					  echo "<a href=\"post.php?action=deletecomment&amp;p=".$comment->comment_post_ID."&amp;comment=".$comment->comment_ID."\" onclick=\"return confirm('" . sprintf(_("You are about to delete this comment by \'%s\'\\n  \'Cancel\' to stop, \'OK\' to delete."), $comment->comment_author) . "')\"    class='delete'>" . _('Delete') . "</a>"; } ?></td>
			</tr>
<?php
		} // end foreach
?>
		</table>
		<p>
			<a href="javascript:;" onclick="checkAll(document.getElementById('deletecomments')); return false; "><?php _e('Invert Checkbox Selection') ?></a>
		</p>
		<p style="text-align: right;">
			<input type="submit" name="deladd" value="<?php _e('Delete & Add') ?>" onclick="return confirm('<?php _e("You are about to delete these comments permanently \\n  \'Cancel\' to stop, \'OK\' to delete.") ?>')" />
			<input type="submit" name="Submit" value="<?php _e('Delete Checked') ?>" onclick="return confirm('<?php _e("You are about to delete these comments permanently \\n  \'Cancel\' to stop, \'OK\' to delete.") ?>')" />
		</p>
	</form>
<?php
	} else {
		if ($valid) {
			// the blacklist-based search will end up here when there are no results
			echo '<p><strong>';
			_e('No results found.');
			echo '</strong></p>';
		} else {
			echo '<p><strong>';
			_e('Please enter a valid search expression!');
			echo '</strong></p>';
		}
	} // !empty($sql)
} // if ($action == 'search') || ($action == 'delete')
?>

</div>
<?php
include('admin-footer.php');
?>
