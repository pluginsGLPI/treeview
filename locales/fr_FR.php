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

$LANGTREEVIEW["title"][0]="".$title."";

$LANGTREEVIEW["profile"][0] = "Gestion des droits";
$LANGTREEVIEW["profile"][1] = "$title";
$LANGTREEVIEW["profile"][3] = "Utiliser l'arborescence";
$LANGTREEVIEW["profile"][4] = "Listes des profils déjà configurés";

$LANGTREEVIEW["setup"][1]="Installer le plugin $title 1.1";
$LANGTREEVIEW["setup"][2]="Configuration du plugin ".$title."";
$LANGTREEVIEW["setup"][3]="Mettre à jour le plugin $title vers la version 1.1";
$LANGTREEVIEW["setup"][4]="Désinstaller le plugin $title 1.1";
$LANGTREEVIEW["setup"][5]="Attention, la désinstallation du plugin est irréversible.<br> Vous perdrez toutes les données.";
$LANGTREEVIEW["setup"][6]="Affichage";
$LANGTREEVIEW["setup"][7]="Oui";
$LANGTREEVIEW["setup"][8]="Non";
$LANGTREEVIEW["setup"][9]="Ouverture des liens";
$LANGTREEVIEW["setup"][10]="Utiliser les répertoires des lieux sous forme de liens <br> pour utiliser le plugin freport";
$LANGTREEVIEW["setup"][11]="Les noeuds peuvent être en surbrillance";
$LANGTREEVIEW["setup"][13]="L'arborescence est dessinée avec des lignes";
$LANGTREEVIEW["setup"][14]="L'arborescence est dessinée avec des icônes";
$LANGTREEVIEW["setup"][16]="Seulement un noeud avec un parent <br> peut être affiché en même temps";
$LANGTREEVIEW["setup"][17]="Dans une nouvelle fenêtre";
$LANGTREEVIEW["setup"][18]="";
$LANGTREEVIEW["setup"][20]="Dans la console centrale";
$LANGTREEVIEW["setup"][21]="Affichage du matériel";
$LANGTREEVIEW["setup"][22]="Affichage du lieu";
$LANGTREEVIEW["setup"][23]="Nom";
$LANGTREEVIEW["setup"][24]="Numéro d'inventaire";
$LANGTREEVIEW["setup"][25]="Nom court";
$LANGTREEVIEW["setup"][26]="Nom complet";
$LANGTREEVIEW["setup"][27]="Commentaires";
$LANGTREEVIEW["setup"][28] = "Mode d'emploi";
$LANGTREEVIEW["setup"][29] = "FAQ";
$LANGTREEVIEW["setup"][30] = "Merci de vous placer sur l'entité racine (voir tous)";
$LANGTREEVIEW["setup"][31] = "Lancer le plugin Treeview au démarrage de GLPI";
$LANGTREEVIEW["setup"][32] = "Attention : si plusieurs plugins sont lancés au démarrage, seul le premier sera actif";

$LANGTREEVIEW["warning"][0]="Le plugin freport n'est pas installé";

?>