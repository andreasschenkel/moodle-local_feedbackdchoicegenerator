<?php

require_once(__DIR__ . '/../../config.php');

use report_feedbackchoicegenerator\View\FeedbackChoiceGenerator;

/* 
 * @todo Assign global variables to local (parameter) variables.
 * At the moment, this approach is used for documentation purposes.
 */

$courseId = required_param('id', PARAM_INT);
$page = $PAGE;
$output = $OUTPUT;
$user = $USER;
$db = $DB;

$feedbackChoiceGeneratorInstance = new FeedbackChoiceGenerator($db, $courseId, $page, $output, $user);

global $CFG;
$isactive = $CFG->report_feedbackchoicegenerator_isactive;
if ($isactive) {
    $feedbackChoiceGeneratorInstance->init();
} else {
    echo "is not activ";
}
