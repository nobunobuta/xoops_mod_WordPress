#
# Table Structure `wp6_categories`
#

CREATE TABLE wp6_categories (
  `cat_ID` int(4) NOT NULL auto_increment,
  `cat_name` varchar(55) NOT NULL default '',
  `category_nicename` varchar(200) NOT NULL default '',
  `category_description` text NOT NULL,
  `category_parent` int(4) NOT NULL default '0',
  PRIMARY KEY  (`cat_ID`),
  UNIQUE KEY `cat_name` (`cat_name`),
  KEY `category_nicename` (`category_nicename`)
) ;

#
# Table Dump data `wp6_categories`
#

INSERT INTO wp6_categories (`cat_ID`, `cat_name`, `category_nicename`, `category_description`, `category_parent`) VALUES (1, 'General', 'general', '', 0);

# --------------------------------------------------------

#
# Table Structure wp6_comments
#

CREATE TABLE wp6_comments (
  `comment_ID` int(11) unsigned NOT NULL auto_increment,
  `comment_post_ID` int(11) NOT NULL default '0',
  `comment_author` tinytext NOT NULL,
  `comment_author_email` varchar(100) NOT NULL default '',
  `comment_author_url` varchar(100) NOT NULL default '',
  `comment_author_IP` varchar(100) NOT NULL default '',
  `comment_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `comment_content` text NOT NULL,
  `comment_karma` int(11) NOT NULL default '0',
  `comment_approved` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`comment_ID`),
  KEY `comment_approved` (`comment_approved`),
  KEY `comment_post_ID` (`comment_post_ID`)
);

# --------------------------------------------------------

#
# Table Structure `wp6_linkcategories`
#

CREATE TABLE wp6_linkcategories (
  `cat_id` int(11) NOT NULL auto_increment,
  `cat_name` tinytext NOT NULL,
  `auto_toggle` enum('Y','N') NOT NULL default 'N',
  `show_images` enum('Y','N') NOT NULL default 'Y',
  `show_description` enum('Y','N') NOT NULL default 'N',
  `show_rating` enum('Y','N') NOT NULL default 'Y',
  `show_updated` enum('Y','N') NOT NULL default 'Y',
  `sort_order` varchar(64) NOT NULL default 'name',
  `sort_desc` enum('Y','N') NOT NULL default 'N',
  `text_before_link` varchar(128) NOT NULL default '<li>',
  `text_after_link` varchar(128) NOT NULL default '<br />',
  `text_after_all` varchar(128) NOT NULL default '</li>',
  `list_limit` int(11) NOT NULL default '-1',
  PRIMARY KEY  (`cat_id`)
);

#
# Table Dump data `wp6_linkcategories`
#

INSERT INTO wp6_linkcategories (`cat_id`, `cat_name`, `auto_toggle`, `show_images`, `show_description`, `show_rating`, `show_updated`, `sort_order`, `sort_desc`, `text_before_link`, `text_after_link`, `text_after_all`, `list_limit`) VALUES (1, 'Links', 'N', 'Y', 'Y', 'Y', 'Y', 'name', 'N', '<li>', '<br />', '</li>', -1);

# --------------------------------------------------------

#
# Table Structure wp6_links
#

CREATE TABLE wp6_links (
  `link_id` int(11) NOT NULL auto_increment,
  `link_url` varchar(255) NOT NULL default '',
  `link_name` varchar(255) NOT NULL default '',
  `link_image` varchar(255) NOT NULL default '',
  `link_target` varchar(25) NOT NULL default '',
  `link_category` int(11) NOT NULL default '0',
  `link_description` varchar(255) NOT NULL default '',
  `link_visible` enum('Y','N') NOT NULL default 'Y',
  `link_owner` int(11) NOT NULL default '1',
  `link_rating` int(11) NOT NULL default '0',
  `link_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `link_rel` varchar(255) NOT NULL default '',
  `link_notes` mediumtext NOT NULL,
  `link_rss` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`link_id`),
  KEY `link_category` (`link_category`),
  KEY `link_visible` (`link_visible`)
);

#
# Table Dump data wp6_links
#

