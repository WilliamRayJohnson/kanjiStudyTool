SELECT k.kanji
    FROM student_kanji sk
    JOIN kanji k ON sk.kanji_id = k.id
    JOIN student s ON sk.student_id = s.id
    WHERE username = ?