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

define('GLPI_ROOT', '../..');
include (GLPI_ROOT . "/inc/includes.php");
include_once ("inc/plugin_treeview.constant.php");
useplugin('treeview',true);

echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Frameset//EN\" \"http://www.w3.org/TR/html4/frameset.dtd\">";
echo "\n<html><head><title>GLPI - ".$LANG['plugin_treeview']['title'][0]."</title>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8 \" >";
// Send extra expires header if configured
echo "<meta http-equiv=\"Expires\" content=\"Fri, Jun 12 1981 08:20:00 GMT\">\n";
echo "<meta http-equiv=\"Pragma\" content=\"no-cache\">\n";
echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\">\n";
echo "<link rel='stylesheet' type='text/css'  href='".$CFG_GLPI["root_doc"]."/plugins/treeview/treeview.css' type=\"text/css\" >\n";
echo "<script type=\"text/javascript\" src='".$CFG_GLPI["root_doc"]."/plugins/treeview/treeview.js'></script></head>\n";

echo '<div id="ie5menu" class="skin0" onMouseover="highlightie5(event)" onMouseout="lowlightie5(event)" onClick="jumptoie5(event)" display:none>';
echo '</div>';
echo "<body>";
// Title bar
echo '<div id=explorer_bar><div id=explorer_title>';
echo $LANG['plugin_treeview']['title'][0] . '</div>';
echo "<div id=explorer_close><img border=0 src=\"pics/close.gif\" name=\"explorer_close\"' onmouseover=\"ChangeImg(document.images.explorer_close, 'pics/close_hover.gif');\" onmouseout=\"ChangeImg(document.images.explorer_close, 'pics/close.gif');\" onclick=\"parent.location.href = parent.right.location.href;\"></div>";
echo "</div>";

echo "<form method='get' name='get_level' action=\"" .$_SERVER["PHP_SELF"]. "\">";
// The IDs (primary key) of the requested nodes are stored in this field
echo "<input type='hidden' name='nodes' value=''>";
// Which item type should be opened?
echo "<input type='hidden' name='openedType' value=''>";
echo "</form>";

// Print the tree
plugin_treeview_buildTreeview();

echo "</body>";
echo "</html>";

?>