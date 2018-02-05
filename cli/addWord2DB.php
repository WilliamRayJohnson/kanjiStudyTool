#!/usr/bin/env php

<?php
    /*
    This script will ask for a word in kanji, add the word to the DB and link it with the correct kanji.
    If the kanji doesn't exist, it will be added.
    */
    include '../src/DBAccessor.php';
    $dbInfo = include('../config/config.php');
    $accessor = new DBAccessor($dbInfo);
    $readUnicode = "./getUnicode.py";
    
    mb_regex_encoding('UTF-8');
    mb_internal_encoding('UTF-8');
    
    printf("Please print the word and reading you would like to add\n");
    printf("Word: ");
    exec($readUnicode, $wordToAdd);
    printf("Reading: ");
    exec($readUnicode, $readingForWord);
    $accessor->addWord($wordToAdd[0], $readingForWord[0]);
    
    for( $kan = 0; $kan <= mb_strlen($wordToAdd[0]); $kan++) {
        $kanji = mb_substr($wordToAdd[0], $kan, 1);
        if ($accessor->hasKanji($kanji)) {
            $kanjiID = $accessor->getKanjiID($kanji);
            $wordID = $accessor->getWordID($wordToAdd[0]);
            $accessor->linkWordAndKanji($wordID, $kanjiID);
        }
        else {
            //Kanji will be added, but user must be prompted for source
        }
    }
?>