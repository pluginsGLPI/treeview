DROP TABLE IF EXISTS `glpi_plugin_treeview_preference`;
CREATE TABLE `glpi_plugin_treeview_preference` (
	`id` int(11) NOT NULL auto_increment,
	`user_id` int(11) NOT NULL,
	`show` varchar(255) NOT NULL,
	PRIMARY KEY  (`id`)
) ENGINE=MyISAM;