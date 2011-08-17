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

if (!defined('GLPI_ROOT')) {
   define('GLPI_ROOT', '../../..');
}

include (GLPI_ROOT . "/inc/includes.php");

$config = new PluginTreeviewConfig();
if (isset($_POST["update"])) {
   $config->update($_POST);
   glpi_header($_SERVER['HTTP_REFERER']);

} else {
   $plugin = new Plugin();
   if ($plugin->isInstalled("treeview") && $plugin->isActivated("treeview")) {
      Html::header($LANG['plugin_treeview']['title'][0], $_SERVER["PHP_SELF"], "config", "plugins");
      $config->showForm(1);

   } else {
      Html::header($LANG['common'][12], $_SERVER['PHP_SELF'], "config", "plugins");
      // Get the configuration from the database and show it
      echo " <script type='text/javascript'>
         if (top != self)
         top.location = self.location;
         </script>";
   }
}
Html::footer();
?>