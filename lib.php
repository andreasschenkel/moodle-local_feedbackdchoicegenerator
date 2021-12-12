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

defined('MOODLE_INTERNAL') || die;

/**
 * This function extends the navigation with the report items
 *
 * @param navigation_node $navigation The navigation node to extend
 * @param stdClass $course The course to object for the report
 * @param stdClass $context The context of the course
 */
function report_feedbackchoicegenerator_extend_navigation_course($navigation, $course, $context) {
    global $CFG;
    $page = $GLOBALS['PAGE'];
    $url = new moodle_url('/report/feedbackchoicegenerator/index.php', array('id' => $course->id));

    $feedbackchoicegeneratornode = $page->navigation->find($course->id, navigation_node::TYPE_COURSE);

    $collection = $feedbackchoicegeneratornode->children;

    foreach ($collection->getIterator() as $child) {
        $key = $child->key;
        break;
    }

    if ($CFG->report_feedbackchoicegenerator_isactive == true) {
        $isactive = true;
    } else {
        $isactive = false;
    }

    if ($isactive) {
        $node = $feedbackchoicegeneratornode->create(get_string('pluginname', 'report_feedbackchoicegenerator'),
            $url, navigation_node::NODETYPE_LEAF, null, 'gradebook',  new pix_icon('i/report', 'grades'));
        $feedbackchoicegeneratornode->add_node($node,  $key);
    }

    if (has_capability('moodle/feedbackchoicegenerator:view', $context)) {
        $navigation->add(
            get_string('pluginname', 'report_feedbackchoicegenerator'),
            $url,
            navigation_node::TYPE_SETTING,
            null,
            null,
            new pix_icon('i/report', '')
        );
    }
}
