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

if (!defined('GLPI_ROOT')){
	die("Sorry. You can't access directly to this file");
	}

function plugin_treeview_checkIfPreferenceExists($users_id)
{
	global $DB;
	$result = $DB->query("SELECT `id` 
							FROM `glpi_plugin_treeview_preferences` 
							WHERE `users_id` = '".$users_id."' ");
	if ($DB->numrows($result) > 0)
		return $DB->result($result,0,"id");
	else
		return 0;	
}

function plugin_treeview_addDefaultPreference($users_id)
{
	$input["users_id"]=$users_id;
	$input["show_on_load"]=0;
	
	$pref = new PluginTreeViewPreference;
	return $pref->add($input);
}

function plugin_treeview_checkPreferenceValue($users_id)
{
	global $DB;
	$result = $DB->query("SELECT * 
							FROM `glpi_plugin_treeview_preferences` 
							WHERE `users_id` = '".$users_id."' ");
	if ($DB->numrows($result) > 0)
		return $DB->result($result,0,"show_on_load");
	else
		return 0;	
}

?>