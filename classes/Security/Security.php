<?php

namespace report_feedbackchoicegenerator\Security;

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
    private $dbM;

    /**
     * Security constructor.
     * @param moodle_database $dbM
     */
    public function __construct(moodle_database $dbM)
    {
        $this->dbM = $dbM;
    }

    /**
     * @throws coding_exception
     * @throws moodle_exception
     * @throws require_login_exception
     */
    public function userIsAllowedToViewTheCourseAndHasCapabilityToUseGenerator($courseId)
    {
        $params = ['id' => $courseId];
        /**
         * @todo check this code if it works correct????
         */
        $course = $this->dbM->get_record('course', $params, '*', MUST_EXIST);
        require_login($course);

        $coursecontext = context_course::instance($courseId);
        require_capability('report/feedbackchoicegenerator:view', $coursecontext);
    }
}
