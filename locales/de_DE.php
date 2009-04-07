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

$title="Baumstruktur";

$LANG['plugin_treeview']['title'][0] = "".$title."";

$LANG['plugin_treeview']['profile'][0] = "Rights management";
$LANG['plugin_treeview']['profile'][3] = "Use the tree";

$LANG['plugin_treeview']['setup'][6] = "Ansicht";
$LANG['plugin_treeview']['setup'][7] = "Ja";
$LANG['plugin_treeview']['setup'][8] = "Nein";
$LANG['plugin_treeview']['setup'][9] = "Zielfenster für alle Verweise";
$LANG['plugin_treeview']['setup'][10] = "Ordner können Verweise enthalten";
$LANG['plugin_treeview']['setup'][11] = "Knoten können markiert werden";
$LANG['plugin_treeview']['setup'][13] = "Der Baum wird mit Linien dargestellt";
$LANG['plugin_treeview']['setup'][14] = "Der Baum wird mit Symbolen dargestellt";
$LANG['plugin_treeview']['setup'][16] = "Es kann nur ein einziger Knoten innerhalb<br>demselben Level gleichzeitig expandiert werden.";
$LANG['plugin_treeview']['setup'][17] = "Neues Fenster";
$LANG['plugin_treeview']['setup'][18] = "You cannot use this plugin on helpdesk";
$LANG['plugin_treeview']['setup'][20] = "Die Zentralkonsole";
$LANG['plugin_treeview']['setup'][21] = "Materialname";
$LANG['plugin_treeview']['setup'][22] = "Standortname";
$LANG['plugin_treeview']['setup'][23] = "Name";
$LANG['plugin_treeview']['setup'][24] = "Inventarnummer";
$LANG['plugin_treeview']['setup'][25] = "Kurzer Name";
$LANG['plugin_treeview']['setup'][26] = "Langer Name";
$LANG['plugin_treeview']['setup'][27] = "Kommentar";
$LANG['plugin_treeview']['setup'][31] = "Launch the plugin Treeview with GLPI launching";
$LANG['plugin_treeview']['setup'][32] = "Warning : If there are more than one plugin which be loaded at startup, then only the first will be used";

$LANG['plugin_treeview']['warning'][0] = "Das Plugin freport wurde nicht gefunden";

?>
