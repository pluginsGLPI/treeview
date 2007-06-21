<?php
/*
 * @version $Id: setup.php,v 1.2 2006/04/02 14:45:27 moyo Exp $
 ----------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2006 by the INDEPNET Development Team.

 http://indepnet.net/   http://glpi-project.org/
 ----------------------------------------------------------------------

 LICENSE

 This file is part of GLPI.

 GLPI is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 GLPI is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with GLPI; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 ------------------------------------------------------------------------
 */

// ----------------------------------------------------------------------
// Original Author of file: AL-Rubeiy Hussein
// Purpose of file:
// ----------------------------------------------------------------------

/**
 * Install the plugin tables on the GLPI database
 * @param 
 * @return 
 **/
function plugin_treeview_Install()
{
	global $DB;

	$query = "CREATE TABLE `glpi_plugin_treeview_display` (
				`ID` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
				`target` VARCHAR(255) NOT NULL DEFAULT '_self',
				`folderLinks` ENUM( '1', '0' ) NOT NULL DEFAULT '1',
				`useSelection` ENUM( '1', '0' ) NOT NULL DEFAULT '1',
				`useLines` ENUM( '1', '0' ) NOT NULL DEFAULT '1',
				`useIcons` ENUM( '1', '0' ) NOT NULL DEFAULT '1',
				`closeSameLevel` ENUM( '1', '0' ) NOT NULL DEFAULT '0',
				`itemName` INT(1) NOT NULL DEFAULT '3',
				`locationName` INT(1) NOT NULL DEFAULT '0'
				) TYPE = MYISAM ;";
	
		$DB->query($query) or die($db->error());
		
		// Insert default values
		$query ="INSERT INTO `glpi_plugin_treeview_display` ( `ID`, `target`, `folderLinks`, `useSelection`, `useLines`, `useIcons`,  `closeSameLevel`, `itemName`, `locationName`)
		VALUES ('1','right','1','1','1','1','0', '3', '2');";
		
		$DB->query($query) or die($DB->error());
}

/**
 * Drop the plugin tables from the GLPI database
 * @param 
 * @return 
 **/
function plugin_treeview_uninstall()
{
	global $DB;
	$query = "DROP TABLE `glpi_plugin_treeview_display`;";
	$DB->query($query) or die($DB->error());
}
?>
