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
// Modified: NobuNobu, nobunobu@gmail.com
//  for XOOPS Special Usage.
// ------------------------------------------------
//                                    www.kowa.org
// ================================================
// $Revision$, $Date$
// ================================================

// unset $spaw_imglib_include
unset($spaw_imglib_include);

// include wysiwyg config
include '../config/spaw_control.config.php';
include $spaw_root.'class/util.class.php';
include $spaw_root.'class/lang.class.php';

if (!defined('SPAW_VSEP')) define('SPAW_VSEP','!-!');
if (!defined('SPAW_IMG_ROOT')) define('SPAW_IMG_ROOT',XOOPS_ROOT_PATH . '/');

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
if (!empty($spaw_imglib_include)) {
  include $spaw_imglib_include;
}

$value_found = false;
foreach ($spaw_imglibs as $spaw_imglib) {
  if ($lib == $spaw_imglib['catID']){
    $cur_imglib = $spaw_imglib;
    $value_found=true;
    break;
  }
}
if (!$value_found || empty($lib)) {
  $cur_imglib = $spaw_imglibs[0];
  $lib = $spaw_imglibs[0]['catID'];
}

$lib_options = liboptions($spaw_imglibs,'',$lib);

if (isset($_POST['imglist'])) {
  $img_params = explode(SPAW_VSEP, $_POST['imglist']);
  $img = basename($img_params[1]);
}

$preview = '';
$errors = array();

