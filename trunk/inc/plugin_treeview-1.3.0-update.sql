ALTER TABLE `glpi_plugin_treeview_display` RENAME `glpi_plugin_treeview_displayprefs`;
ALTER TABLE `glpi_plugin_treeview_preference` RENAME `glpi_plugin_treeview_preferences`;

ALTER TABLE `glpi_plugin_treeview_displayprefs` CHANGE `ID` `id` int(11) NOT NULL auto_increment;
ALTER TABLE `glpi_plugin_treeview_displayprefs` CHANGE `target` `target` varchar(255) collate utf8_unicode_ci default NULL;
ALTER TABLE `glpi_plugin_treeview_displayprefs` CHANGE `folderLinks` `folderLinks` tinyint(1) NOT NULL default '0';
ALTER TABLE `glpi_plugin_treeview_displayprefs` CHANGE `useSelection` `useSelection` tinyint(1) NOT NULL default '0';
ALTER TABLE `glpi_plugin_treeview_displayprefs` CHANGE `useLines` `useLines` tinyint(1) NOT NULL default '0';
ALTER TABLE `glpi_plugin_treeview_displayprefs` CHANGE `useIcons` `useIcons` tinyint(1) NOT NULL default '0';
ALTER TABLE `glpi_plugin_treeview_displayprefs` CHANGE `closeSameLevel` `closeSameLevel` tinyint(1) NOT NULL default '0';
ALTER TABLE `glpi_plugin_treeview_displayprefs` CHANGE `itemName` `itemName` int(11) NOT NULL default '0';
ALTER TABLE `glpi_plugin_treeview_displayprefs` CHANGE `locationName` `locationName` int(11) NOT NULL default '0';

ALTER TABLE `glpi_plugin_treeview_profiles` CHANGE `ID` `id` int(11) NOT NULL auto_increment;
ALTER TABLE `glpi_plugin_treeview_profiles` CHANGE `name` `name` varchar(255) collate utf8_unicode_ci default NULL;
ALTER TABLE `glpi_plugin_treeview_profiles` CHANGE `treeview` `treeview` char(1) collate utf8_unicode_ci default NULL;

ALTER TABLE `glpi_plugin_treeview_preferences` CHANGE `ID` `id` int(11) NOT NULL auto_increment;
ALTER TABLE `glpi_plugin_treeview_preferences` CHANGE `user_id` `users_id` int(11) NOT NULL default '0' COMMENT 'RELATION to glpi_users (id)';
ALTER TABLE `glpi_plugin_treeview_preferences` CHANGE `show` `show_on_load` int(11) NOT NULL default '0';