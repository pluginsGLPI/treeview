<?php

/**
 * -------------------------------------------------------------------------
 * TreeView plugin for GLPI
 * -------------------------------------------------------------------------
 *
 * LICENSE
 *
 * This file is part of TreeView.
 *
 * TreeView is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * TreeView is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with TreeView. If not, see <http://www.gnu.org/licenses/>.
 * -------------------------------------------------------------------------
 * @copyright Copyright (C) 2007-2023 by Teclib'.
 * @license   GPLv2 https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://github.com/pluginsGLPI/treeview
 * -------------------------------------------------------------------------
 */

include ('../../../inc/includes.php');


$config = new PluginTreeviewConfig();
if (isset($_POST["update"])) {
   $config->update($_POST);
   Html::back();
} else {
   if (Plugin::isPluginActive("treeview")) {
      Html::header(PluginTreeviewConfig::getTypeName(), $_SERVER['PHP_SELF'], "config", "plugin");
      $config->showForm(1);
   } else {
      Html::header(__('Setup'), $_SERVER['PHP_SELF'], "config", "plugin");
      // Get the configuration from the database and show it
      echo " <script type='text/javascript'>
         if (top != self)
         top.location = self.location;
         </script>";
   }
}

Html::footer();