if( isset($_FILES['img_file']['size']) && $_FILES['img_file']['size']>0) {
  $img = uploadImg('img_file',$cur_imglib);
}
// delete confirm
if ($cur_imglib['delete_allowed'] && isset($_POST['lib_action']) 
    && ($_POST['lib_action']=='delete') && !empty($img)) {
  deleteConfirm($cur_imglib);
}
// delete
if ($cur_imglib['delete_allowed'] && isset($_POST['lib_action']) 
    && ($_POST['lib_action']=='dodelete') && !empty($img)) {
  deleteImg($cur_imglib, $img);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $l->getCharset()?>">
  <title><?php echo $l->m('title')?></title>
  <link rel="stylesheet" type="text/css" href="<?php echo $theme_path.'css/'?>dialog.css">
  <?php if (SPAW_Util::getBrowser() == 'Gecko') { ?>
  <script language="javascript" src="<?php echo $spaw_dir ?>dialogs/utils.gecko.js"></script>
  <?php }else{ ?>
  <script language="javascript" src="<?php echo $spaw_dir ?>dialogs/utils.js"></script>
  <?php } ?>
  <script language="javascript">
<!--
var selimg_name;
var selimg_desc;
var selimg_date;
var selimg_thumbflg;

function ImgInfo() {
}

function getSelectedImg() {
  if (document.libbrowser.lib.selectedIndex>=0 && document.libbrowser.imglist.selectedIndex>=0) {
    values = document.libbrowser.imglist.options[document.libbrowser.imglist.selectedIndex].value.split('<?php echo SPAW_VSEP; ?>');
    imgInfo = new ImgInfo();
    imgInfo.name = values[0];
    imgInfo.dname = values[1];
    imgInfo.thumb_name = values[2];
    imgInfo.desc = values[3];
    imgInfo.date = values[4];
    imgInfo.width = values[5];
    imgInfo.height = values[6];
    imgInfo.twidth = values[7];
    imgInfo.theight = values[8];
    imgInfo.isimg = values[9];

<?php if ($cur_imglib['type'] == 'XoopsImage'){ ?>
    imgInfo.imgUrl = '<?php if ($cur_imglib['storetype'] == "file") { echo XOOPS_URL.'/uploads/'; } else { echo XOOPS_URL.'/image.php?id='; }?>'+imgInfo.name;
<?php } else { ?>
    if (imgInfo.thumb_name == '__NO_IMAGE_ICON__') {
      imgInfo.imgUrl = '<?php echo XOOPS_URL."/".$cur_imglib['file_icon'] ?>';
    } else if (imgInfo.thumb_name != '') {
      imgInfo.imgUrl = '<?php echo XOOPS_URL."/".$cur_imglib['thumb_dir'] ?>' + imgInfo.thumb_name;
    } else {
      imgInfo.imgUrl = '<?php echo XOOPS_URL."/".$cur_imglib['value'] ?>' + imgInfo.name;
    }
<?php } ?>
  } else {
    imgInfo = '';
  }
  return (imgInfo);
}
function selectClick() {
  var retval = {};
  var imgInfo = getSelectedImg();
  if (imgInfo != '' ) {
    retval.imgurl = imgInfo.imgUrl;
    var zoom =  document.libbrowser.zoom.checked;
    var zoomrate =  document.libbrowser.zoomrate.value;
    if ((imgInfo.thumb_name =='') && zoom) {
      retval.zoomrate = zoomrate/100;
    } else {
      retval.zoomrate = 1;
    }
    if (imgInfo.thumb_name !='') {
      retval.thumbFlg = 'Thumb';
    } else {
      retval.thumbFlg = '';
    }
    retval.imgHref = '<?php echo XOOPS_URL."/".$cur_imglib['value'] ?>' + imgInfo.name;

    if (imgInfo.desc != '') {
      retval.title = imgInfo.desc;
    } else {
      retval.title = imgInfo.dname;
    }
    retval.isImg = imgInfo.isimg;
    if (!imgInfo.isimg) {
      retval.size = imgInfo.width/1024;
      retval.twidth = imgInfo.twidth;
    }
    window.returnValue = retval;
    window.close();
    <?php
    if (!empty($_GET['callback']))
      echo "opener.SPAW_".htmlspecialchars($_GET['callback'],ENT_QUOTES)."_callback('".htmlspecialchars($_GET['editor'],ENT_QUOTES)."',this);\n";
    ?>
  } else {
      alert('<?php echo $l->m('error').': '.$l->m('error_no_image')?>');
  }
}
    
function deleteClick() {
  if (document.libbrowser.imglist.selectedIndex>=0){
    document.getElementById('lib_action').value = 'delete';
    document.getElementById('libbrowser').submit();
  }
}

function Init() {
  resizeDialogToContent();
}

function selectChange() {
  var imgInfo = getSelectedImg();
  if (imgInfo == '') return;
  var zoom =  document.libbrowser.zoom.checked;
  var zoomrate =  document.libbrowser.zoomrate.value;
  imgurl = imgInfo.imgUrl;
  var html = '<html><meta http-equiv="content-type" content="text/html; charset=<?php echo _CHARSET;?>" /><body>';
  if (imgInfo.width == '') {
    imgpreview.document.body.innerHTML = html + '<img name="preview_img" id="preview_img" src="'+imgurl+'"/></body></html>';
    var w = imgpreview.document.images['preview_img'].width;
    var h = imgpreview.document.images['preview_img'].height;
  } else {
    var w = imgInfo.width;
    var h = imgInfo.height;
  }
  html +='<small><b>Name&nbsp;:&nbsp;</b>'+imgInfo.dname+'<br /><b>Desc&nbsp;:&nbsp;</b>'+imgInfo.desc+'<br /><b>Date&nbsp;:&nbsp;</b>'+imgInfo.date+'<br />';
  if (h != '') {
    html += '<b>Size&nbsp;:&nbsp;</b>'+w+'x'+h+'</small>';
  } else {
    html += '<b>Size&nbsp;:&nbsp;</b>'+w+'byte</small>';
  }
  if (imgInfo.twidth != '') {
    w = imgInfo.twidth;
    h = imgInfo.theight;
    html += '<small>&nbsp;&nbsp;(Thumbnail&nbsp;:&nbsp;'+w+'x'+h+')</small>';
  } else {
    html += '<small>&nbsp;&nbsp;(No&nbsp;Thumbnail)</small>';
  }
  imgpreview.document.body.innerHTML = html + '<hr /><img name="preview_img" id="preview_img" src="'+imgurl+'"/></body></html>';
  if ((w>h) && (w>300)) {
    imgpreview.document.images['preview_img'].width = 300;
    imgpreview.document.images['preview_img'].height = 300 * h/w;
  } else if ((h>w) && (h>220)) {
    imgpreview.document.images['preview_img'].width = 220 * w/h;
    imgpreview.document.images['preview_img'].height = 220;
  } else {
    imgpreview.document.images['preview_img'].width = w;
    imgpreview.document.images['preview_img'].height = h;
  }
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
<div style="border: 1px solid Black; padding: 5 5 5 5;">
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
  <iframe name="imgpreview" id="imgpreview" src="<?php echo $preview?>" style="width: 300px; height: 320px;" scrolling="Auto" marginheight="0" marginwidth="0" frameborder="0"></iframe>
  </td>
</tr>
<tr>
  <td valign="top" align="left"><b><?php echo $l->m('images')?>:</b></td>
</tr>
<tr>
  <td valign="top" align="left">
    <select name="imglist" size="20" class="input" style="width: 150px;" onchange="selectChange();" ondblclick="selectClick();">
      <?php listimages($cur_imglib, $img) ?>
    </select>
  </td>
</tr>
<tr>
  <td valign="top" align="left" colspan="3">
    <input type='checkbox' name='zoom' value='1' <?php echo $zoom ? "checked='checked'" : "" ?>  onclick="selectChange();" />Use Zoomed Image that hasn&rsquo;t  Thumbnail:<input type='text' name='zoomrate' size='4' value='<?php echo $zoomrate ?>'  onchange="selectChange();"/>%
  </td>
</tr>
<tr>
  <td valign="top" align="left" colspan="3">
  <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 0px 0px 0px 0px;">
  <tr>
    <td align="left" valign="middle" width="70%">
      <input type="button" value="<?php echo $l->m('select')?>" class="bt" onclick="selectClick();">
      <?php if (($cur_imglib['delete_allowed'])&& ($cur_imglib['type'] == 'Dir')) { ?>
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

<?php if (($cur_imglib['upload_allowed'])&& ($cur_imglib['type'] == 'Dir')) { ?>
<div style="border: 1px solid Black; padding: 5 5 5 5;">
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
  if (@dir(XOOPS_ROOT_PATH.'/'.$cur_imglib['value'])) {
  ?>
    <b><?php echo $l->m('upload')?>:</b> <input type="file" name="img_file" class="input"><br>
<?php if (function_exists('imagecreate')) { ?>
    Thumbnail : 
    <input type='radio' name='thumb' value='0'/> None 
    <input type='radio' name='thumb' value='1' checked='checked'/> 180px
    <input type='radio' name='thumb' value='2'/> 240px 
    <input type='radio' name='thumb' value='3'/> 300px <br>
<?php } ?>
    <input type="submit" name="btnupload" id="btnupload" class="bt" value="<?php echo $l->m('upload_button')?>">
  <?php 
  }
  ?>
  </td>
  <td valign="top" align="left" colspan="3">
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
    $buf .= '<option value="'.$lib['catID'].'"'.(($lib['catID'] == $sel)?' selected':'').'>'.$prefix.htmlspecialchars($lib['text'],ENT_QUOTES).'</option>'."\n";
  }
  return $buf;
}

function listimages($cur_imglib,$img) {
  $images = array();
  if ($cur_imglib['type'] == 'Dir') {
    $d = @dir(SPAW_IMG_ROOT.$cur_imglib['value']);
    if ($d) {
      while (($fname = $d->read()) !== false) {
        $file_path = SPAW_IMG_ROOT.$cur_imglib['value'].$fname;
        $thumb_path = SPAW_IMG_ROOT.$cur_imglib['thumb_dir'].$cur_imglib['thumb_prefix'].$fname;
        if (is_file($file_path)) {
          if (preg_match('/^'.preg_quote($cur_imglib['thumb_prefix']).'.*/',$fname)) continue;
          if (!($image_info = checkImgExtension($file_path, $cur_imglib['allowed_type']))) continue;
          $images[$fname]['name'] = $fname;
          $images[$fname]['title'] = $fname;
          $images[$fname]['ext'] = $image_info['ext'];
          $images[$fname]['width'] = $image_info[0];
          $images[$fname]['height'] = $image_info[1];

          if (in_array($image_info['ext'], array('jpg','jpeg'))) {
            $exif = array();
            if (function_exists('exif_read_data')) {
              $exif  = exif_read_data($file_path, 0, true);
            }
            $images[$fname]['desc'] = (isset($exif['IFD0']['ImageDescription']) ? htmlspecialchars($exif['IFD0']['ImageDescription'],ENT_QUOTES) :'');
            if (function_exists('mb_convert_encoding')) {
            	$images[$fname]['desc'] = mb_convert_encoding($images[$fname]['desc'], _CHARSET, 'auto');
            }
            $images[$fname]['date'] = (isset($exif['IFD0']['DateTime']) ? htmlspecialchars($exif['IFD0']['DateTime'],ENT_QUOTES) :date('Y:m:d H:i:s', filemtime($file_path)));
          } else if (in_array($image_info['ext'], array('gif','png'))) {
            $images[$fname]['desc'] = '';
            $images[$fname]['date'] = date('Y:m:d H:i:s', filemtime($file_path));
          }
          if (in_array($image_info['ext'],  $GLOBALS['spaw_valid_imgs']) && (file_exists($thumb_path) && ($thumb_info = checkImgExtension($thumb_path, $cur_imglib['allowed_type'])))) {
            $images[$fname]['thumb_name'] = $cur_imglib['thumb_prefix'].rawurlencode($fname);
            $images[$fname]['thumb_witdh'] = $thumb_info[0];
            $images[$fname]['thumb_height'] = $thumb_info[1];
          } else if (!in_array($image_info['ext'], $GLOBALS['spaw_valid_imgs'])&&(file_exists(XOOPS_ROOT_PATH.'/'.$cur_imglib['file_icon']) && ($thumb_info = checkImgExtension(XOOPS_ROOT_PATH.'/'.$cur_imglib['file_icon'], $cur_imglib['allowed_type'])))) {
            $images[$fname]['thumb_name'] = '__NO_IMAGE_ICON__';
            $images[$fname]['thumb_witdh'] = $thumb_info[0];
            $images[$fname]['thumb_height'] = $thumb_info[1];
          } else {
            $images[$fname]['thumb_name'] = '';
            $images[$fname]['thumb_witdh'] = '';
            $images[$fname]['thumb_height'] = '';
          }
        }
      }
      ksort($images);
      $d->close();
    } else {
    }
  } else if ($cur_imglib['type'] == 'XoopsImage') {
    global $xoopsDB;
    $result = $xoopsDB->query('SELECT image_id, image_name, image_nicename, image_created 
                               FROM '.$xoopsDB->prefix('image').' 
                               WHERE imgcat_id ='.intval($cur_imglib['autoID'])
                             );
    while($image = $xoopsDB->fetcharray($result)){
      if ($cur_imglib['storetype'] == 'file') {
        $fname = htmlspecialchars($image['image_name'], ENT_QUOTES);;
        $file_path = SPAW_IMG_ROOT.$cur_imglib['value'].$fname;
        if (!($image_info = checkImgExtension($file_path, $cur_imglib['allowed_type']))) continue;
      } else {
        $fname = htmlspecialchars($image['image_id'], ENT_QUOTES);
      }
      $images[$fname]['name'] = $fname;
      $images[$fname]['title'] = htmlspecialchars($image['image_nicename'], ENT_QUOTES);
      $images[$fname]['desc'] = $images[$fname]['title']; 
      $images[$fname]['date'] = date('Y:m:d H:i:s', $image['image_created']);
      if ($image_info) {
          $images[$fname]['width'] = $image_info[0];
          $images[$fname]['height'] = $image_info[1];
          $images[$fname]['ext'] = $image_info['ext'];
      } else {
          $images[$fname]['width'] = '';
          $images[$fname]['height'] = '';
          $images[$fname]['ext'] = '';
      }
      $images[$fname]['thumb_name'] = '';
      $images[$fname]['thumb_witdh'] = '';
      $images[$fname]['thumb_height'] = '';
    };
  } else {
    global $xoopsDB;
    $mydirnumber = $cur_imglib['storetype'] === '' ? '' : intval( $cur_imglib['storetype'] ) ;
    $result = $xoopsDB->query('SELECT lid, title, ext, date, res_x, res_y 
                               FROM '.$xoopsDB->prefix("myalbum{$mydirnumber}_photos").' 
                               WHERE cid=\''.intval($cur_imglib['autoID']).'\' AND status>0 ORDER BY title' ); // GIJ
    while($image = $xoopsDB->fetcharray($result)){
      $fname = trim($image['lid']).'.'.$image['ext'];
      $file_path = SPAW_IMG_ROOT.$cur_imglib['value'].$fname;
      if (in_array($image['ext'], $GLOBALS['spaw_valid_imgs'])) {
        $thumb_path = SPAW_IMG_ROOT.$cur_imglib['thumb_dir'].$cur_imglib['thumb_prefix'].$fname;
      } else {
        $thumb_path = SPAW_IMG_ROOT.$cur_imglib['thumb_dir'].$cur_imglib['thumb_prefix'].trim($image['lid']).'.gif';
      }
      if (!($image_info = checkImgExtension($file_path, $cur_imglib['allowed_type']))) continue;
      $images[$fname]['name'] = $fname;
      $images[$fname]['title'] = htmlspecialchars($image['title'], ENT_QUOTES);
      $images[$fname]['desc'] = $images[$fname]['title']; 
      $images[$fname]['date'] = date('Y:m:d H:i:s', $image['date']);
      $images[$fname]['width'] = $image_info[0];
      $images[$fname]['height'] = $image_info[1];
      $images[$fname]['ext'] = $image['ext'];
      if (file_exists($thumb_path) && ($thumb_info = checkImgExtension($thumb_path, $cur_imglib['allowed_type']))) {
        $images[$fname]['thumb_name'] = basename($thumb_path);
        if (in_array($image['ext'], $GLOBALS['spaw_valid_imgs'])) {
          $images[$fname]['thumb_witdh'] = $thumb_info[0];
          $images[$fname]['thumb_height'] = $thumb_info[1];
        } else {
          $images[$fname]['thumb_witdh'] = 32;
          $images[$fname]['thumb_height'] = 32;
        }
      } else {
        $images[$fname]['thumb_name'] = '';
        $images[$fname]['thumb_witdh'] = '';
        $images[$fname]['thumb_height'] = '';
      }
    }
  }
  foreach($images as $fname => $attr) {
    $option_value = implode(SPAW_VSEP, array(
                                       rawurlencode($fname),
                                       $fname,
                                       $attr['thumb_name'],
                                       $attr['desc'],
                                       $attr['date'],
                                       $attr['width'],
                                       $attr['height'],
                                       $attr['thumb_witdh'],
                                       $attr['thumb_height'],
                                       in_array($attr['ext'],$GLOBALS['spaw_valid_imgs']),
                             ));
    echo '<option value="'.$option_value.'" '.(($fname == $img)?'selected':''). '>'.$attr['title'].'</option>'."\n";
  }
}

function uploadImg($img, $cur_imglib) {
  global $cur_imglib;
  global $errors;
  global $l;
  
  if (!$cur_imglib['upload_allowed'] || ($cur_imglib['type'] != 'Dir')) {
    $errors[] = $l->m('error_uploading');
    return false;
  }
  if (!SPAW_Util::checkReferer('dialogs/img_library.php')) {
    $errors[] = $l->m('error_uploading');
    return false;
  }
  
  if ($_FILES[$img]['size']>0) {
    $data['type'] = $_FILES[$img]['type'];
    $data['name'] = $_FILES[$img]['name'];
    $data['size'] = $_FILES[$img]['size'];
    $data['tmp_name'] = $_FILES[$img]['tmp_name'];

    // get file extension
    if (!($image_info = checkImgExtension($data['tmp_name'], $cur_imglib['allowed_type'],$data['name']))){
      $errors[] = $l->m('error_wrong_type');
      return false;
    }
    $dir_name = SPAW_IMG_ROOT.$cur_imglib['value'];

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
    $ext = strtolower(substr(strrchr($data['name'],'.'), 1));
    if (!empty($_POST['thumb']) && in_array($ext,$GLOBALS['spaw_valid_imgs'])) {
      $thumb_size = intval($_POST['thumb']);
      $thums_size_array = array(0, 180, 240, 300);
      if ($thumb_size < 3) $thumb_size = $thums_size_array[$thumb_size];
      
      if (!function_exists('imagegif') && $image_info[2] == 1) {
          $errors[] = 'Filetype not supported. Thumbnail not created.';
      } elseif (!function_exists('imagejpeg') && $image_info[2] == 2) {
          $errors[] = 'Filetype not supported. Thumbnail not created.';
      } elseif (!function_exists('imagepng') && $image_info[2] == 3) {
          $errors[] = 'Filetype not supported. Thumbnail not created.';
      } else {
        // create the initial copy from the original file
        if ($image_info[2] == 1) {
            $image = imagecreatefromgif($dir_name.$img_name);
        } elseif ($image_info[2] == 2) {
            $image = imagecreatefromjpeg($dir_name.$img_name);
        } elseif ($image_info[2] == 3) {
            $image = imagecreatefrompng($dir_name.$img_name);
        } 

        if (function_exists('imageantialias'))
            imageantialias($image, TRUE);

        // figure out the longest side
        if ($image_info[0] > $image_info[1]) {
          $image_width = $image_info[0];
          $image_height = $image_info[1];
          $image_new_width = $thumb_size;

          $image_ratio = $image_width / $image_new_width;
          $image_new_height = $image_height / $image_ratio; 
          // width is > height
        } else {
          $image_width = $image_info[0];
          $image_height = $image_info[1];
          $image_new_height = $thumb_size;

          $image_ratio = $image_height / $image_new_height;
          $image_new_width = $image_width / $image_ratio; 
          // height > width
        } 
        if (function_exists('gd_info')) {
          $gdver=gd_info();
          if(strstr($gdver['GD Version'],'1.')!=false){
            //For GD
            $thumbnail = imagecreate($image_new_width, $image_new_height);
          }else{
            //For GD2
            $thumbnail = imagecreatetruecolor($image_new_width, $image_new_height);
          }
        } else {
          if (function_exists('imagecreatetruecolor')) {
            $thumbnail = @imagecreatetruecolor($image_new_width, $image_new_height);
          }
          if (!$thumbnail) {
             $thumbnail =imagecreate($image_new_width, $image_new_width);
          }
        }
        @imagecopyresized($thumbnail, $image, 0, 0, 0, 0, $image_new_width, $image_new_height, $image_info[0], $image_info[1]); 
        
        // move the thumbnail to it's final destination
        
        $path = explode('/', $file);

        $thumbpath = SPAW_IMG_ROOT.$cur_imglib['thumb_dir'].$cur_imglib['thumb_prefix'].$img_name;
        touch($thumbpath);

        if ($image_info[2] == 1) {
          if (!imagegif($thumbnail, $thumbpath)) {
            $errors[] = 'Thumbnail path invalid';
          } 
        } elseif ($image_info[2] == 2) {
          if (!imagejpeg($thumbnail, $thumbpath)) {
            $errors[] = 'Thumbnail path invalid';
          } 
        } elseif ($image_info[2] == 3) {
          if (!imagepng($thumbnail, $thumbpath)) {
            $errors[] = 'Thumbnail path invalid';
          } 
        } 
      }
      if (!empty($errors)) {
        return false;
      } 
    }
    return $img_name;
  }
  return false;
}
function deleteConfirm($cur_imglib)
{
  global $errors;
  global $request_uri;
  global $l;
  global $img_params;
  global $theme_path;

  if (!$cur_imglib['delete_allowed'] || ($cur_imglib['type'] != 'Dir')) {
    $errors[] = $l->m('error_cant_delete');
    return false;
  }
  if (!SPAW_Util::checkReferer('dialogs/img_library.php')) {
    $errors[] = $l->m('error_cant_delete');
    return false;
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $l->getCharset()?>">
  <title><?php echo $l->m('title')?></title>
  <link rel="stylesheet" type="text/css" href="<?php echo $theme_path.'css/'?>dialog.css">
  <script language="javascript">
  <!--
function deleteClick() {
  document.getElementById('lib_action').value = 'dodelete';
  document.getElementById('libbrowser').submit();
}
function cancelClick() {
  document.getElementById('libbrowser').submit();
}
  -->
  </script>
</head>
<body>
Are you sure deleting "<?php echo htmlspecialchars($img_params[0],ENT_QUOTES)?>" ?
<form name="libbrowser" id="libbrowser" method="post" action="" target="imglibrary">
<input type="hidden" name="theme" id="theme" value="<?php echo $theme?>">
<input type="hidden" name="request_uri" id="request_uri" value="<?php echo urlencode($request_uri)?>">
<input type="hidden" name="lang" id="lang" value="<?php echo $l->lang?>">
<input type="hidden" name="lib_action" id="lib_action" value="">
<input type="hidden" name="imglist" id="imglist" value="<?php echo htmlspecialchars($_POST['imglist'],ENT_QUOTES)?>">
<input type="hidden" name="lib" id="lib" value="<?php echo intval($_POST['lib'])?>">
<input type="button" value="<?php echo $l->m('delete')?>" class="bt" onclick="deleteClick();">
<input type="button" value="<?php echo $l->m('cancel')?>" class="bt" onclick="cancelClick();">
</form>
</body>
</html>
<?php
exit();
}
function deleteImg($cur_imglib, $img)
{
  global $spaw_img_delete_allowed;
  global $errors;
  global $l;

  if (!$cur_imglib['delete_allowed'] || ($cur_imglib['type'] != 'Dir')) {
    $errors[] = $l->m('error_cant_delete');
    return false;
  }
  if (!SPAW_Util::checkReferer('dialogs/img_library.php')) {
    $errors[] = $l->m('error_cant_delete');
    return false;
  }
  $thumnail_img_name = SPAW_IMG_ROOT.$cur_imglib['thumb_dir'].$cur_imglib['thumb_prefix'].$img;
  if (file_exists($thumnail_img_name)) {
    @unlink($thumnail_img_name);
  }
  $full_img_name = SPAW_IMG_ROOT.$cur_imglib['value'].$img;
  if (@unlink($full_img_name)) {
    return true;
  } else {
    $errors[] = $l->m('error_cant_delete');
    return false;
  }
}

function checkImgExtension($real_name, $allowed_type, $fname='') {
  if (!$fname) $fname = $real_name;
  $ext = strtolower(substr(strrchr($fname,'.'), 1));
  if (!in_array($ext, $allowed_type)) return false;
  if (in_array($ext, array_diff($allowed_type, $GLOBALS['spaw_valid_imgs']))) {
    $image_info[0] = filesize($fname);
    $image_info[1] = '';
  	$image_info['ext'] = $ext;
  	return $image_info;
  }
  $valid_image_type = array('gif'=>1, 'jpg'=>2, 'jpeg'=>2, 'png'=>3);
  $image_info = getimagesize($real_name);
  if (!$image_info || $image_info[2] != $valid_image_type[$ext]) {
  	return false;
  }
  $image_info['ext'] = $ext;
  return  $image_info;
}
?>