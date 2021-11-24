<?php

namespace report_feedbackchoicegenerator\View;

use stdClass;
use moodle_database;
use context_course;

use report_feedbackchoicegenerator\Helper;
use report_feedbackchoicegenerator\Files\FileInfo;
use report_feedbackchoicegenerator\Manager;
use report_feedbackchoicegenerator\Misc;
use report_feedbackchoicegenerator\HTML;

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

    public function getPage(): Page
    {
        return $this->page;
    }

    /**
     * if the page is opened with a POST request,
     * this means the user has confirmed to delete a single orphaned file,
     * then we are checking if the file belongs to the user and delete it
     *
     * @return void
     * @throws coding_exception
     * @throws moodle_exception
     * @throws require_login_exception
     */
    public function deleteOrphanedFile(): void
    {
        // validate if the user is logged in and allowed to view the course
        // this method throws an exception if the user is not allowed
        $this->apiM->security()->userIsAllowedToViewTheCourse($this->courseId);

        if (
            $_SERVER['REQUEST_METHOD'] === 'POST' &&
            FileInfo::isSufficientForConstruction($_POST)
        ) {
            $this->afterDeletion = $this->apiM->files()->deleteFileByUserInCourse(
                $this->apiM->security(),
                new FileInfo($_POST),
                $this->user,
                $this->courseId
            );
        }
    }

    public function listOrphansForSection($sectionInfo)
    {
        $courseContextId = context_course::instance($this->courseId)->id;

        $viewOrphanedFiles = [];
        $viewOrphanedFiles = $this->apiM->handler()->sectionSummaryHandler()->getViewOrphanedFiles(
            $viewOrphanedFiles,
            $courseContextId,
            $sectionInfo,
            $this->user,
            $this->courseId,
            '' // Intentionally left blank: In case of a section summary, there is no iconHtml information
        );

        $modInfo = $sectionInfo->modinfo;

        foreach ($modInfo->instances as $instances) {
            foreach ($instances as $instance) {
                if ($sectionInfo->id === $instance->section) {
                    if ($instance->deletioninprogress !== '1') {
                        if ($this->apiM->handler()->hasHandlerFor($instance)) {
                            $viewOrphanedFiles = $this->apiM->handler()->getHandlerFor($instance)
                                ->bind($this->user, $this->courseId, $instance, $this->getPage())
                                ->addOrphans($viewOrphanedFiles);
                        }
                    }
                }
            }
        }

        return $viewOrphanedFiles;
    }

    public function createOrphansList($sectionInfo, $usingTemplate): string
    {
        $viewOrphanedFiles = $this->listOrphansForSection($sectionInfo);

        if (!empty($viewOrphanedFiles)) {
            $translations = Misc::translate(['isallowedtodeleteallfiles', 'description'], 'report_feedbackchoicegenerator');
            $translations['header'] = Misc::translate(['modName', 'content', 'filename', 'preview', 'tool', 'moduleContent', 'code'], 'report_feedbackchoicegenerator', 'header.');

            return $this->getPage()->getOutput()->render_from_template(
                $usingTemplate,
                ['orphanedFiles' => $viewOrphanedFiles, 'translation' => $translations]
            );
        }

        return "";
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
        $maxlength = $CFG->report_feedbackchoicegenerator_maxlength;

        // validate if the user is logged in and allowed to view the course
        // this method throws an exception if the user is not allowed
        $this->apiM->security()->userIsAllowedToViewTheCourse($this->courseId);

        /* löschen  $allowedToViewDeleteAllFiles = $this->apiM->security()->allowedToViewDeleteAllFiles(
            $this->courseId,
            $this->user
        );*/

        echo $this->getPage()->getOutput()->header();

        $size = trim($_POST["size"]);
        if ($size === '') {
            $size = 5;
        }

        $filename = '';
        for ($i = 1; $i <= (int)$size; $i++) {
            $option_i = trim($_POST["option$i"]); //bisherige werte auslesen trim($_POST["size"])
            $options[] = array(
                'optionnumber' => $i,
                'optionlable' => "Option $i",
                'optionname' => "option$i",
                'optionvalue' => $option_i 
            );
            $optionsArray[$i] = "$option_i";
        }
      
        $textareacontent = $this->textareagenerator($optionsArray);

        echo $this->getPage()->getOutput()->render_from_template(
            'report_feedbackchoicegenerator/reportgenerator',
            [
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
                'textareacontent' => $textareacontent
            ]
        );

        echo $this->getPage()->getOutput()->footer();
    }



    public function textareagenerator( $optionsArray ): string
    {

        // only for testing and developing purpose some examle options
        //$optionsArray = ["Auswahlmöglichkeit Option 1", "Auswahlmöglichkeit Option 2", "Auswahlmöglichkeit Option 3", "Auswahlmöglichkeit Option 4",  "Auswahlmöglichkeit Option 5"];
        //////$optionsArray = $_SESSION['options'];

        // define the itemnumber to start with (maybe later I will set it to 1 instead of 680)
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
             $textareacontent = $textareacontent. $helper->generateSelectionOverview(
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
