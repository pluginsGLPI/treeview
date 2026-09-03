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

use Computer;
use Entity;
use GlpiPlugin\Treeview\Tests\TreeviewTestCase;
use Location;
use Profile;
use ProfileRight;

final class ConfigTest extends TreeviewTestCase
{
    public function testGetNodesFromDbOnlyShowsActiveEntityData(): void
    {
        $this->login();
        $root_id = $this->getTestRootEntity(true);

        $entity_a = $this->createItem(Entity::class, [
            'name'        => 'treeview_entity_a_' . $this->getUniqueString(),
            'entities_id' => $root_id,
        ]);
        $entity_b = $this->createItem(Entity::class, [
            'name'        => 'treeview_entity_b_' . $this->getUniqueString(),
            'entities_id' => $root_id,
        ]);

        $location_a = $this->createItem(Location::class, [
            'name'        => 'treeview_loc_a_' . $this->getUniqueString(),
            'entities_id' => $entity_a->getID(),
        ]);
        $location_b = $this->createItem(Location::class, [
            'name'        => 'treeview_loc_b_' . $this->getUniqueString(),
            'entities_id' => $entity_b->getID(),
        ]);

        $computer_a = $this->createItem(Computer::class, [
            'name'         => 'treeview_computer_a_' . $this->getUniqueString(),
            'entities_id'  => $entity_a->getID(),
            'locations_id' => $location_a->getID(),
        ]);
        $computer_b = $this->createItem(Computer::class, [
            'name'         => 'treeview_computer_b_' . $this->getUniqueString(),
            'entities_id'  => $entity_b->getID(),
            'locations_id' => $location_b->getID(),
        ]);

        // Switch active entity A only (not recursive).
        $this->setEntity($entity_a->getID(), false);

        $output = $this->getTreeOutput($location_a->getID());

        $this->assertStringContainsString($computer_a->fields['name'], $output);
        $this->assertStringNotContainsString($computer_b->fields['name'], $output);
        $this->assertStringNotContainsString($location_b->fields['name'], $output);
    }

    public function testGetNodesFromDbHidesItemtypeWithoutViewRight(): void
    {
        $this->login();
        $entity_id = $this->getTestRootEntity(true);

        $location = $this->createItem(Location::class, [
            'name'        => 'treeview_loc_' . $this->getUniqueString(),
            'entities_id' => $entity_id,
        ]);
        $computer = $this->createItem(Computer::class, [
            'name'         => 'treeview_computer_' . $this->getUniqueString(),
            'entities_id'  => $entity_id,
            'locations_id' => $location->getID(),
        ]);

        $super_admin_id  = getItemByTypeName(Profile::class, 'Super-Admin', true);
        $original_rights = ProfileRight::getProfileRights($super_admin_id, [Computer::$rightname]);

        // remove all rights to view computers
        ProfileRight::updateProfileRights($super_admin_id, [
            Computer::$rightname => $original_rights[Computer::$rightname] & ~(READ),
        ]);
        try {
            $this->login('glpi');
            $this->setEntity($entity_id, false);
            $output = $this->getTreeOutput($location->getID());

            $this->assertStringNotContainsString($computer->fields['name'], $output);
        } finally {
            ProfileRight::updateProfileRights($super_admin_id, [
                Computer::$rightname => $original_rights[Computer::$rightname],
            ]);
        }
    }
}
