SELECT k.kanji, w.word, w.reading
    FROM kanji k
    LEFT JOIN kanji_in_word kiw ON k.id = kiw.kanji_id
    LEFT JOIN word w ON kiw.word_id = w.id
    ORDER BY k.id desc;