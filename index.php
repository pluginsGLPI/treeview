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


define('GLPI_ROOT', '../..');
include (GLPI_ROOT . "/inc/includes.php");

// Redirect to configuration page if plugin is not installed yet
if(!isset($_SESSION["glpi_plugin_treeview_installed"]) || $_SESSION["glpi_plugin_treeview_installed"]!=1) {
	glpi_header("./front/plugin_treeview.config.php");
} 
else {
	echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Frameset//EN\" \"http://www.w3.org/TR/html4/frameset.dtd\">";
	echo "\n<html><head><title>GLPI - ".$LANGTREEVIEW["title"][0]."</title>";
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8 \" >";
	// Send extra expires header if configured
	if ($CFG_GLPI["sendexpire"]) {
		echo "<meta http-equiv=\"Expires\" content=\"Fri, Jun 12 1981 08:20:00 GMT\">\n";
		echo "<meta http-equiv=\"Pragma\" content=\"no-cache\">\n";
		echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\">\n";
	}
	echo "<link rel='stylesheet' type='text/css' media='print' href='".$CFG_GLPI["root_doc"]."/css/print.css' >\n";
	echo "<link rel='shortcut icon' type='images/x-icon' href='".$CFG_GLPI["root_doc"]."/pics/favicon.ico' >\n";
	// Must be always the top window
	echo "<script type=\"text/javascript\">";
		echo "if (top != self)";
		echo "top.location = self.location;";
	echo "</script></head>";
	echo "<frameset cols='250,*'>";
		echo "<frame src='left.php' name='left' scrolling='yes'>";
		echo "<frame src='".GLPI_ROOT."/front/central.php' name='right'>";
		echo "<noframes>";
			echo "<body>";
				echo "<p><a href='".GLPI_ROOT."/front/central.php'>GLPI</a></p>";
			echo "</body>";
		echo "</noframes>";
	echo "</frameset>";
	echo "</html>";
}
?>