INSERT INTO wp6_links (`link_id`, `link_url`, `link_name`, `link_image`, `link_target`, `link_category`, `link_description`, `link_visible`, `link_owner`, `link_rating`, `link_updated`, `link_rel`, `link_notes`, `link_rss`) VALUES (1, 'http://cafelog.net/', 'Cafelog.NET', '', '', 1, '', 'Y', 1, 0, '0000-00-00 00:00:00', '', '', '');
INSERT INTO wp6_links (`link_id`, `link_url`, `link_name`, `link_image`, `link_target`, `link_category`, `link_description`, `link_visible`, `link_owner`, `link_rating`, `link_updated`, `link_rel`, `link_notes`, `link_rss`) VALUES (2, 'http://detlog.org/', 'detlog.org', '', '', 1, '', 'Y', 1, 0, '0000-00-00 00:00:00', '', '', '');
INSERT INTO wp6_links (`link_id`, `link_url`, `link_name`, `link_image`, `link_target`, `link_category`, `link_description`, `link_visible`, `link_owner`, `link_rating`, `link_updated`, `link_rel`, `link_notes`, `link_rss`) VALUES (3, 'http://plasticdreams.org/', 'plasticdreams', '', '', 1, '', 'Y', 1, 0, '0000-00-00 00:00:00', '', '', '');
INSERT INTO wp6_links (`link_id`, `link_url`, `link_name`, `link_image`, `link_target`, `link_category`, `link_description`, `link_visible`, `link_owner`, `link_rating`, `link_updated`, `link_rel`, `link_notes`, `link_rss`) VALUES (4, 'http://tekapo.com/st/', 'Standing Tall', '', '', 1, '', 'Y', 1, 0, '2004-04-17 21:45:07', '', '', '');
INSERT INTO wp6_links (`link_id`, `link_url`, `link_name`, `link_image`, `link_target`, `link_category`, `link_description`, `link_visible`, `link_owner`, `link_rating`, `link_updated`, `link_rel`, `link_notes`, `link_rss`) VALUES (5, 'http://tkzy.net/', 'tkzy.net', '', '', 1, '', 'Y', 1, 0, '0000-00-00 00:00:00', '', '', '');

# --------------------------------------------------------

#
# Table Structure wp6_optiongroup_options
#

CREATE TABLE wp6_optiongroup_options (
  `group_id` int(11) NOT NULL default '0',
  `option_id` int(11) NOT NULL default '0',
  `seq` int(11) NOT NULL default '0',
  PRIMARY KEY  (`group_id`,`option_id`)
);

#
# Table Dump data wp6_optiongroup_options
#

INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (1, 48, 1);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (1, 49, 2);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (1, 50, 3);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (1, 51, 4);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (1, 52, 5);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (1, 53, 6);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (2, 9, 1);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (2, 11, 3);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (2, 12, 4);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (2, 13, 5);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (2, 14, 6);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (2, 15, 7);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (2, 16, 8);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (2, 17, 9);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (2, 18, 10);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (2, 19, 11);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (2, 20, 12);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (3, 21, 1);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (3, 22, 2);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (3, 23, 3);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (3, 24, 4);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (3, 25, 5);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (3, 26, 6);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (3, 27, 7);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (3, 28, 8);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (3, 29, 9);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (3, 30, 10);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (4, 31, 1);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (4, 32, 2);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (4, 33, 3);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (4, 34, 4);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (4, 35, 5);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (4, 36, 6);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (4, 37, 7);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (5, 38, 1);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (5, 39, 2);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (5, 40, 3);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (5, 41, 4);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (5, 42, 5);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (5, 43, 6);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (5, 44, 7);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (5, 45, 8);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (5, 46, 9);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (5, 47, 10);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (6, 1, 1);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (6, 2, 2);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (6, 3, 3);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (6, 4, 4);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (6, 7, 6);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (6, 8, 7);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (6, 54, 8);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (7, 55, 1);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (7, 56, 2);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (7, 57, 3);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (7, 58, 4);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (7, 59, 5);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (7, 83, 5);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (8, 60, 1);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (8, 61, 2);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (8, 62, 3);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (8, 63, 4);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (8, 64, 5);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (8, 65, 6);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (8, 66, 7);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (8, 67, 8);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (8, 68, 9);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (8, 69, 10);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (8, 70, 11);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (8, 71, 12);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (8, 72, 13);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (8, 73, 14);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (8, 74, 15);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (8, 75, 16);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (8, 76, 17);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (8, 77, 18);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (8, 78, 19);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (8, 79, 20);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (8, 80, 21);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (8, 81, 22);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (8, 82, 23);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (9, 84, 1);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (9, 85, 1);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (9, 86, 1);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (9, 87, 1);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (2, 88, 13);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (2, 89, 14);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (2, 91, 5);
INSERT INTO wp6_optiongroup_options (`group_id`, `option_id`, `seq`) VALUES (2, 92, 5);

