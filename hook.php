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

function plugin_treeview_install() {
   global $DB;

   $default_charset = DBConnection::getDefaultCharset();
   $default_collation = DBConnection::getDefaultCollation();
   $default_key_sign = DBConnection::getDefaultPrimaryKeySignOption();

   // version 1.0
   if ($DB->tableExists("glpi_plugin_treeview_display")
       && !$DB->tableExists("glpi_plugin_treeview_preference")) {
         plugin_treeview_upgrade10to11();
   }

   // version 1.1
   if ($DB->tableExists("glpi_plugin_treeview_profiles")
       && $DB->fieldExists("glpi_plugin_treeview_profiles", "interface")) {
      plugin_treeview_upgrade11to12();
   }

   // version 1.2
   if (!$DB->tableExists("glpi_plugin_treeview_displayprefs")
       && $DB->tableExists("glpi_plugin_treeview_profiles")) {
      plugin_treeview_upgrade12to13();
   }

   // version 1.3
   if ($DB->tableExists("glpi_plugin_treeview_preferences")) {
      plugin_treeview_upgrade13to14();
   }

   // not installed
   if (!$DB->tableExists("glpi_plugin_treeview_configs")) {
      $query = "CREATE TABLE IF NOT EXISTS `glpi_plugin_treeview_configs` (
                  `id` int {$default_key_sign} NOT NULL auto_increment,
                  `target` varchar(255) NOT NULL default 'right',
                  `folderLinks` tinyint NOT NULL default '0',
                  `useSelection` tinyint NOT NULL default '0',
                  `useLines` tinyint NOT NULL default '0',
                  `useIcons` tinyint NOT NULL default '0',
                  `closeSameLevel` tinyint NOT NULL default '0',
                  `itemName` int NOT NULL default '0',
                  `locationName`  int NOT NULL default '0',
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET={$default_charset} COLLATE={$default_collation} ROW_FORMAT=DYNAMIC;";

      $DB->query($query) or die($DB->error());

      $DB->insertOrDie('glpi_plugin_treeview_configs', [
         'id' => 1,
         'target' => 'right',
         'folderLinks' => 1,
         'useSelection' => 1,
         'useLines' => 1,
         'useIcons' => 1,
         'closeSameLevel' => 0,
         'itemName' => 3,
         'locationName' => 2
      ]);

      $query = "CREATE TABLE IF NOT EXISTS `glpi_plugin_treeview_profiles` (
                  `id` int {$default_key_sign} NOT NULL auto_increment,
                  `name` varchar(255) default NULL,
                  `treeview` char(1) default NULL,
                  PRIMARY KEY (`id`),
                  KEY `name` (`name`)
                ) ENGINE=InnoDB DEFAULT CHARSET={$default_charset} COLLATE={$default_collation} ROW_FORMAT=DYNAMIC;";

      $DB->query($query) or die($DB->error());

      $query = "CREATE TABLE IF NOT EXISTS `glpi_plugin_treeview_preferences` (
                  `id` int {$default_key_sign} NOT NULL auto_increment,
                  `users_id` int {$default_key_sign} NOT NULL default '0' COMMENT 'RELATION to glpi_users (id)',
                  `show_on_load` int NOT NULL default '0',
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET={$default_charset} COLLATE={$default_collation} ROW_FORMAT=DYNAMIC;";

      $DB->query($query) or die($DB->error());

   }

   // No autoload when plugin is not activated
   require 'inc/profile.class.php';

   PluginTreeviewProfile::createFirstAccess($_SESSION['glpiactiveprofile']['id']);
   return true;

}


function plugin_treeview_upgrade10to11() {
   global $DB;

   $default_charset = DBConnection::getDefaultCharset();
   $default_collation = DBConnection::getDefaultCollation();
   $default_key_sign = DBConnection::getDefaultPrimaryKeySignOption();

   // plugin tables
   if (!$DB->tableExists("glpi_plugin_treeview_preference")) {
      $query = "CREATE TABLE `glpi_plugin_treeview_preference` (
                  `ID` int {$default_key_sign} auto_increment,
                  `user_id` int {$default_key_sign} NOT NULL default '0',
                  `show` varchar(255) NOT NULL default '0',
                  PRIMARY KEY (`ID`)
                ) ENGINE=InnoDB DEFAULT CHARSET={$default_charset} COLLATE={$default_collation} ROW_FORMAT=DYNAMIC;";

      $DB->query($query) or die($DB->error());
   }
}


function plugin_treeview_upgrade11to12() {
   global $DB;

   if ($DB->tableExists("glpi_plugin_treeview_profiles")) {
      $query = "ALTER TABLE `glpi_plugin_treeview_profiles` ";

      if ($DB->fieldExists("glpi_plugin_treeview_profiles", "interface")) {
         $query .= " DROP `interface`,";
      }
      if ($DB->fieldExists("glpi_plugin_treeview_profiles", "is_default")) {
         $query .= " DROP `is_default`";
      }

      $DB->query($query) or die($DB->error());
   }
}


