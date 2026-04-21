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
 * Plugin strings are defined here.
 *
 * @package     local_feedbackchoicegenerator
 * @category    string
 * @copyright   Andreas Schenkel
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * This function extends the navigation with the report items
 *
 * @param navigation_node $navigation The navigation node to extend
 * @param stdClass $course The course to object for the generator
 * @param stdClass $context The context of the course
 * @package    local_feedbackchoicegenerator
 */
function local_feedbackchoicegenerator_extend_navigation_course($navigation, $course, $context) {
    global $CFG, $PAGE;
    $isactive = false;
    $isactive = $CFG->local_feedbackchoicegenerator_isactive;
    if ($isactive) {
        $url = new moodle_url('/local/feedbackchoicegenerator/index.php', ['id' => $course->id]);

        $feedbackchoicegeneratornode = $PAGE->navigation->find($course->id, navigation_node::TYPE_COURSE);

        $collection = $feedbackchoicegeneratornode->children;

        foreach ($collection->getIterator() as $child) {
            $key = $child->key;
            // Position of node before this note.
            if ($key === 'participants') {
                break;
            }
        }

        $node = $feedbackchoicegeneratornode->create(
            get_string('pluginname', 'local_feedbackchoicegenerator'),
            $url,
            navigation_node::NODETYPE_LEAF,
            null,
            'feedbackchoicegenerator',
            new pix_icon('i/report', 'grades')
        );
        $feedbackchoicegeneratornode->add_node($node, $key);

        $navigation->add(
            get_string('pluginname', 'local_feedbackchoicegenerator'),
            $url,
            navigation_node::TYPE_SETTING,
            null,
            null,
            new pix_icon('i/report', '')
        );
    }
}
