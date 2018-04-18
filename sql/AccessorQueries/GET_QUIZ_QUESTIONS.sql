SELECT qKanji, qWord, qReading
    FROM
        (SELECT k.kanji AS qKanji, w.word AS qWord,
                w.reading AS qReading, sk.retention_score AS qRetention
            FROM student s
            JOIN student_kanji sk ON s.id = sk.student_id
            JOIN kanji k ON sk.kanji_id = k.id
            JOIN kanji_in_word kiw ON kiw.kanji_id = k.id
            JOIN word w ON kiw.word_id = w.id
            WHERE s.username = ? AND w.word NOT IN
                (SELECT w.word
                    FROM word w
                    JOIN kanji_in_word kiw ON w.id = kiw.word_id
                    JOIN kanji k ON kiw.kanji_id = k.id
                    WHERE k.kanji NOT IN
                        (SELECT k.kanji
                            FROM student s
                            JOIN student_kanji sk ON s.id = sk.student_id
                            JOIN kanji k ON sk.kanji_id = k.id
                            WHERE s.username = ?))
            ORDER BY RAND()) AS q
    GROUP BY qKanji
    ORDER BY qRetention
    LIMIT ?