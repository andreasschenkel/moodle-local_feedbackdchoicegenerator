<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package    local_feedbackchoicegenerator
 * @copyright   Andreas Schenkel
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    $settings->add(new admin_setting_configcheckbox(
        'local_feedbackchoicegenerator_isactive',
        get_string('isactive', 'local_feedbackchoicegenerator'),
        get_string('configisactive', 'local_feedbackchoicegenerator'),
        0
    ));

    $options = array(5 => '5', 10 => '10', 20 => '20', 30 => '30', 40 => '40', 50 => '50', 100 => '100', 200 => '200');

    $settings->add(new admin_setting_configselect(
        'local_feedbackchoicegenerator_maxlength',
        get_string('maxlength', 'local_feedbackchoicegenerator'),
        get_string('configmaxlength', 'local_feedbackchoicegenerator'),
        '40',
        $options
    ));

    $options = array(5 => '5', 10 => '10', 20 => '20', 30 => '30', 40 => '40', 50 => '50');
    $settings->add(new admin_setting_configselect(
        'local_feedbackchoicegenerator_maxoptionslength',
        get_string('maxoptionslength', 'local_feedbackchoicegenerator'),
        get_string('configmaxoptionslength', 'local_feedbackchoicegenerator'),
        '30',
        $options
    ));

}
