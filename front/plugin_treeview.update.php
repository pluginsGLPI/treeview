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

$NEEDED_ITEMS=array("profile");
define('GLPI_ROOT', '../../..');
include (GLPI_ROOT . "/inc/includes.php");

// Have the user sufficient rights to uninstall the plugin
if(haveRight("config","w") && haveRight("profile","w")){
	if(!TableExists("glpi_plugin_treeview_preference")){
		cleanCache("GLPI_HEADER_".$_SESSION["glpiID"]);
		plugin_treeview_update();
		plugin_treeview_createfirstaccess($_SESSION['glpiactiveprofile']['ID']);
		plugin_treeview_initSession();
		plugin_treeview_addDefaultPreference($_SESSION["glpiID"]);
	}
	glpi_header($_SERVER['HTTP_REFERER']);
}
// Print warning message if not
else{
	commonHeader($LANG["login"][5],$_SERVER["PHP_SELF"]);
	echo "<div align='center'><br><br><img src=\"".GLPI_ROOT."/pics/warning.png\" alt=\"warning\"><br><br>";
	echo "<b>".$LANG["login"][5]."</b></div>";
	commonFooter();
}
?>
