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

$title="Arborescence";

$LANG['plugin_treeview']["title"][0]="".$title."";

$LANG['plugin_treeview']["profile"][0] = "Gestion des droits";
$LANG['plugin_treeview']["profile"][1] = "$title";
$LANG['plugin_treeview']["profile"][3] = "Utiliser l'arborescence";
$LANG['plugin_treeview']["profile"][4] = "Listes des profils déjà configurés";

$LANG['plugin_treeview']["setup"][1]="Installer le plugin $title 1.1";
$LANG['plugin_treeview']["setup"][2]="Configuration du plugin ".$title."";
$LANG['plugin_treeview']["setup"][3]="Mettre à jour le plugin $title vers la version 1.1";
$LANG['plugin_treeview']["setup"][4]="Désinstaller le plugin $title 1.1";
$LANG['plugin_treeview']["setup"][5]="Attention, la désinstallation du plugin est irréversible.<br> Vous perdrez toutes les données.";
$LANG['plugin_treeview']["setup"][6]="Affichage";
$LANG['plugin_treeview']["setup"][7]="Oui";
$LANG['plugin_treeview']["setup"][8]="Non";
$LANG['plugin_treeview']["setup"][9]="Ouverture des liens";
$LANG['plugin_treeview']["setup"][10]="Utiliser les répertoires des lieux sous forme de liens <br> pour utiliser le plugin freport";
$LANG['plugin_treeview']["setup"][11]="Les noeuds peuvent être en surbrillance";
$LANG['plugin_treeview']["setup"][13]="L'arborescence est dessinée avec des lignes";
$LANG['plugin_treeview']["setup"][14]="L'arborescence est dessinée avec des icônes";
$LANG['plugin_treeview']["setup"][16]="Seulement un noeud avec un parent <br> peut être affiché en même temps";
$LANG['plugin_treeview']["setup"][17]="Dans une nouvelle fenêtre";
$LANG['plugin_treeview']["setup"][18]="";
$LANG['plugin_treeview']["setup"][20]="Dans la console centrale";
$LANG['plugin_treeview']["setup"][21]="Affichage du matériel";
$LANG['plugin_treeview']["setup"][22]="Affichage du lieu";
$LANG['plugin_treeview']["setup"][23]="Nom";
$LANG['plugin_treeview']["setup"][24]="Numéro d'inventaire";
$LANG['plugin_treeview']["setup"][25]="Nom court";
$LANG['plugin_treeview']["setup"][26]="Nom complet";
$LANG['plugin_treeview']["setup"][27]="Commentaires";
$LANG['plugin_treeview']["setup"][28] = "Mode d'emploi";
$LANG['plugin_treeview']["setup"][29] = "FAQ";
$LANG['plugin_treeview']["setup"][30] = "Merci de vous placer sur l'entité racine (voir tous)";
$LANG['plugin_treeview']["setup"][31] = "Lancer le plugin Treeview au démarrage de GLPI";
$LANG['plugin_treeview']["setup"][32] = "Attention : si plusieurs plugins sont lancés au démarrage, seul le premier sera actif";

$LANG['plugin_treeview']["warning"][0]="Le plugin freport n'est pas installé";

?>