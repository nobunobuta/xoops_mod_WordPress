<?php
// Functions to be called in install and upgrade scripts

function upgrade_all() {
	upgrade_103();
}

// General
function maybe_create_table($table_name, $create_ddl) {
    global $wpdb;
    foreach ($wpdb->get_col("SHOW TABLES",0) as $table ) {
        if ($table == $table_name) {
            return true;
        }
    }
    //didn't find it try to create it.
    $q = $wpdb->query($create_ddl);
    // we cannot directly tell that whether this succeeded!
    foreach ($wpdb->get_col("SHOW TABLES",0) as $table ) {
        if ($table == $table_name) {
            return true;
        }
    }
    return false;
}

function drop_index($table, $index) {
	global $wpdb;
	$wpdb->hide_errors();
	$wpdb->query("ALTER TABLE `$table` DROP INDEX `$index`");
	// Now we need to take out all the extra ones we may have created
	for ($i = 0; $i < 25; $i++) {
		$wpdb->query("ALTER TABLE `$table` DROP INDEX `{$index}_$i`");
	}
	$wpdb->show_errors();
	return true;
}

function add_clean_index($table, $index) {
	global $wpdb;
	drop_index($table, $index);
	$wpdb->query("ALTER TABLE `$table` ADD INDEX ( `$index` )");
	return true;
}

/**
 ** maybe_add_column()
 ** Add column to db table if it doesn't exist.
 ** Returns:  true if already exists or on successful completion
 **           false on error
 */
function maybe_add_column($table_name, $column_name, $create_ddl) {
    global $wpdb, $debug;
    foreach ($wpdb->get_col("DESC $table_name", 0) as $column ) {
        if ($debug) echo("checking $column == $column_name<br />");
        if ($column == $column_name) {
            return true;
        }
    }
    //didn't find it try to create it.
    $q = $wpdb->query($create_ddl);
    // we cannot directly tell that whether this succeeded!
    foreach ($wpdb->get_col("DESC $table_name", 0) as $column ) {
        if ($column == $column_name) {
            return true;
        }
    }
    return false;
}

function upgrade_103() {
  global $wpdb, $tableusers, $tablecomments, $tableposts, $tableoptiongroups, $tableoptiongroup_options, $tableoptions, $tablepostmeta;

	$query = "INSERT INTO $tableoptiongroups (group_id,  group_name, group_desc) VALUES (1, 'Other Options', '_LANG_INST_BASE_HELP1')"; $q = $wpdb->query($query);
	$query = "INSERT INTO $tableoptiongroups (group_id,  group_name, group_desc) VALUES (2, 'General blog settings', '_LANG_INST_BASE_HELP2')"; $q = $wpdb->query($query);
	$query = "INSERT INTO $tableoptiongroups (group_id,  group_name, group_desc) VALUES (3, 'RSS/RDF Feeds, Track/Ping-backs', '_LANG_INST_BASE_HELP3')"; $q = $wpdb->query($query);
	$query = "INSERT INTO $tableoptiongroups (group_id,  group_name, group_desc) VALUES (6, 'Base settings', '_LANG_INST_BASE_HELP6')"; $q = $wpdb->query($query);
	$query = "INSERT INTO $tableoptiongroups (group_id,  group_name, group_desc) VALUES (7, 'Default post options', '_LANG_INST_BASE_HELP7')"; $q = $wpdb->query($query);

}

?>