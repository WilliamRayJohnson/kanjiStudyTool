<?php
    /**
    * An accessor that that provides all necessary queries to the kanji_studier DB
    */
    class DBAccessor {
        var $dbInfo;
        
        /**
        * Constructs the accessor with the information necessary to access the DB
        * @param string $dbinfo An array that contains DB_SERVER, the server IP, 
        *       DB_USERNAME, the username to login under, DB_PASSWORD, the user's password, 
        *       and DB_DATABASE, the name of the database
        */
        function __construct($dbInfo) {
            $this->dbInfo = $dbInfo;
        }
        
        /**
        * Echos all of the kanji found in the DB
        */
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
        
        /**
        * Retrives all words and readings that a kanji is contained within given a kanji_id.
        * @param int $kanjiID The ID of the kanji
        * @return string A 2-dimensional array of words containing the kanji and their associated hiragana reading 
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
        
        /**
        * Adds a word and its reading to the DB.
        * @param string $word The word in kanji to add to the DB
        * @param string $reading The hiragana reading for the word
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
        
        /**
        * Adds a kanji to the DB.
        * @param string $kanji A single kanji to add to the DB
        * @param int $source_id the id of the source the kanji comes from
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
        
        /**
        * Adds a source to the DB.
        * @param string $source_name the name of the source to add
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
        
        /**
        * Associates a kanji and a word in the DB
        * @param int $wordID the ID of the word
        * @param int $kanjiID the ID of the kanji
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
        
        /**
        * Checks to see if kanji is in the DB.
        * @param string $theKanji the kanji in question
        * @return bool True if kanji is found in the DB
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

        /**
        * Get the id and names of all sources
        * @return string A 2-dimensional array of source id and name pairs
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
        
        /**
        * Gets the id of a given kanji
        * @param string $theKanji the kanji in question
        * @return int The ID of the kanji passed
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
        
        /**
        * Gets the id of a given word
        * @param string $theWord the word in question
        * @return int The ID of the word passed
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
        
        /**
        * Get stats on kanji for a particular user
        * @param string $kanji The kanji stats are wanted on
        * @param string $user The user who the stats are on
        * @return mixed A array of containing the user's stats on the kanji passed
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
                $stats["totalQuestions"] = $row["total_questions_asked"];
            }
            mysqli_close($db);
            
            return $stats;
        }
        
        /**
        * Updates stats of particular user's kanji
        * @param string $kanji The kanji the user was quizzed on
        * @param string $user The user who produced the results
        * @param float $newRetentionScore The newly generated retention score for the kanji of that user
        */
        function updateKanjiStats($kanji, $user, $newRetentionScore) {
            $db = mysqli_connect($this->dbInfo['DB_SERVER'], $this->dbInfo['DB_USERNAME'], $this->dbInfo['DB_PASSWORD'], $this->dbInfo['DB_DATABASE']);
            mysqli_set_charset($db, "utf8");
            
            if (!$db)
                die("Connection failed: " . mysqli_connect_error());
        
            $sql = sprintf("CALL UPDATE_KANJI_STATS(\"%s\", \"%s\", %f)", 
                        $kanji, $user, $newRetentionScore);
            mysqli_query($db, $sql);
            mysqli_close($db);
        }
        
        /**
        * Retrives the kanji and word for N number of questions
        * to be asked for a user. Results will be N kanji with the lowest
        * retention scores for that user.
        * @param string $username The user taking the quiz
        * @param int $quizLength The number of questions to be asked
        * @return string A 2-dimensional array of a kanji, word, and reading triplet 
        *       denoted as qKanji, qWord, qReading for use in a quiz
        */
        function getQuizQuestions($username, $quizLength) {
            $quizQuestions = array();
            $db = mysqli_connect($this->dbInfo['DB_SERVER'], $this->dbInfo['DB_USERNAME'], $this->dbInfo['DB_PASSWORD'], $this->dbInfo['DB_DATABASE']);
            mysqli_set_charset($db, "utf8");

            if (!$db)
                die("Connection failed: " . mysqli_connect_error());

            $sql = sprintf("CALL GET_QUIZ_QUESTIONS(\"%s\", %d)", $username, $quizLength);
            $results = mysqli_query($db, $sql);

            if (mysqli_num_rows($results) > 0) {
                while($row = mysqli_fetch_assoc($results))
                    array_push($quizQuestions, $row);
            }
            mysqli_close($db);

            return $quizQuestions;
        }

        /**
        * Retrieves answers in the form of word for a question involving
        * a particular kanji while excluding the word the question is asking
        * about.
        * @param string $kanji The kanji to get quiz choices for
        * @param string $word The word the question will be asking about (included so it can be excluded from query)
        * @param int $answerCount The number of choices to retrieve
        * @return string A 2-dimensional array containing the array of words retrieved, denoted
        *       by words, and the array of readings retrieved, denoted by readings. Words and
        *       readings do not need to be explictly pair up as the question will use one or the
        *       other.
        */
        function getQuizAnswers($kanji, $word, $answerCount) {
            $quizAnswers = array("words" => array(), "readings" => array());
            $db = mysqli_connect($this->dbInfo['DB_SERVER'], $this->dbInfo['DB_USERNAME'], $this->dbInfo['DB_PASSWORD'], $this->dbInfo['DB_DATABASE']);
            mysqli_set_charset($db, "utf8");

            if (!$db)
                die("Connection failed: " . mysqli_connect_error());

            $sql = sprintf("CALL GET_QUIZ_ANSWERS(\"%s\", \"%s\", %d)",
                        $kanji, $word, $answerCount);
            $results = mysqli_query($db, $sql);

            if (mysqli_num_rows($results) > 0) {
                while($row = mysqli_fetch_assoc($results)) {
                    array_push($quizAnswers["words"], $row["word"]);
                    array_push($quizAnswers["readings"], $row["reading"]);
                }
            }
            mysqli_close($db);

            return $quizAnswers;
        }
    }
?>
