<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin strings are defined here.
 *
 * @package     local_feedbackchoicegenerator
 * @category    string
 * @copyright   Andreas Schenkel
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = '1./2. Wahl Feedback-Generator'; 

$string['feedbackchoicegenerator:view'] = '1./2. Wahl Feedback-Generator anzeigen'; 

$string['isactive'] = 'Generator aktivieren';
$string['configisactive'] = 'Wenn aktiviert kann der Generator bei vorhandenen Berechtigungen im der Kursnavigation aufgerufen werden.';

$string['isallowedonfrontpage'] = 'Generator auf Startseite mit Kursid=1 erlauben';
$string['configisallowedonfrontpage'] = 'Wenn aktiviert kann der Generator auf der Startseite aufgerufen werden. 
    Link wird allerdings nicht angezeigt. URL ist: moodleurl/local/feedbackchoicegenerator/index.php?id=1';

$string['maxoptionslength'] = 'Max. Länge der Optionen';
$string['configmaxoptionslength'] = 'Bis zu dieser Länge kann der Text einer Option eingegeben werden.';

$string['maxlength'] = 'Max. Anzahl der Optionen';
$string['configmaxlength'] = 'Maximale Anzahl an Optionen, die man anbieten kann.';

$string['firstchoicelabel'] = '1. Wahl';
$string['secondchoicelabel'] = '2. Wahl';

$string['header3'] = '1. Wahl und 2. Wahl';
$string['summary'] = 'Ein Generator für die Aktivität Feedback, um eine 1. und 2. Wahl umzusetzen.';

$string['courseidlabel'] = 'Kursid';
$string['backtocourselabel'] = 'zurück zum Kurs';
$string['sizelabel'] = 'Anzahl der Optionen';

$string['optionslengthinfo'] = 'max. Zeichenanzahl je Option:';

$string['description'] = 'Den hier erzeugten xml-Code mit Hilfe des Download-Links herunterladen (rechte Maustaste "Ziel speichern unter..." nutzen). 
    Alternativ den xml-Code in einer Textdatei kopieren und mit der Endung .xml speichern.';

$string['buttonlabel'] = 'XML erzeugen';
$string['updatebuttonlabel'] = 'aktualisieren';
$string['downloadbuttonlabel'] = 'XML-Download (rechte Maustaste "Ziel speichern unter...")';
$string['resetbuttonlabel'] = 'Eingaben zurücksetzen';

$string['selectlabel'] = 'auswählen';
$string['optionlabel'] = 'Option';
