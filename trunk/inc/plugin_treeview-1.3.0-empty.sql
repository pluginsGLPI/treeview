DROP TABLE IF EXISTS `glpi_plugin_treeview_displayprefs`;
CREATE TABLE `glpi_plugin_treeview_displayprefs` (
	`id` int(11) NOT NULL auto_increment,
	`target` VARCHAR(255) NOT NULL DEFAULT 'right',
	`folderLinks` tinyint(1) NOT NULL default '0',
	`useSelection` tinyint(1) NOT NULL default '0',
	`useLines` tinyint(1) NOT NULL default '0',
	`useIcons` tinyint(1) NOT NULL default '0',
	`closeSameLevel` tinyint(1) NOT NULL default '0',
	`itemName` int(11) NOT NULL default '0',
	`locationName`  int(11) NOT NULL default '0',
	PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `glpi_plugin_treeview_displayprefs` ( `id`, `target`, `folderLinks`, `useSelection`, `useLines`, `useIcons`,  `closeSameLevel`, `itemName`, `locationName`) VALUES ('1','right','1','1','1','1','0', '3', '2');

DROP TABLE IF EXISTS `glpi_plugin_treeview_profiles`;
CREATE TABLE `glpi_plugin_treeview_profiles` (
	`id` int(11) NOT NULL auto_increment,
	`name` varchar(255) collate utf8_unicode_ci default NULL,
	`treeview` char(1) collate utf8_unicode_ci default NULL,
	PRIMARY KEY  (`id`),
	KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `glpi_plugin_treeview_preferences`;
CREATE TABLE `glpi_plugin_treeview_preferences` (
	`id` int(11) NOT NULL auto_increment,
	`users_id` int(11) NOT NULL default '0' COMMENT 'RELATION to glpi_users (id)',
	`show_on_load` int(11) NOT NULL default '0',
	PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;