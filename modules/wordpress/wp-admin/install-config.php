<?php
/* ÈþÆý */
$_wp_installing = 1;
require("../wp-lang/lang_ja.php");
$wpj_head = <<<EOD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>WordPress &rsaquo; Setup Configuration File</title>
<meta http-equiv="Content-Type" content="text/html; charset=$blog_charset" />
<style media="screen" type="text/css">
    <!--
	body {
		font-family: "¥Ò¥é¥®¥Î³Ñ¥´ Pro W3", Osaka, Verdana, "£Í£Ó £Ð¥´¥·¥Ã¥¯", sans-serif;
		margin-left: 15%;
		margin-right: 15%;
	}
	#logo {
		margin: 0;
		padding: 0;
		background-image: url(../wp-images/wordpress.gif);
		background-repeat: no-repeat;
		height: 60px;
		border-bottom: 1px solid #dcdcdc;
	}
	#logo a {
		display: block;
		height: 60px;
	}
	#logo a span {
		display: none;
	}
	p, li {
		line-height: 140%;
	}
    -->
	</style>
</head>
<body> 
<h1 id="logo"><a href="http://wordpress.xwd.jp/"><span>WordPress Japan</span></a></h1>
EOD;

$wpj_foot = <<<EOD
</body></html>
EOD;

if (file_exists('../wp-config.php')) 
	die($wpj_head . _LANG_WA_CONFIG_GUIDE1 . $wpj_foot);

if (!file_exists('../wp-config-sample.php'))
    die($wpj_head . _LANG_WA_CONFIG_GUIDE2 . $wpj_foot);
$configFile = file('../wp-config-sample.php');

if (!is_writable('../')) die($wpj_head . _LANG_WA_CONFIG_GUIDE3 . $wpj_foot);

$step = $HTTP_GET_VARS['step'];
if (!$step) $step = 0;

echo $wpj_head;

switch($step) {
	case 0:
?> 
<p><?php echo _LANG_WA_CONFIG_GUIDE4; ?></p> 
<ol> 
  <li><?php echo _LANG_WA_CONFIG_DATABASE; ?></li> 
  <li><?php echo _LANG_WA_CONFIG_USERNAME; ?></li> 
  <li><?php echo _LANG_WA_CONFIG_PASSWORD; ?></li> 
  <li><?php echo _LANG_WA_CONFIG_LOCALHOST; ?></li> 
  <li><?php echo _LANG_WA_CONFIG_PREFIX; ?></li>
</ol> 
<p><?php echo _LANG_WA_CONFIG_GUIDE5; ?></p>
<?php
	break;

	case 1:
	?> 
</p> 
<form method="post" action="install-config.php?step=2"> 
  <p><?php echo _LANG_WA_CONFIG_GUIDE6; ?></p>
  <table>
    <tr>
      <th scope="row" align="left"><?php echo _LANG_WA_CONFIG_DATABASE; ?></th>
      <td><input name="dbname" type="text" size="45" value="wordpress" /></td>
    </tr>
   <tr>
      <td colspan="2"><?php echo _LANG_WA_CONFIG_GUIDE7; ?><br /><br /></td>
    </tr>
    <tr> 
      <th scope="row" align="left"><?php echo _LANG_WA_CONFIG_USERNAME; ?></th> 
      <td><input name="uname" type="text" size="45" value="username" /></td> 
    </tr>
   <tr>
      <td colspan="2"><?php echo _LANG_WA_CONFIG_GUIDE8; ?><br /><br /></td>
    </tr>
    <tr> 
      <th scope="row" align="left"><?php echo _LANG_WA_CONFIG_PASSWORD; ?></th> 
      <td><input name="pwd" type="text" size="45" value="password" /></td> 
    </tr>
   <tr>
      <td colspan="2"><?php echo _LANG_WA_CONFIG_GUIDE9; ?><br /><br /></td>
    </tr>
    <tr> 
      <th scope="row" align="left"><?php echo _LANG_WA_CONFIG_LOCALHOST; ?></th> 
      <td><input name="dbhost" type="text" size="45" value="localhost" /></td> 
    </tr>
   <tr>
      <td colspan="2"><?php echo _LANG_WA_CONFIG_GUIDE10; ?><br /><br /></td>
    </tr>
    <tr>
      <th scope="row" align="left"><?php echo _LANG_WA_CONFIG_PREFIX; ?></th>
      <td><input name="prefix" type="text" id="prefix" value="wp_" size="45" /></td>
    </tr>
   <tr>
      <td colspan="2"><?php echo _LANG_WA_CONFIG_GUIDE11; ?><br /><br /></td>
    </tr>
  </table> 
  <input name="submit" type="submit" value="Submit" /> 
</form> 
<?php
	break;
	
	case 2:
	$dbname = $HTTP_POST_VARS['dbname'];
    $uname = $HTTP_POST_VARS['uname'];
    $passwrd = $HTTP_POST_VARS['pwd'];
    $dbhost = $HTTP_POST_VARS['dbhost'];
	$prefix = $HTTP_POST_VARS['prefix'];
	if (empty($prefix)) $prefix = 'wp_';

    // Test the db connection.
    define('DB_NAME', $dbname);
    define('DB_USER', $uname);
    define('DB_PASSWORD', $passwrd);
    define('DB_HOST', $dbhost);

    // We'll fail here if the values are no good.
    require_once('../wp-includes/wp-db.php');
	$handle = fopen('../wp-config.php', 'w');

    foreach ($configFile as $line_num => $line) {
        switch (substr($line,0,16)) {
            case "define('DB_NAME'":
                fwrite($handle, str_replace("wordpress", $dbname, $line));
                break;
            case "define('DB_USER'":
                fwrite($handle, str_replace("'username'", "'$uname'", $line));
                break;
            case "define('DB_PASSW":
                fwrite($handle, str_replace("'password'", "'$passwrd'", $line));
                break;
            case "define('DB_HOST'":
                fwrite($handle, str_replace("localhost", $dbhost, $line));
                break;
			case '$table_prefix  =':
				fwrite($handle, str_replace('wp_', $prefix, $line));
				break;
            default:
                fwrite($handle, $line);
        }
    }
    fclose($handle);
	chmod('../wp-config.php', 0666);
?> 
<p><?php echo _LANG_WA_CONFIG_GUIDE12; ?></p> 
<?php
	break;

}
?> 
</body>
</html>
