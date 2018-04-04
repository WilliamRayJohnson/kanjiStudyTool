<?php
session_start();
include '../src/DBAccessor.php';
$dbInfo = include('../config/config.php');
$accessor = new DBAccessor($dbInfo);

if(isset($_SESSION["sourceToAdd"])){
    $kanjiToRate = $accessor->getKanjiOfSource($_SESSION["sourceToAdd"]);
    foreach($kanjiToRate as $kanji) {
        print <<<INPUT
        <h3>$kanji</h3>
        <fieldset>
        <input type="radio" name="$kanji" id="poor" value="0.1">
            <label for="poor">Poor</label>
        <input type="radio" name="$kanji" id="fine" value="0.3">
            <label for="fine">Fine</label>
        <input type="radio" name="$kanji" id="average" value="0.5">
            <label for="average">Average</label>
        <input type="radio" name="$kanji" id="memorized" value="0.7">
            <label for="memorized">Memorized</label>
        <input type="radio" name="$kanji" id="known" value="0.9">
            <label for="known">Known</label>
        </fieldset>
INPUT;

    unset($_SESSION["sourceToAdd"]);
    }
}
else
    echo "None";
?>