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

use Glpi\Application\View\TemplateRenderer;

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
        /**
         * @var array $CFG_GLPI
         */
        global $CFG_GLPI;

        $menu          = [];
        $menu['title'] = __('Tree view', 'treeview');
        $menu['page']  = '/' . $CFG_GLPI['root_doc'] . 'plugins/treeview/public/index.php';
        $menu['icon']  = 'ti ti-sitemap';

        return $menu;
    }

    public function showFormUserPreference($target, $id)
    {
        $this->getFromDB($id);
        TemplateRenderer::getInstance()->display(
            '@treeview/preference.html.twig',
            [
                'target'        => $target,
                'show_on_load'  => $this->fields['show_on_load'],
                'pref_id'       => $id,
            ],
        );

        return true;
    }

    public function checkIfPreferenceExists($users_id)
    {
        /** @var DBmysql $DB */
        global $DB;

        $result = $DB->request([
            'SELECT' => ['id'],
            'FROM'   => 'glpi_plugin_treeview_preferences',
            'WHERE'  => ['users_id' => $users_id],
        ]);
        if (count($result) > 0) {
            return $result->current()['id'];
        }

        return 0;
    }

    public function addDefaultPreference($users_id)
    {
        $input['users_id']     = $users_id;
        $input['show_on_load'] = 0;

        return $this->add($input);
    }

    public function checkPreferenceValue($users_id)
    {
        /** @var DBmysql $DB */
        global $DB;

        $result = $DB->request([
            'SELECT' => ['show_on_load'],
            'FROM'   => 'glpi_plugin_treeview_preferences',
            'WHERE'  => ['users_id' => $users_id],
        ]);
        if (count($result) > 0) {
            return $result->current()['show_on_load'];
        }

        return 0;
    }

    public function getTabNameForItem(CommonGLPI $item, $withtemplate = 0)
    {
        if ($item->getType() == 'Preference') {
            return self::createTabEntry(PluginTreeviewConfig::getTypeName(), 0, $item::getType(), PluginTreeviewConfig::getIcon());
        }

        return '';
    }

    public static function displayTabContentForItem(CommonGLPI $item, $tabnum = 1, $withtemplate = 0)
    {
        if ($item->getType() == 'Preference') {
            $pref    = new self();
            $pref_ID = $pref->checkIfPreferenceExists(Session::getLoginUserID());
            if (!$pref_ID) {
                $pref_ID = $pref->addDefaultPreference(Session::getLoginUserID());
            }
            $pref->showFormUserPreference($pref->getFormURL(), $pref_ID);
        }

        return true;
    }
}
