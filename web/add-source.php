<?php
session_start();
if(!isset($_SESSION["username"]))
    header("Location: index.php");
?>
<!DOCTYPE html>

<html>
    <head>
        <title>The Kanji Studier: Add Source</title>
        <meta charset="utf-8" />
        
        <link rel="stylesheet" type="text/css" href="index.css" />
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    </head>

    <body>
        <?php include '../src/MenuBar.php'?>
        
        <div class="content">
            <div class="content-block">
                <h2 class="content-header">Please choose a kanji source to begin tracking</h2>
                <form action="rate-kanji.php" method="post">
                    <label for="source">Source</label>
                    <br>
                    <select id="source" name="source" size=4>
                        <?php include '../src/GetSourcesToAdd.php'?>
                    </select>
                    <br>
                    <input type="submit" value="Submit" style="width: 100%">
                </form>
            </div>
        </div>
    </body>
</html>