# --------------------------------------------------------

#
# Table Structure wp6_optiongroups
#

CREATE TABLE wp6_optiongroups (
  `group_id` int(11) NOT NULL auto_increment,
  `group_name` varchar(64) NOT NULL default '',
  `group_desc` varchar(255) default NULL,
  `group_longdesc` tinytext,
  PRIMARY KEY  (`group_id`)
);

#
# Table Dump data wp6_optiongroups
#

INSERT INTO wp6_optiongroups (`group_id`, `group_name`, `group_desc`, `group_longdesc`) VALUES (1, 'Other Options', '_LANG_INST_BASE_HELP1', NULL);
INSERT INTO wp6_optiongroups (`group_id`, `group_name`, `group_desc`, `group_longdesc`) VALUES (2, 'General blog settings', '_LANG_INST_BASE_HELP2', NULL);
INSERT INTO wp6_optiongroups (`group_id`, `group_name`, `group_desc`, `group_longdesc`) VALUES (3, 'RSS/RDF Feeds, Track/Ping-backs', '_LANG_INST_BASE_HELP3', NULL);
INSERT INTO wp6_optiongroups (`group_id`, `group_name`, `group_desc`, `group_longdesc`) VALUES (4, 'File uploads', '_LANG_INST_BASE_HELP4', NULL);
INSERT INTO wp6_optiongroups (`group_id`, `group_name`, `group_desc`, `group_longdesc`) VALUES (5, 'Blog-by-Email settings', '_LANG_INST_BASE_HELP5', NULL);
INSERT INTO wp6_optiongroups (`group_id`, `group_name`, `group_desc`, `group_longdesc`) VALUES (6, 'Base settings', '_LANG_INST_BASE_HELP6', NULL);
INSERT INTO wp6_optiongroups (`group_id`, `group_name`, `group_desc`, `group_longdesc`) VALUES (7, 'Default post options', '_LANG_INST_BASE_HELP7', NULL);
INSERT INTO wp6_optiongroups (`group_id`, `group_name`, `group_desc`, `group_longdesc`) VALUES (8, 'Link Manager Settings', '_LANG_INST_BASE_HELP8', NULL);
INSERT INTO wp6_optiongroups (`group_id`, `group_name`, `group_desc`, `group_longdesc`) VALUES (9, 'Geo Options', '_LANG_INST_BASE_HELP9', NULL);

# --------------------------------------------------------

#
# Table Structure wp6_options
#

CREATE TABLE wp6_options (
  `option_id` int(11) NOT NULL auto_increment,
  `blog_id` int(11) NOT NULL default '0',
  `option_name` varchar(64) NOT NULL default '',
  `option_can_override` enum('Y','N') NOT NULL default 'Y',
  `option_type` int(11) NOT NULL default '1',
  `option_value` varchar(255) NOT NULL default '',
  `option_width` int(11) NOT NULL default '20',
  `option_height` int(11) NOT NULL default '8',
  `option_description` tinytext NOT NULL,
  `option_admin_level` int(11) NOT NULL default '1',
  PRIMARY KEY  (`option_id`,`blog_id`,`option_name`)
);

#
# Table Dump data wp6_options
#

INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (1, 0, 'siteurl', 'Y', 3, 'http://example.com', 30, 8, '_LANG_INST_BASE_VALUE1', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (2, 0, 'blogfilename', 'Y', 3, 'index.php', 20, 8, '_LANG_INST_BASE_VALUE2', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (3, 0, 'blogname', 'Y', 3, 'my weblog', 20, 8, '_LANG_INST_BASE_VALUE3', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (4, 0, 'blogdescription', 'Y', 3, 'babblings!', 40, 8, '_LANG_INST_BASE_VALUE4', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (7, 0, 'new_users_can_blog', 'Y', 2, '0', 20, 8, '_LANG_INST_BASE_VALUE7', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (8, 0, 'users_can_register', 'Y', 2, '1', 20, 8, '_LANG_INST_BASE_VALUE8', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (54, 0, 'admin_email', 'Y', 3, 'you@example.com', 20, 8, '_LANG_INST_BASE_VALUE54', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (9, 0, 'start_of_week', 'Y', 5, '1', 20, 8, '_LANG_INST_BASE_VALUE9', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (11, 0, 'use_bbcode', 'Y', 2, '0', 20, 8, '_LANG_INST_BASE_VALUE11', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (12, 0, 'use_gmcode', 'Y', 2, '0', 20, 8, '_LANG_INST_BASE_VALUE12', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (13, 0, 'use_quicktags', 'Y', 2, '1', 20, 8, '_LANG_INST_BASE_VALUE13', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (14, 0, 'use_htmltrans', 'Y', 2, '0', 20, 8, '_LANG_INST_BASE_VALUE14', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (15, 0, 'use_balanceTags', 'Y', 2, '1', 20, 8, '_LANG_INST_BASE_VALUE15', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (16, 0, 'use_smilies', 'Y', 2, '1', 20, 8, '_LANG_INST_BASE_VALUE16', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (17, 0, 'smilies_directory', 'Y', 3, 'http://example.com/wp-images/smilies', 40, 8, '_LANG_INST_BASE_VALUE17', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (18, 0, 'require_name_email', 'Y', 2, '0', 20, 8, '_LANG_INST_BASE_VALUE18', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (20, 0, 'comments_notify', 'Y', 2, '1', 20, 8, '_LANG_INST_BASE_VALUE20', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (21, 0, 'posts_per_rss', 'Y', 1, '10', 20, 8, '_LANG_INST_BASE_VALUE21', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (22, 0, 'rss_language', 'Y', 3, 'ja', 20, 8, '_LANG_INST_BASE_VALUE22', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (23, 0, 'rss_encoded_html', 'Y', 2, '0', 20, 8, '_LANG_INST_BASE_VALUE23', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (24, 0, 'rss_excerpt_length', 'Y', 1, '50', 20, 8, '_LANG_INST_BASE_VALUE24', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (25, 0, 'rss_use_excerpt', 'Y', 2, '1', 20, 8, '_LANG_INST_BASE_VALUE25', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (26, 0, 'use_weblogsping', 'Y', 2, '0', 20, 8, '_LANG_INST_BASE_VALUE26', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (27, 0, 'use_blodotgsping', 'Y', 2, '0', 20, 8, '_LANG_INST_BASE_VALUE27', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (28, 0, 'blodotgsping_url', 'Y', 3, 'http://www.kowa.org/modules/wp', 30, 8, '_LANG_INST_BASE_VALUE28', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (29, 0, 'use_trackback', 'Y', 2, '1', 20, 8, '_LANG_INST_BASE_VALUE29', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (30, 0, 'use_pingback', 'Y', 2, '1', 20, 8, '_LANG_INST_BASE_VALUE30', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (31, 0, 'use_fileupload', 'Y', 2, '0', 20, 8, '_LANG_INST_BASE_VALUE31', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (32, 0, 'fileupload_realpath', 'Y', 3, '/home/your/site/wordpress/images', 40, 8, '_LANG_INST_BASE_VALUE32', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (33, 0, 'fileupload_url', 'Y', 3, 'http://example.com/images', 40, 8, '_LANG_INST_BASE_VALUE33', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (34, 0, 'fileupload_allowedtypes', 'Y', 3, 'jpg gif png', 20, 8, '_LANG_INST_BASE_VALUE34', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (35, 0, 'fileupload_maxk', 'Y', 1, '300', 20, 8, '_LANG_INST_BASE_VALUE35', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (36, 0, 'fileupload_minlevel', 'Y', 1, '1', 20, 8, '_LANG_INST_BASE_VALUE36', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (37, 0, 'fileupload_allowedusers', 'Y', 3, '', 30, 8, '_LANG_INST_BASE_VALUE37', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (38, 0, 'mailserver_url', 'Y', 3, 'mail.example.com', 20, 8, '_LANG_INST_BASE_VALUE38', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (39, 0, 'mailserver_login', 'Y', 3, 'login@example.com', 20, 8, '_LANG_INST_BASE_VALUE39', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (40, 0, 'mailserver_pass', 'Y', 3, 'password', 20, 8, '_LANG_INST_BASE_VALUE40', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (41, 0, 'mailserver_port', 'Y', 1, '110', 20, 8, '_LANG_INST_BASE_VALUE41', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (42, 0, 'default_category', 'Y', 1, '1', 20, 8, '_LANG_INST_BASE_VALUE42', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (43, 0, 'subjectprefix', 'Y', 3, 'blog:', 20, 8, '_LANG_INST_BASE_VALUE43', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (44, 0, 'bodyterminator', 'Y', 3, '___', 20, 8, '_LANG_INST_BASE_VALUE44', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (45, 0, 'emailtestonly', 'Y', 2, '0', 20, 8, '_LANG_INST_BASE_VALUE45', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (46, 0, 'use_phoneemail', 'Y', 2, '0', 20, 8, '_LANG_INST_BASE_VALUE46', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (47, 0, 'phoneemail_separator', 'Y', 3, ':::', 20, 8, '_LANG_INST_BASE_VALUE47', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (48, 0, 'posts_per_page', 'Y', 1, '20', 20, 8, '_LANG_INST_BASE_VALUE48', 4);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (49, 0, 'what_to_show', 'Y', 5, 'posts', 20, 8, '_LANG_INST_BASE_VALUE49', 4);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (50, 0, 'archive_mode', 'Y', 5, 'monthly', 20, 8, '_LANG_INST_BASE_VALUE50', 4);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (51, 0, 'time_difference', 'Y', 6, '0', 20, 8, '_LANG_INST_BASE_VALUE51', 4);
##INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (52, 0, 'date_format', 'Y', 3, 'Y年n月j日(l)', 20, 8, '_LANG_INST_BASE_VALUE52', 4);
##INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (53, 0, 'time_format', 'Y', 3, 'H時i分s秒', 20, 8, '_LANG_INST_BASE_VALUE53', 4);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (55, 0, 'default_post_status', 'Y', 5, 'publish', 20, 8, '_LANG_INST_BASE_VALUE55', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (56, 0, 'default_comment_status', 'Y', 5, 'open', 20, 8, '_LANG_INST_BASE_VALUE56', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (57, 0, 'default_ping_status', 'Y', 5, 'open', 20, 8, '_LANG_INST_BASE_VALUE57', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (58, 0, 'default_pingback_flag', 'Y', 5, '1', 20, 8, '_LANG_INST_BASE_VALUE58', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (59, 0, 'default_post_category', 'Y', 7, '1', 20, 8, '_LANG_INST_BASE_VALUE59', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (83, 0, 'default_post_edit_rows', 'Y', 1, '20', 5, 8, '_LANG_INST_BASE_VALUE83', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (60, 0, 'links_minadminlevel', 'Y', 1, '5', 10, 8, '_LANG_INST_BASE_VALUE60', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (61, 0, 'links_use_adminlevels', 'Y', 2, '1', 20, 8, '_LANG_INST_BASE_VALUE61', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (62, 0, 'links_rating_type', 'Y', 5, 'image', 10, 8, '_LANG_INST_BASE_VALUE62', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (63, 0, 'links_rating_char', 'Y', 3, '*', 5, 8, '_LANG_INST_BASE_VALUE63', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (64, 0, 'links_rating_ignore_zero', 'Y', 2, '1', 20, 8, '_LANG_INST_BASE_VALUE64', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (65, 0, 'links_rating_single_image', 'Y', 2, '1', 20, 8, '_LANG_INST_BASE_VALUE65', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (66, 0, 'links_rating_image0', 'Y', 3, 'wp-images/links/tick.png', 40, 8, '_LANG_INST_BASE_VALUE66', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (67, 0, 'links_rating_image1', 'Y', 3, 'wp-images/links/rating-1.gif', 40, 8, '_LANG_INST_BASE_VALUE67', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (68, 0, 'links_rating_image2', 'Y', 3, 'wp-images/links/rating-2.gif', 40, 8, '_LANG_INST_BASE_VALUE68', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (69, 0, 'links_rating_image3', 'Y', 3, 'wp-images/links/rating-3.gif', 40, 8, '_LANG_INST_BASE_VALUE69', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (70, 0, 'links_rating_image4', 'Y', 3, 'wp-images/links/rating-4.gif', 40, 8, '_LANG_INST_BASE_VALUE70', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (71, 0, 'links_rating_image5', 'Y', 3, 'wp-images/links/rating-5.gif', 40, 8, '_LANG_INST_BASE_VALUE71', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (72, 0, 'links_rating_image6', 'Y', 3, 'wp-images/links/rating-6.gif', 40, 8, '_LANG_INST_BASE_VALUE72', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (73, 0, 'links_rating_image7', 'Y', 3, 'wp-images/links/rating-7.gif', 40, 8, '_LANG_INST_BASE_VALUE73', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (74, 0, 'links_rating_image8', 'Y', 3, 'wp-images/links/rating-8.gif', 40, 8, '_LANG_INST_BASE_VALUE74', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (75, 0, 'links_rating_image9', 'Y', 3, 'wp-images/links/rating-9.gif', 40, 8, '_LANG_INST_BASE_VALUE75', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (76, 0, 'weblogs_cache_file', 'Y', 3, 'weblogs.com.changes.cache', 40, 8, '_LANG_INST_BASE_VALUE76', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (77, 0, 'weblogs_xml_url', 'Y', 3, 'http://www.weblogs.com/changes.xml', 40, 8, '_LANG_INST_BASE_VALUE77', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (78, 0, 'weblogs_cacheminutes', 'Y', 1, '60', 10, 8, '_LANG_INST_BASE_VALUE78', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (79, 0, 'links_updated_date_format', 'Y', 3, 'd/m/Y h:i', 25, 8, '_LANG_INST_BASE_VALUE79', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (80, 0, 'links_recently_updated_prepend', 'Y', 3, '&gt;&gt;', 10, 8, '_LANG_INST_BASE_VALUE80', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (81, 0, 'links_recently_updated_append', 'Y', 3, '&lt;&lt;', 20, 8, '_LANG_INST_BASE_VALUE81', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (82, 0, 'links_recently_updated_time', 'Y', 1, '120', 20, 8, '_LANG_INST_BASE_VALUE82', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (84, 0, 'use_geo_positions', 'Y', 2, '0', 20, 8, '_LANG_INST_BASE_VALUE84', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (85, 0, 'use_default_geourl', 'Y', 2, '1', 20, 8, '_LANG_INST_BASE_VALUE85', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (86, 0, 'default_geourl_lat', 'Y', 8, '0', 20, 8, '_LANG_INST_BASE_VALUE86', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (87, 0, 'default_geourl_lon', 'Y', 8, '0', 20, 8, '_LANG_INST_BASE_VALUE87', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (88, 0, 'comment_moderation', 'Y', 5, 'none', 20, 8, '_LANG_INST_BASE_VALUE88', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (89, 0, 'moderation_notify', 'Y', 2, '1', 20, 8, '_LANG_INST_BASE_VALUE89', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (90, 0, 'permalink_structure', 'Y', 3, '', 20, 8, '_LANG_INST_BASE_VALUE90', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (91, 0, 'gzipcompression', 'Y', 2, '0', 20, 8, '_LANG_INST_BASE_VALUE91', 8);
INSERT INTO wp6_options (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (92, 0, 'hack_file', 'Y', 2, '0', 20, 8, '_LANG_INST_BASE_VALUE92', 8);

# --------------------------------------------------------

#
# Table Structure wp6_optiontypes
#

CREATE TABLE wp6_optiontypes (
  `optiontype_id` int(11) NOT NULL auto_increment,
  `optiontype_name` varchar(64) NOT NULL default '',
  PRIMARY KEY  (`optiontype_id`)
);

#
# Table Dump data wp6_optiontypes
#

INSERT INTO wp6_optiontypes (`optiontype_id`, `optiontype_name`) VALUES (1, 'integer');
INSERT INTO wp6_optiontypes (`optiontype_id`, `optiontype_name`) VALUES (2, 'boolean');
INSERT INTO wp6_optiontypes (`optiontype_id`, `optiontype_name`) VALUES (3, 'string');
INSERT INTO wp6_optiontypes (`optiontype_id`, `optiontype_name`) VALUES (4, 'date');
INSERT INTO wp6_optiontypes (`optiontype_id`, `optiontype_name`) VALUES (5, 'select');
INSERT INTO wp6_optiontypes (`optiontype_id`, `optiontype_name`) VALUES (6, 'range');
INSERT INTO wp6_optiontypes (`optiontype_id`, `optiontype_name`) VALUES (7, 'sqlselect');
INSERT INTO wp6_optiontypes (`optiontype_id`, `optiontype_name`) VALUES (8, 'float');

# --------------------------------------------------------

#
# Table Structure wp6_optionvalues
#

CREATE TABLE wp6_optionvalues (
  `option_id` int(11) NOT NULL default '0',
  `optionvalue` tinytext,
  `optionvalue_desc` varchar(255) default NULL,
  `optionvalue_max` int(11) default NULL,
  `optionvalue_min` int(11) default NULL,
  `optionvalue_seq` int(11) default NULL,
  UNIQUE KEY `option_id` (`option_id`,`optionvalue`(255)),
  KEY `option_id_2` (`option_id`,`optionvalue_seq`)
);

#
# Table Dump data wp6_optionvalues
#

INSERT INTO wp6_optionvalues (`option_id`, `optionvalue`, `optionvalue_desc`, `optionvalue_max`, `optionvalue_min`, `optionvalue_seq`) VALUES (49, 'days', 'days', NULL, NULL, 1);
INSERT INTO wp6_optionvalues (`option_id`, `optionvalue`, `optionvalue_desc`, `optionvalue_max`, `optionvalue_min`, `optionvalue_seq`) VALUES (49, 'posts', 'posts', NULL, NULL, 2);
INSERT INTO wp6_optionvalues (`option_id`, `optionvalue`, `optionvalue_desc`, `optionvalue_max`, `optionvalue_min`, `optionvalue_seq`) VALUES (49, 'paged', 'posts paged', NULL, NULL, 3);
INSERT INTO wp6_optionvalues (`option_id`, `optionvalue`, `optionvalue_desc`, `optionvalue_max`, `optionvalue_min`, `optionvalue_seq`) VALUES (50, 'daily', 'daily', NULL, NULL, 1);
INSERT INTO wp6_optionvalues (`option_id`, `optionvalue`, `optionvalue_desc`, `optionvalue_max`, `optionvalue_min`, `optionvalue_seq`) VALUES (50, 'weekly', 'weekly', NULL, NULL, 2);
INSERT INTO wp6_optionvalues (`option_id`, `optionvalue`, `optionvalue_desc`, `optionvalue_max`, `optionvalue_min`, `optionvalue_seq`) VALUES (50, 'monthly', 'monthly', NULL, NULL, 3);
INSERT INTO wp6_optionvalues (`option_id`, `optionvalue`, `optionvalue_desc`, `optionvalue_max`, `optionvalue_min`, `optionvalue_seq`) VALUES (50, 'postbypost', 'post by post', NULL, NULL, 4);
INSERT INTO wp6_optionvalues (`option_id`, `optionvalue`, `optionvalue_desc`, `optionvalue_max`, `optionvalue_min`, `optionvalue_seq`) VALUES (51, 'hours', 'hours', 23, -23, NULL);
INSERT INTO wp6_optionvalues (`option_id`, `optionvalue`, `optionvalue_desc`, `optionvalue_max`, `optionvalue_min`, `optionvalue_seq`) VALUES (9, '0', 'Sunday', NULL, NULL, 1);
INSERT INTO wp6_optionvalues (`option_id`, `optionvalue`, `optionvalue_desc`, `optionvalue_max`, `optionvalue_min`, `optionvalue_seq`) VALUES (9, '1', 'Monday', NULL, NULL, 2);
INSERT INTO wp6_optionvalues (`option_id`, `optionvalue`, `optionvalue_desc`, `optionvalue_max`, `optionvalue_min`, `optionvalue_seq`) VALUES (9, '6', 'Saturday', NULL, NULL, 3);
INSERT INTO wp6_optionvalues (`option_id`, `optionvalue`, `optionvalue_desc`, `optionvalue_max`, `optionvalue_min`, `optionvalue_seq`) VALUES (55, 'publish', 'Publish', NULL, NULL, 1);
INSERT INTO wp6_optionvalues (`option_id`, `optionvalue`, `optionvalue_desc`, `optionvalue_max`, `optionvalue_min`, `optionvalue_seq`) VALUES (55, 'draft', 'Draft', NULL, NULL, 2);
INSERT INTO wp6_optionvalues (`option_id`, `optionvalue`, `optionvalue_desc`, `optionvalue_max`, `optionvalue_min`, `optionvalue_seq`) VALUES (55, 'private', 'Private', NULL, NULL, 3);
INSERT INTO wp6_optionvalues (`option_id`, `optionvalue`, `optionvalue_desc`, `optionvalue_max`, `optionvalue_min`, `optionvalue_seq`) VALUES (56, 'open', 'Open', NULL, NULL, 1);
INSERT INTO wp6_optionvalues (`option_id`, `optionvalue`, `optionvalue_desc`, `optionvalue_max`, `optionvalue_min`, `optionvalue_seq`) VALUES (56, 'closed', 'Closed', NULL, NULL, 2);
INSERT INTO wp6_optionvalues (`option_id`, `optionvalue`, `optionvalue_desc`, `optionvalue_max`, `optionvalue_min`, `optionvalue_seq`) VALUES (57, 'open', 'Open', NULL, NULL, 1);
INSERT INTO wp6_optionvalues (`option_id`, `optionvalue`, `optionvalue_desc`, `optionvalue_max`, `optionvalue_min`, `optionvalue_seq`) VALUES (57, 'closed', 'Closed', NULL, NULL, 2);
INSERT INTO wp6_optionvalues (`option_id`, `optionvalue`, `optionvalue_desc`, `optionvalue_max`, `optionvalue_min`, `optionvalue_seq`) VALUES (58, '1', 'Checked', NULL, NULL, 1);
INSERT INTO wp6_optionvalues (`option_id`, `optionvalue`, `optionvalue_desc`, `optionvalue_max`, `optionvalue_min`, `optionvalue_seq`) VALUES (58, '0', 'Unchecked', NULL, NULL, 2);
INSERT INTO wp6_optionvalues (`option_id`, `optionvalue`, `optionvalue_desc`, `optionvalue_max`, `optionvalue_min`, `optionvalue_seq`) VALUES (62, 'number', 'Number', NULL, NULL, 1);
INSERT INTO wp6_optionvalues (`option_id`, `optionvalue`, `optionvalue_desc`, `optionvalue_max`, `optionvalue_min`, `optionvalue_seq`) VALUES (62, 'char', 'Character', NULL, NULL, 2);
INSERT INTO wp6_optionvalues (`option_id`, `optionvalue`, `optionvalue_desc`, `optionvalue_max`, `optionvalue_min`, `optionvalue_seq`) VALUES (62, 'image', 'Image', NULL, NULL, 3);
INSERT INTO wp6_optionvalues (`option_id`, `optionvalue`, `optionvalue_desc`, `optionvalue_max`, `optionvalue_min`, `optionvalue_seq`) VALUES (88, 'none', 'None', NULL, NULL, 1);
INSERT INTO wp6_optionvalues (`option_id`, `optionvalue`, `optionvalue_desc`, `optionvalue_max`, `optionvalue_min`, `optionvalue_seq`) VALUES (88, 'manual', 'Manual', NULL, NULL, 2);

# --------------------------------------------------------

#
# Table Structure wp6_post2cat
#

CREATE TABLE wp6_post2cat (
  `rel_id` int(11) NOT NULL auto_increment,
  `post_id` int(11) NOT NULL default '0',
  `category_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`rel_id`),
  KEY `post_id` (`post_id`,`category_id`)
);

#
# Table Dump data wp6_post2cat
#

INSERT INTO wp6_post2cat (`rel_id`, `post_id`, `category_id`) VALUES (1, 1, 1);

# --------------------------------------------------------

#
# Table Structure wp6_posts
#

CREATE TABLE wp6_posts (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `post_author` int(4) NOT NULL default '0',
  `post_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `post_content` text NOT NULL,
  `post_title` text NOT NULL,
  `post_category` int(4) NOT NULL default '0',
  `post_excerpt` text NOT NULL,
  `post_lat` float default NULL,
  `post_lon` float default NULL,
  `post_status` enum('publish','draft','private') NOT NULL default 'publish',
  `comment_status` enum('open','closed') NOT NULL default 'open',
  `ping_status` enum('open','closed') NOT NULL default 'open',
  `post_password` varchar(20) NOT NULL default '',
  `post_name` varchar(200) NOT NULL default '',
  `to_ping` text NOT NULL,
  `pinged` text NOT NULL,
  `post_modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `post_content_filtered` text NOT NULL,
  PRIMARY KEY  (`ID`),
  KEY `post_name` (`post_name`),
  KEY `post_status` (`post_status`)
);


# --------------------------------------------------------

#
# Table Structure wp6_users
#

CREATE TABLE wp6_users (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `user_login` varchar(20) NOT NULL default '',
  `user_pass` varchar(20) NOT NULL default '',
  `user_firstname` varchar(50) NOT NULL default '',
  `user_lastname` varchar(50) NOT NULL default '',
  `user_nickname` varchar(50) NOT NULL default '',
  `user_icq` int(10) unsigned NOT NULL default '0',
  `user_email` varchar(100) NOT NULL default '',
  `user_url` varchar(100) NOT NULL default '',
  `user_ip` varchar(15) NOT NULL default '',
  `user_domain` varchar(200) NOT NULL default '',
  `user_browser` varchar(200) NOT NULL default '',
  `dateYMDhour` datetime NOT NULL default '0000-00-00 00:00:00',
  `user_level` int(2) unsigned NOT NULL default '0',
  `user_aim` varchar(50) NOT NULL default '',
  `user_msn` varchar(100) NOT NULL default '',
  `user_yim` varchar(50) NOT NULL default '',
  `user_idmode` varchar(20) NOT NULL default '',
  `user_description` text NOT NULL,
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `user_login` (`user_login`)
);
