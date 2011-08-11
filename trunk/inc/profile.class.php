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
   die("Sorry. You can't access directly to this file");
}

class PluginTreeviewProfile extends CommonDBTM {


   static function createFirstAccess($ID) {

      $firstProf = new self();
      if (!$firstProf->GetfromDB($ID)) {
         $profile = new Profile();
         $profile->getFromDB($ID);
         $name = $profile->fields["name"];

         $firstProf->add(array('id'        => $ID,
                               'name'      => $name,
                               'treeview'  => 'r'));
      }
   }


   function createAccess($profile) {
      return $this->add(array('id'   => $profile->getField('id'),
                              'name' => $profile->getField('name')));
   }


   static function changeProfile() {

      $prof = new self();
      if ($prof->getFromDB($_SESSION['glpiactiveprofile']['id'])) {
         $_SESSION["glpi_plugin_treeview_profile"] = $prof->fields;
      } else {
         unset($_SESSION["glpi_plugin_treeview_profile"]);
      }

//   require 'preference.class.php';

      $Pref = new PluginTreeviewPreference();
      $pref_value = $Pref->checkPreferenceValue(Session::getLoginUserID());
      if ($pref_value==1) {
         $_SESSION["glpi_plugin_treeview_preference"] = 1;
      } else {
         unset($_SESSION["glpi_plugin_treeview_preference"]);
      }
   }


   /**
    * profiles modification
   **/
   function showForm($id, $options) {
      global $LANG;

      $target = $this->getFormURL();
      if (isset($options['target'])) {
        $target = $options['target'];
      }

      if (!haveRight("profile","r")) {
         return false;
      }
      $canedit = haveRight("profile","w");
      $prof = new Profile();
      if ($id){
         $this->getFromDB($id);
         $prof->getFromDB($id);
      }

      echo "<form action='".$target."' method='post'>";
      echo "<table class='tab_cadre_fixe'>";
      echo "<tr><th colspan='2' class='center b'>".$LANG['plugin_treeview']['profile'][0]." ".
            $this->fields["name"]."</th></tr>";

      echo "<tr class='tab_bg_2'>";
      echo "<td>".$LANG['plugin_treeview']['profile'][1]."&nbsp;:</td><td>";
      Profile::dropdownNoneReadWrite("treeview", $this->fields["treeview"], 1, 1, 0);
      echo "</td></tr>";

      if ($canedit) {
         echo "<tr class='tab_bg_1'>";
         echo "<td class='center' colspan='2'>";
         echo "<input type='hidden' name='id' value=$id>";
         echo "<input type='submit' name='update_user_profile' value='".$LANG['buttons'][7]."'
                class='submit'>";
         echo "</td></tr>";
      }
      echo "</table></form>";
   }


   static function cleanProfiles(Profile $prof) {

      $plugprof = new self();
      $plugprof->delete(array('id' => $prof->getField("id")));
   }
}

?>