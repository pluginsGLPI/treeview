<?php
/*
 * @version $Id: setup.php,v 1.2 2006/04/02 14:45:27 moyo Exp $
 ---------------------------------------------------------------------- 
 GLPI - Gestionnaire Libre de Parc Informatique 
 Copyright (C) 2003-2008 by the INDEPNET Development Team.

 http://indepnet.net/   http://glpi-project.org/
 ----------------------------------------------------------------------

 LICENSE

 This file is part of GLPI.

 GLPI is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 GLPI is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with GLPI; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 ------------------------------------------------------------------------
 */

// ----------------------------------------------------------------------
// Original Author of file: AL-Rubeiy Hussein
// Purpose of file:
// ----------------------------------------------------------------------
/**
* Computer
*/
$PLUGIN_TREEVIEW_DEVICES[0]['type'] = COMPUTER_TYPE;
$PLUGIN_TREEVIEW_DEVICES[0]['name'] = $LANG['Menu'][0];
$PLUGIN_TREEVIEW_DEVICES[0]['pic'] = 'computer.gif';
$PLUGIN_TREEVIEW_DEVICES[0]['page'] = '/front/computer.php';

/**
* Monitor
*/
$PLUGIN_TREEVIEW_DEVICES[1]['type'] = MONITOR_TYPE;
$PLUGIN_TREEVIEW_DEVICES[1]['name'] = $LANG['Menu'][3];
$PLUGIN_TREEVIEW_DEVICES[1]['pic'] = 'monitor.gif';
$PLUGIN_TREEVIEW_DEVICES[1]['page'] = '/front/monitor.php';

/**
* Networking
*/
$PLUGIN_TREEVIEW_DEVICES[2]['type'] = NETWORKING_TYPE;
$PLUGIN_TREEVIEW_DEVICES[2]['name'] = $LANG['Menu'][1];
$PLUGIN_TREEVIEW_DEVICES[2]['pic'] = 'page.gif';
$PLUGIN_TREEVIEW_DEVICES[2]['page'] = '/front/networking.php';

/**
* Peripheral
*/
$PLUGIN_TREEVIEW_DEVICES[3]['type'] = PERIPHERAL_TYPE;
$PLUGIN_TREEVIEW_DEVICES[3]['name'] = $LANG['Menu'][16];
$PLUGIN_TREEVIEW_DEVICES[3]['pic'] = 'device.gif';
$PLUGIN_TREEVIEW_DEVICES[3]['page'] = '/front/peripheral.php';

/**
* Printer
*/
$PLUGIN_TREEVIEW_DEVICES[4]['type'] = PRINTER_TYPE;
$PLUGIN_TREEVIEW_DEVICES[4]['name'] = $LANG['Menu'][2];
$PLUGIN_TREEVIEW_DEVICES[4]['pic'] = 'printer.gif';
$PLUGIN_TREEVIEW_DEVICES[4]['page'] = '/front/printer.php';

/**
* Software
*/
$PLUGIN_TREEVIEW_DEVICES[5]['type'] = SOFTWARE_TYPE;
$PLUGIN_TREEVIEW_DEVICES[5]['name'] = $LANG['Menu'][4];
$PLUGIN_TREEVIEW_DEVICES[5]['pic'] = 'software.gif';
$PLUGIN_TREEVIEW_DEVICES[5]['page'] = '/front/software.php';

/**
* Cartridge
*/
$PLUGIN_TREEVIEW_DEVICES[6]['type'] = CARTRIDGE_TYPE;
$PLUGIN_TREEVIEW_DEVICES[6]['name'] = $LANG['Menu'][21];
$PLUGIN_TREEVIEW_DEVICES[6]['pic'] = 'page.gif';
$PLUGIN_TREEVIEW_DEVICES[6]['page'] = '/front/cartridge.php';

/**
* Phone
*/
$PLUGIN_TREEVIEW_DEVICES[7]['type'] = PHONE_TYPE;
$PLUGIN_TREEVIEW_DEVICES[7]['name'] = $LANG['Menu'][34];
$PLUGIN_TREEVIEW_DEVICES[7]['pic'] = 'phone.gif';
$PLUGIN_TREEVIEW_DEVICES[7]['page'] = '/front/phone.php';

/**
* Consumable
*/
$PLUGIN_TREEVIEW_DEVICES[8]['type'] = CONSUMABLE_TYPE;
$PLUGIN_TREEVIEW_DEVICES[8]['name'] = $LANG['Menu'][32];
$PLUGIN_TREEVIEW_DEVICES[8]['pic'] = 'cd.gif';
$PLUGIN_TREEVIEW_DEVICES[8]['page'] = '/front/consumable.php';
?>