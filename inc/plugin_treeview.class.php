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
 * class plugin_treeview_display
 * Load and store the display configuration from the database
 */
class plugin_treeview_display extends CommonDBTM
{
	function __construct()
	{
		$this->table="glpi_plugin_treeview_display";
	}
}
/**
 * class plugin_treeview_preference
 * Load and store the preference configuration from the database
 */
class plugin_treeview_preference extends CommonDBTM
{
	function __construct()
	{
		$this->table="glpi_plugin_treeview_preference";
		$this->type=-1;
	}
	
	function showForm($target,$ID,$user_id){
		global $LANG,$DB;
		
		$data=plugin_version_treeview();
		$this->getFromDB($ID);
		echo "<form action='".$target."' method='post'>";
		echo "<div align='center'>";

		echo "<table class='tab_cadre_fixe' cellpadding='5'>";
		echo "<tr><th colspan='2'>" . $data['name'] . " - ". $data['version'] . "</th></tr>";

		echo "<tr class='tab_bg_1' align='center'><td>".$LANG['plugin_treeview']['setup'][31]."</td>";
		echo "<td>";
		dropdownyesno("show",$this->fields["show"]);
		echo "</td></tr>";
		echo "<tr class='tab_bg_1' align='center'><td colspan='2'>";
		echo "<input type='submit' name='update_user_preferences_treeview' value='".$LANG['buttons'][2]."' class='submit'>";
		echo "<input type='hidden' name='ID' value='".$ID."'>";
		echo "</td></tr>";
		echo "<tr class='tab_bg_1' align='center'><td colspan='2'>";
		echo $LANG['plugin_treeview']['setup'][32];
		echo "</td></tr>";
		echo "</table>";

		echo "</div>";
		echo "</form>";
		
	}
}
/**
 * class plugin_treeview_Treeview_Config
 * Contains the display configuration of the treeview
 */
class plugin_treeview_Treeview_Config
{
	/**
    * the default target of the nodes
    * @var string 
    */
	var $target;
	/**
    * Should folders be links
    * @var bool 
    */
	var $folderLinks;
	/**
    * Nodes can be selected(highlighted)
    * @var bool 
    */
	var $useSelection;
	/**
    * Tree is drawn with lines
    * @var bool 
    */
	var $useLines;
	/**
    * Tree is drawn with icons
    * @var bool 
    */
	var $useIcons;
	/**
    * Only one node within a parent can be expanded at the same time.
    * @var bool 
    */
	var $closeSameLevel;
	/**
    * If parent nodes are always added before children, setting this to true speeds up the tree
    * @var bool 
    */
	var $inOrder;
	/**
    * the folder of the treeview's images
    * @var string 
    */
	var $iconFolder;
	/**
    * Name schema of the items nodes in the treeview
    * @var string 
    */
	var $itemName;
	/**
    * Name schema of the locations nodes in the treeview
    * @var string 
    */
	var $locationName;
	
	function plugin_treeview_Treeview_Config()
	{
		$this->target;
		$this->folderLinks = true;
		$this->useSelection = true;
		$this->useLines = true;
		$this->useIcons = true;
		$this->useStatusText = false;
		$this->closeSameLevel = false;
		$this->inOrder = false;
		$this->iconFolder = 'pics/';
		$this->itemName = 3;
		$this->locationName = 0;
	}
}

class plugin_treeview_Profile extends CommonDBTM {

	function __construct () {
		$this->table="glpi_plugin_treeview_profiles";
		$this->type=-1;
	}

	//if profile deleted
	function cleanProfiles($ID) {
	
		global $DB;
		$query = "DELETE 
					FROM glpi_plugin_treeview_profiles 
					WHERE ID='$ID' ";
		$DB->query($query);
	}

	//profiles modification
	function showForm($target,$ID){
		global $LANG;

		if (!haveRight("profile","r")) return false;
		$canedit=haveRight("profile","w");
		if ($ID){
			$this->getFromDB($ID);
		}
		echo "<form action='".$target."' method='post'>";
		echo "<table class='tab_cadre_fixe'>";

		echo "<tr><th colspan='2' align='center'><strong>".$LANG['plugin_treeview']['profile'][0]." ".$this->fields["name"]."</strong></th></tr>";

		echo "<tr class='tab_bg_2'>";
		echo "<td>".$LANG['plugin_treeview']['profile'][3].":</td><td>";
		dropdownNoneReadWrite("treeview",$this->fields["treeview"],1,1,0);
		echo "</td>";
		echo "</tr>";

		if ($canedit){
			echo "<tr class='tab_bg_1'>";
			echo "<td align='center' colspan='2'>";
			echo "<input type='hidden' name='ID' value=$ID>";
			echo "<input type='submit' name='update_user_profile' value=\"".$LANG['buttons'][7]."\" class='submit'>";
			echo "</td></tr>";
		}
		echo "</table></form>";

	}
}

?>