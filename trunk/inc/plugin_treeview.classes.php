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
 * class plugin_treeview_display
 * Load and store the display configuration from the database
 */
class plugin_treeview_display extends CommonDBTM
{
	function plugin_treeview_display()
	{
		$this->table="glpi_plugin_treeview_display";
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

	function plugin_treeview_Profile () {
		$this->table="glpi_plugin_treeview_profiles";
		$this->type=-1;
	}

	//if profile deleted
	function cleanProfiles($ID) {
	
		global $DB;
		$query = "DELETE FROM glpi_plugin_treeview_profiles WHERE ID='$ID' ";
		$DB->query($query);
	}


	function showprofileForm($target,$ID){
		global $LANG,$CFG_GLPI,$LANGTREEVIEW;

		if (!haveRight("profile","r")) return false;

		$onfocus="";
		if ($ID){
			$this->getFromDB($ID);
		} else {
			$this->getEmpty();
			$onfocus="onfocus=\"this.value=''\"";
		}

		if (empty($this->fields["interface"])) $this->fields["interface"]="treeview";
		if (empty($this->fields["name"])) $this->fields["name"]=$LANG["common"][0];


		echo "<form name='form' method='post' action=\"$target\">";
		echo "<div align='center'>";
		echo "<table class='tab_cadre'><tr>";
		echo "<th>".$LANG["common"][16].":</th>";
		echo "<th><input type='text' name='name' value=\"".$this->fields["name"]."\" $onfocus></th>";
		echo "<th>".$LANG["profiles"][2].":</th>";
		echo "<th><select name='interface' id='profile_interface'>";
		echo "<option value='treeview' ".($this->fields["interface"]!="treeview"?"selected":"").">".$LANGTREEVIEW["profile"][1]."</option>";

		echo "</select></th>";
		echo "</tr></table>";
		echo "</div>";

		$params=array('interface'=>'__VALUE__',
				'ID'=>$ID,
		);
		ajaxUpdateItemOnSelectEvent("profile_interface","profile_form",$CFG_GLPI["root_doc"]."/plugins/treeview/ajax/profiles.php",$params,false);
		ajaxUpdateItem("profile_form",$CFG_GLPI["root_doc"]."/plugins/treeview/ajax/profiles.php",$params,false,'profile_interface');
		echo "<br>";

		echo "<div align='center' id='profile_form'>";
		echo "</div>";

		echo "</form>";

	}

	function showtreeviewForm($ID){
		global $LANG,$LANGTREEVIEW;

		if (!haveRight("profile","r")) return false;
		$canedit=haveRight("profile","w");

		if ($ID){
			$this->getFromDB($ID);
		} else {
			$this->getEmpty();
		}

		echo "<table class='tab_cadre'><tr>";

		echo "<tr><th colspan='2' align='center'><strong>".$LANGTREEVIEW["profile"][0]."</strong></td></tr>";

		echo "<tr class='tab_bg_2'>";
		echo "<td>".$LANGTREEVIEW["profile"][3].":</td><td>";
		dropdownNoneReadWrite("treeview",$this->fields["treeview"],1,1,0);
		echo "</td>";
		echo "</tr>";

		if ($canedit){
			echo "<tr class='tab_bg_1'>";
			if ($ID){
				echo "<td  align='center'>";
				echo "<input type='hidden' name='ID' value=$ID>";
				echo "<input type='submit' name='update' value=\"".$LANG["buttons"][7]."\" class='submit'>";
				echo "</td><td  align='center'>";
				echo "<input type='submit' name='delete' value=\"".$LANG["buttons"][6]."\" class='submit'>";
			} else {
				echo "<td colspan='2' align='center'>";
				echo "<input type='submit' name='add' value=\"".$LANG["buttons"][8]."\" class='submit'>";
			}
			echo "</td></tr>";
		}
		echo "</table>";

	}

}

?>