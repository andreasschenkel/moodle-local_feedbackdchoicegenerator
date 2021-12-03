<?php

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
    private $page;

    /**
     * @var int
     */
    private $courseId;

    /**
     * @var stdClass
     */
    private $user;

    /**
     * @var Manager
     */
    private $apiM;


    /**
     * FeedbackChoiceGenerator constructor.
     * @param moodle_database $db
     * @param int $courseId
     * @param moodle_page $page
     * @param bootstrap_renderer $output
     * @param stdClass $user
     */
    public function __construct($db, int $courseId, $page, $output, $user)
    {
        $this->courseId = $courseId;
        $this->user = $user;
        $this->apiM = new Manager($db);

        $course = $this->apiM->database()->dataFiles()->getCourse($courseId);

        $this->page = new Page($page, $course, $courseId, $output);
    }

    /**
     * @return Page
     */
    public function getPage(): Page
    {
        return $this->page;
    }

    /**
     * @throws coding_exception
     * @throws dml_exception
     * @throws moodle_exception
     * @throws require_login_exception
     */
    public function init()
    {
        global $CFG;
        $maxlength = (int)$CFG->report_feedbackchoicegenerator_maxlength;
        $maxoptionslength = (int)$CFG->report_feedbackchoicegenerator_maxoptionslength;

        $this->apiM->security()->userIsAllowedToViewTheCourseAndHasCapabilityToUseGenerator($this->courseId);

        echo $this->getPage()->getOutput()->header();
       
        $size = (is_numeric($_POST['size']) ? (int)$_POST['size'] : 2);
            if ($size > $maxlength) {
                $size = $maxlength;
            }

        if ($size === '') {
            $size = 2;
        }

        $filename = '';
        for ($i = 1; $i <= (int)$size; $i++) {
            $option_i = trim($_POST["option$i"]);
            // cut option_i if it is to long
            $option_i = substr($option_i , 0, $maxoptionslength);
            $options[] = array(
                'optionnumber' => $i,
                'optionlabel' => "Option $i",
                'optionname' => "option$i",
                'optionvalue' => $option_i
            );
            $optionsArray[$i] = "$option_i";
        }

        $textareacontent = $this->textareagenerator($optionsArray);
        $dataurl = 'data:application/xml;charset=UTF-8;utf8,' . $textareacontent;

        echo $this->getPage()->getOutput()->render_from_template(
            'report_feedbackchoicegenerator/reportgenerator',
            [
                'courseid' => $this->courseId,
                'title' => $this->getPage()->getTitle(),
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
                'dataurl' => $dataurl
            ]
        );

        echo $this->getPage()->getOutput()->footer();
    }

    /**
     * @param array $optionsArray   Array contains all options
     * 
     * @return string xml-code to add into textarea in htmlpage
     */
    public function textareagenerator($optionsArray): string
    {
        // define the itemnumber to start with (maybe later I will set it to 1 instead of 367)
        $itemnumber = 367;

        // we need $itemnumberFirstChoice as reference for the second choice
        $itemnumberFirstChoice = $itemnumber + 1;

        // A. head of document
        $helper = new Helper();
        $textareacontent = $helper->generateDocumentHeaderOpeninglines();
        $textareacontent = $textareacontent . $helper->generateDocumentHeader($itemnumber);

        // B. generate first choice
        $selectedoption = "alleOptionenNutzenFürErstwahl"; // bei der erstwahl ist keine auswahl vorhanden, also werden dann einfach alle genutzt
        $level = 1; // first selectionoverview with all options
        // @todo $option has to be set -> use of pattern SOLID
        $textareacontent = $textareacontent . $helper->generateSelectionOverview(
            $level,
            ++$itemnumber,
            $itemnumberFirstChoice,
            $helper->generateOptionsList($optionsArray, $selectedoption),
            $option
        );

        // C. generate pagebreak to seperate first choice
        $textareacontent = $textareacontent . $helper->generatePagebreak(++$itemnumber);

        // D. generate second choice
        foreach ($optionsArray as $option) {
            $textareacontent = $textareacontent . $helper->generateLabel(++$itemnumber, $itemnumberFirstChoice, $option);

            $selectedoption = $option;
            $level = 2; // second selectionoverview
            $textareacontent = $textareacontent . $helper->generateSelectionOverview(
                $level,
                ++$itemnumber,
                $itemnumberFirstChoice,
                $helper->generateOptionsList($optionsArray, $selectedoption),
                $option
            );

            $textareacontent = $textareacontent . $helper->generatePagebreak(++$itemnumber);
        }
        $textareacontent = $textareacontent . $helper->generateDocumentLastlines();

        return $textareacontent;
    }
}
