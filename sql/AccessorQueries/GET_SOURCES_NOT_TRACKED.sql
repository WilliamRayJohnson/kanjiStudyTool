SELECT ks.source
    FROM kanji_source ks
    WHERE ks.id NOT IN (SELECT k.source_id
                            FROM student_kanji sk
                            JOIN kanji k ON sk.kanji_id = k.id
                            JOIN kanji_source kks ON k.source_id = kks.id
                            JOIN student s ON sk.student_id = s.id
                            WHERE s.username = ?)