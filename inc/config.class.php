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

if (!defined('GLPI_ROOT')) {
    die("Sorry. You can't access directly to this file");
}

/**
 * Contains the display configuration of the treeview
**/
class PluginTreeviewConfig extends CommonDBTM
{
    public static $types = [
        'Computer',
        'Monitor',
        'NetworkEquipment',
        'Peripheral',
        'Phone',
        'Printer',
        'Software',
        'Rack',
        'Enclosure',
        'PDU',
        'PassiveDCEquipment',
    ];

    /**
    * Display name of itemtype
    *
    * @return string
    **/
    public static function getTypeName($nb = 0)
    {
        return __('Tree view', 'treeview');
    }

    /**
     * Configuration form
    **/
    public function showForm($id, $options = [])
    {
        $this->getFromDB($id);
        echo "<form method='post' action='./config.form.php' method='post'>";
        echo "<table class='tab_cadre_fixe' cellpadding='5'>";
        echo "<tr><th colspan='2'>" . __('Display', 'treeview') . '</th></tr>';

        echo "<tr class='tab_bg_1'><td>" . __('Target for all the nodes', 'treeview') . '</td>';
        echo "<td><select name='target'>";
        echo "<option value='_blank' " . (($this->fields['target'] == '_blank') ? ' selected ' : '') . '>' .
             __('New window', 'treeview') . '</option>';
        echo "<option value='right' " . (($this->fields['target'] == 'right') ? ' selected ' : '') . '>' .
             __('The central console', 'treeview') . '</option>';
        echo '</select></td></tr>';

        echo "<tr class='tab_bg_1'>";
        echo '<td>' . __('Should folders be links', 'treeview') . '</td>';
        echo "<td><select name='folderLinks'>";
        echo "<option value='0' " . (($this->fields['folderLinks'] == 0) ? ' selected ' : '') . '>' .
             __('No') . '</option>';
        echo "<option value='1' " . (($this->fields['folderLinks'] == 1) ? ' selected ' : '') . '>' .
             __('Yes') . '</option>';
        echo '</select></td></tr>';

        echo "<tr class='tab_bg_1'>";
        echo '<td>' . __('Nodes can be highlighted', 'treeview') . '</td>';
        echo "<td><select name='useSelection'>";
        echo "<option value='1' " . (($this->fields['useSelection'] == 1) ? ' selected ' : '') . '>' .
             __('Yes') . '</option>';
        echo "<option value='0' " . (($this->fields['useSelection'] == 0) ? ' selected ' : '') . '>' .
             __('No') . '</option>';
        echo '</select></td></tr>';

        echo "<tr class='tab_bg_1'><td>" . __('Tree is drawn with lines', 'treeview') . '</td>';
        echo "<td><select name='useLines'>";
        echo "<option value='1' " . (($this->fields['useLines'] == 1) ? ' selected ' : '') . '>' .
             __('Yes') . '</option>';
        echo "<option value='0' " . (($this->fields['useLines'] == 0) ? ' selected ' : '') . '>' .
             __('No') . '</option>';
        echo '</select></td></tr>';

        echo "<tr class='tab_bg_1'><td>" . __('Tree is drawn with icons', 'treeview') . '</td>';
        echo '<td>';
        echo "<select name='useIcons'>";
        echo "<option value='1' " . (($this->fields['useIcons'] == 1) ? ' selected ' : '') . '>' .
             __('Yes') . '</option>';
        echo "<option value='0' " . (($this->fields['useIcons'] == 0) ? ' selected ' : '') . '>' .
             __('No') . '</option>';
        echo '</select></td></tr>';

        echo "<tr class='tab_bg_1'>";
        echo '<td>' . __('Only one node within a parent', 'treeview') . '<br>' .
                 __('can be expanded at the same time.', 'treeview');
        echo '<td>';
        echo "<select name='closeSameLevel'>";
        echo "<option value='1' " . (($this->fields['closeSameLevel'] == 1) ? ' selected ' : '') . '>' .
             __('Yes') . '</option>';
        echo "<option value='0' " . (($this->fields['closeSameLevel'] == 0) ? ' selected ' : '') . '>' .
             __('No') . '</option>';
        echo '</select></td></tr>';

        echo "<tr class='tab_bg_1'><td>" . __('Item name', 'treeview') . '</td>';
        echo "<td><select name='itemName'>";
        echo "<option value='0' " . (($this->fields['itemName'] == '0') ? ' selected ' : '') . '>' .
             __('Name') . '</option>';
        echo "<option value='1' " . (($this->fields['itemName'] == '1') ? ' selected ' : '') . '>' .
             __('Inventory number') . '</option>';
        echo "<option value='2' " . (($this->fields['itemName'] == '2') ? ' selected ' : '') . '>';
        printf(__('%1$s / %2$s'), __('Name'), __('Inventory number'));
        echo '</option>';
        echo "<option value='3' " . (($this->fields['itemName'] == '3') ? ' selected ' : '') . '>';
        printf(__('%1$s / %2$s'), __('Inventory number'), __('Name'));
        echo '</option>';
        echo '</select></td></tr>';

        echo "<tr class='tab_bg_1'><td>" . __('Location name', 'treeview') . '</td>';
        echo '<td>';
        echo "<select name='locationName'>";
        echo "<option value='0' " . (($this->fields['locationName'] == '0') ? ' selected ' : '') . '>' .
             __('Short name', 'treeview') . '</option>';
        echo "<option value='1' " . (($this->fields['locationName'] == '1') ? ' selected ' : '') . '>' .
             __('Long name', 'treeview') . '</option>';
        echo "<option value='2' " . (($this->fields['locationName'] == '2') ? ' selected ' : '') . '>';
        printf(__('%1$s / %2$s'), __('Short name', 'treeview'), __('Comment', 'treeview'));
        echo '</option>';
        echo "<option value='3' " . (($this->fields['locationName'] == '3') ? ' selected ' : '') . '>';
        printf(__('%1$s / %2$s'), __('Long name', 'treeview'), __('Comment', 'treeview'));
        echo '</option>';
        echo '</select></td></tr>';

        echo "<tr class='tab_bg_2'><td colspan='2' class='center'>";
        echo "<input type='hidden' name='id' value='1'>";
        echo "<input type='submit' name='update' value='" . _sx('button', 'Post') . "' class='submit'>";
        echo '</td></tr>';
        echo '</table>';

        echo '<script type="text/javascript">
              $(\'select\').select2();
            </script>';

        Html::closeForm();

        return true;
    }

    /**
     * For other plugins, add a type to the linkable types
     *
     *
     * @param $type string class name
    **/
    public static function registerType($type)
    {
        if (!in_array($type, self::$types)) {
            self::$types[] = $type;
        }
    }

    /**
     * Type than could be linked to a Resource
     *
     * @param $all boolean, all type, or only allowed ones
     *
     * @return array of types
    **/
    public static function getTypes($all = false)
    {
        if ($all) {
            return self::$types;
        }

        // Only allowed types
        $types = self::$types;

        foreach ($types as $key => $type) {
            if (!class_exists($type)) {
                continue;
            }

            $item = new $type();
            if (!$item->canView()) {
                unset($types[$key]);
            }
        }

        return $types;
    }

    /**
     * The function to see the treeview
    **/
    public function seeTreeview()
    {
        /** @var array $CFG_GLPI */
        global $CFG_GLPI;

        echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Frameset//EN'
             'http://www.w3.org/TR/html4/frameset.dtd'>";
        echo "\n<html><head><title>" . sprintf(__('%1$s - %2$s'), 'GLPI', __('Tree view', 'treeview'));
        echo '</title>';
        echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";

        // Send extra expires header if configured
        echo "<meta http-equiv='Expires' content='Fri, Jun 12 1981 08:20:00 GMT'>\n";
        echo "<meta http-equiv='Pragma' content='no-cache'>\n";
        echo "<meta http-equiv='Cache-Control' content='no-cache'>\n";
        echo "<link rel='shortcut icon' type='images/x-icon' href='" .
             $CFG_GLPI['root_doc'] . "/pics/favicon.ico' >\n";

        // Must be always the top window
        echo '<script type="text/javascript">';
        echo 'if (top != self)';
        echo 'top.location = self.location;';
        echo '</script></head>';
        echo "<frameset cols='250,*'>";
        echo "<frame src='" . Plugin::getWebDir('treeview') . "/left.php' name='left' scrolling='yes'>";
        echo "<frame src='" . $CFG_GLPI['root_doc'] . "/front/central.php' name='right'>";
        echo '<noframes>';
        echo '<body>';
        echo "<p><a href='" . $CFG_GLPI['root_doc'] . "/front/central.php'>GLPI</a></p>";
        echo '</body>';
        echo '</noframes>';
        echo '</frameset>';
        echo '</html>';
    }

    /**
     * The function to hide the treeview
    **/
    public function hideTreeview()
    {
        echo "<script type='text/javascript'>";
        echo 'if (top != self)';
        echo 'top.location = self.location;';
        echo '</script>';
    }

    /**
     * The main function, build the javascript code of the treeview
    **/
    public function buildTreeview()
    {
        $treeview_url = Plugin::getWebDir('treeview');

        //necessary files needed for the tree to work.
        echo "<link rel='stylesheet' type='text/css' href='$treeview_url/css/dtree.css' type='text/css'>";
        echo "<script type='text/javascript' src='$treeview_url/lib/dtree/dtree.js'></script>";

        echo "<div class='dtree'>";
        echo "<script type='text/javascript'>";
        $this->getNodesFromDb();
        echo '</script>';
        echo '</div>';
    }

    /**
     * Requests the nodes from the GLPI database
    **/
    public function getNodesFromDb()
    {
        /** @var DBmysql $DB */
        global $DB;

        // The tree object
        echo "var d = new dTree('d');\n";
        echo "d.add(0,-1,'" . __('Tree view', 'treeview') . "');";

        $config = new PluginTreeviewConfig();

        // Request the display settings from the database and store them in the global object $config
        $this->getFromDB(1);

        $itemName       = $this->fields['itemName'];
        $locationName   = $this->fields['locationName'];
        $target         = $this->fields['target'];
        $folderLinks    = $this->fields['folderLinks'];
        $useSelection   = $this->fields['useSelection'];
        $useLines       = $this->fields['useLines'];
        $useIcons       = $this->fields['useIcons'];
        $closeSameLevel = $this->fields['closeSameLevel'];

        // Load the settings in JavaSript so that dTree script can apply them
        echo "d.config.target         = '" . $target . "';\n";
        echo 'd.config.folderLinks    = ' . $folderLinks . ";\n";
        echo 'd.config.useSelection   = ' . $useSelection . ";\n";
        echo 'd.config.useLines       = ' . $useLines . ";\n";
        echo 'd.config.useIcons       = ' . $useIcons . ";\n";
        echo 'd.config.closeSameLevel = ' . $closeSameLevel . ";\n";

        $dontLoad = 'false';

        // Get the lowest level of the tree nodes and the highest primary key
        $it = $DB->request([
            'SELECT' => [
                new QueryExpression('MAX(' . $DB::quoteName('id') . ') AS ' . $DB::quoteName('max_id')),
                new QueryExpression('MAX(' . $DB::quoteName('level') . ') AS ' . $DB::quoteName('max_level')),
            ],
            'FROM'  => 'glpi_locations',
            'WHERE' => getEntitiesRestrictCriteria('glpi_locations', '', '', true),
        ]);
        $result = $it->current();

        $max_level = $result['max_level'];
        $tv_id     = $max_id = $result['max_id'];
        $tv_id++;

        // Is this the first time we load the page?
        if (isset($_GET['nodes']) && $_GET['nodes'] != '') {
            // If no then get all the nodes requested by the client
            $nodes = array_reverse(explode('.', $_GET['nodes']));
        } else {
            // If yes then get only the root node
            $nodes[0] = 0;
        }

        // If an item group is requested, then save its type to use it later in the openTo function
        if (isset($_GET['openedType']) && $_GET['openedType'] != '') {
            $openedType = $_GET['openedType'];
        } else {
            $openedType = -1;
        }

        // Characters which need to be removed from JS output.
        $trans = ['"' => '`',
            "\r"      => ' ',
            "\n"      => ' ',
        ];

        $node_count = count($nodes);
        for ($n = 1; $n <= $node_count; $n++) {
            if ($nodes[$n - 1] <= $max_id && $n <= $max_level) {
                $it = $DB->request([
                    'FROM'  => 'glpi_locations',
                    'WHERE' => [
                        'level'        => $n,
                        'locations_id' => $nodes[$n - 1],
                    ] + getEntitiesRestrictCriteria('glpi_locations', '', '', true),
                    'ORDER' => ['completename ASC'],
                ]);

                foreach ($it as $r) {
                    $l_name = '';
                    // Location's name schema
                    if ($locationName == 0) {
                        $l_name = $r['name'];
                    } elseif ($locationName == 1) {
                        $l_name = $r['completename'];
                    } elseif ($locationName == 2) {
                        $l_name = $r['name'];
                        if ($r['comment'] != '') {
                            $l_name .= ' (' . $r['comment'] . ')';
                        }
                    } elseif ($locationName == 3) {
                        $l_name = $r['completename'];
                        if ($r['comment'] != '') {
                            $l_name .= ' (' . $r['comment'] . ')';
                        }
                    }

                    // Is this location requested by the user to be opened
                    if (in_array($r['id'], $nodes)) {
                        echo 'd.add(' . $r['id'] . ', ' . $r['locations_id'] . ', "' . strtr($l_name, $trans) .
                                "\", true, -1,'');\n";
                        $dontLoad = 'true';
                        // Then add aloso its items
                        foreach (self::$types as $type) {
                            $item      = new $type();
                            $itemtable = getTableForItemType($type);

                            $criteria = [
                                'FROM'  => $itemtable,
                                'WHERE' => [
                                    'locations_id' => $r['id'],
                                ],
                                'ORDER' => ["$itemtable.name"],
                            ];

                            if ($item->maybeTemplate()) {
                                $criteria['WHERE']['is_template'] = 0;
                            }
                            if ($item->maybeDeleted()) {
                                $criteria['WHERE']['is_deleted'] = 0;
                            }

                            if ($this->isEntityAssign()) {
                                $criteria['WHERE']['entities_id'] = $_SESSION['glpiactive_entity'];
                            }

                            $result_1 = $DB->request($criteria);
                            $pid      = 0;
                            if (count($result_1)) {
                                $pid       = $tv_id;
                                $field_num = 3;

                                $result_location = $DB->request([
                                    'SELECT' => ['completename'],
                                    'FROM'   => 'glpi_locations',
                                    'WHERE'  => ['id' => $r['id']],
                                ]);

                                foreach ($result_location as $row) {
                                    $name_location = $row['completename'];
                                }
                                $value    = $r['id'];
                                $token    = Session::getNewCSRFToken();
                                $getParam = "?is_deleted=0&criteria[0][field]=$field_num&criteria[0][searchtype]=equals&criteria[0][value]=$value&search=Rechercher&start=0&_glpi_csrf_token=$token";

                                $searchUrl = Toolbox::getItemTypeSearchURL($type) . $getParam;

                                $params = ['itemtype' => $type,
                                    'locations_id'    => $value,
                                    'searchurl'       => $searchUrl,
                                ];

                                $opt = Plugin::doHookFunction('treeview_search_url_parent_node', $params);

                                // Add items parent node
                                echo "d.add($tv_id," . $r['id'] . ',"' . strtr($item::getTypeName(2), $trans) .
                                "\", $dontLoad, '" . $type . "', '" . $opt['searchurl'] . "', '', '', '" .
                                $type::getIcon() . "', '" . $type::getIcon() . "');\n";

                                if ($openedType == $type && $nodes[count($nodes) - 1] == $tv_id) {
                                    $openedType = $tv_id;
                                }
                                $tv_id++;
                            }

                            foreach ($result_1 as $r_1) {
                                $i_name = '';
                                // Item's name schema
                                if ($itemName == 0 || $type == 'Software') {
                                    $i_name = $r_1['name'];
                                } elseif ($itemName == 1) {
                                    if (isset($r_1['otherserial']) && !empty($r_1['otherserial'])) {
                                        $i_name = $r_1['otherserial'];
                                    } else {
                                        $i_name = $r_1['name'];
                                    }
                                } elseif ($itemName == 2) {
                                    $i_name = $r_1['name'] != '' ? $r_1['name'] : '';
                                    if (isset($r_1['otherserial']) && !empty($r_1['otherserial'])) {
                                        $i_name .= $r_1['otherserial'] != '' ? ($r_1['name'] != '' ? ' / ' .
                                         $r_1['otherserial'] : $r_1['otherserial']) : '';
                                    } else {
                                        $i_name .= '';
                                    }
                                } elseif ($itemName == 3) {
                                    if (isset($r_1['otherserial']) && !empty($r_1['otherserial'])) {
                                        $i_name = $r_1['otherserial'] != '' ? $r_1['otherserial'] : '';
                                        $i_name .= $r_1['name']       != '' ? ($r_1['otherserial'] != '' ? ' / ' .
                                         $r_1['name'] : $r_1['name']) : '';
                                    } else {
                                        $i_name = $r_1['name'];
                                    }
                                }

                                $url  = Toolbox::getItemTypeFormURL($type) . '?id=' . $r_1['id'];
                                $pic  = 'ti ti-chevrons-right';
                                $name = strtr($i_name, $trans);
                                $opt  = ['url' => $url,
                                    'pic'      => $pic,
                                    'name'     => $name,
                                ];

                                $params = ['itemtype' => $type,
                                    'id'              => $r_1['id'],
                                    'url'             => $url,
                                    'pic'             => $pic,
                                    'name'            => $name,
                                ];

                                $opt = Plugin::doHookFunction('treeview_params', $params);

                                // Add the item
                                echo 'd.add(' . $tv_id++ . ", $pid, \"" . $opt['name'] . "\", true, -1, '" .
                                  $opt['url'] . "', '', '', '" . $opt['pic'] . "','" . $opt['pic'] . "');\n";
                            }
                        }

                        // Add only the location without its items
                    } else {
                        echo 'd.add(' . $r['id'] . ',' . $r['locations_id'] . ',"' . strtr($l_name, $trans) .
                        "\", false, -1,'', '', '', '', '', false, true);\n";
                    }
                }
            }
        }

        // Print the node from JavaScript
        echo "document.write(d);\n";

        // Open the tree to the desired node
        if ($openedType != -1) {
            echo 'd.openTo(' . $openedType . ");\n";
        } else {
            echo 'd.openTo(' . $nodes[count($nodes) - 1] . ");\n";
        }
    }

    /**
     * Make sure that GLPI index page location is on top of window hierarchy
     */
    public static function loginPageToTop()
    {
        echo Html::scriptBlock('
      $(document).ready(
         public function() {
            if (top != self)
               top.location = self.location;
         });
      ');
    }
}
