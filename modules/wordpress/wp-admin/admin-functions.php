<?php
function selected($selected, $current) {
	if ($selected == $current) echo ' selected="selected"';
}

function checked($checked, $current) {
	if ($checked == $current) echo ' checked="checked"';
}

function get_nested_categories($default = 0) {
 global $post_ID, $mode, $wpdb, $wp_id;
 if ($post_ID) {
   $checked_categories = $wpdb->get_col("
     SELECT category_id
     FROM  {$wpdb->categories[$wp_id]}, {$wpdb->post2cat[$wp_id]}
     WHERE {$wpdb->post2cat[$wp_id]}.category_id = cat_ID AND {$wpdb->post2cat[$wp_id]}.post_id = '$post_ID'
     ");
 } else {
   $checked_categories[] = $default;
 }

 $categories = $wpdb->get_results("SELECT * FROM {$wpdb->categories[$wp_id]} ORDER BY category_parent DESC, cat_name ASC");
 $result = array();
 foreach($categories as $category) {
   $array_category = get_object_vars($category);
   $me = 0 + $category->cat_ID;
   $parent = 0 + $category->category_parent;
	if (isset($result[$me]))   $array_category['children'] = $result[$me];
   $array_category['checked'] = in_array($category->cat_ID, $checked_categories);
   $array_category['cat_name'] = stripslashes($category->cat_name);
   $result[$parent][] = $array_category;
 }

 return $result[0];
}

function write_nested_categories($categories) {
 foreach($categories as $category) {
   echo '<label for="category-', $category['cat_ID'], '" class="selectit"><input value="', $category['cat_ID'],
     '" type="checkbox" name="post_category[]" id="category-', $category['cat_ID'], '"',
     ($category['checked'] ? ' checked="checked"' : ""), '/> ', $category['cat_name'], "</label>\n";

   if(isset($category['children'])) {
     echo "\n<span class='cat-nest'>\n";
     write_nested_categories($category['children']);
     echo "</span>\n";
   }
 }
}

function dropdown_categories($default = 0) {
 write_nested_categories(get_nested_categories($default));
} 
// Dandy new recursive multiple category stuff.
function cat_rows($parent = 0, $level = 0, $categories = 0) {
	global $wpdb, $wp_id, $bgcolor;
	if (!$categories) {
		$categories = $wpdb->get_results("SELECT * FROM {$wpdb->categories[$wp_id]} ORDER BY cat_name");
	}
	if ($categories) {
		foreach ($categories as $category) {
			if ($category->category_parent == $parent) {
				$count = $wpdb->get_var("SELECT COUNT(post_id) FROM {$wpdb->post2cat[$wp_id]} WHERE category_id = $category->cat_ID");
				$pad = str_repeat('&#8212; ', $level);

				$bgcolor = ('#eee' == $bgcolor) ? 'none' : '#eee';
				echo "<tr style='background-color: $bgcolor'><th scope='row'>$category->cat_ID</th><td>$pad $category->cat_name</td>
				<td>$category->category_description</td>
				<td>$count</td>
				<td><a href='categories.php?action=edit&amp;cat_ID=$category->cat_ID' class='edit'>" . _LANG_C_NAME_EDIT . "</a></td><td><a href='categories.php?action=Delete&amp;cat_ID=$category->cat_ID' onclick=\"return confirm('".  sprintf("You are about to delete the category \'%s\'.  All of its posts will go to the default category.\\n  \'OK\' to delete, \'Cancel\' to stop.", addslashes($category->cat_name)) . "')\" class='delete'>" . _LANG_C_NAME_DELETE . "</a></td>
				</tr>";
				cat_rows($category->cat_ID, $level + 1);
			}
		}
	} else {
		return false;
	}
}
function wp_dropdown_cats($currentcat, $currentparent = 0, $parent = 0, $level = 0, $categories = 0) {
	global $wpdb, $wp_id, $bgcolor;
	if (!$categories) {
		$categories = $wpdb->get_results("SELECT * FROM {$wpdb->categories[$wp_id]} ORDER BY cat_name");
	}
	if ($categories) {
		foreach ($categories as $category) { if ($currentcat != $category->cat_ID && $parent == $category->category_parent) {
			$count = $wpdb->get_var("SELECT COUNT(post_id) FROM {$wpdb->post2cat[$wp_id]} WHERE category_id = $category->cat_ID");
			$pad = str_repeat('&#8211; ', $level);
			echo "\n\t<option value='$category->cat_ID'";
			if ($currentparent == $category->cat_ID)
				echo " selected='selected'";
			echo ">$pad$category->cat_name</option>";
			wp_dropdown_cats($currentcat, $currentparent, $category->cat_ID, $level + 1, $categories);
		} }
	} else {
		return false;
	}
}



?>
