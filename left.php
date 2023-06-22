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

include ('../../inc/includes.php');

Session::checkLoginUser();

$treeview_url = Plugin::getWebDir('treeview');

Html::includeHeader("TreeView");

echo "<body style='overflow:auto; overflow:initial;'>";
// Title bar
echo '<div id=explorer_bar>';
echo '<div id=explorer_title>'.sprintf(__('%1$s - %2$s'), "GLPI", __('Tree view', 'treeview'));
echo '</div>';
echo "<div id=explorer_close>";
echo "<img border=0 src='pics/close.png' name='explorer_close'
       onclick='parent.location.href = parent.right.location.href;'></div>";
echo "</div>";

echo "<form method='get' name='get_level' action='" .$_SERVER["PHP_SELF"]. "'>";
// The IDs (primary key) of the requested nodes are stored in this field
echo "<input type='hidden' name='nodes' value=''>";
// Which item type should be opened?
echo "<input type='hidden' name='openedType' value=''>";
echo "</form>";

// Print the tree
$config = new PluginTreeviewConfig();
$config->buildTreeview();

echo "</body>";
echo "</html>";