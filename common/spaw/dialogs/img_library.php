<?php 
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// Image library dialog
// ================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Copyright: Solmetra (c)2003 All rights reserved.
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// $Revision$, $Date$
// ================================================

// unset $spaw_imglib_include
unset($spaw_imglib_include);

// include wysiwyg config
include '../config/spaw_control.config.php';
include $spaw_root.'class/util.class.php';
include $spaw_root.'class/lang.class.php';
//include_once 'header.php';

$theme = htmlspecialchars(empty($_GET['theme'])?$spaw_default_theme:$_GET['theme'],ENT_QUOTES);
$theme_path = $spaw_dir.'lib/themes/'.$theme.'/';

$l = new SPAW_Lang(htmlspecialchars(empty($_POST['lang'])?$_GET['lang']:$_POST['lang'],ENT_QUOTES));
$l->setBlock('image_insert');

$request_uri = urldecode(empty($_POST['request_uri'])?(empty($_GET['request_uri'])?'':$_GET['request_uri']):$_POST['request_uri']);

$lib = isset( $_GET['lib'] ) ? $_GET['lib'] : '' ;
$lib = isset( $_POST['lib'] ) ? $_POST['lib'] : $lib ;
$lib = intval($lib);

$zoom = isset( $_POST['zoom'] ) ? intval($_POST['zoom']) : '0';
$zoomrate = isset( $_POST['zoomrate'] ) ? intval($_POST['zoomrate']) : '100';

// if set include file specified in $spaw_imglib_include
if (!empty($spaw_imglib_include))
{
  include $spaw_imglib_include;
}

$value_found = false;
// callback function for preventing listing of non-library directory
function is_array_value($value, $key, $_imglib)
{
  global $value_found,$lib;
  // echo $value.'-'.$_imglib.'<br>';
  
  if (in_array($_imglib,$value)){
    $value_found=true;
    $lib = $spaw_imglibs[$key]['catID'];
  }
}
//array_walk($spaw_imglibs, 'is_array_value',$imglib);
foreach ($spaw_imglibs as $spawimg){
    if ($lib == $spawimg['catID']){
        $imglib= $spawimg['value'];
        $imgcat= $spawimg['autoID'];
        $imagetype= $spawimg['storetype'];
        $libtype =  $spawimg['type'];
        $value_found=true;
        break;
    }
}
if (!$value_found || empty($lib))
{
  $imglib = $spaw_imglibs[0]['value'];
  $lib = $spaw_imglibs[0]['catID'];
  $imagetype= $spaw_imglibs[0]['storetype'];
  $imgcat= $spaw_imglibs[0]['autoID'];
  $libtype =  $spaw_imglibs[0]['type'];
}

$lib_options = liboptions($spaw_imglibs,'',$lib);
$img = isset($_POST['imglist'])?$_POST['imglist']:'';

$preview = '';

