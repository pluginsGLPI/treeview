<?php
/*
 * @version $Id: HEADER 1 2009-09-21 14:58 Tsmr $
 -------------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2009 by the INDEPNET Development Team.

 http://indepnet.net/   http://glpi-project.org
 -------------------------------------------------------------------------

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
 --------------------------------------------------------------------------
 
// ----------------------------------------------------------------------
// Original Author of file: CAILLAUD Xavier & AL-RUBEIY Hussein
// Purpose of file: plugin treeview v1.3.0 - GLPI 0.80
// ----------------------------------------------------------------------
 */

if (!defined('GLPI_ROOT')) {
	die("Sorry. You can't access directly to this file");
}

class PluginTreeViewProfile extends CommonDBTM {

	function __construct () {
		$this->table="glpi_plugin_treeview_profiles";
		$this->type=-1;
	}

	//if profile deleted
	function cleanProfiles($ID) {
	
		$this->delete(array('ID'=>$ID));
	}
   
   function createFirstAccess($ID) {

      if (!$this->GetfromDB($ID)) {
         
         $Profile=new Profile();
         $Profile->GetfromDB($ID);
         $name=$Profile->fields["name"];

         $this->add(array(
            'id' => $ID,
            'name' => $name,
            'treeview' => 'r'));
      }
   }

   function createAccess($ID) {

      $Profile=new Profile();
      $Profile->GetfromDB($ID);
      $name=$Profile->fields["name"];
      
      $this->add(array(
         'id' => $ID,
         'name' => $name));
   }
   
   function changeProfile() {
   
      if ($this->getFromDB($_SESSION['glpiactiveprofile']['id']))
         $_SESSION["glpi_plugin_treeview_profile"]=$this->fields;
      else
         unset($_SESSION["glpi_plugin_treeview_profile"]);
      
      $PluginTreeViewPreference=new PluginTreeViewPreference();
      $pref_ID=$PluginTreeViewPreference->checkIfPreferenceExists($_SESSION['glpiID']);
      if ($pref_ID) {
         $pref_value=$PluginTreeViewPreference->checkPreferenceValue($_SESSION['glpiID']);
         if ($pref_value==1) {
            $_SESSION["glpi_plugin_treeview_loaded"]=0;
         }
      }
   }
  
   function checkRight($module, $right) {
      global $CFG_GLPI;

      if (!plugin_treeview_haveRight($module, $right)) {
         // Gestion timeout session
         if (!isset ($_SESSION["glpiID"])) {
            glpi_header($CFG_GLPI["root_doc"] . "/index.php");
            exit ();
         }

         displayRightError();
      }
   }

	//profiles modification
	function showForm($target,$ID) {
		global $LANG;

		if (!haveRight("profile","r")) return false;
		$canedit=haveRight("profile","w");
		if ($ID) {
			$this->getFromDB($ID);
		}
		echo "<form action='".$target."' method='post'>";
		echo "<table class='tab_cadre_fixe'>";

		echo "<tr><th colspan='2' class='center b'>".$LANG['plugin_treeview']['profile'][0]." ".$this->fields["name"]."</th></tr>";

		echo "<tr class='tab_bg_2'>";
		echo "<td>".$LANG['plugin_treeview']['profile'][3].":</td><td>";
		dropdownNoneReadWrite("treeview",$this->fields["treeview"],1,1,0);
		echo "</td>";
		echo "</tr>";

		if ($canedit) {
			echo "<tr class='tab_bg_1'>";
			echo "<td class='center' colspan='2'>";
			echo "<input type='hidden' name='id' value=$ID>";
			echo "<input type='submit' name='update_user_profile' value=\"".$LANG['buttons'][7]."\" class='submit'>";
			echo "</td></tr>";
		}
		echo "</table></form>";

	}
}

?>