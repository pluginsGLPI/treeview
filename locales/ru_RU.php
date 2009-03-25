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

$title="Список по местонахождению";

$LANG['plugin_treeview']['title'][0] = "".$title."";

$LANG['plugin_treeview']['profile'][0] = "Настройка прав";
$LANG['plugin_treeview']['profile'][1] = "$title";
$LANG['plugin_treeview']['profile'][3] = "Использование плагина";
$LANG['plugin_treeview']['profile'][4] = "Имеющиеся права для профилей";

$LANG['plugin_treeview']['setup'][1] = "Установить плагин $title 1.1";
$LANG['plugin_treeview']['setup'][2] = "Настройка плагина ".$title."";
$LANG['plugin_treeview']['setup'][3] = "Обновить $title до версии 1.1";
$LANG['plugin_treeview']['setup'][4] = "Удалить плагин $title 1.1";
$LANG['plugin_treeview']['setup'][5] = "Warning, the uninstallation of the plugin is irreversible.<br> You will loose all the data.";
$LANG['plugin_treeview']['setup'][6] = "Настройка меню";
$LANG['plugin_treeview']['setup'][7] = "Да";
$LANG['plugin_treeview']['setup'][8] = "Нет";
$LANG['plugin_treeview']['setup'][9] = "Открывать в";
$LANG['plugin_treeview']['setup'][10] = "Папки типов устройств имеют ссылки";
$LANG['plugin_treeview']['setup'][11] = "Выделять выбранный элемент в списке";
$LANG['plugin_treeview']['setup'][13] = "Рисовать линии";
$LANG['plugin_treeview']['setup'][14] = "Рисовать иконки";
$LANG['plugin_treeview']['setup'][16] = "Одновременно раскрывать<br>только одну ветку.";
$LANG['plugin_treeview']['setup'][17] = "новом окне";
$LANG['plugin_treeview']['setup'][18] = "You cannot use this plugin on helpdesk";
$LANG['plugin_treeview']['setup'][20] = "окно GLPI";
$LANG['plugin_treeview']['setup'][21] = "Название объектов";
$LANG['plugin_treeview']['setup'][22] = "Название местоположения";
$LANG['plugin_treeview']['setup'][23] = "Название";
$LANG['plugin_treeview']['setup'][24] = "Инвентарный номер";
$LANG['plugin_treeview']['setup'][25] = "Краткое название";
$LANG['plugin_treeview']['setup'][26] = "Длинное название";
$LANG['plugin_treeview']['setup'][27] = "Примечание";
$LANG['plugin_treeview']['setup'][28] = "Инструкции";
$LANG['plugin_treeview']['setup'][29] = "FAQ";
$LANG['plugin_treeview']['setup'][30] = "Merci de vous placer sur l'entit� racine (voir tous)";
$LANG['plugin_treeview']['setup'][31] = "Открывать окно Списка по местонахождению при входе в GLPI";
$LANG['plugin_treeview']['setup'][32] = "Warning : If there are more than one plugin which be loaded at startup, then only the first will be used";

$LANG['plugin_treeview']['warning'][0] = "freport plugin does not exist";

?>