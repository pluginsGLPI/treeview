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
use PluginTreeviewProfile;
use Profile;

/**
 * Profile access mechanism used by plugin_treeview_install() (createFirstAccess)
 * and by the PRE_ITEM_PURGE hook (cleanProfiles). Transactional: every write is
 * rolled back at tearDown.
 */
final class ProfileTest extends TreeviewTestCase
{
    private function makeProfile(): Profile
    {
        return $this->createItem(Profile::class, [
            'name' => 'treeview_' . $this->getUniqueString(),
        ]);
    }

    public function testCreateFirstAccessGrantsReadRight(): void
    {
        $this->login();
        $profile_id = (int) $this->makeProfile()->getID();

        PluginTreeviewProfile::createFirstAccess($profile_id);

        $row = new PluginTreeviewProfile();
        $this->assertTrue($row->getFromDB($profile_id), 'no plugin row created for the profile');
        $this->assertSame('r', $row->fields['treeview']);
    }

    public function testCreateFirstAccessIsIdempotent(): void
    {
        $this->login();
        $profile_id = (int) $this->makeProfile()->getID();

        PluginTreeviewProfile::createFirstAccess($profile_id);
        PluginTreeviewProfile::createFirstAccess($profile_id);

        $this->assertSame(
            1,
            countElementsInTable('glpi_plugin_treeview_profiles', ['id' => $profile_id]),
        );
    }

    public function testCleanProfilesRemovesRowWhenProfileIsPurged(): void
    {
        $this->login();
        $profile    = $this->makeProfile();
        $profile_id = (int) $profile->getID();

        PluginTreeviewProfile::createFirstAccess($profile_id);
        $this->assertSame(1, countElementsInTable('glpi_plugin_treeview_profiles', ['id' => $profile_id]));

        PluginTreeviewProfile::cleanProfiles($profile);

        $this->assertSame(0, countElementsInTable('glpi_plugin_treeview_profiles', ['id' => $profile_id]));
    }
}
