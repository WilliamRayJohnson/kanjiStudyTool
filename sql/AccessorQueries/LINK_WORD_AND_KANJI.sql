INSERT INTO `kanji_in_word` (`word_id`, `kanji_id`)
    SELECT w.id, k.id
    FROM kanji k
    CROSS JOIN word w
    WHERE k.kanji = ? AND w.word = ?