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
    
    $kanjiOfWord = preg_replace("/\P{Han}/u",'' , $wordToAdd[0]);
    for( $kan = 0; $kan < mb_strlen($kanjiOfWord); $kan++) {
        $kanji = mb_substr($kanjiOfWord, $kan, 1);
        if (!$accessor->hasKanji($kanji)) {
            printf("%s is not in the database. Please provide a source ID.\n", $kanji);
            $sources = $accessor->getSourceInfo();
            foreach ($sources as $source) {
                printf("%s: %s\n", $source[0], $source[1]);
            }
            $sourceID = readline();
            $accessor->addKanji($kanji, (int)$sourceID);
        }
        $accessor->linkWordAndKanji($wordToAdd[0], $kanji);
    }
?>
