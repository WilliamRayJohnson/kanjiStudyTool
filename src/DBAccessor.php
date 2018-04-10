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
        * Adds a word and its reading to the DB.
        * @param string $word The word in kanji to add to the DB
        * @param string $reading The hiragana reading for the word
        */
        function addWord($word, $reading) {
            $db = mysqli_connect($this->dbInfo['DB_SERVER'], $this->dbInfo['DB_USERNAME'], $this->dbInfo['DB_PASSWORD'], $this->dbInfo['DB_DATABASE']);
            mysqli_set_charset($db, "utf8");

            if (!$db)
                die("Connection failed: " . mysqli_connect_error());

            $stmt = $db->prepare("INSERT INTO `word` (`id`, `word`, `reading`)
                                    VALUE (NULL, ?, ?)");
            $stmt->bind_param("ss", $word, $reading);
            $stmt->execute();

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

            if (!$db)
                die("Connection failed: " . mysqli_connect_error());

            $stmt = $db->prepare("INSERT INTO `kanji` (`id`, `kanji`, `source_id`)
                                    VALUES (NULL, ?, ?)");
            $stmt->bind_param("si", $kanji, $source_id);
            $stmt->execute();

            mysqli_close($db);
        }

        /**
        * Associates a kanji and a word in the DB
        * @param string $word the word to associate
        * @param string $kanji the kanji to associate
        */
        function linkWordAndKanji($word, $kanji) {
            $db = mysqli_connect($this->dbInfo['DB_SERVER'], $this->dbInfo['DB_USERNAME'], $this->dbInfo['DB_PASSWORD'], $this->dbInfo['DB_DATABASE']);
            mysqli_set_charset($db, "utf8");

            if (!$db)
                die("Connection failed: " . mysqli_connect_error());

            $stmt = $db->prepare("INSERT INTO `kanji_in_word` (`word_id`, `kanji_id`)
                                    SELECT w.id, k.id
                                        FROM kanji k
                                        CROSS JOIN word w
                                        WHERE k.kanji = ? AND w.word = ?");
            $stmt->bind_param("ss", $kanji, $word);
            $stmt->execute();

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

            if (!$db)
                die("Connection failed: " . mysqli_connect_error());

            $stmt = $db->prepare("SELECT id
                                    FROM kanji
                                    WHERE kanji = ?");
            $stmt->bind_param("s", $theKanji);
            $stmt->execute();
            $result = $stmt->get_result();

            if (mysqli_num_rows($result) > 0)
                $kanjiExist = true;

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

            if (!$db)
                die("Connection failed: " . mysqli_connect_error());

            $sql = "SELECT * FROM kanji_source";
            $result = mysqli_query($db, $sql);

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result))
                    $sourceInfo[] = array($row["id"], $row["source"]);
            }

            mysqli_close($db);
            return $sourceInfo;
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

            $stmt = $db->prepare("SELECT sk.retention_score, sk.total_questions_asked
                                    FROM student_kanji sk
                                    JOIN student s ON s.id = sk.student_id
                                    JOIN kanji k ON k.id = sk.kanji_id
                                    WHERE k.kanji = ? AND s.username = ?");
            $stmt->bind_param("ss", $kanji, $user);
            $stmt->execute();
            $result = $stmt->get_result();

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

            $stmt = $db->prepare("UPDATE student_kanji
                                    SET retention_score = ?,
                                        total_questions_asked = total_questions_asked + 1,
                                        last_time_quized = NOW()
                                    WHERE student_id = (SELECT id FROM student WHERE username = ?)
                                        AND kanji_id = (SELECT id FROM kanji WHERE kanji = ?)");
            $stmt->bind_param("dss", $newRetentionScore, $user, $kanji);
            $stmt->execute();
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

            $stmt = $db->prepare("SELECT qKanji, qWord, qReading
                                    FROM
                                    (SELECT k.kanji AS qKanji, w.word AS qWord,
                                            w.reading AS qReading, sk.retention_score AS qRetention
                                        FROM student s
                                        JOIN student_kanji sk ON s.id = sk.student_id
                                        JOIN kanji k ON sk.kanji_id = k.id
                                        JOIN kanji_in_word kiw ON kiw.kanji_id = k.id
                                        JOIN word w ON kiw.word_id = w.id
                                        WHERE s.username = ?
                                        ORDER BY RAND()) AS q
                                    GROUP BY qKanji
                                    ORDER BY qRetention
                                    LIMIT ?");
            $stmt->bind_param("si", $username, $quizLength);
            $stmt->execute();
            $results = $stmt->get_result();

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

            $stmt = $db->prepare("SELECT w.word, w.reading
                                    FROM word w
                                    JOIN kanji_in_word kiw ON kiw.word_id = w.id
                                    JOIN kanji k ON k.id = kiw.kanji_id
                                    WHERE k.kanji = ? AND NOT w.word = ?
                                UNION
                                SELECT w.word, w.reading
                                    FROM word w
                                    JOIN kanji_in_word kiw ON kiw.word_id = w.id
                                    JOIN kanji k ON k.id = kiw.kanji_id
                                    WHERE k.source_id = (SELECT source_id FROM kanji WHERE kanji=?) AND NOT w.word = ?
                                ORDER BY RAND()
                                LIMIT ?");
            $stmt->bind_param("ssssi", $kanji, $word, $kanji, $word, $answerCount);
            $stmt->execute();
            $results = $stmt->get_result();

            if (mysqli_num_rows($results) > 0) {
                while($row = mysqli_fetch_assoc($results)) {
                    array_push($quizAnswers["words"], $row["word"]);
                    array_push($quizAnswers["readings"], $row["reading"]);
                }
            }
            mysqli_close($db);

            return $quizAnswers;
        }

        /**
        * Retrieves the sources of kanji that are not being track for a particular
        * user
        * @param string $username The user in question
        * @return string An array of the sources not being tracked
        */
        function getSourcesNotTracked($username) {
            $sources = array();
            $db = mysqli_connect($this->dbInfo['DB_SERVER'], $this->dbInfo['DB_USERNAME'],
                    $this->dbInfo['DB_PASSWORD'], $this->dbInfo['DB_DATABASE']);
            mysqli_set_charset($db, "utf8");
            if (!$db)
                die("Connection failed: " . mysqli_connect_error());

            $stmt = $db->prepare("SELECT ks.source
                                    FROM kanji_source ks
                                    WHERE ks.id NOT IN (SELECT k.source_id
                                                        FROM student_kanji sk
                                                        JOIN kanji k ON sk.kanji_id = k.id
                                                        JOIN kanji_source kks ON k.source_id = kks.id
                                                        JOIN student s ON sk.student_id = s.id
                                                        WHERE s.username = ?)");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $results = $stmt->get_result();

            if (mysqli_num_rows($results) > 0) {
                while($row = mysqli_fetch_assoc($results))
                    array_push($sources, $row["source"]);
            }
            mysqli_close($db);

            return $sources;
        }

        /**
        * Retrieves all kanji of a particular source
        * @param string $source The source in question
        * @return string An array containing the kanji of a given source
        */
        function getKanjiOfSource($source) {
            $kanji = array();
            $db = mysqli_connect($this->dbInfo['DB_SERVER'], $this->dbInfo['DB_USERNAME'],
                    $this->dbInfo['DB_PASSWORD'], $this->dbInfo['DB_DATABASE']);
            mysqli_set_charset($db, "utf8");
            if (!$db)
                die("Connection failed: " . mysqli_connect_error());

            $stmt = $db->prepare("SELECT k.kanji
                                    FROM kanji k
                                    JOIN kanji_source ks ON k.source_id = ks.id
                                    WHERE ks.source = ?");
            $stmt->bind_param("s", $source);
            $stmt->execute();
            $results = $stmt->get_result();

            if (mysqli_num_rows($results) > 0) {
                while($row = mysqli_fetch_assoc($results))
                    array_push($kanji, $row["kanji"]);
            }
            mysqli_close($db);

            return $kanji;
        }

        /**
         * Determines if user has an account in the database
         * @param String $username the given username
         * @return boolean True if user has an acccount in the DB
         */
        function hasAccount($username) {
            $hasAccount = false;
            $db = mysqli_connect($this->dbInfo['DB_SERVER'], $this->dbInfo['DB_USERNAME'],
                $this->dbInfo['DB_PASSWORD'], $this->dbInfo['DB_DATABASE']);
            mysqli_set_charset($db, "utf8");
            if (!$db)
                die("Connection failed: " . mysqli_connect_error());

            $stmt = $db->prepare("SELECT s.username
                                    FROM student s
                                    WHERE s.username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $results = $stmt->get_result();

            if (mysqli_num_rows($results) > 0)
                $hasAccount = true;
            mysqli_close($db);

            return $hasAccount;
        }

        /**
         * Creates a new user with the given username
         * @param String $username the new user
         */
        function createUser($username) {
            $db = mysqli_connect($this->dbInfo['DB_SERVER'], $this->dbInfo['DB_USERNAME'],
                $this->dbInfo['DB_PASSWORD'], $this->dbInfo['DB_DATABASE']);
            mysqli_set_charset($db, "utf8");
            if (!$db)
                die("Connection failed: " . mysqli_connect_error());

            $stmt = $db->prepare("INSERT INTO `student` (`id`, `username`, `creation_date`, `last_login`)
                                    VALUE (NULL, ?, NOW(), NOW())");
            $stmt->bind_param("s", $username);
            $stmt->execute();

            mysqli_close($db);
        }

        /**
        * Inserts kanji data for a particular user with the score they self rated with
        * @param String $username the user the kanji data is for
        * @param String $kanji the kanji to start tracking
        * @param float $initialScore the initial self rated score for the kanji
        */
        function startTrackingKanjiForStudent($username, $kanji, $initialScore) {
            $db = mysqli_connect($this->dbInfo['DB_SERVER'], $this->dbInfo['DB_USERNAME'],
                $this->dbInfo['DB_PASSWORD'], $this->dbInfo['DB_DATABASE']);
            mysqli_set_charset($db, "utf8");
            if (!$db)
                die("Connection failed: " . mysqli_connect_error());

            $stmt = $db->prepare("INSERT INTO `student_kanji` (`student_id`, `kanji_id`, `retention_score`, `total_questions_asked`, `last_time_quized`)
                                    SELECT s.id, k.id, ?, 0, NOW()
                                        FROM student s
                                        CROSS JOIN kanji k
                                        WHERE s.username = ? AND k.kanji = ?");
            $stmt->bind_param("dss", $initialScore, $username, $kanji);
            $stmt->execute();

            mysqli_close($db);
        }
    }
?>
