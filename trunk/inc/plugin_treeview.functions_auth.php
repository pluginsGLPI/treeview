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

function plugin_treeview_initSession() {
	global $DB;
	
	if(TableExists("glpi_plugin_treeview_preference")){
		$profile=new plugin_treeview_Profile();
	
		$query = "SELECT DISTINCT glpi_profiles.* FROM glpi_users_profiles INNER JOIN glpi_profiles ON (glpi_users_profiles.FK_profiles = glpi_profiles.ID) WHERE glpi_users_profiles.FK_users='".$_SESSION["glpiID"]."'";
		$result = $DB->query($query);
		$_SESSION['glpi_plugin_treeview_profile'] = array ();
		if ($DB->numrows($result)) {
			while ($data = $DB->fetch_assoc($result)) {
				$profile->fields = array ();
				if(isset($_SESSION["glpiactiveprofile"]["ID"])){
					$profile->getFromDB($_SESSION["glpiactiveprofile"]["ID"]);
					$_SESSION['glpi_plugin_treeview_profile'] = $profile->fields;
				}else{
					$profile->getFromDB($data['ID']);
					$_SESSION['glpi_plugin_treeview_profile'] = $profile->fields;
				}
				$_SESSION["glpi_plugin_treeview_installed"]=1;

				$pref_ID=plugin_treeview_checkIfPreferenceExists($_SESSION['glpiID']);
				if ($pref_ID)
					$pref_value=plugin_treeview_checkPreferenceValue($_SESSION['glpiID']);
					if ($pref_value)
						$_SESSION["glpi_plugin_treeview_loaded"]=0;

			}
		}
	}
}

function plugin_treeview_changeprofile()
{
	if(isset($_SESSION["glpi_plugin_treeview_installed"]) && $_SESSION["glpi_plugin_treeview_installed"]==1){
		$prof=new plugin_treeview_Profile();
		if($prof->getFromDB($_SESSION['glpiactiveprofile']['ID']))
			$_SESSION["glpi_plugin_treeview_profile"]=$prof->fields;
		else
			unset($_SESSION["glpi_plugin_treeview_profile"]);
	}
}

function plugin_treeview_haveRight($module,$right){
	$matches=array(
			""  => array("","r","w"), // ne doit pas arriver normalement
			"r" => array("r","w"),
			"w" => array("w"),
			"1" => array("1"),
			"0" => array("0","1"), // ne doit pas arriver non plus
		      );
	if (isset($_SESSION["glpi_plugin_treeview_profile"][$module])&&in_array($_SESSION["glpi_plugin_treeview_profile"][$module],$matches[$right]))
		return true;
	else return false;
}

function plugin_treeview_checkRight($module, $right) {
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

?>