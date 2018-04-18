SELECT DISTINCT a.word, a.reading
    FROM (
        SELECT w.word, w.reading, FLOOR(100 + RAND()*100) AS weight
            FROM word w
            JOIN kanji_in_word kiw ON kiw.word_id = w.id
            JOIN kanji k ON k.id = kiw.kanji_id
            WHERE k.kanji = ? AND NOT w.word = ?
        UNION
        SELECT w.word, w.reading, FLOOR(200 + RAND()*100) AS weight
            FROM word w
            JOIN kanji_in_word kiw ON kiw.word_id = w.id
            JOIN kanji k ON k.id = kiw.kanji_id
            WHERE k.source_id = (SELECT source_id FROM kanji WHERE kanji=?) AND NOT w.word = ?
        ORDER BY weight ) AS a
    LIMIT ?