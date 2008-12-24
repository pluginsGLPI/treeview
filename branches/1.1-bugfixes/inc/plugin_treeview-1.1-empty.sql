DROP TABLE IF EXISTS `glpi_plugin_treeview_display`;
CREATE TABLE `glpi_plugin_treeview_display` (
	`ID` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`target` VARCHAR(255) NOT NULL DEFAULT '_self',
	`folderLinks` ENUM( '1', '0' ) NOT NULL DEFAULT '1',
	`useSelection` ENUM( '1', '0' ) NOT NULL DEFAULT '1',
	`useLines` ENUM( '1', '0' ) NOT NULL DEFAULT '1',
	`useIcons` ENUM( '1', '0' ) NOT NULL DEFAULT '1',
	`closeSameLevel` ENUM( '1', '0' ) NOT NULL DEFAULT '0',
	`itemName` INT(1) NOT NULL DEFAULT '3',
	`locationName` INT(1) NOT NULL DEFAULT '0'
) TYPE = MYISAM ;

INSERT INTO `glpi_plugin_treeview_display` ( `ID`, `target`, `folderLinks`, `useSelection`, `useLines`, `useIcons`,  `closeSameLevel`, `itemName`, `locationName`) VALUES ('1','right','1','1','1','1','0', '3', '2');

DROP TABLE IF EXISTS `glpi_plugin_treeview_profiles`;
CREATE TABLE `glpi_plugin_treeview_profiles` (
	`ID` int(11) NOT NULL auto_increment,
	`name` varchar(255) default NULL,
	`interface` varchar(50) NOT NULL default 'treeview',
	`is_default` smallint(6) NOT NULL default '0',
	`treeview` char(1) default NULL,
	PRIMARY KEY  (`ID`),
	KEY `interface` (`interface`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `glpi_plugin_treeview_preference`;
CREATE TABLE `glpi_plugin_treeview_preference` (
	`ID` int(11) NOT NULL auto_increment,
	`user_id` int(11) NOT NULL,
	`show` varchar(255) NOT NULL,
	PRIMARY KEY  (`ID`)
) ENGINE=MyISAM;