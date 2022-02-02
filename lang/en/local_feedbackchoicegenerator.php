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

$string['pluginname'] = '1./2. ranked-choise-generator for feedback';

$string['feedbackchoicegenerator:view'] = 'see 1./2-ranked-choice-generator for feedback';

$string['isactive'] = 'Activate generator';
$string['configisactive'] = 'When activated, the generator can be started in the navigation drawer of the course.';

$string['isallowedonfrontpage'] = 'Allow generator on frontpage with coursid=1';
$string['configisallowedonfrontpage'] = 'When activated, the generator can be used on the frontpage with courseid=1. 
URL is: yourmoodleurl/local/feedbackchoicegenerator/index.php?id=1';

$string['maxoptionslength'] = 'maximum text length of each option';
$string['configmaxoptionslength'] = 'Up to this length a user can enter text as an option.';

$string['maxlength'] = 'maximum count of options';
$string['configmaxlength'] = 'Up to how many options can be used.';

$string['firstchoicelabel'] = '1. choice';
$string['secondchoicelabel'] = '2. choice';

$string['header3'] = '1. choice and 2. choice';
$string['summary'] = 'Generating import-file for activity feedback';

$string['courseidlabel'] = 'course id';
$string['backtocourselabel'] = 'Back to the course';
$string['sizelabel'] = 'How many options';

$string['optionslengthinfo'] = 'Maximum lengthof input for each option:';

$string['description'] = 'Download the generated code "Save link as ..." or put the generated XML-Code in a textfile with the extension .xml.';

$string['buttonlabel'] = 'generate XML';
$string['updatebuttonlabel'] = 'update';
$string['downloadbuttonlabel'] = 'download with right click and "save link as..."';
$string['resetbuttonlabel'] = 'reset';

$string['selectlabel'] = 'select';
$string['optionlabel'] = 'Option';