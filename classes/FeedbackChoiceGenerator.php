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

use stdClass;
use moodle_database;

use local_feedbackchoicegenerator\Helper;
use local_feedbackchoicegenerator\Manager;

/**
 * @package    local_feedbackchoicegenerator
 * Class FeedbackChoiceGenerator
 */
class FeedbackChoiceGenerator
{

    /**
     * @var moodle_page
     */
    private $page;

    /**
     * @var int
     */
    private $courseid;


    /**
     * @var Manager
     */
    private $apim;

    /**
     * FeedbackChoiceGenerator constructor.
     * @param moodle_database $db
     * @param int $courseid
     * @param moodle_page $page
     * @param bootstrap_renderer $output
     */
    public function __construct($db, int $courseid, $page, $output) {
        $this->courseid = $courseid;
        $this->apim = new Manager($db);

        $course = $this->apim->database()->data_files()->get_course($courseid);

        $this->page = new Page($page, $course, $courseid, $output);
    }

    /**
     * getter for Page
     * @return Page
     */
    public function get_page(): Page {
        return $this->page;
    }

    /**
     * @throws coding_exception
     * @throws dml_exception
     * @throws moodle_exception
     * @throws require_login_exception
     */
    public function init() {
        global $CFG;
        $maxlength = (int)$CFG->local_feedbackchoicegenerator_maxlength;
        $maxoptionslength = (int)$CFG->local_feedbackchoicegenerator_maxoptionslength;
        $optionlabel = '';
        $optionlabel = get_string('optionlabel', 'local_feedbackchoicegenerator');

        $this->apim->security()->user_is_allowed_to_view_the_course_and_has_capability_to_use_generator($this->courseid);

        echo $this->get_page()->get_output()->header();

        if (isset($_POST['size'])) {
            $size = (is_numeric($_POST['size']) ? (int)$_POST['size'] : 2);
        } else {
            $size = 3;
        }

        if ($size > $maxlength) {
            $size = $maxlength;
        }

        if ($size === '') {
            $size = 2;
        }

        $filename = '';
        for ($i = 1; $i <= (int)$size; $i++) {
            if (isset($_POST["option$i"])) {
                 $optioncounter = trim($_POST["option$i"]);
            } else {
                $optioncounter = '';
            }

            // Cut optioncounter if it is to long.
            $optioncounter = substr($optioncounter , 0, $maxoptionslength);
            $options[] = array(
                'optionnumber' => $i,
                'optionlabel' => "$optionlabel $i",
                'optionname' => "option$i",
                'optionvalue' => $optioncounter
            );
            $optionsarray[$i] = "$optioncounter";
        }

        $textareacontent = $this->textareagenerator($optionsarray);
        $dataurl = 'data:application/xml;charset=UTF-8;utf8,' . $textareacontent;

        $wwwroot = $CFG->wwwroot;

        echo $this->get_page()->get_output()->render_from_template(
            'local_feedbackchoicegenerator/mainpage',
            [
                'wwwroot' => $wwwroot,
                'courseid' => $this->courseid,
                'backtocourselabel' => get_string('backtocourselabel', 'local_feedbackchoicegenerator'),
                
                'title' => $this->get_page()->get_title(),
                'header3' => get_string('header3', 'local_feedbackchoicegenerator'),
                'summary' => get_string('summary', 'local_feedbackchoicegenerator'),

                'courseidlabel' => get_string('courseidlabel', 'local_feedbackchoicegenerator'),
                'sizelabel' => get_string('sizelabel', 'local_feedbackchoicegenerator'),
                'maxlength' => $maxlength,

                'optionslengthinfo' => get_string('optionslengthinfo', 'local_feedbackchoicegenerator'),
                'description' => get_string('description', 'local_feedbackchoicegenerator'),

                'size' => $size,
                'filename' => $filename,
                'options' => $options,
                'maxoptionslength' => $maxoptionslength,
                'textareacontent' => $textareacontent,
                'buttonlabel' => get_string('buttonlabel', 'local_feedbackchoicegenerator'),
                'downloadbuttonlabel' => get_string('downloadbuttonlabel', 'local_feedbackchoicegenerator'),
                'updatebuttonlabel' => get_string('updatebuttonlabel', 'local_feedbackchoicegenerator'),
                'resetbuttonlabel' => get_string('resetbuttonlabel', 'local_feedbackchoicegenerator'),
                'dataurl' => $dataurl
            ]
        );

        echo $this->get_page()->get_output()->footer();
    }

    /**
     * generates the xml-content and returns the content as string
     * @param array $optionsarray   Array contains all options
     * @return string xml-code to add into textarea in htmlpage
     */
    public function textareagenerator($optionsarray): string {
        // Define the itemnumber to start with (maybe later I will set it to 1 instead of 367).
        $itemnumber = 367;

        // We need $itemnumberfirstchoice as reference for the second choice.
        $itemnumberfirstchoice = $itemnumber + 1;

        // A. head of document.
        $helper = new Helper();
        $textareacontent = $helper->generate_document_header_openinglines();
        $textareacontent = $textareacontent . $helper->generate_document_header($itemnumber);

        // B. generate first choice.
        // Bei der erstwahl ist keine auswahl vorhanden, also werden dann einfach alle genutzt.
        $selectedoption = "alleOptionenNutzenFürErstwahl";
        // First selectionoverview with all options is level=1.
        $level = 1;
        // ToDo: $option has to be set -> use of pattern SOLID.
        $option = '';
        $textareacontent = $textareacontent . $helper->generate_selection_overview(
            $level,
            ++$itemnumber,
            $itemnumberfirstchoice,
            $helper->generate_options_list($optionsarray, $selectedoption),
            $option
        );

        // C. generate pagebreak to seperate first choice.
        $textareacontent = $textareacontent . $helper->generate_pagebreak(++$itemnumber);

        // D. generate second choice.
        foreach ($optionsarray as $option) {
            $textareacontent = $textareacontent . $helper->generate_label(++$itemnumber, $itemnumberfirstchoice, $option);

            $selectedoption = $option;
            // Second selectionoverview is level = 2.
            $level = 2;
            $textareacontent = $textareacontent . $helper->generate_selection_overview(
                $level,
                ++$itemnumber,
                $itemnumberfirstchoice,
                $helper->generate_options_list($optionsarray, $selectedoption),
                $option
            );

            $textareacontent = $textareacontent . $helper->generate_pagebreak(++$itemnumber);
        }
        $textareacontent = $textareacontent . $helper->generate_document_last_lines();

        return $textareacontent;
    }
}
