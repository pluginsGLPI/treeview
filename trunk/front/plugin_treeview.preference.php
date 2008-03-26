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

// Original Author of file: BALPE Dévi
// Purpose of file:
// ----------------------------------------------------------------------

global $LANGTREEVIEW,$LANG,$DB;
	
if (!defined('GLPI_ROOT')) {
	define('GLPI_ROOT', '../../..');
}

include_once (GLPI_ROOT . "/inc/includes.php");

commonHeader($LANGTREEVIEW["title"][0],$_SERVER["PHP_SELF"],"plugins","treeview");

if(isset($_POST['valide'])){

	plugin_treeview_addpreference($_POST['ID'],$_SESSION['glpiID'],$_POST['show']);
	glpi_header($_SERVER['HTTP_REFERER']);
	
}else{

	$query = "SELECT * FROM glpi_plugin_treeview_preference WHERE user_id ='".$_SESSION['glpiID']."' ";
	$result = $DB->query($query);
		
	echo "<form action='".$_SERVER['PHP_SELF']."' method='post'>";
	echo "<div align='center'>";
	echo "<table class='tab_cadre' cellpadding='5'>";
	echo "<tr><th>".$LANGTREEVIEW["setup"][0]."</th></tr>";
	echo "<tr class='tab_bg_1' align='center'><td>";
	echo $LANGTREEVIEW["setup"][31]." : ";

	if ($DB->numrows($result)>0){
		while ($data=$DB->fetch_array($result)){

			echo "<select name=\"show\">";
			echo "<option value='0' ".($data["show"]==0?" selected ":"").">".$LANG["choice"][0]."</option>";
			echo "<option value='1' ".($data["show"]==1?" selected ":"").">".$LANG["choice"][1]."</option>";
			echo "</select>";
			echo "</td></tr>";
			echo "<tr class='tab_bg_1' align='center'><td>";
			
			echo "<input type='hidden' name='ID' value='".$data["id"]."' />";
			echo "<input type='submit' name='valide' value='Valider' class='submit' />";
			echo "</td></tr>";
		}
	}else{
		echo "<select name=\"show\">";
		echo "<option value='0'>".$LANG["choice"][0]."</option>";
		echo "<option value='1'>".$LANG["choice"][1]."</option>";
		echo "</select>";
		echo "</td></tr>";
		echo "<tr class='tab_bg_1' align='center'><td>";
		echo "<input type='submit' name='valide' value='Valider' class='submit' />";
		echo "</td></tr>";
	}
	
	echo "</table>";
	echo "</div>";
	echo "</form>";
	
	echo "<br><a href='plugin_treeview.see.php'>".$LANGTREEVIEW["setup"][32]."</a>";

}

commonFooter();

?>