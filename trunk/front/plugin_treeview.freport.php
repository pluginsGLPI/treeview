<?php
/*
 * @version $Id: setup.php,v 1.2 2006/04/02 14:45:27 moyo Exp $
 ---------------------------------------------------------------------- 
 GLPI - Gestionnaire Libre de Parc Informatique 
 Copyright (C) 2003-2008 by the INDEPNET Development Team.

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

define('GLPI_ROOT', '../../..');
include (GLPI_ROOT . "/inc/includes.php");

// Check if the freport plugin is installed
$plugin = new Plugin();
if ($plugin->isActivated("freport")){
	$filename = GLPI_ROOT . '/plugins/freport/index.php';
	if (file_exists($filename)){
	$query = "SELECT `completename` 
				FROM `glpi_locations` 
				WHERE `id` = '". $_GET['id'] ."'";
	$result = $DB->query($query);
	while($r = $DB->fetch_assoc($result)) {
		$name_location=	$r['completename'];
	}		
	$getParam = '?contains[0]=' .str_replace("'","\'",$name_location).  '&field[0]=0&sort=1&is_deleted=0&start=0&from=treeview';
	$target = $filename . $getParam;
//	echo $target;
	echo "<script language=javascript>window.location=\"".html_entity_decode($target)."\"</script>";
	}
} 
// Print error message if not
else {
	commonHeader($LANG['plugin_treeview']['title'][0],$_SERVER["PHP_SELF"],"plugins","treeview");
	echo "<div align='center'><br><br><img src=\"".$CFG_GLPI["root_doc"]."/pics/warning.png\" alt=\"warning\"><br><br>"; 
	echo "<b>".$LANG['plugin_treeview']['warning'][0]."</b></div>"; 
	commonFooter();
}
?>