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
use PluginTreeviewPreference;
use Session;

final class PreferenceTest extends TreeviewTestCase
{
    public function testCheckIfPreferenceExistsIsScopedToOwner(): void
    {
        $this->login();
        $user_a_id = (int) Session::getLoginUserID();
        $pref_a    = new PluginTreeviewPreference();
        $pref_a_id = $pref_a->addDefaultPreference($user_a_id);

        $this->login('normal', 'normal');
        $user_b_id = (int) Session::getLoginUserID();
        $pref_b    = new PluginTreeviewPreference();
        $pref_b_id = $pref_b->addDefaultPreference($user_b_id);

        $this->assertNotEquals($pref_a_id, $pref_b_id);

        // Even if an attacker-controlled value referenced user A's record,
        // resolving "own_id" must always come back to the logged-in user.
        $own_id = $pref_b->checkIfPreferenceExists($user_b_id);
        $this->assertEquals($pref_b_id, $own_id);
        $this->assertNotEquals($pref_a_id, $own_id);
    }

    public function testUpdateScopedToOwnPreferenceDoesNotAffectOtherUser(): void
    {
        $this->login();
        $pref_a    = new PluginTreeviewPreference();
        $pref_a_id = $pref_a->addDefaultPreference((int) Session::getLoginUserID());

        $this->login('normal', 'normal');
        $pref_b    = new PluginTreeviewPreference();
        $pref_b_id = $pref_b->addDefaultPreference((int) Session::getLoginUserID());

        // Reproduces the fixed front/preference.form.php flow: the id used
        // for the update is resolved server-side from the session user,
        // never taken from client-supplied data.
        $own_id = $pref_b->checkIfPreferenceExists(Session::getLoginUserID());
        $this->assertTrue($pref_b->update(['id' => $own_id, 'show_on_load' => 1]));

        $this->assertTrue($pref_a->getFromDB($pref_a_id));
        $this->assertEquals(0, $pref_a->fields['show_on_load']);

        $this->assertTrue($pref_b->getFromDB($pref_b_id));
        $this->assertEquals(1, $pref_b->fields['show_on_load']);
    }
}
