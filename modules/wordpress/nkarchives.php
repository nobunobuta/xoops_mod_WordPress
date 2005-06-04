<?php
// Sortable Nicer Archive for WordPress XOOPS Module Japanese Kanji Edition.
//  Original Sortable Nicer Archives for WordPress 
//    http://weblogtoolscollection.com/archives/2004/05/23/sortable-nicer-archives-for-wordpress/
//  Ported for XOOPS by Nobuki Kowa
//    http://www.kowa.org

//Kakasi関連環境設定
$enable_kakasi    = 1;                  // kakasiを使用して読み仮名によってタイトルを並び替える場合は1
$kakasi           = "/usr/bin/kakasi";  // kakasiプログラムのパス 環境によっては、/usr/local/bin/kakasi等
$kakasi_encode    = "EUC-JP";           // Windows環境でkakasiがSJISベースの設定の時はここを"SJIS"に
//Authorリストの表示設定
$display_authors  = 1;                  // 0:投稿者一覧を表示しない。 1:投稿者一覧を表示する。
//
if (!file_exists($kakasi)) $enable_kakasi = 0;
?>
<?php
$posts_per_page = '-1';
include('header.php');
?>
<div id="rap">
<h2 id="header"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h2>
<div id="wpMainContent">
<?php
$defaultorderby = 'post_date';
$defaultorder = 'DESC';
define('NL', "\n");

function show_year_select() {
	if (!empty($GLOBALS['m'])) {
    	$GLOBALS['m'] = substr($GLOBALS['m'],0,4);
    }
    $years = $GLOBALS['wpdb']->get_col("SELECT DISTINCT YEAR(post_date) as year FROM ".wp_table('posts')." ORDER BY year ASC");
    $output = '<option value="">'._LANG_NKA_ALL_YEAR.'</option>'.NL;
    foreach ($years as $year) {
        $output .= '<option value="'.$year.'"';
        if (!empty($GLOBALS['m']) && ($year == $GLOBALS['m'])) {
            $output .= ' selected="selected"';
        }
        $output .= '>'.$year._LANG_NKA_YEAR_SUFFIX.'</option>';
    }
    $output  = '<select name="m">'.NL.$output.'</select>'.NL;
    echo $output;
}

function show_author_select() {
    $users = $GLOBALS['wpdb']->get_results("SELECT * FROM ".wp_table('users')." WHERE user_level > 0", ARRAY_A);
    $output = '<option value="">'._LANG_NKA_ALL_AUTHOR.'</option>'.NL;
    foreach ($users as $user) {
        $output .= '<option value="'.$user['ID'].'"';
        if ($user['ID'] == $GLOBALS['author']) {
            $output .= 'selected="selected"';
        }
        $output .= '>'.$user['user_nickname'].'</option>'.NL;
    }
    $output = '<select name="author">'.NL.$output.'</select>'.NL;
    echo $output;
}

function show_orderby_select() {
    $GLOBALS['orderby'] = explode(' ', $GLOBALS['orderby']);
    $GLOBALS['orderby'] = $GLOBALS['orderby'][0];
    if ($GLOBALS['orderby'] == 'date') {
       $output = '<option value="date" selected="selected">'._LANG_NKA_ORDER_DATE.'</option>'.NL;
    } else {
       $output = '<option value="date">'._LANG_NKA_ORDER_DATE.'</option>'.NL;
    }
    if ($GLOBALS['orderby'] == 'title') {
       $output .= '<option value="title" selected="selected">'._LANG_NKA_ORDER_TITLE.'</option>'.NL;
    } else {
       $output .= '<option value="title">'._LANG_NKA_ORDER_TITLE.'</option>'.NL;
    }
    if ($GLOBALS['orderby'] == 'category') {
       $output .= '<option value="category" selected="selected">'._LANG_NKA_ORDER_CATEGORY.'</option>'.NL;
    } else {
       $output .= '<option value="category">'._LANG_NKA_ORDER_CATEGORY.'</option>'.NL;
    }
    $output = '<select name="orderby" onchange="Choose(this)">'.NL.$output.'</select>'.NL;
    echo $output;
}

function show_order_select() {
    if ($GLOBALS['order'] == 'ASC') {
       $output = '<option value="ASC" selected="selected">'._LANG_NKA_SORT_ASC.'</option>'.NL;
    } else {
       $output = '<option value="ASC">'._LANG_NKA_SORT_ASC.'</option>'.NL;
    }
    if ($GLOBALS['order'] == 'DESC') {
       $output .= '<option value="DESC" selected="selected">'._LANG_NKA_SORT_DSC.'</option>'.NL;
    } else {
       $output .= '<option value="DESC">'._LANG_NKA_SORT_DSC.'</option>'.NL;
   }
   $output = '<select name="order" id="asc_desc">'.NL.$output.'</select>'.NL;
   echo $output;
}

