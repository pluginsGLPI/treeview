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

namespace GlpiPlugin\Treeview\Tests\Units;

use DBmysql;
use Glpi\Tests\GLPITestCase;
use PluginTreeviewConfig;

/**
 * Real plugin_treeview_uninstall() run, followed by a reinstall in finally so
 * the shared test database is left in its original state for the other suites.
 */
final class UninstallationTest extends GLPITestCase
{
    private const SUPER_ADMIN_PROFILE_ID = 4;

    private const PLUGIN_TABLES = [
        'glpi_plugin_treeview_configs',
        'glpi_plugin_treeview_profiles',
        'glpi_plugin_treeview_preferences',
    ];

    public function testUninstallDropsTablesThenReinstallRestoresThem(): void
    {
        /** @var DBmysql $DB */
        global $DB;

        foreach (self::PLUGIN_TABLES as $table) {
            $this->assertTrue($DB->tableExists($table), "precondition: {$table} should exist");
        }

        $previous_profile = $_SESSION['glpiactiveprofile'] ?? null;
        $_SESSION['glpiactiveprofile']['id'] = self::SUPER_ADMIN_PROFILE_ID;

        $ob_level = ob_get_level();
        try {
            // plugin_treeview_uninstall() has no return value; success is
            // observed through the dropped tables below.
            ob_start();
            plugin_treeview_uninstall();
            while (ob_get_level() > $ob_level) {
                ob_end_clean();
            }
            $DB->clearSchemaCache();

            foreach (self::PLUGIN_TABLES as $table) {
                $this->assertFalse($DB->tableExists($table), "{$table} not dropped by uninstall");
            }
        } finally {
            ob_start();
            $reinstalled = plugin_treeview_install();
            while (ob_get_level() > $ob_level) {
                ob_end_clean();
            }
            $DB->clearSchemaCache();

            if ($previous_profile === null) {
                unset($_SESSION['glpiactiveprofile']);
            } else {
                $_SESSION['glpiactiveprofile'] = $previous_profile;
            }
        }

        $this->assertTrue($reinstalled, 'reinstall failed - test database left without treeview tables');
        foreach (self::PLUGIN_TABLES as $table) {
            $this->assertTrue($DB->tableExists($table), "{$table} not recreated by reinstall");
        }

        $config = new PluginTreeviewConfig();
        $this->assertTrue($config->getFromDB(1), 'reinstall did not re-seed config row id=1');
    }
}
