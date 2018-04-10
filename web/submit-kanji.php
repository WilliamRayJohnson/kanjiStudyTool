<?php
session_start();
if(!isset($_SESSION["username"]))
    header('Location: index.php');
?>
<!DOCTYPE html>

<html>
    <head>
        <title>The Kanji Studier: Kanji Rated</title>
        <meta charset="utf-8" />

        <link rel="stylesheet" type="text/css" href="index.css" />
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    </head>

    <body>
        <?php include '../src/MenuBar.php'?>

        <div class="content">
            <div class="content-block">
                <?php
                    $dbInfo = require_once('../config/config.php');
                    $accessor = new DBAccessor($dbInfo);
                    while($score = current($_POST)) {
                        $accessor->startTrackingKanjiForStudent($_SESSION["username"], key($_POST), floatval($score));
                        next($_POST);
                    }
                    echo "Source successfully added to your study set!";
                ?>
            </div>
        </div>
    </body>
</html>
