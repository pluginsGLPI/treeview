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

use GlpiPlugin\Treeview\Tests\TreeviewTestCase;
use PluginTreeviewConfig;
use PluginTreeviewPreference;
use PluginTreeviewProfile;
use Session;

/**
 * Smoke tests for the three Twig forms of the plugin.
 *
 * On GLPI 12 CSRF tokens are injected transparently: the templates no longer
 * carry a `_glpi_csrf_token` hidden input nor call the deprecated
 * `Session::getNewCSRFToken()`. GLPITestCase::tearDown() turns any deprecation
 * or logged error raised while rendering into a test failure, so simply
 * rendering each form guards the migration.
 */
final class FormRenderingTest extends TreeviewTestCase
{
    private function render(callable $renderer): string
    {
        $ob_level = ob_get_level();
        try {
            ob_start();
            $renderer();
            return (string) ob_get_clean();
        } catch (\Throwable $e) {
            while (ob_get_level() > $ob_level) {
                ob_end_clean();
            }
            throw $e;
        }
    }

    public function testConfigFormRenders(): void
    {
        $this->login();

        $config = new PluginTreeviewConfig();
        $html   = $this->render(static fn() => $config->showConfigForm());

        $this->assertStringContainsString('<form', $html);
        $this->assertMatchesRegularExpression('/name=[\'"]target[\'"]/', $html);
        $this->assertStringNotContainsString('_glpi_csrf_token', $html);
    }

    public function testProfileFormRenders(): void
    {
        $this->login();
        $profile_id = (int) $_SESSION['glpiactiveprofile']['id'];

        $plugin_profile = new PluginTreeviewProfile();
        if (!$plugin_profile->getFromDB($profile_id)) {
            $plugin_profile->add(['id' => $profile_id, 'name' => 'treeview_test', 'treeview' => 'r']);
        }

        $html = $this->render(static fn() => $plugin_profile->showForm($profile_id));

        $this->assertStringContainsString('<form', $html);
        $this->assertMatchesRegularExpression('/name=[\'"]treeview[\'"]/', $html);
        $this->assertStringNotContainsString('_glpi_csrf_token', $html);
    }

    public function testPreferenceFormRenders(): void
    {
        $this->login();

        $pref    = new PluginTreeviewPreference();
        $pref_id = $pref->addDefaultPreference((int) Session::getLoginUserID());
        $this->assertGreaterThan(0, $pref_id);

        $html = $this->render(static fn() => $pref->showFormUserPreference($pref->getFormURL(), $pref_id));

        $this->assertStringContainsString('<form', $html);
        $this->assertMatchesRegularExpression('/name=[\'"]show_on_load[\'"]/', $html);
        $this->assertStringNotContainsString('_glpi_csrf_token', $html);
    }
}
