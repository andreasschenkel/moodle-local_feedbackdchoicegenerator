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

namespace local_feedbackchoicegenerator\local\Database;

use moodle_database;

/**
 * DataFiles
 *
 * @package    local_feedbackchoicegenerator
 * @copyright  2021 Andreas Schenkel
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class DataFiles {
    /**
     * @var moodle_database The database connection an instance of this class
     *                      operates on.
     */
    private $dbm;

    /**
     * Creates a new instance which is bound to a database using the given
     * database connection.
     * @param moodle_database $dbm The database connection to be used by this
     *                             instance.
     */
    public function __construct(moodle_database $dbm) {
        $this->dbm = $dbm;
    }

    /**
     * Returns the database connection used by the instance.
     * @return moodle_database The database instance.
     */
    public function get_database(): moodle_database {
        return $this->dbm;
    }

    /**
     * Queries created by this class are based on SELECT statements. The Moodle
     * database subsystem provides functionality for statement construction, i.e.
     * a mechanism that substitutes variables in strings with concrete values.
     * This method creates strings that follow this pattern. For each variable
     * name in the parameter array, a corresponding entry in the result array is
     * created, consisting of the variable's name (SQL world) and its substitution
     * position (Moodle world), i.e. the name prefixed with „:“.
     * Example: „userid“ ---> „userid = :userid“
     * @param array $elements The array of strings which should be interpreted as
     *                        variable names.
     * @return array An array of strings conforming to the described structural
     *               pattern.
     */
    protected function create_where_string(array $elements): array {
        return array_map(function ($element) {
            return $element . " = :" . $element;
        }, $elements);
    }

    /**
     * Prepares the statement to be emitted to the database layer of the Moodle
     * system. Given parameters are combined using AND, forming the final
     * WHERE clause.
     * @param array $params An array whose keys should be used as components of the
     *                      WHERE clause for a SELECT statement.
     * @return string A valid SQL statement ready to be used with the Moodle database
     *                subsystem.
     */
    protected function prepare_statement(array $params): string {
        $where = implode(" AND ", $this->create_where_string(array_keys($params)));

        return "SELECT * FROM {files} WHERE {$where}";
    }

    /**
     * ToDo: check if this is needed.
     *
     * @param array $params
     * @return array
     * @throws \dml_exception
     */
    protected function perform_query(array $params): array {
        return $this->get_database()->get_records_sql($this->prepare_statement($params), $params);
    }

    /**
     * Getter for course
     *
     * @param int $courseid
     * @return false|mixed|\stdClass
     * @throws \dml_exception
     */
    public function get_course($courseid): mixed {
        return $this->get_database()->get_record('course', ['id' => $courseid], '*', MUST_EXIST);
    }
}
