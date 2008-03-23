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

$LANGTREEVIEW["title"][0]="".$title."";

$LANGTREEVIEW["profile"][0] = "Rights management";
$LANGTREEVIEW["profile"][1] = "$title";
$LANGTREEVIEW["profile"][2] = "Setup";
$LANGTREEVIEW["profile"][3] = "Use the tree";
$LANGTREEVIEW["profile"][4] = "List of profiles already configured";

$LANGTREEVIEW["setup"][2]="".$title." Einstellungen";
$LANGTREEVIEW["setup"][3]="Plugin $title installieren";
$LANGTREEVIEW["setup"][4]="Plugin $title deinstallieren";
$LANGTREEVIEW["setup"][5]="Vorsicht, Die Deinstallation kann nicht r�ckg�ngig gemacht werden.<br> Die Daten werden unwiderruflich gel�scht.";
$LANGTREEVIEW["setup"][6]="Ansicht";
$LANGTREEVIEW["setup"][7]="Ja";
$LANGTREEVIEW["setup"][8]="Nein";
$LANGTREEVIEW["setup"][9]="Zielfenster f�r alle Verweise";
$LANGTREEVIEW["setup"][10]="Ordner k�nnen Verweise enthalten";
$LANGTREEVIEW["setup"][11]="Knoten k�nnen markiert werden";
$LANGTREEVIEW["setup"][13]="Der Baum wird mit Linien dargestellt";
$LANGTREEVIEW["setup"][14]="Der Baum wird mit Symbolen dargestellt";
$LANGTREEVIEW["setup"][15]="Knotenname in der <br>Statuszeile anzeigen";
$LANGTREEVIEW["setup"][16]="Es kann nur ein einziger Knoten innerhalb<br>demselben Level gleichzeitig expandiert werden.";
$LANGTREEVIEW["setup"][17]="Neues Fenster";
$LANGTREEVIEW["setup"][18]="Aktuelles Fenster";
$LANGTREEVIEW["setup"][20]="Die Zentralkonsole";
$LANGTREEVIEW["setup"][21]="Materialname";
$LANGTREEVIEW["setup"][22]="Standortname";
$LANGTREEVIEW["setup"][23]="Name";
$LANGTREEVIEW["setup"][24]="Inventarnummer";
$LANGTREEVIEW["setup"][25]="Kurzer Name";
$LANGTREEVIEW["setup"][26]="Langer Name";
$LANGTREEVIEW["setup"][27]="Kommentar";
$LANGTREEVIEW["setup"][28] = "Instructions";
$LANGTREEVIEW["setup"][29] = "FAQ";
$LANGTREEVIEW["setup"][30] = "Merci de vous placer sur l'entit� racine (voir tous)";

$LANGTREEVIEW["warning"][0]="Das Plugin freport wurde nicht gefunden";

?>