function archive_header($before='', $after='') {
    $GLOBALS['orderby'] = explode(' ', $GLOBALS['orderby']);
    $GLOBALS['orderby'] = $GLOBALS['orderby'][0];
    if ('date' == $GLOBALS['orderby'] || empty($GLOBALS['orderby'])) {
        $thismonth = mysql2date('m', $GLOBALS['post']->post_date);
        $thisyear = mysql2date('Y', $GLOBALS['post']->post_date);
        $thisdate = $thisyear.$thismonth;
        if ($thisdate != $GLOBALS['previous']) {
            $thismonth = mysql2date('m', $GLOBALS['post']->post_date);
            $monthstr = ereg_replace('%MONTH',$GLOBALS['month'][zeroise($thismonth,2)],$GLOBALS['wp_month_format']);
            $monthstr = ereg_replace('%YEAR',sprintf("%d",$thisyear),$monthstr);
            $output = '<strong><br/><a href="'.get_month_link($thisyear,$thismonth).'">'.$monthstr.'</a></strong>';
        }
        $GLOBALS['previous'] = $thisdate;
    } elseif ('title' == $GLOBALS['orderby']) {
    	if (_LANGCODE == 'ja') {
	    	$thisletter = ucfirst(mb_substr($GLOBALS['post']->yomi,0,1,$GLOBALS['blog_charset']));
    		if ($thisletter > "ん") $thisletter = "漢字";
    	} else {
    		$thisletter = ucfirst(substr($GLOBALS['post']->yomi,0,1));
    	}
        if (empty($GLOBALS['previous']) || $thisletter != $GLOBALS['previous']) {
            $output = "<br/>".$thisletter;
        }
        $GLOBALS['previous'] = $thisletter;
    } elseif ('category' == $GLOBALS['orderby']) {
        $thiscategory = $GLOBALS['category_name'];
        if ($thiscategory != $GLOBALS['previous']) {
            $output = '<br/><strong><a href="'.get_category_link(false,$thiscategory).'">'.get_catname($thiscategory).'</a></strong>';
        }
        $GLOBALS['previous'] = $thiscategory;
    }
    if (!empty($output)) {
        $output = $before.$output.$after.NL;
        echo $output;
    }
}

function archive_date($format='Y-m-d H:i:s') {
    echo mysql2date($format, $GLOBALS['post']->post_date);
}

function cmp($a, $b) {
    if ($GLOBALS['order'] == 'ASC') {
		return strcasecmp($a->yomi, $b->yomi);
	} else {
		return strcasecmp($b->yomi, $a->yomi);
	}
}
?>

<script language="javascript" type="text/javascript">
function Choose(whichSort) {
    if (whichSort.selectedIndex == 2) {
        document.getElementById('asc_desc').selectedIndex = 1;
    } else {
        document.getElementById('asc_desc').selectedIndex = 0;
    }
}
</script>

