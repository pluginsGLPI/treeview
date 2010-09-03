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

function plugin_treeview_install() {
   global $DB;

   // version 1.0
   if (TableExists("glpi_plugin_treeview_display")
       && !TableExists("glpi_plugin_treeview_preference")) {
         plugin_treeview_upgrade10to11();
   }

   // version 1.1
   if (TableExists("glpi_plugin_treeview_profiles")
       && FieldExists("glpi_plugin_treeview_profiles", "interface")) {
      plugin_treeview_upgrade11to12();
   }

   // version 1.2
   if (!TableExists("glpi_plugin_treeview_displayprefs")
       && TableExists("glpi_plugin_treeview_profiles")) {
      plugin_treeview_upgrade12to13();
   }

   // version 1.3
   if (TableExists("glpi_plugin_treeview_preferences")) {
      plugin_treeview_upgrade13to14();
   }

   // not installed
   if (!TableExists("glpi_plugin_treeview_configs")) {

      $query = "CREATE TABLE IF NOT EXISTS `glpi_plugin_treeview_configs` (
                  `id` int(11) NOT NULL auto_increment,
                  `target` varchar(255) NOT NULL default 'right',
                  `folderLinks` tinyint(1) NOT NULL default '0',
                  `useSelection` tinyint(1) NOT NULL default '0',
                  `useLines` tinyint(1) NOT NULL default '0',
                  `useIcons` tinyint(1) NOT NULL default '0',
                  `closeSameLevel` tinyint(1) NOT NULL default '0',
                  `itemName` int(11) NOT NULL default '0',
                  `locationName`  int(11) NOT NULL default '0',
                  PRIMARY KEY (`id`)
                ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ";

      $DB->query($query) or die($DB->error());

      $query = "INSERT INTO `glpi_plugin_treeview_configs`
                     (`id`, `target`, `folderLinks`, `useSelection`, `useLines`, `useIcons`,
                      `closeSameLevel`, `itemName`, `locationName`)
                VALUES ('1','right','1','1','1','1','0', '3', '2');";

      $DB->query($query) or die($DB->error());

      $query = "CREATE TABLE IF NOT EXISTS `glpi_plugin_treeview_profiles` (
                  `id` int(11) NOT NULL auto_increment,
                  `name` varchar(255) collate utf8_unicode_ci default NULL,
                  `treeview` char(1) collate utf8_unicode_ci default NULL,
                  PRIMARY KEY (`id`),
                  KEY `name` (`name`)
                ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ";

      $DB->query($query) or die($DB->error());


      $query = "CREATE TABLE IF NOT EXISTS `glpi_plugin_treeview_preferences` (
                  `id` int(11) NOT NULL auto_increment,
                  `users_id` int(11) NOT NULL default '0' COMMENT 'RELATION to glpi_users (id)',
                  `show_on_load` int(11) NOT NULL default '0',
                  PRIMARY KEY (`id`)
                ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ";

      $DB->query($query) or die($DB->error());

   }

   // No autoload when plugin is not activated
   require 'inc/profile.class.php';

   PluginTreeviewProfile::createFirstAccess($_SESSION['glpiactiveprofile']['id']);
   return true;

}


function plugin_treeview_upgrade10to11() {
   global $DB;

   // plugin tables
   if (!TableExists("glpi_plugin_treeview_preference")) {
      $query = "CREATE TABLE `glpi_plugin_treeview_preference` (
                  `ID` int(11) auto_increment,
                  `user_id` int(11) NOT NULL default '0',
                  `show` varchar(255) NOT NULL default '0',
                  PRIMARY KEY (`ID`)
                ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ";

      $DB->query($query) or die($DB->error());
   }
}


function plugin_treeview_upgrade11to12() {
   global $DB;

   if (TableExists("glpi_plugin_treeview_profiles")) {
      $query = "ALTER TABLE `glpi_plugin_treeview_profiles` ";

      if (FieldExists("glpi_plugin_treeview_profiles", "interface")) {
         $query .= " DROP `delete_frequency`,";
      }
      if (FieldExists("glpi_plugin_treeview_profiles", "is_default")) {
         $query .= " DROP `is_default`";
      }

      $DB->query($query) or die($DB->error());
   }
}


