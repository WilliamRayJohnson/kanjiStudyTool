CREATE PROCEDURE `add_source_to_student_kanji` (IN student_id INT, IN source_to_add_id INT)
BEGIN
    DECLARE v_finished INTEGER DEFAULT 0;
    DECLARE v_kanji_id INTEGER DEFAULT 0;

    DECLARE kanji_cursor CURSOR FOR
    SELECT id FROM kanji WHERE source_id=source_to_add_id;
    
    DECLARE CONTINUE HANDLER
        FOR NOT FOUND SET v_finished = 1;
        
    OPEN kanji_cursor;
    
    get_kanji_id: LOOP
        FETCH kanji_cursor INTO v_kanji_id;
        IF v_finished = 1 THEN
            LEAVE get_kanji_id;
        END IF;
        CALL add_student_kanji(student_id, v_kanji_id);
    END LOOP get_kanji_id;
    
    CLOSE kanji_cursor;
END