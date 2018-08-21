<?php
/*
 * @version $Id: setup.php 313 2011-12-19 09:39:58Z remi $
 -------------------------------------------------------------------------
 treeview - TreeView browser plugin for GLPI
 Copyright (C) 2003-2012 by the treeview Development Team.

 https://forge.indepnet.net/projects/treeview
 -------------------------------------------------------------------------

 LICENSE

 This file is part of treeview.

 treeview is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 treeview is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with treeview. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */

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

            Html::redirect($CFG_GLPI["root_doc"]."/plugins/treeview/index.php");
      }

      if ($_SERVER['PHP_SELF'] == $CFG_GLPI["root_doc"]."/front/logout.php"
          && (isset($_SESSION["glpi_plugin_treeview_loaded"])
          && $_SESSION["glpi_plugin_treeview_loaded"] == 1
          && class_exists('PluginTreeviewConfig'))) {

         $config = new PluginTreeviewConfig();
         $config->hideTreeview();
      }
      // Add specific files to add to the header : javascript or css
      $PLUGIN_HOOKS['add_javascript']['treeview']  = "js/dtree.js";
      $PLUGIN_HOOKS['add_css']['treeview']         = "css/dtree.css";
      $PLUGIN_HOOKS['add_javascript']['treeview']  = "js/functions.js";
      $PLUGIN_HOOKS['add_css']['treeview']         = "css/style.css";
      $PLUGIN_HOOKS['add_javascript']['treeview']  = "js/treeview.js";
      $PLUGIN_HOOKS['add_css']['treeview']         = "css/treeview.css";
   }

   // Config page
   if (Session::haveRight("config", UPDATE) || Session::haveRight("profile", UPDATE)) {
      $PLUGIN_HOOKS['config_page']['treeview'] = 'front/config.form.php';
   }
}


/**
 * Get the name and the version of the plugin - Needed
**/
function plugin_version_treeview() {

   return ['name'           => __('Tree view', 'treeview'),
           'version'        => '1.6.2',
           'license'        => 'GPLv2+',
           'author'         => 'AL-Rubeiy Hussein, Xavier Caillaud, Nelly Mahu-Lasson',
           'homepage'       => 'https://forge.indepnet.net/projects/treeview',
           'minGlpiVersion' => '9.2']; // For compatibility
}


function plugin_treeview_check_prerequisites() {
   // Strict version check (could be less strict, or could allow various version)
   if (version_compare(GLPI_VERSION, '9.2', 'lt')) {
      if (method_exists('Plugin', 'messageIncompatible')) {
         echo Plugin::messageIncompatible('core', '9.2');
      } else {
         echo "This plugin requires GLPI >= 9.2";
      }
      return false;
   }
   return true;
}


function plugin_treeview_check_config() {
   return true;
}