function plugin_treeview_upgrade12to13() {
   global $DB;

   if (TableExists("glpi_plugin_treeview_display")) {
      $DB->query("RENAME TABLE `glpi_plugin_treeview_display` to `glpi_plugin_treeview_displayprefs`");

      $query = "ALTER TABLE `glpi_plugin_treeview_displayprefs` ";

      if (FieldExists("glpi_plugin_treeview_displayprefs", "ID")) {
         $query .= " CHANGE `ID` `id` int(11) NOT NULL auto_increment";
      }
      if (FieldExists("glpi_plugin_treeview_displayprefs", "folderLinks")) {
         $query .= " CHANGE `folderLinks` `folderLinks` tinyint(1) NOT NULL default '0',";
      }
      if (FieldExists("glpi_plugin_treeview_displayprefs", "useSelection")) {
         $query .= " CHANGE `useSelection` `useSelection` tinyint(1) NOT NULL default '0',";
      }
      if (FieldExists("glpi_plugin_treeview_displayprefs", "useLines")) {
         $query .= " CHANGE `useLines` `useLines` tinyint(1) NOT NULL default '0',";
      }
      if (FieldExists("glpi_plugin_treeview_displayprefs", "useIcons")) {
         $query .= " CHANGE `useIcons` `useIcons` tinyint(1) NOT NULL default '0',";
      }
      if (FieldExists("glpi_plugin_treeview_displayprefs", "closeSameLevel")) {
         $query .= " CHANGE `closeSameLevel` `closeSameLevel` tinyint(1) NOT NULL default '0',";
      }
      if (FieldExists("glpi_plugin_treeview_displayprefs", "itemName")) {
         $query .= " CHANGE `itemName` `itemName` int(11) NOT NULL default '0',";
      }
      if (FieldExists("glpi_plugin_treeview_displayprefs", "locationName")) {
         $query .= " CHANGE `locationName` `locationName` int(11) NOT NULL default '0',";
      }
      $query .= " ADD PRIMARY KEY (`id`)";
      $DB->query($query) or die($DB->error());
   }

   if (TableExists("glpi_plugin_treeview_profiles")) {
      $query = "ALTER TABLE `glpi_plugin_treeview_profiles` ";

      if (FieldExists("glpi_plugin_treeview_profiles", "ID")) {
         $query .= " CHANGE `ID` `id` int(11) NOT NULL auto_increment,";
      }
      $DB->query($query) or die($DB->error());
   }

   if (TableExists("glpi_plugin_treeview_preference")) {
      $DB->query("RENAME TABLE `glpi_plugin_treeview_preference` to `glpi_plugin_treeview_preferences`");

      $query = "ALTER TABLE `glpi_plugin_treeview_preferences` ";

      if (FieldExists("glpi_plugin_treeview_preferences", "ID")) {
        $query .= " CHANGE `ID` `id` int(11) NOT NULL auto_increment,";
      }
      if (FieldExists("glpi_plugin_treeview_preferences", "user_id")) {
         $query .= " CHANGE `user_id` `users_id` int(11) NOT NULL default '0' COMMENT 'RELATION to glpi_users (id)',";
      }
      if (FieldExists("glpi_plugin_treeview_preferences", "show")) {
         $query .= " change `show` `show_on_load` int(11) NOT NULL default '0'";
      }
      $DB->query($query) or die($DB->error());
   }
}


function plugin_treeview_upgrade13to14() {
   global $DB;

   if (TableExists("glpi_plugin_treeview_displayprefs")) {
      $query = "RENAME TABLE `glpi_plugin_treeview_displayprefs` to `glpi_plugin_treeview_configs`";
      $DB->query($query) or die($DB->error());
   }
}


function plugin_treeview_uninstall() {
   global $DB;

   $tables = array ("glpi_plugin_treeview_display",
                    "glpi_plugin_treeview_displayprefs",
                    "glpi_plugin_treeview_configs",
                    "glpi_plugin_treeview_profiles",
                    "glpi_plugin_treeview_preference",
                    "glpi_plugin_treeview_preferences");

   foreach ($tables as $table) {
      $query = "DROP TABLE IF EXISTS `$table`;";
      $DB->query($query) or die($DB->error());
   }

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


function plugin_treeview_get_headings($item,$withtemplate) {
   global $LANG, $PLUGIN_HOOKS;

   $type = get_class($item);
   if ($type == 'Preference') {
      return array(1 => $LANG['plugin_treeview']['title'][0]);

   }

   if ($type == 'Profile') {
      if ($item->fields['interface']!='helpdesk') {
         return array(1 => $LANG['plugin_treeview']['title'][0]);
      }
   }
   return false;
}


function plugin_treeview_headings_actions($item) {

   $type = get_class($item);
   switch ($type) {
      case 'Profile' :
         if ($item->getField('interface')!='helpdesk') {
            return array(1 => "plugin_treeview_headings");
         }
         break;

      case 'Preference' :
         return array(1 => "plugin_treeview_headings");
   }
   return false;
}


function plugin_treeview_headings($item, $withtemplate=0) {
   global $CFG_GLPI;

   $type = get_class($item);

   switch ($type) {
      case 'Profile' :
         $prof =  new PluginTreeviewProfile();
         $ID = $item->getField('id');
         if (!$prof->GetfromDB($ID)) {
            $prof->createAccess($item);
         }
         $prof->showForm($ID,
                         array('target' => $CFG_GLPI["root_doc"]."/plugins/treeview/front/profile.php"));
         break;

      case 'Preference' :
         $pref = new PluginTreeviewPreference;
         $pref_ID = $pref->checkIfPreferenceExists($_SESSION['glpiID']);
         if (!$pref_ID) {
             $pref_ID = $pref->addDefaultPreference($_SESSION['glpiID']);
         }
         $pref->showFormUserPreference($CFG_GLPI['root_doc']."/plugins/treeview/front/preference.form.php",
                                       $pref_ID);
         break;
   }
}

?>