<?php
//Make sure categories get parsed out, they are deprecated in wp-blog-header.php
if ($_GET["orderby"] == 'category') {
    global $author, $m;
    $orderby = 'category';
    if ($_GET["order"] == '') $order = "DESC";
    else $order = $_GET["order"];
    $year = '' . intval($_GET["m"]);
    $m = $year;
    $author = ''.intval($_GET["author"]);
    if (empty($author)) {
        $whichauthor='';
    } else {
        $author = ''.urldecode($author).'';
        $author = addslashes_gpc($author);
        if (stristr($author, '-')) {
            $eq = '!=';
            $andor = 'AND';
            $author = explode('-', $author);
            $author = ''.intval($author[1]);
        } else {
            $eq = '=';
            $andor = 'OR';
        }
        $author_array = explode(' ', $author);
        $whichauthor .= ' AND (post_author '.$eq.' '.intval($author_array[0]);
        for ($i = 1; $i < (count($author_array)); $i = $i + 1) {
            $whichauthor .= ' '.$andor.' post_author '.$eq.' '.intval($author_array[$i]);
        }
        $whichauthor .= ')';
    }

    // Author stuff for nice URIs

    if ('' != $author_name) {
        if (stristr($author_name,'/')) {
            $author_name = explode('/',$author_name);
            if ($author_name[count($author_name)-1]) {
            $author_name = $author_name[count($author_name)-1];#no trailing slash
            } else {
            $author_name = $author_name[count($author_name)-2];#there was a trailling slash
            }
        }
        $author_name = preg_replace('|[^a-z0-9-]|', '', strtolower($author_name));
        $author = $wpdb->get_var("SELECT ID FROM ".wp_table('users')." WHERE user_nicename='".$author_name."'");
        $whichauthor .= ' AND (post_author = '.intval($author).')';
    }
    if (!empty($year)) $where .= ' AND YEAR(post_date)=' . $year;
    if (!empty($whichauthor)) $where .= $whichauthor;
    ?>

    過去ログ :
    <form action="<?php getenv('PHP_SELF') ?>" method="get">
    <?php show_orderby_select() ?>
    <?php show_order_select() ?>
    <?php show_year_select() ?>
    <?php if ($display_authors) show_author_select(); ?>
    <input type="submit" name="submit" value="<?php echo _LANG_NKA_ACTION_SORT ?>" />
    </form>
    <?php
    $dogs = $wpdb->get_results("SELECT * FROM ".wp_table('categories')." WHERE 1=1 ORDER BY cat_name $order");
    foreach ($dogs as $catt) {
        $categories = $wpdb->get_results("SELECT * FROM ".wp_table('post2cat')." WHERE category_id = $catt->cat_ID");
        if ($categories) {
            foreach ($categories as $post2category) {
                $posts = $wpdb->get_results("SELECT * FROM ".wp_table('posts')." WHERE $post2category->post_id = ID".$where);
                global $category_name;
                $category_name = $post2category->category_id;
                if ($posts) {
                    foreach ($posts as $post) {
                        start_wp();
                        archive_header('<h3>', '</h3>');
                        archive_date('Y/m/d H:i:s') ?>: <a href="<?php echo get_permalink($post->ID) ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a><br />
                        <?php

                    }
                }
            }
        }
    }
}
else {
    require_once ('wp-blog-header.php');
    // echo $request;
    ?>

    過去ログ :
    <form action="<?php getenv('PHP_SELF') ?>" method="get">
    <?php show_orderby_select() ?>
    <?php show_order_select() ?>
    <?php show_year_select() ?>
    <?php if ($display_authors) show_author_select(); ?>
    <input type="submit" name="submit" value="<?php echo _LANG_NKA_ACTION_SORT ?>" />
    </form>
    <?php
	if ($_GET["orderby"] == 'title') {
    	if (_LANGCODE == 'ja') {
			if ($enable_kakasi) {
				$descriptorspec = array(
					0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
					1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
				);
				$process = proc_open($kakasi." -kH -KH -JH", $descriptorspec, $pipes);
				if (is_resource($process)) {
			    	for($i = 0; $i < count($posts); $i++) {
						fputs($pipes[0], mb_conv($posts[$i]->post_title."\n", $kakasi_encode, $GLOBALS['blog_charset']));
					}
					fclose($pipes[0]);
			    	for($i = 0; $i < count($posts); $i++) {
						$posts[$i]->yomi = mb_conv(fgets ($pipes[1]), $GLOBALS['blog_charset'], $kakasi_encode);
			    	}
					fclose($pipes[1]);
					$return_value = proc_close($process);
				}
			} else {
		    	for($i = 0; $i < count($posts); $i++) {
					$posts[$i]->yomi = mb_convert_kana($posts[$i]->post_title,"KcV", $GLOBALS['blog_charset']);
				}
			}
		} else {
	    	for($i = 0; $i < count($posts); $i++) {
				$posts[$i]->yomi = $posts[$i]->post_title;
			}
		}
    	usort($posts, "cmp");
    }
    ?>

    <?php if ($posts) { foreach ($posts as $post) { start_wp(); ?>
    <?php archive_header('<h3>', '</h3>') ?>
    <?php archive_date('Y/m/d H:i:s') ?>: <a href="<?php echo get_permalink($post->ID) ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a><br />
    <?php } }
    }?>
<p class="credit"><?php echo $wpdb->querycount; ?> queries. <?php timer_stop(1); ?> sec.<br /><cite>Powered by <a href="http://www.kowa.org/" title="NobuNobu XOOPS"><strong>WordPress Module</strong></a> based on <a href="http://wordpress.xwd.jp/" title="Powered by WordPress Japan"><strong>WordPress ME</strong></a> & <a href="http://www.wordpress.org/" title="Powered by WordPress"><strong>WordPress</strong></a></cite></p>
</div>
</div>
<?php include(XOOPS_ROOT_PATH."/footer.php"); ?>
