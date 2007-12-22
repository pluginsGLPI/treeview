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

$NEEDED_ITEMS=array("setup");
if(!defined('GLPI_ROOT')){
	define('GLPI_ROOT', '../../..'); 
}

include (GLPI_ROOT."/inc/includes.php");

checkRight("config","w");

if(!isset($_SESSION["glpi_plugin_treeview_installed"]) || $_SESSION["glpi_plugin_treeview_installed"]!=1) { 
	
	commonHeader($LANG["title"][2],$_SERVER['PHP_SELF'],"config","plugins");
	
	if ($_SESSION["glpiactive_entity"]==0){
	
		if(!TableExists("glpi_plugin_treeview_display")){
		
			echo "<div align='center'>";
			echo "<table class='tab_cadre' cellpadding='5'>";
			echo "<tr><th>".$LANGTREEVIEW["setup"][2];
			echo "</th></tr>";
			echo "<tr class='tab_bg_1'><td>";
			echo "<a href='plugin_treeview.install.php'>".$LANGTREEVIEW["setup"][3]."</a></td></tr>";
			echo "</table></div>";
		}
	}else{ 
		echo "<div align='center'><br><br><img src=\"".$CFG_GLPI["root_doc"]."/pics/warning.png\" alt=\"warning\"><br><br>"; 
		echo "<b>".$LANG["login"][5]."</b></div>"; 
	}
}elseif(isset($_POST["update"])){
		checkRight("config","w");
		$plugin_treeview_display = new plugin_treeview_display;
		$plugin_treeview_display->update($_POST);
		glpi_header($_SERVER['HTTP_REFERER']);

}else{
	commonHeader($LANGTREEVIEW["title"][0],$_SERVER["PHP_SELF"],"plugins","treeview");
	
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
		echo $LANGTREEVIEW["setup"][6].": </th></tr>";
		echo "<tr class='tab_bg_1'><td>".$LANGTREEVIEW["setup"][9]."</td>";
		echo "<td>";
		echo "<select name=\"target\">";
		//echo "<option value='_self' "; if($target=='_self') echo " selected ";  echo ">".$LANGTREEVIEW["setup"][18]."</option>";
		echo "<option value='_blank' "; if($target=='_blank') echo " selected ";  echo ">".$LANGTREEVIEW["setup"][17]."</option>";
		echo "<option value='right' "; if($target=='right') echo " selected ";  echo ">".$LANGTREEVIEW["setup"][20]."</option>";
		echo "</select>";
		echo "</td>";
		echo "</tr>";
		echo "<tr class='tab_bg_1'><td>".$LANGTREEVIEW["setup"][10]."</td>";
		echo "<td>";
		echo "<select name=\"folderLinks\">";
		echo "<option value='0' ".($folderLinks==0?" selected ":"").">".$LANGTREEVIEW["setup"][8]."</option>";
		echo "<option value='1' ".($folderLinks==1?" selected ":"").">".$LANGTREEVIEW["setup"][7]."</option>";
		
		echo "</select>";
		echo "</td>";
		echo "</tr>";
		echo "<tr class='tab_bg_1'><td>".$LANGTREEVIEW["setup"][11]."</td>";
		echo "<td>";
		echo "<select name=\"useSelection\">";
		echo "<option value='1' ".($useSelection==1?" selected ":"").">".$LANGTREEVIEW["setup"][7]."</option>";
		echo "<option value='0' ".($useSelection==0?" selected ":"").">".$LANGTREEVIEW["setup"][8]."</option>";
		echo "</select>";
		echo "</td>";
		echo "</tr>";
		echo "<tr class='tab_bg_1'><td>".$LANGTREEVIEW["setup"][13]."</td>";
		echo "<td>";
		echo "<select name=\"useLines\">";
		echo "<option value='1' ".($useLines==1?" selected ":"").">".$LANGTREEVIEW["setup"][7]."</option>";
		echo "<option value='0' ".($useLines==0?" selected ":"").">".$LANGTREEVIEW["setup"][8]."</option>";
		echo "</select>";
		echo "</td>";
		echo "</tr>";
		echo "<tr class='tab_bg_1'><td>".$LANGTREEVIEW["setup"][14]."</td>";
		echo "<td>";
		echo "<select name=\"useIcons\">";
		echo "<option value='1' ".($useIcons==1?" selected ":"").">".$LANGTREEVIEW["setup"][7]."</option>";
		echo "<option value='0' ".($useIcons==0?" selected ":"").">".$LANGTREEVIEW["setup"][8]."</option>";
		echo "</select>";
		echo "</td>";
		echo "</tr>";
		echo "<tr class='tab_bg_1'><td>".$LANGTREEVIEW["setup"][16];
		echo "<td>";
		echo "<select name=\"closeSameLevel\">";
		echo "<option value='1' ".($closeSameLevel==1?" selected ":"").">".$LANGTREEVIEW["setup"][7]."</option>";
		echo "<option value='0' ".($closeSameLevel==0?" selected ":"").">".$LANGTREEVIEW["setup"][8]."</option>";
		echo "</select>";
		echo "</td>";
		echo "</tr>";
		echo "<tr class='tab_bg_1'><td>".$LANGTREEVIEW["setup"][21]."</td>";
		echo "<td>";
		echo "<select name=\"itemName\">";
		echo "<option value='0' "; if($itemName=='0') echo " selected ";  echo ">".$LANGTREEVIEW["setup"][23]."</option>";
		echo "<option value='1' "; if($itemName=='1') echo " selected ";  echo ">".$LANGTREEVIEW["setup"][24]."</option>";
		echo "<option value='2' "; if($itemName=='2') echo " selected ";  echo ">".$LANGTREEVIEW["setup"][23]. ' / ' . $LANGTREEVIEW["setup"][24]. "</option>";
		echo "<option value='3' "; if($itemName=='3') echo " selected ";  echo ">".$LANGTREEVIEW["setup"][24]. ' / ' . $LANGTREEVIEW["setup"][23]."</option>";
		echo "</select>";
		echo "</td>";
		echo "</tr>";
		echo "<tr class='tab_bg_1'><td>".$LANGTREEVIEW["setup"][22]."</td>";
		echo "<td>";
		echo "<select name=\"locationName\">";
		echo "<option value='0' "; if($locationName=='0') echo " selected ";  echo ">".$LANGTREEVIEW["setup"][25]."</option>";
		echo "<option value='1' "; if($locationName=='1') echo " selected ";  echo ">".$LANGTREEVIEW["setup"][26]."</option>";
		echo "<option value='2' "; if($locationName=='2') echo " selected ";  echo ">".$LANGTREEVIEW["setup"][25]. ' / '. $LANGTREEVIEW["setup"][27] ."</option>";
		echo "<option value='3' "; if($locationName=='3') echo " selected ";  echo ">".$LANGTREEVIEW["setup"][26]. ' / '. $LANGTREEVIEW["setup"][27] ."</option>";
		echo "</select>";
		echo "</td>";
		echo "</tr>";

		echo "<tr class='tab_bg_2'><td colspan='2'>";
		echo "<input type='hidden' name='ID' value=\"1\">";
		echo "<div align='center'><input type='submit' name='update' value=\"".$LANG["buttons"][2]."\" class='submit' ></div></td></tr>";
		echo "</table>";
		echo "</form>";			

		echo "<table class='tab_cadre' cellpadding='5'>";
		echo "<tr><th>".$LANGTREEVIEW["setup"][2];
		echo "</th></tr>";
		if (haveRight("config","w") && haveRight("profile","w")){
			echo "<tr class='tab_bg_1'><td align='center'>";
			echo "<a href=\"./plugin_treeview.profile.php\">".$LANGTREEVIEW["profile"][0]."</a>";
			echo "</td></tr>";
			}
		echo "<tr class='tab_bg_1'><td align='center'>";
			echo "<a href='http://glpi-project.org/wiki/doku.php?id=".substr($_SESSION["glpilanguage"],0,2).":plugins:treeview_use' target='_blank'>".$LANGTREEVIEW["setup"][28]."&nbsp;</a>";
			echo "/&nbsp;<a href='http://glpi-project.org/wiki/doku.php?id=".substr($_SESSION["glpilanguage"],0,2).":plugins:treeview_faq' target='_blank'>".$LANGTREEVIEW["setup"][29]." </a>";
			echo "</td></tr>";
			if ($_SESSION["glpiactive_entity"]==0){
		echo "<tr class='tab_bg_1'><td align='center'>";
		echo "<a href='plugin_treeview.uninstall.php'>".$LANGTREEVIEW["setup"][4]."</a>";
		echo " <img src='".GLPI_ROOT."/pics/aide.png' onmouseout=\"setdisplay(getElementById('comments'),'none')\" onmouseover=\"setdisplay(getElementById('comments'),'block')\">";
		echo "<span class='over_link' id='comments'>".$LANGTREEVIEW["setup"][5]."</span>";
		echo "</td></tr>";
		}
		echo "</table>";	
	}


commonFooter();

?>