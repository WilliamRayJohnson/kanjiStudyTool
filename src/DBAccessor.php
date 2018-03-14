<?php
    /*
        An accessor that that provides all necessary queries to the kanji_studier DB.
    */
    class DBAccessor {
        var $dbInfo;
        
        function __construct($dbInfo) {
            $this->dbInfo = $dbInfo;
        }
        
        function displayAllKanji() {
            $db = mysqli_connect($this->dbInfo['DB_SERVER'], $this->dbInfo['DB_USERNAME'], $this->dbInfo['DB_PASSWORD'], $this->dbInfo['DB_DATABASE']);
            mysqli_set_charset($db, "utf8");
            
            if (!$db) {
                die("Connection failed: " . mysqli_connect_error());
            }
            
            $sql = "SELECT * FROM kanji";
            $result = mysqli_query($db, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<p>" . $row["kanji"] . "</p>";
                }
            }
            else {
                echo "0 results";
            }
            
            mysqli_close($db);
        }
        
        /*
            Retrives all words and readings that a kanji is contained within given a kanji_id.
        */
        function getWordsWithKanji($kanjiID) {
            $wordsAndReadings = array();
            $db = mysqli_connect($this->dbInfo['DB_SERVER'], $this->dbInfo['DB_USERNAME'], $this->dbInfo['DB_PASSWORD'], $this->dbInfo['DB_DATABASE']);
            mysqli_set_charset($db, "utf8");
            
            if (!$db) {
                die("Connection failed: " . mysqli_connect_error());
            }
            
            $sql = "CALL get_words_containing_kanji(" . $kanjiID . ")";
            $result = mysqli_query($db, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $wordsAndReadings[] = array($row["word"], $row["reading"]);
                }
            }
            
            mysqli_close($db);
            
            return $wordsAndReadings;
        }
        
        /*
            Adds a word and its reading to the DB.
        */
        function addWord($word, $reading) {
            $db = mysqli_connect($this->dbInfo['DB_SERVER'], $this->dbInfo['DB_USERNAME'], $this->dbInfo['DB_PASSWORD'], $this->dbInfo['DB_DATABASE']);
            mysqli_set_charset($db, "utf8");
            
            if (!$db) {
                die("Connection failed: " . mysqli_connect_error());
            }
            
            $sql = "CALL add_word(\"" . $word . "\",\"" . $reading . "\")";
            mysqli_query($db, $sql);

            mysqli_close($db);
        }
        
        /*
            Adds a kanji to the DB.
        */
        function addKanji($kanji, $source_id) {
            $db = mysqli_connect($this->dbInfo['DB_SERVER'], $this->dbInfo['DB_USERNAME'], $this->dbInfo['DB_PASSWORD'], $this->dbInfo['DB_DATABASE']);
            mysqli_set_charset($db, "utf8");
            
            if (!$db) {
                die("Connection failed: " . mysqli_connect_error());
            }
            
            $sql = "CALL add_kanji(\"" . $kanji . "\"," . $source_id . ")";
            mysqli_query($db, $sql);

            mysqli_close($db);
        }
        
        /*
            Adds a source to the DB.
        */
        function addSource($source_name) {
            $db = mysqli_connect($this->dbInfo['DB_SERVER'], $this->dbInfo['DB_USERNAME'], $this->dbInfo['DB_PASSWORD'], $this->dbInfo['DB_DATABASE']);
            mysqli_set_charset($db, "utf8");
            
            if (!$db) {
                die("Connection failed: " . mysqli_connect_error());
            }
            
            $sql = "CALL add_source(\"" . $source_name . "\")";
            mysqli_query($db, $sql);

            mysqli_close($db);
        }
        
        /*
            Links a word and kanji together
        */
        function linkWordAndKanji($wordID, $kanjiID) {
            $db = mysqli_connect($this->dbInfo['DB_SERVER'], $this->dbInfo['DB_USERNAME'], $this->dbInfo['DB_PASSWORD'], $this->dbInfo['DB_DATABASE']);
            mysqli_set_charset($db, "utf8");
            
            if (!$db) {
                die("Connection failed: " . mysqli_connect_error());
            }
            
            $sql = "CALL link_kanji_and_word(" . $kanjiID . "," . $wordID . ")";
            mysqli_query($db, $sql);

            mysqli_close($db);
        }
        
        /*
            Checks to see if kanji is in the DB.
        */
        function hasKanji($theKanji) {
            $kanjiExist = false;
            $db = mysqli_connect($this->dbInfo['DB_SERVER'], $this->dbInfo['DB_USERNAME'], $this->dbInfo['DB_PASSWORD'], $this->dbInfo['DB_DATABASE']);
            mysqli_set_charset($db, "utf8");
            
            if (!$db) {
                die("Connection failed: " . mysqli_connect_error());
            }
            
            $sql = "SELECT id FROM kanji WHERE kanji=\"" . $theKanji . "\"";
            $result = mysqli_query($db, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                $kanjiExist = true;
            }
            
            mysqli_close($db);
            
            return $kanjiExist;
        }

        /*
            Get the id and names of all sources
         */
        function getSourceInfo() {
            $sourceInfo = array();
            $db = mysqli_connect($this->dbInfo['DB_SERVER'], $this->dbInfo['DB_USERNAME'], $this->dbInfo['DB_PASSWORD'], $this->dbInfo['DB_DATABASE']);
            mysqli_set_charset($db, "utf8");
            
            if (!$db) {
                die("Connection failed: " . mysqli_connect_error());
            }
            
            $sql = "SELECT * FROM kanji_source";
            $result = mysqli_query($db, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $sourceInfo[] = array($row["id"], $row["source"]);
                }
            }
            
            mysqli_close($db);
            return $sourceInfo;
        }
        
        /*
            Gets the id of a given kanji
        */
        function getKanjiID($theKanji) {
            $kanjiID;
            $db = mysqli_connect($this->dbInfo['DB_SERVER'], $this->dbInfo['DB_USERNAME'], $this->dbInfo['DB_PASSWORD'], $this->dbInfo['DB_DATABASE']);
            mysqli_set_charset($db, "utf8");
            
            if (!$db) {
                die("Connection failed: " . mysqli_connect_error());
            }
            
            $sql = "SELECT id FROM kanji WHERE kanji=\"" . $theKanji . "\"";
            $result = mysqli_query($db, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $kanjiID = $row["id"];
            }
            
            mysqli_close($db);
            
            return (int)$kanjiID;
        }
        
        /*
            Gets the id of a given word
        */
        function getWordID($theWord) {
            $wordID;
            $db = mysqli_connect($this->dbInfo['DB_SERVER'], $this->dbInfo['DB_USERNAME'], $this->dbInfo['DB_PASSWORD'], $this->dbInfo['DB_DATABASE']);
            mysqli_set_charset($db, "utf8");
            
            if (!$db) {
                die("Connection failed: " . mysqli_connect_error());
            }
            
            $sql = "SELECT id FROM word WHERE word=\"" . $theWord . "\"";
            $result = mysqli_query($db, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $wordID = $row["id"];
            }
            
            mysqli_close($db);
            
            return (int)$wordID;
        }
        
        /*
            Get stats on kanji for a particular user
        */
        function getKanjiStats($kanji, $user) {
            $stats = array();
            $db = mysqli_connect($this->dbInfo['DB_SERVER'], $this->dbInfo['DB_USERNAME'], $this->dbInfo['DB_PASSWORD'], $this->dbInfo['DB_DATABASE']);
            mysqli_set_charset($db, "utf8");
            
            if (!$db)
                die("Connection failed: " . mysqli_connect_error());
        
            $sql = sprintf("CALL GET_KANJI_STATS(\"%s\", \"%s\")", $kanji, $user);
            $result = mysqli_query($db, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $stats["score"] = $row["retention_score"];
                $stats["correct"] = $row["correct_response_count"];
                $stats["incorrect"] = $row["incorrect_response_count"];
            }
            mysqli_close($db);
            
            return $stats;
        }
        
        /*
            Updates stats of particular user's kanji
        */
        function updateKanjiStats($kanji, $user, $quizCR, $quizIR, $newRetentionScore) {
            $db = mysqli_connect($this->dbInfo['DB_SERVER'], $this->dbInfo['DB_USERNAME'], $this->dbInfo['DB_PASSWORD'], $this->dbInfo['DB_DATABASE']);
            mysqli_set_charset($db, "utf8");
            
            if (!$db)
                die("Connection failed: " . mysqli_connect_error());
        
            $sql = sprintf("CALL UPDATE_KANJI_STATS(\"%s\", \"%s\", %d, %d, %f)", 
                        $kanji, $user, $quizCR, $quizIR, $newRetentionScore);
            mysqli_query($db, $sql);
            mysqli_close($db);
        }
    }
?>
