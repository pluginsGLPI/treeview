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

$LANGTREEVIEW["title"][0]="".$title."";

$LANGTREEVIEW["profile"][0] = "Настройка прав";
$LANGTREEVIEW["profile"][1] = "$title";
$LANGTREEVIEW["profile"][3] = "Использование плагина";
$LANGTREEVIEW["profile"][4] = "Имеющиеся права для профилей";

$LANGTREEVIEW["setup"][1]="Установить плагин $title 1.1";
$LANGTREEVIEW["setup"][2]="Настройка плагина ".$title."";
$LANGTREEVIEW["setup"][3]="Обновить $title до версии 1.1";
$LANGTREEVIEW["setup"][4]="Удалить плагин $title 1.1";
$LANGTREEVIEW["setup"][5]="Warning, the uninstallation of the plugin is irreversible.<br> You will loose all the data.";
$LANGTREEVIEW["setup"][6]="Настройка меню";
$LANGTREEVIEW["setup"][7]="Да";
$LANGTREEVIEW["setup"][8]="Нет";
$LANGTREEVIEW["setup"][9]="Открывать в";
$LANGTREEVIEW["setup"][10]="Папки типов устройств имеют ссылки";
$LANGTREEVIEW["setup"][11]="Выделять выбранный элемент в списке";
$LANGTREEVIEW["setup"][13]="Рисовать линии";
$LANGTREEVIEW["setup"][14]="Рисовать иконки";
$LANGTREEVIEW["setup"][16]="Одновременно раскрывать<br>только одну ветку.";
$LANGTREEVIEW["setup"][17]="новом окне";
$LANGTREEVIEW["setup"][18]="Same window";
$LANGTREEVIEW["setup"][20]="окно GLPI";
$LANGTREEVIEW["setup"][21]="Название объектов";
$LANGTREEVIEW["setup"][22]="Название местоположения";
$LANGTREEVIEW["setup"][23]="Название";
$LANGTREEVIEW["setup"][24]="Инвентарный номер";
$LANGTREEVIEW["setup"][25]="Краткое название";
$LANGTREEVIEW["setup"][26]="Длинное название";
$LANGTREEVIEW["setup"][27]="Примечание";
$LANGTREEVIEW["setup"][28] = "Инструкции";
$LANGTREEVIEW["setup"][29] = "FAQ";
$LANGTREEVIEW["setup"][30] = "Merci de vous placer sur l'entit� racine (voir tous)";
$LANGTREEVIEW["setup"][31] = "Открывать окно Списка по местонахождению при входе в GLPI";

$LANGTREEVIEW["warning"][0]="freport plugin does not exist";

?>