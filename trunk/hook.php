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

include_once ("inc/plugin_treeview.display.function.php");
include_once ("inc/plugin_treeview.class.php");
include_once ("inc/plugin_treeview.db.function.php");
include_once ("inc/plugin_treeview.setup.function.php");

function plugin_treeview_install(){
		
	include_once (GLPI_ROOT."/inc/profile.class.php");
	
	if(!TableExists("glpi_plugin_treeview_display") && !TableExists("glpi_plugin_treeview_displayprefs")){
	
		plugin_treeview_installing("1.3.0");
	
	}elseif(TableExists("glpi_plugin_treeview_display") && !TableExists("glpi_plugin_treeview_preference")) {
	
		plugin_treeview_update("1.1");
		plugin_treeview_update("1.2.0");
		plugin_treeview_update("1.3.0");

	}elseif(TableExists("glpi_plugin_treeview_profiles") && FieldExists("glpi_plugin_treeview_profiles","interface")) {
	
		plugin_treeview_update("1.2.0");
		plugin_treeview_update("1.3.0");

	}elseif(!TableExists("glpi_plugin_treeview_displayprefs")) {
	
		plugin_treeview_update("1.3.0");

	}
	
	plugin_treeview_createFirstAccess($_SESSION['glpiactiveprofile']['id']);

	$pref_ID=plugin_treeview_checkIfPreferenceExists($_SESSION['glpiID']);
	if ($pref_ID){
		$pref_value=plugin_treeview_checkPreferenceValue($_SESSION['glpiID']);
		if ($pref_value==1) {
			$_SESSION["glpi_plugin_treeview_loaded"]=0;
		}
	}
	
	return true;
}

function plugin_treeview_uninstall(){
	global $DB;
	
	$query = "DROP TABLE `glpi_plugin_treeview_displayprefs`;";
	$DB->query($query);
	
	$query = "DROP TABLE `glpi_plugin_treeview_profiles`;";
	$DB->query($query);
	
	$query = "DROP TABLE `glpi_plugin_treeview_preferences`;";
	$DB->query($query);
	
	plugin_init_treeview();

	return true;
}

// Hook done on before update item case
function plugin_pre_item_update_treeview($input){
	if (isset($input["_item_type_"]))
		if (in_array($input["_item_type_"],array(COMPUTER_TYPE,
				MONITOR_TYPE,NETWORKING_TYPE,PERIPHERAL_TYPE,PHONE_TYPE,PRINTER_TYPE,SOFTWARE_TYPE,CONSUMABLE_ITEMTYPE,CARTRIDGE_ITEMTYPE))){
					
				$ci = new CommonItem();
				$ci->GetfromDB($input["_item_type_"],$input["id"]);
					
				if (isset($input["locations_id"]) && isset($ci->obj->fields["locations_id"]) && $input["locations_id"]!=$ci->obj->fields["locations_id"])
          echo "<script type='text/javascript'>parent.left.location.reload(true);</script>";
		}
	return $input;
}

// Hook done on delete item case

function plugin_pre_item_delete_treeview($input){
	if (isset($input["_item_type_"]))
		switch ($input["_item_type_"]){
			case PROFILE_TYPE :
				// Manipulate data if needed 
				$PluginTreeViewProfile=new PluginTreeViewProfile;
				$PluginTreeViewProfile->cleanProfiles($input["id"]);
				break;
		}
	return $input;
}

function plugin_change_entity_Treeview(){
	if ($_SESSION['glpiactiveprofile']['interface'] == 'central' && (isset($_SESSION["glpi_plugin_treeview_loaded"]) && $_SESSION["glpi_plugin_treeview_loaded"] == 1))
		echo "<script type='text/javascript'>parent.left.location.reload(true);</script>";
}

// Define headings added by the plugin //
function plugin_get_headings_treeview($type,$ID,$withtemplate){

	global $LANG;
	
	if ($type==PROFILE_TYPE) {
		$prof = new Profile();
		if ($ID>0 && $prof->getFromDB($ID) && $prof->fields['interface']!='helpdesk') {
			return array(
				1 => $LANG['plugin_treeview']['title'][0],
				);
		} else {
			return array();			
		}
	}		
		
	if ($type=="prefs") {
		return array(
			1 => $LANG['plugin_treeview']['title'][0],
			);
	}
	return false;
}

// Define headings actions added by the plugin	 
function plugin_headings_actions_treeview($type){
	
	if (in_array($type,array("prefs",PROFILE_TYPE))){
		return array(
				1 => "plugin_headings_treeview",
				);
	}else
		return false;	
}

// action heading
function plugin_headings_treeview($type,$ID,$withtemplate=0){
	global $CFG_GLPI,$LANG;

		switch ($type){
			case PROFILE_TYPE :
				$prof=new PluginTreeViewProfile();	
				if (!$prof->GetfromDB($ID))
					plugin_treeview_createAccess($ID);				
				$prof->showForm($CFG_GLPI["root_doc"]."/plugins/treeview/front/plugin_treeview.profile.php",$ID);
			break;
			default :
				if ($type=="prefs"){
					$pref = new PluginTreeViewPreference;
					$pref_ID=plugin_treeview_checkIfPreferenceExists($_SESSION['glpiID']);
					if (!$pref_ID)
						$pref_ID=plugin_treeview_addDefaultPreference($_SESSION['glpiID']);
					
					$pref->showForm($CFG_GLPI['root_doc']."/plugins/treeview/front/plugin_treeview.preferences.form.php",$pref_ID,$_SESSION['glpiID']);
				}
			break;
		}
}

?>
