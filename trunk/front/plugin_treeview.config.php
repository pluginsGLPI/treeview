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

if(!defined('GLPI_ROOT')){
	define('GLPI_ROOT', '../../..');
	$NEEDED_ITEMS=array("setup");
	include (GLPI_ROOT . "/inc/includes.php");
}

checkRight("config","w");

useplugin('treeview');

if(isset($_POST["update"])){
		checkRight("config","w");
		$plugin_treeview_display = new plugin_treeview_display;
		$plugin_treeview_display->update($_POST);
		glpi_header($_SERVER['HTTP_REFERER']);

}else{

	$plugin = new Plugin();
	if ($plugin->isInstalled("treeview") && $plugin->isActivated("treeview")) {
	
		commonHeader($LANG['plugin_treeview']['title'][0],$_SERVER["PHP_SELF"],"plugins","treeview");
	
		// Get the configuration from the database and show it 
		echo "	<script type='text/javascript'>
				if (top != self)
				top.location = self.location;
				</script>";
	
		echo "<div align='center'>";
		
		// Requests the settings from the database
		$plugin_treeview_display = new plugin_treeview_display;
		$plugin_treeview_display->getFromDB('1');
		
		$target=$plugin_treeview_display->fields["target"];
		$folderLinks=$plugin_treeview_display->fields["folderLinks"];
		$useSelection=$plugin_treeview_display->fields["useSelection"];	
		$useLines=$plugin_treeview_display->fields["useLines"];
		$useIcons=$plugin_treeview_display->fields["useIcons"];
		$closeSameLevel=$plugin_treeview_display->fields["closeSameLevel"];
		$itemName=$plugin_treeview_display->fields["itemName"];
		$locationName=$plugin_treeview_display->fields["locationName"];
		
		// Configuration form
		echo "<form method='post' action=\"./plugin_treeview.config.php\">";		
		echo "<table class='tab_cadre' cellpadding='5'><tr><th colspan='2'>";
		echo $LANG['plugin_treeview']['setup'][6].": </th></tr>";
		echo "<tr class='tab_bg_1'><td>".$LANG['plugin_treeview']['setup'][9]."</td>";
		echo "<td>";
		echo "<select name=\"target\">";
		//echo "<option value='_self' "; if($target=='_self') echo " selected ";  echo ">".$LANG['plugin_treeview']['setup'][18]."</option>";
		echo "<option value='_blank' "; if($target=='_blank') echo " selected ";  echo ">".$LANG['plugin_treeview']['setup'][17]."</option>";
		echo "<option value='right' "; if($target=='right') echo " selected ";  echo ">".$LANG['plugin_treeview']['setup'][20]."</option>";
		echo "</select>";
		echo "</td>";
		echo "</tr>";
		echo "<tr class='tab_bg_1'><td>".$LANG['plugin_treeview']['setup'][10]."</td>";
		echo "<td>";
		echo "<select name=\"folderLinks\">";
		echo "<option value='0' ".($folderLinks==0?" selected ":"").">".$LANG['plugin_treeview']['setup'][8]."</option>";
		echo "<option value='1' ".($folderLinks==1?" selected ":"").">".$LANG['plugin_treeview']['setup'][7]."</option>";
		
		echo "</select>";
		echo "</td>";
		echo "</tr>";
		echo "<tr class='tab_bg_1'><td>".$LANG['plugin_treeview']['setup'][11]."</td>";
		echo "<td>";
		echo "<select name=\"useSelection\">";
		echo "<option value='1' ".($useSelection==1?" selected ":"").">".$LANG['plugin_treeview']['setup'][7]."</option>";
		echo "<option value='0' ".($useSelection==0?" selected ":"").">".$LANG['plugin_treeview']['setup'][8]."</option>";
		echo "</select>";
		echo "</td>";
		echo "</tr>";
		echo "<tr class='tab_bg_1'><td>".$LANG['plugin_treeview']['setup'][13]."</td>";
		echo "<td>";
		echo "<select name=\"useLines\">";
		echo "<option value='1' ".($useLines==1?" selected ":"").">".$LANG['plugin_treeview']['setup'][7]."</option>";
		echo "<option value='0' ".($useLines==0?" selected ":"").">".$LANG['plugin_treeview']['setup'][8]."</option>";
		echo "</select>";
		echo "</td>";
		echo "</tr>";
		echo "<tr class='tab_bg_1'><td>".$LANG['plugin_treeview']['setup'][14]."</td>";
		echo "<td>";
		echo "<select name=\"useIcons\">";
		echo "<option value='1' ".($useIcons==1?" selected ":"").">".$LANG['plugin_treeview']['setup'][7]."</option>";
		echo "<option value='0' ".($useIcons==0?" selected ":"").">".$LANG['plugin_treeview']['setup'][8]."</option>";
		echo "</select>";
		echo "</td>";
		echo "</tr>";
		echo "<tr class='tab_bg_1'><td>".$LANG['plugin_treeview']['setup'][16];
		echo "<td>";
		echo "<select name=\"closeSameLevel\">";
		echo "<option value='1' ".($closeSameLevel==1?" selected ":"").">".$LANG['plugin_treeview']['setup'][7]."</option>";
		echo "<option value='0' ".($closeSameLevel==0?" selected ":"").">".$LANG['plugin_treeview']['setup'][8]."</option>";
		echo "</select>";
		echo "</td>";
		echo "</tr>";
		echo "<tr class='tab_bg_1'><td>".$LANG['plugin_treeview']['setup'][21]."</td>";
		echo "<td>";
		echo "<select name=\"itemName\">";
		echo "<option value='0' "; if($itemName=='0') echo " selected ";  echo ">".$LANG['plugin_treeview']['setup'][23]."</option>";
		echo "<option value='1' "; if($itemName=='1') echo " selected ";  echo ">".$LANG['plugin_treeview']['setup'][24]."</option>";
		echo "<option value='2' "; if($itemName=='2') echo " selected ";  echo ">".$LANG['plugin_treeview']['setup'][23]. ' / ' . $LANG['plugin_treeview']['setup'][24]. "</option>";
		echo "<option value='3' "; if($itemName=='3') echo " selected ";  echo ">".$LANG['plugin_treeview']['setup'][24]. ' / ' . $LANG['plugin_treeview']['setup'][23]."</option>";
		echo "</select>";
		echo "</td>";
		echo "</tr>";
		echo "<tr class='tab_bg_1'><td>".$LANG['plugin_treeview']['setup'][22]."</td>";
		echo "<td>";
		echo "<select name=\"locationName\">";
		echo "<option value='0' "; if($locationName=='0') echo " selected ";  echo ">".$LANG['plugin_treeview']['setup'][25]."</option>";
		echo "<option value='1' "; if($locationName=='1') echo " selected ";  echo ">".$LANG['plugin_treeview']['setup'][26]."</option>";
		echo "<option value='2' "; if($locationName=='2') echo " selected ";  echo ">".$LANG['plugin_treeview']['setup'][25]. ' / '. $LANG['plugin_treeview']['setup'][27] ."</option>";
		echo "<option value='3' "; if($locationName=='3') echo " selected ";  echo ">".$LANG['plugin_treeview']['setup'][26]. ' / '. $LANG['plugin_treeview']['setup'][27] ."</option>";
		echo "</select>";
		echo "</td>";
		echo "</tr>";

		echo "<tr class='tab_bg_2'><td colspan='2'>";
		echo "<input type='hidden' name='ID' value=\"1\">";
		echo "<div align='center'><input type='submit' name='update' value=\"".$LANG['buttons'][2]."\" class='submit' ></div></td></tr>";
		echo "</table>";
		echo "</form>";
		
	}else{
			commonHeader($LANG['common'][12],$_SERVER['PHP_SELF'],"config","plugins");
			echo "<div align='center'><br><br><img src=\"".$CFG_GLPI["root_doc"]."/pics/warning.png\" alt=\"warning\"><br><br>";
			echo "<b>Please activate the plugin</b></div>";
	}
	
	commonFooter();
	
}

?>