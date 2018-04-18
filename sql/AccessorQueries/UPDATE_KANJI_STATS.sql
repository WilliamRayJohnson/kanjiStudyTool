UPDATE student_kanji
    SET retention_score = ?,
        total_questions_asked = total_questions_asked + 1,
        last_time_quized = NOW()
    WHERE student_id = (SELECT id FROM student WHERE username = ?)
        AND kanji_id = (SELECT id FROM kanji WHERE kanji = ?)