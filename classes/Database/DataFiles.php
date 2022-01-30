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

namespace local_feedbackrankedchoicegenerator\Database;
defined('MOODLE_INTERNAL') || die();
use moodle_database;

/**
 * @package    local_feedbackrankedchoicegenerator
 * This class provides high-level functionality for the module. Concepts like
 * enumerating files belonging to a specific component are mapped to the
 * relevant SQL queries, therefore encapsulating low-level database access inside
 * this class.
 */
class DataFiles
{
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
     * Performs a query using the keys and values of the parameter array as part
     * of the command's WHERE clause.
     * @param array $params An array whose keys should be used as components of the
     *                      WHERE clause for the SELECT statement.
     * @return array An array containing the results of the performed query.
     */
    protected function perform_query(array $params): array {
        return $this->get_database()->get_records_sql($this->prepare_statement($params), $params);
    }

    public function get_course($courseid) {
        return $this->get_database()->get_record('course', ['id' => $courseid], '*', MUST_EXIST);
    }

    public function get_page($instance) {
        return $this->get_database()->get_record('page', ['id' => $instance->instance], '*');
    }
}
