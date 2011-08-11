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

/**
 * Init the hooks of the plugins -Needed
 **/
function plugin_init_treeview() {
   global $PLUGIN_HOOKS, $CFG_GLPI;

   $PLUGIN_HOOKS['change_profile']['treeview'] = array('PluginTreeviewProfile','changeprofile');

   if (isset($_SESSION["glpi_plugin_treeview_profile"])
       && $_SESSION["glpi_plugin_treeview_profile"]["treeview"]) {

      $PLUGIN_HOOKS['menu_entry']['treeview'] = true;

      $PLUGIN_HOOKS['headings']['treeview']        = 'plugin_treeview_get_headings';
      $PLUGIN_HOOKS['headings_action']['treeview'] = 'plugin_treeview_headings_actions';

      $PLUGIN_HOOKS['pre_item_purge']['treeview']
                              = array('Profile' => array('PluginTreeviewProfile','cleanProfiles'));

      $PLUGIN_HOOKS['change_entity']['treeview'] = 'plugin_change_entity_Treeview';

      if (isset($_SESSION["glpi_plugin_treeview_loaded"])
          && $_SESSION["glpi_plugin_treeview_loaded"] == 1) {

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

            glpi_header(GLPI_ROOT."/plugins/treeview/index.php");
      }

      if ($_SERVER['PHP_SELF'] == $CFG_GLPI["root_doc"]."/logout.php"
          && (isset($_SESSION["glpi_plugin_treeview_loaded"])
          && $_SESSION["glpi_plugin_treeview_loaded"] == 1)) {

         $config = new PluginTreeviewConfig();
         $config->hideTreeview();
      }
      // Add specific files to add to the header : javascript or css
      $PLUGIN_HOOKS['add_javascript']['treeview']  = "dtree.js";
      $PLUGIN_HOOKS['add_css']['treeview']         = "dtree.css";
      $PLUGIN_HOOKS['add_javascript']['treeview']  = "functions.js";
      $PLUGIN_HOOKS['add_css']['treeview']         = "style.css";
      $PLUGIN_HOOKS['add_javascript']['treeview']  = "treeview.js";
      $PLUGIN_HOOKS['add_css']['treeview']         = "treeview.css";
   }

   // Config page
   if (Session::haveRight("config","w") || Session::haveRight("profile", "w")) {
      $PLUGIN_HOOKS['config_page']['treeview'] = 'front/config.form.php';
   }
}


/**
 * Get the name and the version of the plugin - Needed
**/
function plugin_version_treeview() {
   global $LANG;

   return array('name'           => $LANG['plugin_treeview']['title'][0],
                'version'        => '1.6.0',
                'author'         => 'AL-Rubeiy Hussein, Xavier Caillaud, Nelly Mahu-Lasson',
                'homepage'       => 'https://forge.indepnet.net/projects/show/treeview',
                'minGlpiVersion' => '0.83'); // For compatibility / no install in version < 0.78
}


function plugin_treeview_check_prerequisites() {

   if (version_compare(GLPI_VERSION,'0.83','lt') || version_compare(GLPI_VERSION,'0.84','ge')) {
      echo "This plugin requires GLPI >= 0.83 and GLPI < 0.84";
      return false;
   }
   return true;
}


function plugin_treeview_check_config() {
   return true;
}

?>