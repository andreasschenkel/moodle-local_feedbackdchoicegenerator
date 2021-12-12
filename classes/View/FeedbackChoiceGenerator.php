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

namespace report_feedbackchoicegenerator\View;

use stdClass;
use moodle_database;

use report_feedbackchoicegenerator\Helper;
use report_feedbackchoicegenerator\Manager;

/**
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
     * @var stdClass
     */
    private $user;

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
     * @param stdClass $user
     */
    public function __construct($db, int $courseid, $page, $output, $user) {
        $this->courseid = $courseid;
        $this->user = $user;
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
        $maxlength = (int)$CFG->report_feedbackchoicegenerator_maxlength;
        $maxoptionslength = (int)$CFG->report_feedbackchoicegenerator_maxoptionslength;

        $this->apim->security()->user_is_allowed_to_view_the_course_and_has_capability_to_use_generator($this->courseid);

        echo $this->get_page()->get_output()->header();

        $size = (is_numeric($_POST['size']) ? (int)$_POST['size'] : 2);
        if ($size > $maxlength) {
            $size = $maxlength;
        }

        if ($size === '') {
            $size = 2;
        }

        $filename = '';
        for ($i = 1; $i <= (int)$size; $i++) {
            $optioncounter = trim($_POST["option$i"]);
            // Cut optioncounter if it is to long.
            $optioncounter = substr($optioncounter , 0, $maxoptionslength);
            $options[] = array(
                'optionnumber' => $i,
                'optionlabel' => "Option $i",
                'optionname' => "option$i",
                'optionvalue' => $optioncounter
            );
            $optionsarray[$i] = "$optioncounter";
        }

        $textareacontent = $this->textareagenerator($optionsarray);
        $dataurl = 'data:application/xml;charset=UTF-8;utf8,' . $textareacontent;

        echo $this->get_page()->get_output()->render_from_template(
            'report_feedbackchoicegenerator/reportgenerator',
            [
                'courseid' => $this->courseid,
                'title' => $this->get_page()->get_title(),
                'header3' => get_string('header3', 'report_feedbackchoicegenerator'),
                'summary' => get_string('summary', 'report_feedbackchoicegenerator'),

                'courseidlabel' => get_string('courseidlabel', 'report_feedbackchoicegenerator'),
                'sizelabel' => get_string('sizelabel', 'report_feedbackchoicegenerator'),
                'maxlength' => $maxlength,

                'optionsheader' => get_string('optionsheader', 'report_feedbackchoicegenerator'),
                'description' => get_string('description', 'report_feedbackchoicegenerator'),

                'size' => $size,
                'filename' => $filename,
                'options' => $options,
                'maxoptionslength' => $maxoptionslength,
                'textareacontent' => $textareacontent,
                'buttonlabel' => get_string('buttonlabel', 'report_feedbackchoicegenerator'),
                'downloadbuttonlabel' => get_string('downloadbuttonlabel', 'report_feedbackchoicegenerator'),
                'resetbuttonlabel' => get_string('resetbuttonlabel', 'report_feedbackchoicegenerator'),
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
