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

namespace local_feedbackchoicegenerator;

use moodle_url;

/**
 * Page
 *
 * @package    local_feedbackchoicegenerator
 * @copyright  2021 Andreas Schenkel
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class Page {
    /**
     * @var moodle_page
     */
    private $page;
    /**
     * @var bootstrap_renderer
     */
    private $output;
    /**
     * @var \lang_string|string
     */
    private $title;
    /**
     * @var course
     */
    private $course;

    /**
     * Constructor
     *
     * @param moodle_page $page
     * @param course $course
     * @param int $courseid
     * @param bootstrap_renderer $output
     * @throws \coding_exception
     * @throws \core\exception\moodle_exception
     */
    public function __construct($page, $course, $courseid, $output) {
        $this->page = $page;
        $this->output = $output;
        $this->course = $course;
        $this->title = get_string('pluginname', 'local_feedbackchoicegenerator');

        $page->set_context(\context_course::instance($courseid));
        $page->set_url(new moodle_url('/local/feedbackchoicegenerator/index.php', ['id' => $courseid]));
        $page->set_title($this->get_title());
        $page->set_heading($course->fullname);
        $page->set_pagelayout('incourse');
    }

    /**
     * Getter for rendered output
     *
     * @return bootstrap_renderer
     */
    public function get_output() {
        return $this->output;
    }

    /**
     *  Getter for title
     *
     * @return \lang_string|string
     */
    public function get_title() {
        return $this->title;
    }

    /**
     * Getter for course
     *
     * @return course
     */
    public function get_course() {
        return $this->course;
    }

    /**
     * Getter for courseinfo
     *
     * @return \course_modinfo|null
     * @throws \moodle_exception
     */
    public function get_course_info() {
        return get_fast_modinfo($this->get_course());
    }

    /**
     * Getter for page
     *
     * @return moodle_page
     */
    protected function get_page() {
        return $this->page;
    }
}
