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

define('PLUGIN_TREEVIEW_VERSION', '1.10.2');

// Minimal GLPI version, inclusive
define('PLUGIN_TREEVIEW_MIN_GLPI', '10.0.0');
// Maximum GLPI version, exclusive
define('PLUGIN_TREEVIEW_MAX_GLPI', '10.0.99');

/**
 * Init the hooks of the plugins -Needed
 **/
function plugin_init_treeview() {
   global $PLUGIN_HOOKS, $CFG_GLPI;

   $PLUGIN_HOOKS['csrf_compliant']['treeview'] = true;

   Plugin::registerClass('PluginTreeviewPreference', ['addtabon' => ['Preference']]);

   Plugin::registerClass('PluginTreeviewProfile', ['addtabon' => ['Profile']]);

   $PLUGIN_HOOKS['change_profile']['treeview'] = ['PluginTreeviewProfile','changeprofile'];

   if (isset($_SESSION["glpi_plugin_treeview_profile"])
       && $_SESSION["glpi_plugin_treeview_profile"]["treeview"]) {

      $PLUGIN_HOOKS['menu_toadd']['treeview']['tools'] = 'PluginTreeviewPreference';

      $PLUGIN_HOOKS['pre_item_purge']['treeview'] = [
         'Profile' => ['PluginTreeviewProfile', 'cleanProfiles']
      ];

      $PLUGIN_HOOKS['change_entity']['treeview'] = 'plugin_change_entity_Treeview';

      if (isset($_SESSION["glpi_plugin_treeview_loaded"])
          && $_SESSION["glpi_plugin_treeview_loaded"] == 1
          && class_exists('PluginTreeviewConfig')) {

         foreach (PluginTreeviewConfig::getTypes() as $type) {
            $PLUGIN_HOOKS['item_update']['treeview'][$type]  = 'plugin_item_update_treeview';
            $PLUGIN_HOOKS['item_delete']['treeview'][$type]  = 'plugin_treeview_reload';
            $PLUGIN_HOOKS['item_restore']['treeview'][$type] = 'plugin_treeview_reload';
         }
      }

      if ($_SERVER['PHP_SELF'] == $CFG_GLPI["root_doc"]."/front/central.php"
          && (!isset($_SESSION["glpi_plugin_treeview_loaded"])
              || $_SESSION["glpi_plugin_treeview_loaded"] == 0)
          && isset($_SESSION["glpi_plugin_treeview_preference"])
          && $_SESSION["glpi_plugin_treeview_preference"] == 1) {

            Html::redirect(Plugin::getWebDir('treeview')."/index.php");
      }

      if ($_SERVER['PHP_SELF'] == $CFG_GLPI["root_doc"]."/front/logout.php"
          && (isset($_SESSION["glpi_plugin_treeview_loaded"])
          && $_SESSION["glpi_plugin_treeview_loaded"] == 1
          && class_exists('PluginTreeviewConfig'))) {

         $config = new PluginTreeviewConfig();
         $config->hideTreeview();
      }
      // Add specific files to add to the header : javascript or css
      $PLUGIN_HOOKS['add_css']['treeview'] = "css/treeview.css";
   }

   // Config page
   if (Session::haveRight("config", UPDATE) || Session::haveRight("profile", UPDATE)) {
      $PLUGIN_HOOKS['config_page']['treeview'] = 'front/config.form.php';
   }

   $currentPage =  explode("/", $_SERVER['PHP_SELF']);
   if (array_pop($currentPage) == "index.php") {
      $PLUGIN_HOOKS['display_login']['treeview'] = [
         "PluginTreeviewConfig",
         "loginPageToTop"
      ];
   }
}


/**
 * Get the name and the version of the plugin - Needed
**/
function plugin_version_treeview() {

   return [
      'name'         => __('Tree view', 'treeview'),
      'version'      => PLUGIN_TREEVIEW_VERSION,
      'license'      => 'GPLv2+',
      'author'       => 'AL-Rubeiy Hussein, Xavier Caillaud, Nelly Mahu-Lasson',
      'homepage'     => 'https://forge.indepnet.net/projects/treeview',
      'requirements' => [
         'glpi' => [
            'min' => PLUGIN_TREEVIEW_MIN_GLPI,
            'max' => PLUGIN_TREEVIEW_MAX_GLPI,
         ]
      ]

   ];
}
