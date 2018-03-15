SELECT s.name, k.kanji, sk.retention_score, sk.correct_response_count,
    sk.incorrect_response_count, sk.last_time_quized
    FROM student_kanji sk
    JOIN kanji k ON k.id = sk.kanji_id
    JOIN student s ON sk.student_id=s.id
    ORDER BY s.id;