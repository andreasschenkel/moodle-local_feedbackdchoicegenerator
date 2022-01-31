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

namespace local_feedbackrankedchoicegenerator;

defined('MOODLE_INTERNAL') || die;
use moodle_url;

class Page
{
    private $page;
    private $output;
    private $title;
    private $course;

    /**
     * @param moodle_page   $page
     * @param               $course
     * @param int           $courseid
     * @param bootstrap_renderer $output
     */
    public function __construct($page, $course, $courseid, $output) {
        $this->page = $page;
        $this->output = $output;
        $this->course = $course;
        $this->title = get_string('pluginname', 'local_feedbackrankedchoicegenerator');

        $page->set_context(\context_course::instance($courseid));
        $page->set_url(new moodle_url('/local/feedbackrankedchoicegenerator/index.php', ['id' => $courseid]));
        $page->set_title($this->get_title());
        $page->set_heading($course->fullname);
        $page->set_pagelayout('incourse');

    }

    public function get_output() {
        return $this->output;
    }

    public function get_title() {
        return $this->title;
    }

    public function get_course() {
        return $this->course;
    }

    public function get_course_info() {
        return get_fast_modinfo($this->get_course());
    }

    protected function get_page() {
        return $this->page;
    }

    public function get_icon_url_löschen($instance) {
        return $this->get_page()->theme->image_url('icon', $instance->modname)->out();
    }
}
