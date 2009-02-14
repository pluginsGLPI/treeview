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

include_once ("inc/plugin_treeview.functions_display.php");
include_once ("inc/plugin_treeview.functions_db.php");
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
		if(plugin_treeview_haveRight("treeview","r") && isset($_SESSION["glpi_plugin_treeview_installed"]) && $_SESSION["glpi_plugin_treeview_installed"] == 1){
			$PLUGIN_HOOKS['menu_entry']['treeview'] = true;
			$PLUGIN_HOOKS['pre_item_update']['treeview'] = 'plugin_pre_item_update_treeview';
			$PLUGIN_HOOKS['pre_item_delete']['treeview'] = 'plugin_pre_item_delete_treeview';
			$PLUGIN_HOOKS['headings']['treeview'] = 'plugin_get_headings_treeview';
			$PLUGIN_HOOKS['headings_action']['treeview'] = 'plugin_headings_actions_treeview';		
			if ($_SERVER['PHP_SELF'] == $CFG_GLPI["root_doc"]."/front/central.php" && (isset($_SESSION["glpi_plugin_treeview_loaded"]) && $_SESSION["glpi_plugin_treeview_loaded"] == 0)){
				$_SESSION["glpi_plugin_treeview_loaded"] = 1;
				glpi_header(GLPI_ROOT."/plugins/treeview/index.php");
				
			}
			
			if ($_SERVER['PHP_SELF'] == $CFG_GLPI["root_doc"]."/logout.php" && (isset($_SESSION["glpi_plugin_treeview_loaded"]) && $_SESSION["glpi_plugin_treeview_loaded"] == 1)){
				plugin_treeview_HideTreeview();
				
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
	global $LANG;
	
	return array (
		'name' => $LANG['plugin_treeview']["title"][0],
		'version' => '1.2.0',
		'author'=>'AL-Rubeiy Hussein, Xavier Caillaud',
		'homepage'=>'http://glpi-project.org/wiki/doku.php?id='.substr($_SESSION["glpilanguage"],0,2).':plugins:pluginslist',
		'minGlpiVersion' => '0.72',// For compatibility / no install in version < 0.72
	);
}

function plugin_treeview_install(){
		
	include_once (GLPI_ROOT."/inc/profile.class.php");
	
	if(!TableExists("glpi_plugin_treeview_display") ){
	
		plugin_treeview_installing("1.2.0");
	
	}elseif(!TableExists("glpi_plugin_treeview_preference")) {
	
		plugin_treeview_update("1.1");
		plugin_treeview_update("1.2.0");

	}elseif(TableExists("glpi_plugin_treeview_profiles") && FieldExists("glpi_plugin_treeview_profiles","interface")) {
	
		plugin_treeview_update("1.2.0");

	}
	
	plugin_treeview_createfirstaccess($_SESSION['glpiactiveprofile']['ID']);
	plugin_treeview_initSession();
	return true;
}

function plugin_treeview_uninstall(){
	global $DB;
	
	$query = "DROP TABLE `glpi_plugin_treeview_display`;";
	$DB->query($query);
	
	$query = "DROP TABLE `glpi_plugin_treeview_profiles`;";
	$DB->query($query);
	
	$query = "DROP TABLE `glpi_plugin_treeview_preference`;";
	$DB->query($query);
	
	unset($_SESSION["glpi_plugin_treeview_installed"]);
	plugin_init_treeview();
	cleanCache("GLPI_HEADER_".$_SESSION["glpiID"]);

	return true;
}

// Optional : check prerequisites before install : may print errors or add to message after redirect
function plugin_treeview_check_prerequisites(){
	if (GLPI_VERSION>=0.72){
		return true;
	} else {
		echo "GLPI version not compatible need 0.72";
	}
}

// Uninstall process for plugin : need to return true if succeeded : may display messages or add to message after redirect
function plugin_treeview_check_config(){
	return true;
}

?>