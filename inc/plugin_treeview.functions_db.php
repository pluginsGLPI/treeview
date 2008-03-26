<?php
/*
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
// Original Author of file: CAILLAUD Xavier
// Purpose of file:
// ----------------------------------------------------------------------

if (!defined('GLPI_ROOT')){
	die("Sorry. You can't access directly to this file");
	}

function plugin_treeview_addpreference($ID,$user_id,$show){
	
	GLOBAL $DB;
	
	if ($ID){
		$query = "UPDATE `glpi_plugin_treeview_preference` SET `show` = '".$show."' WHERE `glpi_plugin_treeview_preference`.`id` ='".$ID."';";
		$DB->query($query);
	}else{
		$query = "INSERT INTO `glpi_plugin_treeview_preference` (`id` ,`user_id` ,`show` ) VALUES (NULL , '$user_id', '$show');";
		$DB->query($query);
	}
}
		
function plugin_treeview_createfirstaccess($ID){

	GLOBAL $DB;
	
	$plugin_treeview_Profile=new plugin_treeview_Profile();
	if (!$plugin_treeview_Profile->GetfromDB($ID)){
		
		$Profile=new Profile();
		$Profile->GetfromDB($ID);
		$name=$Profile->fields["name"];

		$query ="INSERT INTO `glpi_plugin_treeview_profiles` ( `ID`, `name` , `interface`, `is_default`, `treeview`) VALUES ('$ID', '$name','treeview','0','r');";
		$DB->query($query);
	}
}

	
function plugin_treeview_createaccess($ID){

	GLOBAL $DB;
	
	$Profile=new Profile();
	$Profile->GetfromDB($ID);
	$name=$Profile->fields["name"];

	$query ="INSERT INTO `glpi_plugin_treeview_profiles` ( `ID`, `name` , `interface`, `is_default`, `treeview`) VALUES ('$ID', '$name','treeview','0',NULL);";

	$DB->query($query);

}

?>