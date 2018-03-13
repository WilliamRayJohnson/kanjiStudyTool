<?php
include '../../src/QuizResultsProcessor.php';

openlog('kanjistudier', LOG_NDELAY, LOG_USER);
syslog(LOG_NOTICE, sprintf("%s submitted a quiz", $_POST["username"]));
closelog();
?>