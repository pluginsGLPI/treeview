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

include_once ("inc/plugin_treeview.functions_db.php");
include_once ("inc/plugin_treeview.functions_display.php");
include_once ("inc/plugin_treeview.functions_auth.php");
include_once ("inc/plugin_treeview.functions_setup.php");
include_once ("inc/plugin_treeview.classes.php");

/**
 * Init the hooks of the plugins -Needed
 * @param 
 * @return 
 **/
function plugin_init_treeview() 
{
	global $PLUGIN_HOOKS,$DB,$CFG_GLPI;
	
	$PLUGIN_HOOKS['init_session']['treeview'] = 'plugin_treeview_initSession';
	$PLUGIN_HOOKS['change_profile']['treeview'] = 'plugin_treeview_changeprofile';
	$PLUGIN_HOOKS['change_entity']['treeview'] = 'plugin_change_entity_treeview';
	if (isset($_SESSION["glpiID"])){
	
	// Display a menu entry
		if(plugin_treeview_haveRight("treeview","r") && (isset($_SESSION["glpi_plugin_treeview_installed"]) && $_SESSION["glpi_plugin_treeview_installed"] == 1) && isset($_SESSION["glpi_plugin_treeview_profile"])){
			$PLUGIN_HOOKS['menu_entry']['treeview'] = true;
			$PLUGIN_HOOKS['user_preferences']['treeview'] = 'plugin_user_preferences_treeview'; 
			//$PLUGIN_HOOKS['action_user_preferences']['treeview'] = 'plugin_action_user_preferences_treeview'; 
			$PLUGIN_HOOKS['pre_item_delete']['treeview'] = 'plugin_pre_item_delete_treeview';
						
			if ($_SERVER['PHP_SELF'] == $CFG_GLPI["root_doc"]."/front/central.php" && (isset($_SESSION["glpi_plugin_treeview_loaded"]) && $_SESSION["glpi_plugin_treeview_loaded"] == 0)){
				$_SESSION["glpi_plugin_treeview_loaded"] = 1;
				glpi_header(GLPI_ROOT."/plugins/treeview/index.php");
				
			}		
		}
	// Config page
		if (plugin_treeview_haveRight("treeview","r") || haveRight("config","w"))
			$PLUGIN_HOOKS['config_page']['treeview'] = 'front/plugin_treeview.config.php';
		
	// Add specific files to add to the header : javascript or css
		$PLUGIN_HOOKS['add_javascript']['treeview']="dtree.js";
		$PLUGIN_HOOKS['add_css']['treeview']="dtree.css";
		$PLUGIN_HOOKS['add_javascript']['treeview']="functions.js";
		$PLUGIN_HOOKS['add_css']['treeview']="style.css";
		$PLUGIN_HOOKS['add_javascript']['treeview']="treeview.js";
		$PLUGIN_HOOKS['add_css']['treeview']="treeview.css";
		
		
	}
}

/**
 * Get the name and the version of the plugin - Needed
 * @param 
 * @return 
 **/
function plugin_version_treeview()
{
	global $LANGTREEVIEW;

	return array( 	'name'    => $LANGTREEVIEW["title"][0],
					'version' => '1.1');
}

//////////////////////////////

// Hook done on delete item case

function plugin_pre_item_delete_treeview($input){
	if (isset($input["_item_type_"]))
		switch ($input["_item_type_"]){
			case PROFILE_TYPE :
				// Manipulate data if needed 
				$plugin_treeview_Profile=new plugin_treeview_Profile;
				$plugin_treeview_Profile->cleanProfiles($input["ID"]);
				break;
		}
	return $input;
}

function plugin_change_entity_treeview(){
	if ($_SESSION['glpiactiveprofile']['interface'] == 'central')
	echo "<script type='text/javascript'>parent.left.location.reload(true);</script>";
}

function plugin_user_preferences_treeview($parm){

	$pref = new plugin_treeview_preference;
	if (isset($parm["update_user_preferences_treeview"]))
		$pref->update($parm);
		
	$pref_ID=plugin_treeview_checkIfPreferenceExists($_SESSION['glpiID']);
	if (!$pref_ID)
		$pref_ID=plugin_treeview_addDefaultPreference($_SESSION['glpiID']);
	
	$pref->showForm($_SERVER['PHP_SELF'],$pref_ID,$_SESSION['glpiID']);
}

?>