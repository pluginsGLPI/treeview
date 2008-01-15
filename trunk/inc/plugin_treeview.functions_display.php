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

/**
 * The main function, build the javascript code of the treeview
 * @param 
 * @return 
**/
function plugin_treeview_buildTreeview()
{
	global $CFG_GLPI;
	
	# necessary files needed for the tree to work.
	echo "<link rel='stylesheet' type='text/css'  href='".$CFG_GLPI["root_doc"]."/plugins/treeview/dtree.css' type=\"text/css\" >\n";
	echo "<script type=\"text/javascript\" src='".$CFG_GLPI["root_doc"]."/plugins/treeview/dtree.js'></script>\n";

	echo "<div class=\"dtree\">";

	echo "<script type=\"text/javascript\">";
	
	plugin_treeview_getNodesFromDb();
		
	echo "</script>";
	echo "</div>";
}

/**
 * Requests the nodes from the GLPI database
 * @param 
 * @return 
 **/
function plugin_treeview_getNodesFromDb()
{	
	global $LINK_ID_TABLE;
	global $INFOFORM_PAGES;
	global $PLUGIN_TREEVIEW_DEVICES;
	global $DB;
	
	// The tree object
	echo "var d = new dTree('d');";	
	echo "d.add(0,-1,'GLPI Desktop');";
	
	$config = new plugin_treeview_Treeview_Config();
	$plugin_treeview_display = new plugin_treeview_display;
	
	// Request the display settings from the database and store them in the global object $config
	$plugin_treeview_display->getFromDB(1);
	
	//$config->useCookies = $plugin_treeview_display->fields["useCookies"];
	$config->itemName = $plugin_treeview_display->fields["itemName"];
	$config->locationName = $plugin_treeview_display->fields["locationName"];

	
	$config->target = $plugin_treeview_display->fields["target"];
	$config->folderLinks = $plugin_treeview_display->fields["folderLinks"];
	$config->useSelection = $plugin_treeview_display->fields["useSelection"];
	$config->useLines = $plugin_treeview_display->fields["useLines"];
	$config->useIcons = $plugin_treeview_display->fields["useIcons"];
	$config->closeSameLevel = $plugin_treeview_display->fields["closeSameLevel"];
	
	
	// Load the settings in JavaSript so that dTree script can apply them
	echo "d.config.target = '" .$config->target. "';";
	echo "d.config.folderLinks = " .$config->folderLinks. ";";
	echo "d.config.useSelection = " .$config->useSelection. ";";
	echo "d.config.useLines = " .$config->useLines. ";";
	echo "d.config.useIcons = " .$config->useIcons. ";";
	echo "d.config.closeSameLevel = " .$config->closeSameLevel. ";";
	
	$dontLoad = 'false';
	
	// Get the lowest level of the tree nodes and the highest primary key		 
	$query = "	SELECT MAX(`ID`) AS `max_ID`, MAX(`level`) AS `max_level` 
				FROM `glpi_dropdown_locations` WHERE FK_entities='".$_SESSION["glpiactive_entity"]."';";			 
	$result = $DB->query($query);
	$max_level = $DB->result($result, 0, "max_level");
	$tv_id = $max_id = $DB->result($result, 0, "max_ID");
	$tv_id++;
	
	// Is this the first time we load the page?
	if(isset($_GET['nodes']) && $_GET['nodes'] != "") {
		// If no then get all the nodes requested by the client
		$nodes = array_reverse(explode('.', $_GET['nodes']));
	}
	else {
		// If yes then get only the root node
		$nodes[0] = 0;
	}
	// If an item group is requested, then save its type to use it later in the openTo function
	if(isset($_GET['openedType']) && is_numeric($_GET['openedType']) && $_GET['openedType'] != "")
		$openedType = $_GET['openedType'];
	else
		$openedType = -1;
	
	for($n=1; $n<=count($nodes); $n++) {
		if($nodes[$n-1] <= $max_id && $n <= $max_level) {
			$query = "SELECT * FROM `glpi_dropdown_locations` WHERE `level` = '". $n ."' AND `parentID` = '". $nodes[$n-1] ."' AND FK_entities='" . $_SESSION["glpiactive_entity"]."' ORDER BY `completename` ASC";			 
			//echo "document.write(\"".$query."\"+'<br>');";
			$result = $DB->query($query);
			while($r = $DB->fetch_assoc($result)) {
				// Location's name schema
				if($config->locationName == 0)
					$l_name = $r['name'];
				else if($config->locationName == 1)
					$l_name = $r['completename'];				
				else if($config->locationName == 2) {
					$l_name = $r['name'];
					if($r['comments'] != "")
						$l_name .= ' (' . $r['comments'] . ')';				
				}
				else if($config->locationName == 3) {
					$l_name = $r['completename'];
					if($r['comments'] != "")
						$l_name .= ' (' . $r['comments'] . ')';				
				}
				if(isset($_SESSION["glpi_plugin_freport_installed"]) && $_SESSION["glpi_plugin_freport_installed"]==1)
				$locationLink = 'front/plugin_treeview.freport.php?ID=' . $r['ID'];
				else
				$locationLink = '';
				// Is this location requested by the user to be opened
				if(in_array($r['ID'], $nodes)) {
					echo "d.add(".$r['ID'].",".$r['parentID'].",\"".$l_name."\", true, -1, '" .$locationLink. "');";
					// If the items parent node is closed, then request only one item
					//if($nodes[$n+1] <= $max_id) {
					//	$limit = " LIMIT 0, 10";
					//}
					// Else display all the items
					//else {
						$limit = "";
						$dontLoad = 'true';
					//}
					// Then add aloso its items
					for($a=0; $a<count($PLUGIN_TREEVIEW_DEVICES); $a++) {
						$query = "SELECT *  FROM `" .$LINK_ID_TABLE[$PLUGIN_TREEVIEW_DEVICES[$a]['type']]. "` WHERE `location` = '".$r['ID']."' AND deleted=0 ";
						if($PLUGIN_TREEVIEW_DEVICES[$a]['type'] == COMPUTER_TYPE || $PLUGIN_TREEVIEW_DEVICES[$a]['type'] == MONITOR_TYPE || $PLUGIN_TREEVIEW_DEVICES[$a]['type'] == NETWORKING_TYPE || $PLUGIN_TREEVIEW_DEVICES[$a]['type'] == PERIPHERAL_TYPE  || $PLUGIN_TREEVIEW_DEVICES[$a]['type'] == PRINTER_TYPE || $PLUGIN_TREEVIEW_DEVICES[$a]['type'] == SOFTWARE_TYPE || $PLUGIN_TREEVIEW_DEVICES[$a]['type'] == PHONE_TYPE)
						$query.= " AND is_template=0 AND FK_entities='" . $_SESSION["glpiactive_entity"] . "'";
						
						$query.= " $limit ;";
						//echo "document.write(\"<b>".$query."\"+'</b><br>');";
						$result_1 = $DB->query($query);
						if($DB->numrows($result_1)) {
							$pid = $tv_id;
							$field_num = 3;
							if($PLUGIN_TREEVIEW_DEVICES[$a]['type'] == CARTRIDGE_TYPE || $PLUGIN_TREEVIEW_DEVICES[$a]['type'] == CONSUMABLE_TYPE)
								$field_num = 6;
							
							$query_location = "SELECT completename FROM `glpi_dropdown_locations` WHERE `ID` = '". $r['ID'] ."'";
							$result_location = $DB->query($query_location);
							while($row = $DB->fetch_assoc($result_location)) {
								$name_location=	$row['completename'];
							}	
							$getParam = '?contains[0]=' .$name_location. '&field[0]=' .$field_num. '&sort=1&deleted=0&start=0';
							// Add items parent node
							echo "d.add(".$tv_id.",".$r['ID'].",\"".strtr($PLUGIN_TREEVIEW_DEVICES[$a]['name'],"\"","`")."\", " . $dontLoad . ", " .$PLUGIN_TREEVIEW_DEVICES[$a]['type']. ", '" . GLPI_ROOT . $PLUGIN_TREEVIEW_DEVICES[$a]['page'] . $getParam . "', '', '', '" . $config->iconFolder . $PLUGIN_TREEVIEW_DEVICES[$a]['pic']. "', '" . $config->iconFolder . $PLUGIN_TREEVIEW_DEVICES[$a]['pic'] . "');";
							
							if($openedType == $PLUGIN_TREEVIEW_DEVICES[$a]['type'] && $nodes[count($nodes)-1] == $tv_id)
								$openedType = $tv_id;
							$tv_id++;
						}
						while($r_1 = $DB->fetch_assoc($result_1)) {
							// Item's name schema
							if($config->itemName == 0  || $PLUGIN_TREEVIEW_DEVICES[$a]['type'] == SOFTWARE_TYPE)
								$i_name = $r_1['name'];
							else if($config->itemName == 1)
								if (isset($r_1['otherserial']) && !empty($r_1['otherserial']))
									$i_name = $r_1['otherserial'];
								else
									$i_name = $r_1['name'];		
							else if($config->itemName == 2) {
								$i_name = $r_1['name'] != "" ? $r_1['name'] : "";
								if (isset($r_1['otherserial']) && !empty($r_1['otherserial']))
									$i_name .= $r_1['otherserial'] != "" ? ($r_1['name'] != "" ? ' / ' . $r_1['otherserial'] : $r_1['otherserial']) : "";
								else
									$i_name .= '';	
							}
							else if($config->itemName == 3) {
								if (isset($r_1['otherserial']) && !empty($r_1['otherserial'])){
								$i_name = $r_1['otherserial'] != "" ? $r_1['otherserial'] : "";
								$i_name .= $r_1['name'] != "" ? ($r_1['otherserial'] != "" ? ' / ' . $r_1['name'] : $r_1['name']) : "";
								}else
									$i_name = $r_1['name'];				
							}
							// Add the item
							echo "d.add(".$tv_id++.",".$pid.",\"" . strtr($i_name,"\"","`") . "\", true, -1, '" .GLPI_ROOT. "/" .$INFOFORM_PAGES[$PLUGIN_TREEVIEW_DEVICES[$a]['type']]. "?ID=" .$r_1['ID']. "', '', '', '" . $config->iconFolder . "node.gif', '" . $config->iconFolder . "node.gif');";
						}
					}
				}
				// Add only the location without its items
				else {
					echo "d.add(".$r['ID'].",".$r['parentID'].",\"".$l_name."\", false, -1, '" .$locationLink. "', '', '', '', '', false, true);";
				}	
			}
		}
	}
	
	// Print the node from JavaScript
	echo "document.write(d);";
	//echo "document.write('".$openedType."');";
	
	
	// Open the tree to the desired node
	if($openedType != -1)
		echo "d.openTo(" .$openedType. ");";
	else
		echo "d.openTo(" .$nodes[count($nodes)-1]. ");";
}

?>