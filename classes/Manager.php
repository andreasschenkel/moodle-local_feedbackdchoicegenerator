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
defined('MOODLE_INTERNAL') || die;
use moodle_database;
use local_feedbackchoicegenerator\Database\Factory as DatabaseFactory;
use local_feedbackchoicegenerator\Security\Security;

defined('MOODLE_INTERNAL') || die();

/**
 * @package    local_feedbackchoicegenerator
 * Class manager
 */
class Manager
{
    /**
     * @var moodle_database
     */
    private $dbm;

    /**
     * Manager constructor.
     * @param moodle_database $dbm
     */
    public function __construct(moodle_database $dbm) {
        $this->dbm = $dbm;
    }

    /**
     * @return DatabaseFactory
     */
    public function database(): DatabaseFactory {
        return new DatabaseFactory($this->dbm);
    }

    /**
     * @return Security
     */
    public function security(): Security {
        return new Security($this->dbm);
    }
}
