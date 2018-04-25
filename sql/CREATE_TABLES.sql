/*These are the set of tables to be used in the Kanji Studier Project*/

CREATE TABLE kanji_source (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    source VARCHAR(40));

CREATE TABLE kanji (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    kanji VARCHAR(1) UNIQUE KEY,
    source_id INT,
    FOREIGN KEY (source_id)
        REFERENCES kanji_source(id)
        ON UPDATE CASCADE ON DELETE RESTRICT);

CREATE TABLE word (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    word VARCHAR(10) UNIQUE KEY,
    reading VARCHAR(20));

CREATE TABLE kanji_in_word (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    word_id INT,
    kanji_id INT,
    FOREIGN KEY (word_id)
        REFERENCES word(id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (kanji_id)
        REFERENCES kanji(id)
        ON UPDATE CASCADE ON DELETE CASCADE);

CREATE TABLE student (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(30),
    creation_date DATETIME,
    last_login DATETIME);

CREATE TABLE student_kanji (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    student_id INT,
    kanji_id INT,
    UNIQUE KEY (student_id, kanji_id),
    FOREIGN KEY (student_id)
        REFERENCES student(id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (kanji_id)
        REFERENCES kanji(id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    retention_score FLOAT,
    total_questions_asked INT,
    last_time_quized DATETIME);

CREATE TABLE weights (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    literacy_weight FLOAT NOT NULL,
    total_q_weight FLOAT NOT NULL);

CREATE TABLE strong_distractor (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    question_word_id INT NOT NULL,
    distractor_word_id INT NOT NULL,
    FOREIGN KEY (question_word_id)
        REFERENCES word(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY (distractor_word_id)
        REFERENCES word(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    UNIQUE KEY (question_word_id, distractor_word_id));
