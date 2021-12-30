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

namespace local_feedbackchoicegenerator\Security;
defined('MOODLE_INTERNAL') || die;
use coding_exception;
use context_course;
use moodle_database;
use moodle_exception;
use require_login_exception;
use stdClass;

/**
 * Class Security
 */
class Security
{
    /**
     * @var moodle_database
     */
    private $dbm;

    /**
     * Security constructor.
     * @param moodle_database $dbm
     */
    public function __construct(moodle_database $dbm) {
        $this->dbm = $dbm;
    }

    /**
     * @throws coding_exception
     * @throws moodle_exception
     * @throws require_login_exception
     */
    public function user_is_allowed_to_view_the_course_and_has_capability_to_use_generator($courseid) {
        $params = ['id' => $courseid];

        // Check this code if it works correct????
        $course = $this->dbm->get_record('course', $params, '*', MUST_EXIST);
        require_login($course);

        $coursecontext = context_course::instance($courseid);
        require_capability('local/feedbackchoicegenerator:view', $coursecontext);
    }
}
