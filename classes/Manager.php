<?php
namespace report_feedbackchoicegenerator;

use moodle_database;

use report_feedbackchoicegenerator\Database\Factory as DatabaseFactory;
use report_feedbackchoicegenerator\Security\Security;

defined('MOODLE_INTERNAL') || die();

/**
 * Class manager
 */
class Manager
{
    /**
     * @var moodle_database
     */
    private $dbM;

    /**
     * Manager constructor.
     * @param moodle_database $dbM
     */
    public function __construct(moodle_database $dbM)
    {
        $this->dbM = $dbM;
    }

    /**
     * @return DatabaseFactory
     */
    public function database(): DatabaseFactory
    {
        return new DatabaseFactory($this->dbM);
    }

    /**
     * @return Security
     */
    public function security(): Security
    {
        return new Security($this->dbM);
    }

}
