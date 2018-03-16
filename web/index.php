<!DOCTYPE html>
<?php
session_start();
$_SESSION["username"] = "William";
?>

<html>
    <head>
        <title>The Kanji Studier</title>
        <meta charset="utf-8" />
        
        <link rel="stylesheet" type="text/css" href="index.css" />
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    </head>

    <body>
        <?php include '../src/MenuBar.php'?>
        
        <div class="content">
            <a class="content-button" href="QuizPage.php">Take a Quiz</a>
        </div>
    </body>
</html>
