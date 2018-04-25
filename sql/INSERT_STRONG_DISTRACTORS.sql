INSERT INTO `strong_distractor` (`question_word_id`, `distractor_word_id`)
    SELECT qw.id, dw.id
        FROM word qw
        CROSS JOIN word dw
        WHERE qw.word = "一" AND dw.word = "二";

INSERT INTO `strong_distractor` (`question_word_id`, `distractor_word_id`)
    SELECT qw.id, dw.id
        FROM word qw
        CROSS JOIN word dw
        WHERE qw.word = "一" AND dw.word = "三";

INSERT INTO `strong_distractor` (`question_word_id`, `distractor_word_id`)
    SELECT qw.id, dw.id
        FROM word qw
        CROSS JOIN word dw
        WHERE qw.word = "一" AND dw.word = "四";

INSERT INTO `strong_distractor` (`question_word_id`, `distractor_word_id`)
    SELECT qw.id, dw.id
        FROM word qw
        CROSS JOIN word dw
        WHERE qw.word = "百円" AND dw.word = "百万";

INSERT INTO `strong_distractor` (`question_word_id`, `distractor_word_id`)
    SELECT qw.id, dw.id
        FROM word qw
        CROSS JOIN word dw
        WHERE qw.word = "百円" AND dw.word = "千円";

INSERT INTO `strong_distractor` (`question_word_id`, `distractor_word_id`)
    SELECT qw.id, dw.id
        FROM word qw
        CROSS JOIN word dw
        WHERE qw.word = "一つ" AND dw.word = "三つ";

INSERT INTO `strong_distractor` (`question_word_id`, `distractor_word_id`)
    SELECT qw.id, dw.id
        FROM word qw
        CROSS JOIN word dw
        WHERE qw.word = "一つ" AND dw.word = "二つ";

INSERT INTO `strong_distractor` (`question_word_id`, `distractor_word_id`)
    SELECT qw.id, dw.id
        FROM word qw
        CROSS JOIN word dw
        WHERE qw.word = "一つ" AND dw.word = "四つ";

INSERT INTO `strong_distractor` (`question_word_id`, `distractor_word_id`)
    SELECT qw.id, dw.id
        FROM word qw
        CROSS JOIN word dw
        WHERE qw.word = "一つ" AND dw.word = "五つ";

INSERT INTO `strong_distractor` (`question_word_id`, `distractor_word_id`)
    SELECT qw.id, dw.id
        FROM word qw
        CROSS JOIN word dw
        WHERE qw.word = "一つ" AND dw.word = "六つ";

INSERT INTO `strong_distractor` (`question_word_id`, `distractor_word_id`)
    SELECT qw.id, dw.id
        FROM word qw
        CROSS JOIN word dw
        WHERE qw.word = "一つ" AND dw.word = "七つ";


INSERT INTO `strong_distractor` (`question_word_id`, `distractor_word_id`)
    SELECT qw.id, dw.id
        FROM word qw
        CROSS JOIN word dw
        WHERE qw.word = "一つ" AND dw.word = "八つ";

INSERT INTO `strong_distractor` (`question_word_id`, `distractor_word_id`)
    SELECT qw.id, dw.id
        FROM word qw
        CROSS JOIN word dw
        WHERE qw.word = "一つ" AND dw.word = "九つ";