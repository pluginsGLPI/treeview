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

use Glpi\Plugin\Hooks;

define('PLUGIN_TREEVIEW_VERSION', '1.20.0-beta1');
define('PLUGIN_TREEVIEW_MIN_GLPI', '11.0.0');
define('PLUGIN_TREEVIEW_MAX_GLPI', '11.0.99');

function plugin_init_treeview()
{
    /**
     * @var array $PLUGIN_HOOKS
     * @var array $CFG_GLPI
     */
    global $PLUGIN_HOOKS, $CFG_GLPI;

    $PLUGIN_HOOKS['csrf_compliant']['treeview'] = true;

    Plugin::registerClass(PluginTreeviewPreference::class, ['addtabon' => [Preference::class]]);
    Plugin::registerClass(PluginTreeviewProfile::class, ['addtabon' => [Profile::class]]);
    Plugin::registerClass(PluginTreeviewConfig::class, ['addtabon' => [Config::class]]);

    $PLUGIN_HOOKS[Hooks::CHANGE_PROFILE]['treeview'] = [PluginTreeviewProfile::class, 'changeprofile'];

    if (
        isset($_SESSION['glpi_plugin_treeview_profile'])
        && $_SESSION['glpi_plugin_treeview_profile']['treeview']
    ) {
        $PLUGIN_HOOKS[Hooks::MENU_TOADD]['treeview']['tools'] = PluginTreeviewPreference::class;

        $PLUGIN_HOOKS[Hooks::PRE_ITEM_PURGE]['treeview'] = [
            'Profile' => [PluginTreeviewProfile::class, 'cleanProfiles'],
        ];

        $PLUGIN_HOOKS[Hooks::CHANGE_ENTITY]['treeview'] = 'plugin_change_entity_Treeview';

        if (
            isset($_SESSION['glpi_plugin_treeview_loaded'])
            && $_SESSION['glpi_plugin_treeview_loaded'] == 1
            && class_exists(PluginTreeviewConfig::class)
        ) {
            foreach (PluginTreeviewConfig::getTypes() as $type) {
                $PLUGIN_HOOKS[Hooks::ITEM_UPDATE]['treeview'][$type]  = 'plugin_item_update_treeview';
                $PLUGIN_HOOKS[Hooks::ITEM_DELETE]['treeview'][$type]  = 'plugin_treeview_reload';
                $PLUGIN_HOOKS[Hooks::ITEM_RESTORE]['treeview'][$type] = 'plugin_treeview_reload';
            }
        }

        if (
            $_SERVER['PHP_SELF'] == $CFG_GLPI['root_doc'] . '/front/central.php'
            && (!isset($_SESSION['glpi_plugin_treeview_loaded'])
              || $_SESSION['glpi_plugin_treeview_loaded'] == 0)
            && isset($_SESSION['glpi_plugin_treeview_preference'])
            && $_SESSION['glpi_plugin_treeview_preference'] == 1
        ) {
            Html::redirect($CFG_GLPI['root_doc'] . '/plugins/treeview/public/index.php');
        }

        if (
            $_SERVER['PHP_SELF'] == $CFG_GLPI['root_doc'] . '/front/logout.php'
            && (isset($_SESSION['glpi_plugin_treeview_loaded'])
            && $_SESSION['glpi_plugin_treeview_loaded'] == 1
            && class_exists(PluginTreeviewConfig::class))
        ) {
            $config = new PluginTreeviewConfig();
            $config->hideTreeview();
        }
        // Add specific files to add to the header : javascript or css
        $PLUGIN_HOOKS[Hooks::ADD_CSS]['treeview'] = 'public/css/treeview.css';
    }

    // Config page
    if (Session::haveRight('config', UPDATE)) {
        $PLUGIN_HOOKS[Hooks::CONFIG_PAGE]['treeview'] = '../../front/config.form.php?forcetab=PluginTreeviewConfig$1';
    }

    $currentPage = explode('/', $_SERVER['PHP_SELF']);
    if (array_pop($currentPage) == 'index.php') {
        $PLUGIN_HOOKS[Hooks::DISPLAY_LOGIN]['treeview'] = [
            'PluginTreeviewConfig',
            'loginPageToTop',
        ];
    }
}

function plugin_treeview_check_prerequisites()
{
    if (!is_readable(__DIR__ . '/vendor/autoload.php') || !is_file(__DIR__ . '/vendor/autoload.php')) {
        echo "Run composer install --no-dev in the plugin directory<br>";
        return false;
    }

    return true;
}


/**
 * Get the name and the version of the plugin - Needed
**/
function plugin_version_treeview()
{
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
            ],
        ],

    ];
}