$errors = array();
if( isset($_FILES['img_file']['size']) && $_FILES['img_file']['size']>0)
{
  if ($img = uploadImg('img_file'))
  {
    $preview = $spaw_base_url.$imglib.$img;
  }
}
// delete
if ($spaw_img_delete_allowed && isset($_POST['lib_action']) 
	&& ($_POST['lib_action']=='delete') && !empty($img)) {
  deleteImg();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
  <title><?php echo $l->m('title')?></title>
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $l->getCharset()?>">
  <link rel="stylesheet" type="text/css" href="<?php echo $theme_path.'css/'?>dialog.css">
  <?php if (SPAW_Util::getBrowser() == 'Gecko') { ?>
  <script language="javascript" src="<?php echo $spaw_dir ?>/dialogs/utils.gecko.js"></script>
  <?php }else{ ?>
  <script language="javascript" src="<?php echo $spaw_dir ?>/dialogs/utils.js"></script>
  <?php } ?>
  
  <script language="javascript">
  <!--
  	function getImgUrl() {
      if (document.libbrowser.lib.selectedIndex>=0 && document.libbrowser.imglist.selectedIndex>=0) {
<?php if ($libtype == 'Dir') {?>
        imgUrl = '<?php echo XOOPS_URL."/".$imglib ?>' + document.libbrowser.imglist.options[document.libbrowser.imglist.selectedIndex].value;
<?php } else if ($libtype == 'XoopsImage'){ ?>
        imgUrl = '<?php if ($imagetype == "file") { echo XOOPS_URL.'/uploads/'; } else { echo XOOPS_URL.'/image.php?id='; }?>'+document.libbrowser.imglist.options[document.libbrowser.imglist.selectedIndex].value;
<?php } else { ?>
        imgUrl = '<?php echo XOOPS_URL."/uploads/" ?>' + document.libbrowser.imglist.options[document.libbrowser.imglist.selectedIndex].value;
<?php } ?>
      } else {
        imgUrl = '';
      }
      return (imgUrl);
  	}
    function selectClick()
    {
      var retval = {};
      var imgurl  = getImgUrl();
      if (imgurl != "") {
        retval.imgurl = imgurl;
   		var zoom =  document.libbrowser.zoom.checked;
   		var zoomrate =  document.libbrowser.zoomrate.value;
		if (!imgurl.match(/(.*)\/thumb-(.*)/) && !imgurl.match(/(.*)\/thumbs(\d*)\/(.*)/) && zoom) {
			retval.zoomrate = zoomrate/100;
		} else {
			retval.zoomrate = 1;
		}
        window.returnValue = retval;
        window.close();
        <?php
        if (!empty($_GET['callback']))
          echo "opener.".urlencode($_GET['callback'])."('".htmlspecialchars($_GET['editor'],ENT_QUOTES)."',this);\n";
        ?>
      } else {
        alert('<?php echo $l->m('error').': '.$l->m('error_no_image')?>');
      }
    }
    
function deleteClick()
	{
	  if (document.getElementById('imglist').selectedIndex>=0)
	  {
      document.getElementById('lib_action').value = 'delete';
      document.getElementById('libbrowser').submit();
	  }
	}

function Init()
    {
      resizeDialogToContent();
    }

function selectChange() {
   		var imgurl = getImgUrl();
		if (imgurl == "" ) return;
   		var zoom =  document.libbrowser.zoom.checked;
   		var zoomrate =  document.libbrowser.zoomrate.value;
		imgpreview.document.body.innerHTML = '<html><body><IMG src="'+imgurl+'"/></body></html>';
		if (!imgurl.match(/(.*)\/thumb-(.*)/) && !imgurl.match(/(.*)\/thumbs(\d*)\/(.*)/)) {
			document.libbrowser.zoom.disabled = false;
			document.libbrowser.zoomrate.disabled = false;
			if (zoom) {
				imgpreview.document.body.style.zoom = zoomrate/100;
			}
		} else {
			document.libbrowser.zoom.disabled = true;
			document.libbrowser.zoomrate.disabled = true;
			imgpreview.document.body.style.zoom = 1;
		}
	}
   
  //-->
  </script>
</head>

<body onLoad="Init()" dir="<?php echo $l->getDir();?>">
  <script language="javascript">
  <!--
    window.name = 'imglibrary';
  //-->
  </script>

<form name="libbrowser" id="libbrowser" method="post" action="" enctype="multipart/form-data" target="imglibrary">
<input type="hidden" name="theme" id="theme" value="<?php echo $theme?>">
<input type="hidden" name="request_uri" id="request_uri" value="<?php echo urlencode($request_uri)?>">
<input type="hidden" name="lang" id="lang" value="<?php echo $l->lang?>">
<input type="hidden" name="lib_action" id="lib_action" value="">
<div style="border: 1 solid Black; padding: 5 5 5 5;">
<table border="0" cellpadding="2" cellspacing="0">
<tr>
  <td valign="top" align="left"><b><?php echo $l->m('library')?>:</b></td>
  <td valign="top" align="left">&nbsp;</td>
  <td valign="top" align="left"><b><?php echo $l->m('preview')?>:</b></td>
</tr>
<tr>
  <td valign="top" align="left">
  <select name="lib" id="lib" size="1" class="input" style="width: 150px;" onChange="document.getElementById('libbrowser').submit();">
    <?php echo $lib_options?>
  </select>
  </td>
  <td valign="top" align="left" rowspan="3">&nbsp;</td>
  <td valign="top" align="left" rowspan="3">
  <iframe name="imgpreview" id="imgpreview" src="<?php echo $preview?>" style="width: 300px; height: 100%;" scrolling="Auto" marginheight="0" marginwidth="0" frameborder="0"></iframe>
  </td>
</tr>
<tr>
  <td valign="top" align="left"><b><?php echo $l->m('images')?>:</b></td>
</tr>
<tr>
  <td valign="top" align="left">
  <?php 
    
    $_root = XOOPS_ROOT_PATH."/";
	$d = @dir($_root.$imglib);
	if ($libtype == 'Dir') {
		echo '<select name="imglist" size="15" class="input" style="width: 150px;" onchange="selectChange();" ondblclick="selectClick();">';
		if ($d) {
			while (false !== ($entry = $d->read())) {
				if (is_file($_root.$imglib.$entry)) {
					if (ereg('^thumb-.*',$entry)) continue;
					if (ereg('\.(jpg|jpeg|gif|png)',$entry)) {
						if (file_exists($_root.$imglib.'thumb-'.$entry)) {
							echo '<option value="thumb-'.$entry.'" '.(($entry == $img)?'selected':''). '>'.$entry.'</option>';
						} else {
							echo '<option value="'. $entry.'" '.(($entry == $img)?'selected':''). '>'.$entry.'</option>';
						}
					}
				}
			}
			$d->close();
		} else {
			$errors[] = $l->m('error_no_dir');
		}
	  	echo '</select>';
	} else if ($libtype == 'XoopsImage') {
		// XOOPS original ImageManager
  		echo '<select name="imglist" size="15" class="input" style="width: 150px;" onchange="selectChange();" ondblclick="selectClick();">';

		global $xoopsDB;

		if ($imagetype == "file") {
			$result = $xoopsDB->query("SELECT image_name,image_nicename FROM ".$xoopsDB->prefix('image')." WHERE imgcat_id = ".intval($imgcat));
			while($image = $xoopsDB->fetcharray($result)){

				echo '<option value="'.$image["image_name"].'" '.($image["image_name"] == $img ? 'selected' : ''). '>'.$image["image_nicename"].'</option>' ;
			}
		} else {
			$result = $xoopsDB->query("SELECT image_id, image_name,image_nicename FROM ".$xoopsDB->prefix('image')." WHERE imgcat_id ".intval($imgcat));
			while($image = $xoopsDB->fetcharray($result)){
		  
				echo '<option value="'.$image["image_id"].'" '.($image["image_id"] == $img ? 'selected' : '').'>'.$image["image_nicename"].'</option>' ;
			}
		}
		echo '</select>';

	} else {
	// myAlbum-P ImageManagerIntegration
		echo '<select name="imglist" size="15" class="input" style="width: 150px;" onchange="selectChange();" ondblclick="selectClick();">';

		$mydirnumber = $imagetype === '' ? '' : intval( $imagetype ) ;

		global $xoopsDB;
		$result = $xoopsDB->query("SELECT lid, title, ext FROM ".$xoopsDB->prefix("myalbum{$mydirnumber}_photos")." WHERE cid='".intval($imgcat)."' AND ext IN ('gif','png','jpg','jpeg') ORDER BY title" );
		while($image = $xoopsDB->fetcharray($result)){
			$fname = trim($image["lid"]).".".$image["ext"];
			if (file_exists($_root.$imglib."photos{$mydirnumber}/".$fname)) {
				if (file_exists($_root.$imglib."thumbs{$mydirnumber}/".$fname)) {
					echo '<option value="thumbs'.$mydirnumber.'/'.$fname.'" '.($fname == $img ? 'selected' : '' ).'>'.$image["title"].'</option>' ;
				} else {
				echo '<option value="photos'.$mydirnumber.'/'.$fname.'" '.($fname == $img ? 'selected' : '' ).'>'.$image["title"].'</option>' ;
				}
			}
		}
  		echo '</select>';
  	}

?>

  </td>
</tr>
<tr>
  <td valign="top" align="left" colspan="3">
	<input type='checkbox' name='zoom' value='1' <?php echo $zoom ? "checked='checked'" : "" ?>  onclick="selectChange();" />Use Zoomed Image that hasn&rsquo;t  Thumbnail:<input type='text' name='zoomrate' size='4' value='<?php echo $zoomrate ?>'  onchange="selectChange();"/>%
  </td>
</tr>
<tr>
  <td valign="top" align="left" colspan="3">
  <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 0 0 0 0;">
  <tr>
    <td align="left" valign="middle" width="70%">
      <input type="button" value="<?php echo $l->m('select')?>" class="bt" onclick="selectClick();">
	  <?php if ($spaw_img_delete_allowed) { ?>
      <input type="button" value="<?php echo $l->m('delete')?>" class="bt" onclick="deleteClick();">
	  <?php } ?>
	</td>
	<td align="right" valign="middle" width="30%">
	  <input type="button" value="<?php echo $l->m('cancel')?>" class="bt" onclick="window.close();">
	</td>
  </tr>
  </table>
  </td>
</tr>
</table>
</div>

<?php if (($spaw_upload_allowed)&& ($libtype == 'Dir')) { ?>
<div style="border: 1 solid Black; padding: 5 5 5 5;">
<table border="0" cellpadding="2" cellspacing="0">
<tr>
  <td valign="top" align="left">
    <?php  
    if (!empty($errors))
    {
      echo '<span class="error">';
      foreach ($errors as $err)
      {
        echo $err.'<br>';
      }
      echo '</span>';
    }
    ?>

  <?php 
  if ($d) {
  ?>
    <b><?php echo $l->m('upload')?>:</b> <input type="file" name="img_file" class="input"><br>
    <input type="submit" name="btnupload" id="btnupload" class="bt" value="<?php echo $l->m('upload_button')?>">
  <?php 
  }
  ?>
  </td>
</tr>
</table>
</div>
<?php  } ?>
</form>
</body>
</html>

<?php 
function liboptions($arr, $prefix = '', $sel = '')
{
  $buf = '';
  foreach($arr as $lib) {
    $buf .= '<option value="'.$lib['catID'].'"'.(($lib['catID'] == $sel)?' selected':'').'>'.$prefix.$lib['text'].'</option>'."\n";
  }
  return $buf;
}

function uploadImg($img) {

  global $spaw_valid_imgs;
  global $imglib;
  global $errors;
  global $l;
  global $spaw_upload_allowed;
  
  if (!$spaw_upload_allowed) return false;

  	$_root = XOOPS_ROOT_PATH."/";
  
  if ($_FILES[$img]['size']>0) {
    $data['type'] = $_FILES[$img]['type'];
    $data['name'] = $_FILES[$img]['name'];
    $data['size'] = $_FILES[$img]['size'];
    $data['tmp_name'] = $_FILES[$img]['tmp_name'];

    // get file extension
    $ext = strtolower(substr(strrchr($data['name'],'.'), 1));
    if (in_array($ext,$spaw_valid_imgs)) {
      $dir_name = $_root.$imglib;

      $img_name = $data['name'];
      $i = 1;
      while (file_exists($dir_name.$img_name)) {
        $img_name = ereg_replace('(.*)(\.[a-zA-Z]+)$', '\1_'.$i.'\2', $data['name']);
        $i++;
      }
	  if (!move_uploaded_file($data['tmp_name'], $dir_name.$img_name)) {
        $errors[] = $l->m('error_uploading');
        return false;
      }

      return $img_name;
    }
    else
    {
      $errors[] = $l->m('error_wrong_type');
    }
  }
  return false;
}

function deleteImg()
{
  global $imglib;
  global $img;
  global $spaw_img_delete_allowed;
  global $errors;
  global $l;
  
  if (!$spaw_img_delete_allowed) return false;

  $_root = XOOPS_ROOT_PATH . '/';
	
  $full_img_name = $_root.$imglib.$img;

  if (@unlink($full_img_name)) {
  	return true;
  }
  else
  {
  	$errors[] = $l->m('error_cant_delete');
	return false;
  }
}
?>