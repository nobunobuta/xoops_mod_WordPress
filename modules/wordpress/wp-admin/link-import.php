<?php
// Links
// Copyright (C) 2002 Mike Little -- mike@zed1.com

require_once('../wp-config.php');

$parent_file = 'link-manager.php';
$title = 'Import Blogroll';
$this_file = 'link-import.php';

$step = $_POST['step'];
if (!$step) $step = 0;
?>
<?php
switch ($step) {
    case 0:
    {
        $standalone = 0;
        include_once('admin-header.php');
        if ($user_level < get_settings('links_minadminlevel'))
            die ("Cheatin&#8217; uh?");

        $opmltype = 'blogrolling'; // default.
?>

<ul id="adminmenu2">
	<li><a href="link-manager.php" ><?php echo _LANG_WLA_MANAGE_LINK; ?></a></li>
	<li><a href="link-add.php"><?php echo _LANG_WLA_ADD_LINK; ?></a></li>
	<li><a href="link-categories.php"><?php echo _LANG_WLA_LINK_CATE; ?></a></li>
	<li class="last"><a href="link-import.php"  class="current"><?php echo _LANG_WLA_IMPORT_BLOG; ?></a></li>
</ul>

<div class="wrap">

    <h2><?php echo _LANG_WLI_ROLL_DESC; ?></h2>
	<!-- <form name="blogroll" action="link-import.php" method="get"> -->
	<form enctype="multipart/form-data" action="link-import.php" method="post" name="blogroll">

	<ol>
    <li><a href="http://www.blogrolling.com"><strong>Blogrolling.com : </strong></a><?php echo _LANG_WLI_ROLL_OPMLCODE; ?></li>
    <li><a href="http://blo.gs"><strong>Blo.gs : </strong></a><?php echo _LANG_WLI_ROLL_OPMLLINK; ?></li>
    <li><?php echo _LANG_WLI_ROLL_BELOW; ?><br />
       <input type="hidden" name="step" value="1" />
       <?php echo _LANG_WLI_ROLL_YOURURL; ?><input type="text" name="opml_url" size="65" /></li>
    <li><?php echo _LANG_WLI_ROLL_UPLOAD; ?><br />
       <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
       <label><?php echo _LANG_WLI_ROLL_THISFILE; ?><input name="userfile" type="file" /></label></li>
    <li><?php echo _LANG_WLI_ROLL_CATEGORY; ?><select name="cat_id">
<?php
	$categories = $wpdb->get_results("SELECT cat_id, cat_name, auto_toggle FROM {$wpdb->linkcategories[$wp_id]} ORDER BY cat_id");
	foreach ($categories as $category) {
?>
    <option value="<?php echo $category->cat_id; ?>"><?php echo $category->cat_id.': '.$category->cat_name; ?></option>
<?php
        } // end foreach
?>
    </select>

	</li>

    <li><input type="submit" name="submit" value="<?php echo _LANG_WLI_ROLL_BUTTONTEXT; ?>" /></li>
	</ol>
    </form>

</div>
<?php
                break;
            } // end case 0

    case 1: {
                $standalone = 0;
                include_once('admin-header.php');
                if ($user_level < get_settings('links_minadminlevel'))
                    die ("Cheatin' uh ?");
?>
<div class="wrap">

     <h3>Importing...</h3>
<?php
                $cat_id = $_POST['cat_id'];
                if (($cat_id == '') || ($cat_id == 0)) {
                    $cat_id  = 1;
                }

                $opml_url = $_POST['opml_url'];
                if (isset($opml_url) && $opml_url != '') {
					$blogrolling = true;
                }
                else // try to get the upload file.
				{
					$uploaddir = get_settings('fileupload_realpath');
					$uploadfile = $uploaddir.'/'.$_FILES['userfile']['name'];

					if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
					{
						//echo "Upload successful.<p />";
						$blogrolling = false;
						$opml_url = $uploadfile;
					} else {
						echo "Upload error<p />";
					}
				}

                if (isset($opml_url) && $opml_url != '') {
                    $opml = implode('', file($opml_url));
                    include_once('link-parse-opml.php');

                    $link_count = count($names);
                    for ($i = 0; $i < $link_count; $i++) {
                        if ('Last' == substr($titles[$i], 0, 4))
                            $titles[$i] = '';
                        if ('http' == substr($titles[$i], 0, 4))
                            $titles[$i] = '';
                        $query = "INSERT INTO {$wpdb->links[$wp_id]} (link_url, link_name, link_target, link_category, link_description, link_owner)
                                  VALUES('{$urls[$i]}', '".addslashes($names[$i])."', '', $cat_id, '".addslashes($descriptions[$i])."', $user_ID)\n";
                        $result = $wpdb->query($query);
                        echo "<p>Inserted <strong>{$names[$i]}</strong></p>";
                    }
?>
     <p>Inserted <?php echo $link_count ?> links into category <?php echo $cat_id; ?>. All done! Go <a href="link-manager.php">manage those links</a>.</p>
<?php
                } // end if got url
                else
                {
                    echo "<p>You need to supply your OPML url. Press back on your browser and try again</p>\n";
                } // end else

?>
<?php
                break;
            } // end case 1
} // end switch
?>
</div>
<?php include('admin-footer.php'); ?>