function plugin_treeview_upgrade12to13() {
   global $DB;

   $default_key_sign = DBConnection::getDefaultPrimaryKeySignOption();

   if ($DB->tableExists("glpi_plugin_treeview_display")) {
      $DB->query("RENAME TABLE `glpi_plugin_treeview_display` to `glpi_plugin_treeview_displayprefs`");

      $query = "ALTER TABLE `glpi_plugin_treeview_displayprefs` ";

      if ($DB->fieldExists("glpi_plugin_treeview_displayprefs", "ID")) {
         $query .= " CHANGE `ID` `id` int {$default_key_sign} NOT NULL auto_increment,";
      }
      if ($DB->fieldExists("glpi_plugin_treeview_displayprefs", "folderLinks")) {
         $query .= " CHANGE `folderLinks` `folderLinks` tinyint NOT NULL default '0',";
      }
      if ($DB->fieldExists("glpi_plugin_treeview_displayprefs", "useSelection")) {
         $query .= " CHANGE `useSelection` `useSelection` tinyint NOT NULL default '0',";
      }
      if ($DB->fieldExists("glpi_plugin_treeview_displayprefs", "useLines")) {
         $query .= " CHANGE `useLines` `useLines` tinyint NOT NULL default '0',";
      }
      if ($DB->fieldExists("glpi_plugin_treeview_displayprefs", "useIcons")) {
         $query .= " CHANGE `useIcons` `useIcons` tinyint NOT NULL default '0',";
      }
      if ($DB->fieldExists("glpi_plugin_treeview_displayprefs", "closeSameLevel")) {
         $query .= " CHANGE `closeSameLevel` `closeSameLevel` tinyint NOT NULL default '0',";
      }
      if ($DB->fieldExists("glpi_plugin_treeview_displayprefs", "itemName")) {
         $query .= " CHANGE `itemName` `itemName` int NOT NULL default '0',";
      }
      if ($DB->fieldExists("glpi_plugin_treeview_displayprefs", "locationName")) {
         $query .= " CHANGE `locationName` `locationName` int NOT NULL default '0'";
      }

      $DB->query($query) or die($DB->error());
   }

   if ($DB->tableExists("glpi_plugin_treeview_profiles")) {
      $query = "ALTER TABLE `glpi_plugin_treeview_profiles` ";

      if ($DB->fieldExists("glpi_plugin_treeview_profiles", "ID")) {
         $query .= " CHANGE `ID` `id` int {$default_key_sign} NOT NULL auto_increment";
      }
      $DB->query($query) or die($DB->error());
   }

   if ($DB->tableExists("glpi_plugin_treeview_preference")) {
      $DB->query("RENAME TABLE `glpi_plugin_treeview_preference` to `glpi_plugin_treeview_preferences`");

      $query = "ALTER TABLE `glpi_plugin_treeview_preferences` ";

      if ($DB->fieldExists("glpi_plugin_treeview_preferences", "ID")) {
         $query .= " CHANGE `ID` `id` int {$default_key_sign} NOT NULL auto_increment,";
      }
      if ($DB->fieldExists("glpi_plugin_treeview_preferences", "user_id")) {
         $query .= " CHANGE `user_id` `users_id` int {$default_key_sign} NOT NULL default '0' COMMENT 'RELATION to glpi_users (id)',";
      }
      if ($DB->fieldExists("glpi_plugin_treeview_preferences", "show")) {
         $query .= " CHANGE `show` `show_on_load` int NOT NULL default '0'";
      }
      $DB->query($query) or die($DB->error());
   }
}


function plugin_treeview_upgrade13to14() {
   global $DB;

   if ($DB->tableExists("glpi_plugin_treeview_displayprefs")) {
      $query = "RENAME TABLE `glpi_plugin_treeview_displayprefs` to `glpi_plugin_treeview_configs`";
      $DB->query($query) or die($DB->error());
   }
}


function plugin_treeview_uninstall() {
   global $DB;

   $tables =  ["glpi_plugin_treeview_display",
               "glpi_plugin_treeview_displayprefs",
               "glpi_plugin_treeview_configs",
               "glpi_plugin_treeview_profiles",
               "glpi_plugin_treeview_preference",
               "glpi_plugin_treeview_preferences"];

   foreach ($tables as $table) {
      $query = "DROP TABLE IF EXISTS `$table`;";
      $DB->query($query) or die($DB->error());
   }

   unset($_SESSION['glpimenu']['plugins']['content']['plugintreeviewpreference']);

}


// Hook done on before update item case
function plugin_item_update_treeview($item) {

   if (in_array('locations_id', $item->updates)) {
      echo "<script type='text/javascript'>parent.left.location.reload(true);</script>";
   }
}


/*
 * non affichage des objets mis à la corbeille
 */
function plugin_treeview_reload($item) {
   echo "<script type='text/javascript'>parent.left.location.reload(true);</script>";
}


function plugin_change_entity_Treeview() {

   if ($_SESSION['glpiactiveprofile']['interface'] == 'central'
       && (isset($_SESSION["glpi_plugin_treeview_loaded"])
       && $_SESSION["glpi_plugin_treeview_loaded"] == 1)) {

      echo "<script type='text/javascript'>parent.left.location.reload(true);</script>";
   }
}
