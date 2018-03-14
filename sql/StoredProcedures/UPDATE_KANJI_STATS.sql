CREATE PROCEDURE `UPDATE_KANJI_STATS` (IN quizKanji VARCHAR(1), IN username VARCHAR(30), IN quizCR INT, IN quizIR INT, IN newRetentionScore FLOAT)
BEGIN
    UPDATE student_kanji
    SET retention_score = newRetentionScore,
                            correct_response_count = correct_response_count + quizCR,
                            incorrect_response_count = incorrect_response_count + quizIR,
                            last_time_quized = NOW()
    WHERE student_id = (SELECT id FROM student WHERE name = username)
            AND kanji_id = (SELECT id FROM kanji WHERE kanji = quizKanji);
END