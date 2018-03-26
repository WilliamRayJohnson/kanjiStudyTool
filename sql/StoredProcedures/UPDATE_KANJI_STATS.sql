CREATE PROCEDURE `UPDATE_KANJI_STATS` (IN quizKanji VARCHAR(1), IN username VARCHAR(30), IN newRetentionScore FLOAT)
BEGIN
    UPDATE student_kanji
    SET retention_score = newRetentionScore,
                            total_questions_asked = total_questions_asked + 1,
                            last_time_quized = NOW()
    WHERE student_id = (SELECT id FROM student WHERE name = username)
            AND kanji_id = (SELECT id FROM kanji WHERE kanji = quizKanji);
END