<?php
require_once('admin.php');

$standalone="1";
$title = 'Upload Image or File';
require_once('admin-header.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>WordPress &raquo; Upload images/files</title>
<link rel="stylesheet" href="wp-admin.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $blog_charset ?>" />
<script type="text/javascript">
<!-- // idocs.com's popup tutorial rules !
function targetopener(blah, closeme, closeonly) {
	if (! (window.focus && window.opener))return true;
//	window.opener.focus();
	if (! closeonly)window.opener.document.post.wp_content.value += blah;
	if (closeme)window.close();
	return false;
}
//-->
</script>
</head>
<body>
<h1 id="wphead"><a href="http://wordpress.xwd.jp/" rel="external" target="_blank"><span>WordPress Japan</span></a></h1>
<?php
if ($user_level == 0) {
	die(_LANG_P_CHEATING_ERROR);
	exit();
}

if (!get_settings('use_fileupload')) {
//Checks if file upload is enabled in the config
	die(_LANG_WAU_UPLOAD_DISABLED);
}
$allowed_types = explode(' ', trim(get_settings('fileupload_allowedtypes')));

init_param(array('POST'), 'submit','string', '');

if (get_param('submit')) {
	$action = 'upload';
} else {
	$action = '';
}
if (!is_writable(get_settings('fileupload_realpath')))
	$action = 'not-writable';
switch ($action) {
	case 'not-writable':
?>
<div class="wrap">
<p>(<code><?php echo get_settings('fileupload_realpath'); ?></code>)</p>
<p><?php echo _LANG_WAU_UPLOAD_DIRECTORY; ?></p>
</div>
<?php
		break;
	case '':
		foreach ($allowed_types as $type) {
			$type_tags[] = "<code>$type</code>";
		}
		$i = implode(', ', $type_tags);
?>
<div class="wrap">
<p>
<?php echo _LANG_WAU_UPLOAD_EXTENSION; ?><?php echo $i ?><br />
<?php echo _LANG_WAU_UPLOAD_BYTES; ?><?php echo get_settings('fileupload_maxk'); ?> KB<br />
<?php echo _LANG_WAU_UPLOAD_OPTIONS; ?>
</p>
    <form action="upload.php" method="post" enctype="multipart/form-data">
    <p>
      <label for="img1"><?php echo _LANG_WAU_UPLOAD_FILE; ?></label>
      <br />
	<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo get_settings('fileupload_maxk') * 1024 ?>" />
    <input type="file" name="img1" id="img1" size="35" class="uploadform" /></p>
    <p>
      <label for="imgdesc"><?php echo _LANG_WAU_UPLOAD_ALT; ?></label><br />
    <input type="text" name="imgdesc" id="imgdesc" size="30" class="uploadform" />
    </p>
	
    <p><?php echo _LANG_WAU_UPLOAD_THUMBNAIL; ?></p>
    <p>
    <label for="thumbsize_no">
    <input type="radio" name="thumbsize" value="none" checked="checked" id="thumbsize_no" />
    <?php echo _LANG_WAU_UPLOAD_NO; ?></label>
    <br />
        <label for="attach_icon">
<input type="radio" name="thumbsize" value="icon" id="attach_icon" />
<?php echo _LANG_WAU_ATTACH_ICON; ?></label>
        <br />
        <label for="thumbsize_small">
<input type="radio" name="thumbsize" value="small" id="thumbsize_small" />
<?php echo _LANG_WAU_UPLOAD_SMALL; ?></label>
        <br />
        <label for="thumbsize_large">
<input type="radio" name="thumbsize" value="large" id="thumbsize_large" />
<?php echo _LANG_WAU_UPLOAD_LARGE; ?></label>
        <br />
        <label for="thumbsize_custom">
        <input type="radio" name="thumbsize" value="custom" id="thumbsize_custom" />
        <?php echo _LANG_WAU_UPLOAD_CUSTOM; ?></label>
      : 
      <input type="text" name="imgthumbsizecustom" size="4" />
      <?php echo _LANG_WAU_UPLOAD_PX; ?>
	<br />
    <label for="associate_amazon">
    <input type="radio" name="associate" value="amazon" id="associate_amazon" />
    <?php echo _LANG_WAU_UPLOAD_AMAZON; ?></label>
    </p>
	<p><input type="submit" name="submit" value="<?php echo _LANG_WAU_UPLOAD_BTN; ?>" /></p>
    </form>
</div>
<?php 
		break;
	case 'upload':
	    $imgalt = (isset($_POST['imgalt'])) ? $_POST['imgalt'] : $imgalt;

	    $img1_name = (strlen($imgalt)) ? $_POST['imgalt'] : $_FILES['img1']['name'];
	    $img1_type = (strlen($imgalt)) ? $_POST['img1_type'] : $_FILES['img1']['type'];
	    $imgdesc = str_replace('"', '&amp;quot;', $_POST['imgdesc']);

	    $imgtype = explode(".",$img1_name);
	    $imgtype = strtolower($imgtype[count($imgtype)-1]);

	    if (in_array($imgtype, $allowed_types) == false) {
	        die("File $img1_name of type $imgtype is not allowed.");
	    }

	    if (strlen($imgalt)) {
	        $pathtofile = get_settings('fileupload_realpath')."/".$imgalt;
	        $img1 = $_POST['img1'];
	    } else {
	        $pathtofile = get_settings('fileupload_realpath')."/".$img1_name;
	        $img1 = $_FILES['img1']['tmp_name'];
	    }

		$fsize = sprintf("%5.1f",$_FILES['img1']['size'] / 1024);

	    // makes sure not to upload duplicates, rename duplicates
	    $i = 1;
	    $pathtofile2 = $pathtofile;
	    $tmppathtofile = $pathtofile2;
	    $img2_name = $img1_name;

	    while (file_exists($pathtofile2)) {
	        $pos = strpos($tmppathtofile, '.'.trim($imgtype));
	        $pathtofile_start = substr($tmppathtofile, 0, $pos);
	        $pathtofile2 = $pathtofile_start.'_'.zeroise($i++, 2).'.'.trim($imgtype);
	        $img2_name = explode('/', $pathtofile2);
	        $img2_name = $img2_name[count($img2_name)-1];
	    }

	    if (file_exists($pathtofile) && !strlen($imgalt)) {
	        $i = explode(' ', get_settings('fileupload_allowedtypes'));
	        $i = implode(', ',array_slice($i, 1, count($i)-2));
	        $moved = move_uploaded_file($img1, $pathtofile2);
	        // if move_uploaded_file() fails, try copy()
	        if (!$moved) {
	            $moved = copy($img1, $pathtofile2);
	        }
	        if (!$moved) {
	            die("Couldn't Upload Your File to $pathtofile2.");
	        } else {
				chmod($pathtofile2, 0666);
	            @unlink($img1);
	        }
	    
	// duplicate-renaming function contributed by Gary Lawrence Murphy
    ?>
<div class="wrap">
    <p><strong><?php echo _LANG_WAU_UPLOAD_DUPLICATE; ?></strong></p>
    <p><?php echo _LANG_WAU_UPLOAD_EXISTS; ?><em><?php echo $img1_name; ?></em></p>
    <p> filename '<?php echo $img1; ?>' moved to '<?php echo "$pathtofile2 - $img2_name"; ?>'</p>
    <p><?php echo _LANG_WAU_UPLOAD_RENAME; ?></p>
    <form action="upload.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo  get_settings('fileupload_maxk') *1024 ?>" />
    <input type="hidden" name="img1_type" value="<?php echo $img1_type;?>" />
    <input type="hidden" name="img1_name" value="<?php echo $img2_name;?>" />
    <input type="hidden" name="img1_size" value="<?php echo $img1_size;?>" />
    <input type="hidden" name="img1" value="<?php echo $pathtofile2;?>" />
    <input type="hidden" name="thumbsize" value="<?php echo $_REQUEST['thumbsize'];?>" />
    <input type="hidden" name="imgthumbsizecustom" value="<?php echo $_REQUEST['imgthumbsizecustom'];?>" />
    <input type="hidden" name="associate" value="<?php echo $_REQUEST['associate'];?>" />
    <?php echo _LANG_WAU_UPLOAD_ALTER; ?><br /><input type="text" name="imgalt" size="30" class="uploadform" value="<?php echo $img2_name;?>" /><br />
    <br />
    <?php echo _LANG_WAU_UPLOAD_ALT; ?><br /><input type="text" name="imgdesc" size="30" class="uploadform" value="<?php echo $imgdesc;?>" />
    <br />
    <input type="submit" name="submit" value="<?php echo _LANG_WAU_UPLOAD_REBTN; ?>" />
    </form>
</div>
<?php 
			break;
    	}
	    if (!strlen($imgalt)) {
	        @$moved = move_uploaded_file($img1, $pathtofile); //Path to your images directory, chmod the dir to 777
	        // move_uploaded_file() can fail if open_basedir in PHP.INI doesn't
	        // include your tmp directory. Try copy instead?
	        if(!$moved) {
	            $moved = copy($img1, $pathtofile);
	        }
	        // Still couldn't get it. Give up.
	        if (!$moved) {
	            die("Couldn't Upload Your File to $pathtofile.");
	        } else {
				chmod($pathtofile, 0666);
	            @unlink($img1);
	        }
	        
	    } else {
	        rename($img1, $pathtofile)
	        or die("Couldn't Upload Your File to $pathtofile.");
	    }
	    
	    if(($_POST['thumbsize'] != 'none')&&($_POST['thumbsize'] != 'icon')) {
	        if($_POST['thumbsize'] == 'small') {
	            $max_side = 200;
	        }
	        elseif($_POST['thumbsize'] == 'large') {
	            $max_side = 400;
	        }
	        elseif($_POST['thumbsize'] == 'custom') {
	            $max_side = intval($_POST['imgthumbsizecustom']);
	        }
	        
	        $result = wp_create_thumbnail($pathtofile, $max_side, NULL);
	        if($result != 1) {
	            print $result;
	        }
	    }

		$img_prefix = 'thumb-';
		if ($_POST['associate'] == 'amazon') {
			$asin = explode(".", $img1_name);
			$piece_of_code = "&lt;a href=&quot;http://www.amazon.co.jp/exec/obidos/ASIN/$asin[0]/$amazon_id&quot; target=&quot;_blank&quot;&gt;&lt;img style=&quot;float: left; margin: 0 10px 0 0;&quot; src=&quot;". get_settings('fileupload_url') ."/$img1_name&quot; border=&quot;0&quot; alt=&quot;$imgdesc&quot; /&gt;&lt;/a&gt;";
		} elseif ($_POST['thumbsize'] == 'icon') {
			$piece_of_code = "&lt;a style=&quot;float: left; margin: 0 10px 0 0;&quot; href=&quot;". get_settings('fileupload_url') . "/$img1_name&quot;&gt;" . "&lt;img src=&quot;". $siteurl ."/wp-images/file.gif&quot; alt=&quot;$imgdesc&quot; /&gt;" .$img1_name. "(".$fsize."KB)&lt;/a&gt;";
		} elseif ( ereg('image/',$img1_type) && $_POST['thumbsize'] != 'none') {
			$piece_of_code = "&lt;a style=&quot;float: left; margin: 0 10px 0 0;&quot; href=&quot;". get_settings('fileupload_url') . "/$img1_name&quot;&gt;" . "&lt;img src=&quot;". get_settings('fileupload_url') ."/$img_prefix$img1_name&quot; alt=&quot;$imgdesc&quot; /&gt;" . "&lt;/a&gt;";
		} else {
			$piece_of_code = "&lt;img src=&quot;". get_settings('fileupload_url') . "/$img1_name&quot; alt=&quot;$imgdesc&quot; /&gt;";
		}
?>
<div class="wrap">
	<h3>File uploaded!</h3>
	<p><?php echo _LANG_WAU_UPLOAD_SUCCESS; ?><code><?php echo $img1_name; ?></code></p>
	<p><?php echo _LANG_WAU_UPLOAD_CODE; ?></p>
	<form>
	<input type="text" name="imgpath" value="<?php echo $piece_of_code; ?>" size="45" style="margin: 2px;" /><br />
	<input type="button" name="close" value="<?php echo _LANG_WAU_UPLOAD_CODEIN; ?>" class="search" onClick="targetopener('<?php echo $piece_of_code; ?>')" style="margin: 2px;" />
	</form>
	<p><strong>Image Details</strong>: <br />
	Name:
	<?php echo $img1_name; ?>
	<br />
	Size:
	<?php echo round($img1_size / 1024, 2); ?> <abbr title="Kilobyte">KB</abbr><br />
	Type:
	<?php echo $img1_type; ?>
	</p>
	<p><a href="upload.php"><?php echo _LANG_WAU_UPLOAD_START; ?></a>.</p>
</div>
<?php
		break;
}
?>
</body></html>
