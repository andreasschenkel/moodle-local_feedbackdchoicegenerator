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
require_once(__DIR__ . '/../../config.php');
require_login();

use local_feedbackrankedchoicegenerator\View\FeedbackChoiceGenerator;

// Assign global variables to local (parameter) variables.
// At the moment, this approach is used for documentation purposes.
$courseid = required_param('id', PARAM_INT);
$page = $PAGE;
$output = $OUTPUT;
$db = $DB;

$feedbackrankedchoicegeneratorinstance = new FeedbackChoiceGenerator($db, $courseid, $page, $output);

global $CFG;

$isallowedonfrontpage = $CFG->local_feedbackrankedchoicegenerator_isallowedonfrontpage;
$isactive = $CFG->local_feedbackrankedchoicegenerator_isactive;

if ($isactive) {
    if ($courseid === (int)'1') {
        if ($isallowedonfrontpage) {
            $feedbackrankedchoicegeneratorinstance->init();
        } else {
            echo "not supported on frontpage";
        }
    } else {
        $feedbackrankedchoicegeneratorinstance->init();
    }
} else {
    echo "is not activ";
}
