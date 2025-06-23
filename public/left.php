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

Session::checkLoginUser();

/**
 * @var array $CFG_GLPI
 */
global $CFG_GLPI;

Html::includeHeader('TreeView');

echo "<body style='overflow:auto; overflow:initial;'>";
// Title bar
echo '<div id="explorer_bar" class="d-flex justify-content-between align-items-center  border-bottom">';
echo '<div id=explorer_title>';
echo '<i class="ti ti-sitemap me-2"></i>';
echo '<span class="menu-label">' . __('Tree view', 'treeview') . '</span>';
echo '</div>';
echo '<div id=explorer_close>';

echo "<span role='button' name='explorer_close' class='btn btn-sm btn-ghost-secondary me-1 pe-2' onclick='parent.location.href = parent.right.location.href;''>";
echo "<i class='ti ti-square-rounded-x'></i>";
echo "</span>";
echo '</div>';

echo '</div>';


echo "<form method='get' name='get_level' action='" . $CFG_GLPI['root_doc'] . '/plugins/treeview/left.php' . "'>";
// The IDs (primary key) of the requested nodes are stored in this field
echo "<input type='hidden' name='nodes' value=''>";
// Which item type should be opened?
echo "<input type='hidden' name='openedType' value=''>";
echo '</form>';

// Print the tree
$config = new PluginTreeviewConfig();
$config->buildTreeview();

echo '</body>';
echo '</html>';
