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
    global $wpdb, $tableposts, $m, $wp_id;
    $m = substr($m,0,4);
    $years = $wpdb->get_col("SELECT DISTINCT YEAR(post_date) as year FROM {$wpdb->posts[$wp_id]} ORDER BY year ASC");
    $output .= '<option value="">全期間</option>'.NL;
    foreach ($years as $year) {
        $output .= '<option value="'.$year.'"';
        if ($year == $m) {
            $output .= ' selected="selected"';
        }
        $output .= '>'.$year.'年</option>';
    }
    $output  = '<select name="m">'.NL.$output.'</select>'.NL;
    echo $output;
}

function show_author_select() {
    global $wpdb, $tableusers, $author, $wp_id;
    $users = $wpdb->get_results("SELECT * FROM {$wpdb->users[$wp_id]} WHERE user_level > 0", ARRAY_A);
    $output .= '<option value="">全投稿者</option>'.NL;
    foreach ($users as $user) {
        $output .= '<option value="'.$user['ID'].'"';
        if ($user['ID'] == $author) {
            $output .= 'selected="selected"';
        }
        $output .= '>'.$user['user_nickname'].'</option>'.NL;
    }
    $output = '<select name="author">'.NL.$output.'</select>'.NL;
    echo $output;
}

function show_orderby_select() {
    global $orderby, $wp_id;
    $orderby = explode(' ', $orderby);
    $orderby = $orderby[0];
    if ($orderby == 'date') {
       $output .= '<option value="date" selected="selected">日付</option>'.NL;
    } else {
       $output .= '<option value="date">日付</option>'.NL;
    }
    if ($orderby == 'title') {
       $output .= '<option value="title" selected="selected">タイトル</option>'.NL;
    } else {
       $output .= '<option value="title">タイトル</option>'.NL;
    }
    if ($orderby == 'category') {
       $output .= '<option value="category" selected="selected">カテゴリ</option>'.NL;
    } else {
       $output .= '<option value="category">カテゴリ</option>'.NL;
    }
    $output = '<select name="orderby" onchange="Choose(this)">'.NL.$output.'</select>'.NL;
    echo $output;
}

function show_order_select() {
    global $order;
    if ($order == 'ASC') {
       $output .= '<option value="ASC" selected="selected">昇順</option>'.NL;
    } else {
       $output .= '<option value="ASC">昇順</option>'.NL;
    }
    if ($order == 'DESC') {
       $output .= '<option value="DESC" selected="selected">降順</option>'.NL;
    } else {
       $output .= '<option value="DESC">降順</option>'.NL;
   }
   $output = '<select name="order" id="asc_desc">'.NL.$output.'</select>'.NL;
   echo $output;
}

function archive_header($before='', $after='') {
    global $post, $orderby, $month, $previous, $siteurl, $blogfilename, $archiveheadstart, $archiveheadend, $category_name, $blog_charset;
    $orderby = explode(' ', $orderby);
    $orderby = $orderby[0];
    if ('date' == $orderby || empty($orderby)) {
        $thismonth = mysql2date('m', $post->post_date);
        $thisyear = mysql2date('Y', $post->post_date);
        $thisdate = $thisyear.$thismonth;
        if ($thisdate != $previous) {
            $thismonth = mysql2date('m', $post->post_date);
            $output .= '<strong><br/><a href="'.get_month_link($thisyear,$thismonth).'">'.$thisyear.'年'.$month[$thismonth].'</a></strong>';
        }
        $previous = $thisdate;
    } elseif ('title' == $orderby) {
    	$thisletter = ucfirst(mb_substr($post->yomi,0,1,$blog_charset));
    	if ($thisletter > "ん") $thisletter = "漢字";
        if ($thisletter != $previous) {
            $output .= "<br/>".$thisletter;
        }
        $previous = $thisletter;
    } elseif ('category' == $orderby) {
        $thiscategory = $category_name;
        if ($thiscategory != $previous) {
            $output .= '<br/><strong><a href="'.get_category_link(false,$thiscategory).'">'.get_catname($thiscategory).'</a></strong>';
        }
        $previous = $thiscategory;
    }
    if (!empty($output)) {
        $output = $before.$output.$after.NL;
        echo $output;
    }
}

function archive_date($format='Y-m-d H:i:s') {
    global $post;
    echo mysql2date($format, $post->post_date);
}

function cmp($a, $b) {
	global $order;
    if ($order == 'ASC') {
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
        $author = $wpdb->get_var("SELECT ID FROM {$wpdb->users[$wp_id]} WHERE user_nicename='".$author_name."'");
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
    <input type="submit" name="submit" value="並び替える" />
    </form>
    <?php
    $dogs = $wpdb->get_results("SELECT * FROM {$wpdb->categories[$wp_id]} WHERE 1=1 ORDER BY cat_name $order");
    foreach ($dogs as $catt) {
        $categories = $wpdb->get_results("SELECT * FROM {$wpdb->post2cat[$wp_id]} WHERE category_id = $catt->cat_ID");
        if ($categories) {
            foreach ($categories as $post2category) {
                $posts = $wpdb->get_results("SELECT * FROM {$wpdb->posts[$wp_id]} WHERE $post2category->post_id = ID".$where);
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
    <input type="submit" name="submit" value="並び替える" />
    </form>
    <?php
	if ($_GET["orderby"] == 'title') {
		if ($enable_kakasi) {
			$descriptorspec = array(
				0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
				1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
			);
			$process = proc_open($kakasi." -kH -KH -JH", $descriptorspec, $pipes);
			if (is_resource($process)) {
		    	for($i = 0; $i < count($posts); $i++) {
					fputs($pipes[0], mb_convert_encoding($posts[$i]->post_title."\n", $kakasi_encode, $blog_charset));
				}
				fclose($pipes[0]);
		    	for($i = 0; $i < count($posts); $i++) {
					$posts[$i]->yomi = mb_convert_encoding(fgets ($pipes[1]), $blog_charset, $kakasi_encode);
		    	}
				fclose($pipes[1]);
				$return_value = proc_close($process);
			}
		} else {
	    	for($i = 0; $i < count($posts); $i++) {
				$posts[$i]->yomi = mb_convert_kana($posts[$i]->post_title,"KcV", $blog_charset);
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
