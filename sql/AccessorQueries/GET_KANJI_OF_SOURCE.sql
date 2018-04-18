SELECT k.kanji
    FROM kanji k
    JOIN kanji_source ks ON k.source_id = ks.id
    WHERE ks.source = ?