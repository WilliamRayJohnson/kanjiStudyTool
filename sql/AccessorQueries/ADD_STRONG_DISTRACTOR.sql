INSERT INTO `strong_distractor` (`question_word_id`, `distractor_word_id`)
    SELECT qw.id, dw.id
        FROM word qw
        CROSS JOIN word dw
        WHERE qw.word = ? AND dw.word = ?