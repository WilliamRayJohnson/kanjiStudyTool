<?php
include '../../src/QuizResultsProcessor.php';
include '../../src/DBAccessor.php';
$dbInfo = include('../../config/config.php');

$accessor = new DBAccessor($dbInfo);

openlog('kanjistudier', LOG_NDELAY, LOG_USER);
syslog(LOG_NOTICE, sprintf("%s submitted a quiz", $_POST["username"]));

$kanjiStats;
foreach($_POST["questions"] as $question) {
    $kanjiStats = $accessor->getKanjiStats($question["kanji"], $_POST["username"]);
    $newRetentionScore = QuizResultsProcessor::calcBasicRetentionScore(
                            $kanjiStats["totalQuestions"], $question["correct"],
                            $question["incorrect"], $kanjiStats["score"]);
    $accessor->updateKanjiStats($question["kanji"], $_POST["username"], $newRetentionScore);
    syslog(LOG_NOTICE, sprintf("%s's %s retention score updated to %f",
        $_POST["username"], $question["kanji"], $newRetentionScore));
}
closelog();
?>