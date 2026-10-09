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
 * Post-install state assertions + idempotence of plugin_treeview_install().
 *
 * The plugin is installed and active in the test database (tests/bootstrap.php);
 * these tests describe what that install produced and make sure re-running the
 * raw install routine on GLPI 12 stays a no-op.
 */
final class InstallationTest extends GLPITestCase
{
    /** Super-Admin, present in every GLPI install. */
    private const SUPER_ADMIN_PROFILE_ID = 4;

    /** table => columns that must be present. */
    private const EXPECTED_SCHEMA = [
        'glpi_plugin_treeview_configs' => [
            'id', 'target', 'folderLinks', 'useSelection', 'useLines',
            'useIcons', 'closeSameLevel', 'itemName', 'locationName',
        ],
        'glpi_plugin_treeview_profiles' => [
            'id', 'name', 'treeview',
        ],
        'glpi_plugin_treeview_preferences' => [
            'id', 'users_id', 'show_on_load',
        ],
    ];

    public function testPluginTargetsGlpi12(): void
    {
        $this->assertSame('12.0.0', PLUGIN_TREEVIEW_MIN_GLPI);
        $this->assertSame('12.0.99', PLUGIN_TREEVIEW_MAX_GLPI);
    }

    public function testPluginTablesAndColumnsExist(): void
    {
        /** @var DBmysql $DB */
        global $DB;

        foreach (self::EXPECTED_SCHEMA as $table => $columns) {
            $this->assertTrue($DB->tableExists($table), "missing table {$table}");
            foreach ($columns as $column) {
                $this->assertTrue(
                    $DB->fieldExists($table, $column),
                    "missing column {$table}.{$column}",
                );
            }
        }

        // Legacy tables renamed / dropped by the upgrade path must be gone.
        foreach (['glpi_plugin_treeview_display', 'glpi_plugin_treeview_displayprefs', 'glpi_plugin_treeview_preference'] as $legacy) {
            $this->assertFalse($DB->tableExists($legacy), "legacy table {$legacy} still present");
        }
    }

    public function testDefaultConfigRowIsSeeded(): void
    {
        $config = new PluginTreeviewConfig();

        $this->assertTrue($config->getFromDB(1), 'config row id=1 was not seeded by install');
        $this->assertSame(1, countElementsInTable('glpi_plugin_treeview_configs'));

        foreach (['target', 'folderLinks', 'useSelection', 'useLines', 'useIcons', 'closeSameLevel', 'itemName', 'locationName'] as $field) {
            $this->assertArrayHasKey($field, $config->fields);
        }
        $this->assertContains($config->fields['target'], ['right', '_blank']);
    }

    public function testInstallScriptIsIdempotent(): void
    {
        /** @var DBmysql $DB */
        global $DB;

        // plugin_treeview_install() reads the active profile id from the session.
        $previous_profile = $_SESSION['glpiactiveprofile'] ?? null;
        $_SESSION['glpiactiveprofile']['id'] = self::SUPER_ADMIN_PROFILE_ID;

        $ob_level = ob_get_level();
        try {
            // First re-run may still grant first-access to the stubbed profile;
            // compare the state between two consecutive extra runs.
            $this->assertTrue($this->runInstall());
            $configs_after_1  = countElementsInTable('glpi_plugin_treeview_configs');
            $profiles_after_1 = countElementsInTable('glpi_plugin_treeview_profiles');

            $this->assertTrue($this->runInstall());
        } finally {
            while (ob_get_level() > $ob_level) {
                ob_end_clean();
            }
            if ($previous_profile === null) {
                unset($_SESSION['glpiactiveprofile']);
            } else {
                $_SESSION['glpiactiveprofile'] = $previous_profile;
            }
        }

        $DB->clearSchemaCache();
        foreach (array_keys(self::EXPECTED_SCHEMA) as $table) {
            $this->assertTrue($DB->tableExists($table));
        }
        $this->assertSame($configs_after_1, countElementsInTable('glpi_plugin_treeview_configs'));
        $this->assertSame($profiles_after_1, countElementsInTable('glpi_plugin_treeview_profiles'));
        $this->assertSame(1, countElementsInTable('glpi_plugin_treeview_configs'));
    }

    private function runInstall(): bool
    {
        $ob_level = ob_get_level();
        try {
            ob_start();
            return plugin_treeview_install();
        } finally {
            while (ob_get_level() > $ob_level) {
                ob_end_clean();
            }
        }
    }
}
