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

if (!defined('GLPI_ROOT')) {
    die("Sorry. You can't access directly to this file");
}

/**
 * class plugin_treeview_preference
 * Load and store the preference configuration from the database
**/
class PluginTreeviewPreference extends CommonDBTM
{
    public static function getMenuContent()
    {
        $menu          = [];
        $menu['title'] = __('Tree view', 'treeview');
        $menu['page']  = '/' . Plugin::getWebDir('treeview', false) . '/index.php';
        $menu['icon']  = 'fas fa-sitemap';
        return $menu;
    }

    public function showFormUserPreference($target, $id)
    {

        $data = plugin_version_treeview();
        $this->getFromDB($id);
        echo "<form action='" . $target . "' method='post'>";
        echo "<table class='tab_cadre_fixe' cellpadding='5'>";
        echo "<tr><th colspan='2'>" . sprintf(__('%1$s - %2$s'), $data['name'], $data['version']);
        echo "</th></tr>";

        echo "<tr class='tab_bg_1 center'>";
        echo "<td>" . __('Launch the plugin Treeview with GLPI launching', 'treeview') . "</td>";
        echo "<td>";
        Dropdown::showYesNo("show_on_load", $this->fields["show_on_load"]);
        echo "</td></tr>";

        echo "<tr class='tab_bg_1 center'><td colspan='2'>";
        echo "<input type='submit' name='plugin_treeview_user_preferences_save' value='" .
             _sx('button', 'Post') . "' class='submit'>";
        echo "<input type='hidden' name='id' value='$id'></td></tr>";

        echo "<tr class='tab_bg_1 center'>";
        echo "<td colspan='2'>" . __('Warning: If there are more than one plugin which be loaded at startup, then only the first will be used', 'treeview');
        echo "</td></tr>";

        echo "</table>";
        Html::closeForm();
    }


    public function checkIfPreferenceExists($users_id)
    {
        /** @var DBmysql $DB */
        global $DB;

        $result = $DB->request([
            'SELECT' => ['id'],
            'FROM'   => 'glpi_plugin_treeview_preferences',
            'WHERE'  => ['users_id' => $users_id]
        ]);
        if (count($result) > 0) {
            return $result->current()['id'];
        }
        return 0;
    }


    public function addDefaultPreference($users_id)
    {

        $input["users_id"]     = $users_id;
        $input["show_on_load"] = 0;

        return $this->add($input);
    }


    public function checkPreferenceValue($users_id)
    {
        /** @var DBmysql $DB */
        global $DB;

        $result = $DB->request([
            'SELECT' => ['show_on_load'],
            'FROM'   => 'glpi_plugin_treeview_preferences',
            'WHERE'  => ['users_id' => $users_id]
        ]);
        if (count($result) > 0) {
            return $result->current()['show_on_load'];
        }
        return 0;
    }


    public function getTabNameForItem(CommonGLPI $item, $withtemplate = 0)
    {

        if ($item->getType() == 'Preference') {
            return __('Tree view', 'treeview');
        }
        return '';
    }


    public static function displayTabContentForItem(CommonGLPI $item, $tabnum = 1, $withtemplate = 0)
    {

        if ($item->getType() == 'Preference') {
            $pref = new self();
            $pref_ID = $pref->checkIfPreferenceExists(Session::getLoginUserID());
            if (!$pref_ID) {
                $pref_ID = $pref->addDefaultPreference(Session::getLoginUserID());
            }
            $pref->showFormUserPreference($pref->getFormURL(), $pref_ID);
        }
        return true;
    }
}
