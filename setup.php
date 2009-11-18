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

include_once ("inc/plugin_treeview.profile.class.php");

/**
 * Init the hooks of the plugins -Needed
 * @param 
 * @return 
 **/
function plugin_init_treeview() {
	global $PLUGIN_HOOKS,$CFG_GLPI;
	
	$PLUGIN_HOOKS['change_profile']['treeview'] = 'plugin_treeview_changeProfile';
	$PLUGIN_HOOKS['change_entity']['treeview'] = 'plugin_change_entity_Treeview';
	
	if (isset($_SESSION["glpiID"])) {
	
	// Display a menu entry
		if(plugin_treeview_haveRight("treeview","r")) {
			$PLUGIN_HOOKS['menu_entry']['treeview'] = true;
			$PLUGIN_HOOKS['pre_item_update']['treeview'] = 'plugin_pre_item_update_treeview';
			$PLUGIN_HOOKS['pre_item_delete']['treeview'] = 'plugin_pre_item_delete_treeview';
			$PLUGIN_HOOKS['headings']['treeview'] = 'plugin_get_headings_treeview';
			$PLUGIN_HOOKS['headings_action']['treeview'] = 'plugin_headings_actions_treeview';		
			if ($_SERVER['PHP_SELF'] == $CFG_GLPI["root_doc"]."/front/central.php" && (isset($_SESSION["glpi_plugin_treeview_loaded"]) && $_SESSION["glpi_plugin_treeview_loaded"] == 0)) {
				$_SESSION["glpi_plugin_treeview_loaded"] = 1;
				glpi_header(GLPI_ROOT."/plugins/treeview/index.php");
				
			}
			
			if ($_SERVER['PHP_SELF'] == $CFG_GLPI["root_doc"]."/logout.php" && (isset($_SESSION["glpi_plugin_treeview_loaded"]) && $_SESSION["glpi_plugin_treeview_loaded"] == 1)) {
				$PluginTreeViewDisplayPref=new PluginTreeViewDisplayPref();
            $PluginTreeViewDisplayPref->hideTreeview();
				
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
function plugin_version_treeview() {
	global $LANG;
	
	return array (
		'name' => $LANG['plugin_treeview']['title'][0],
		'version' => '1.3.0',
		'author'=>'AL-Rubeiy Hussein, Xavier Caillaud',
		'homepage'=>'https://forge.indepnet.net/projects/show/treeview',
		'minGlpiVersion' => '0.80',// For compatibility / no install in version < 0.72
	);
}

// Optional : check prerequisites before install : may print errors or add to message after redirect
function plugin_treeview_check_prerequisites() {
	if (GLPI_VERSION>=0.80) {
		return true;
	} else {
		echo "GLPI version not compatible need 0.80";
	}
}

// Uninstall process for plugin : need to return true if succeeded : may display messages or add to message after redirect
function plugin_treeview_check_config() {
	return true;
}

function plugin_treeview_changeProfile() {
	$PluginTreeViewProfile=new PluginTreeViewProfile();
	$PluginTreeViewProfile->changeProfile();
}

function plugin_treeview_haveRight($module,$right) {
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

?>