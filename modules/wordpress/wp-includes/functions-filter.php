<?php
// Filters: these are the core of WP's plugin architecture
function add_filter($tag, $function_to_add, $priority = 10) {
	global $wp_filter, $wp_id;
//	if ($tag=='comment_text') {echo "Add filter - $tag, $function_to_add<br>";}
	// So the format is wp_filter[$wp_id]['tag']['array of priorities']['array of functions']
	if (!@in_array($function_to_add, $wp_filter[$wp_id][$tag]["$priority"])) {
		$wp_filter[$wp_id][$tag]["$priority"][] = $function_to_add;
	}
//	if ($tag=='comment_text') {var_dump($wp_filter[$wp_id]['comment_text']); echo "<br>";}
	return true;
}

function remove_filter($tag, $function_to_remove, $priority = 10) {
	global $wp_filter, $wp_id;;
//	echo "Remove filter - $tag, $function_to_remove<br>";
	if (@in_array($function_to_remove, $wp_filter[$wp_id][$tag]["$priority"])) {
		$new_function_list = array();
		foreach ($wp_filter[$wp_id][$tag]["$priority"] as $function) {
			if ($function_to_remove != $function) {
				$new_function_list[] = $function;
			}
		}
		if (!count($new_function_list)) {
			if (!empty($wp_filter[$wp_id][$tag]["$priority"])) {
				unset($wp_filter[$wp_id][$tag]["$priority"]);
			}
		} else {
			$wp_filter[$wp_id][$tag]["$priority"] = $new_function_list;
		}
	}
	return true;
}

function apply_filters($tag, $string) {
	global $wp_filter, $wp_id, $wpdb;

	if (isset($wp_filter[$wp_id]['all'])) {
		foreach ($wp_filter[$wp_id]['all'] as $priority => $functions) {
			if (isset($wp_filter[$wp_id][$tag][$priority]))
				$wp_filter[$wp_id][$tag][$priority] = array_merge($wp_filter[$wp_id]['all'][$priority], $wp_filter[$wp_id][$tag][$priority]);
			else
				$wp_filter[$wp_id][$tag][$priority] = array_merge($wp_filter[$wp_id]['all'][$priority], array());
			$wp_filter[$wp_id][$tag][$priority] = array_unique($wp_filter[$wp_id][$tag][$priority]);
		}

	}
	/* Keep Plugin Comatibility */
	$tables = array('posts','users','categories','post2cat','comments','links','linkcategories','options','optiontypes','optionvalues','optiongroups','optiongroup_options','postmeta','settings');
	$oldtables = array();
	foreach($tables as $table) {
		if (isset($GLOBALS['table'.$table])) {
			$oldtables[$table] = $GLOBALS['table'.$table];
		}
		$GLOBALS['table'.$table] = $wpdb->{$table}[$wp_id];
	}
	if (isset($wp_filter[$wp_id][$tag])) {
		ksort($wp_filter[$wp_id][$tag]);
		foreach ($wp_filter[$wp_id][$tag] as $priority => $functions) {
			foreach($functions as $function) {
//				echo "$tag - $function  <br>";
				$string = $function($string);
			}
		}
	}
	foreach($tables as $table) {
		unset($GLOBALS['table'.$table]);
	}
	foreach($oldtables as $table=>$value) {
		$GLOBALS['table'.$table] = $value;
	}
	return $string;
}

// The *_action functions are just aliases for the *_filter functions, they take special strings instead of generic content

function do_action($tag, $string) {
	return apply_filters($tag, $string);
}

function add_action($tag, $function_to_add, $priority = 10) {
	add_filter($tag, $function_to_add, $priority);
}

function remove_action($tag, $function_to_remove, $priority = 10) {
	remove_filter($tag, $function_to_remove, $priority);
}
?>
