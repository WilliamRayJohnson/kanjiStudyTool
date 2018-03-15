---
layout: post
title: "What It Takes to Generate a Quiz"
date: 2018-03-14
---
Quiz generation turned out to be a bit more complicated than I initially thought. The main problem 
being, how does one automatically generate authentic possible responses to a multiple choice question. 
The options a student has to choose from should have some thought put into them, as the student won't 
get much out of the quiz if they are not being adequately tested. This is fundamentally a problem with
multiple choice questions, but I prefer the simplicity of multiple choice in this first iteration of 
the Kanji Study Tool. So the question is what are good candidate words for choices of any particular  
kanji question. Or rather what are good distractors for a muliptle choice quiz. I have three
categories of distractors that should fit the bill. The first of which being...

### Words from the same source (Book Chapter)
Students are typically learning kanji on a chapter by chapter basis. This means it is reasonable to 
think that a student may get words in kanji from the same chapter confused with each other as they are 
trying to learn all of them at once. These choices are pretty weak as once the student gets a decent 
grasp on the kanji of the chapter, they won't have trouble distinguishing between words of the same 
chapter. Which takes me to the next best category...

### Words that contain the kanji being quizzed
These are probably the more obvious candidates for choices as kanji can have multiple readings across
different words, so a student is likely to get confused when presented with choices that all have that
kanji within it. The problem with this solution is not all kanji are going to have enough words 
associated with it to generate enough choices for a question, so another category of words must be used
with this category. As the system is implemented today, the categories of words mentioned are the ones
used in generating a quiz, but the last category is...

### Words that are either written similarly or have similar meaning
This category cannot be implemented at this point as an additional table must be added to relate words
to other words that one would reasonably confuse with each other. An example, 右 and 左 which mean 
right and left respectively. Both of these kanji look similar and have related meaning, so it is
reasonable that a student who doesn't know these kanji very well might get them confused. Adding 
this data to the schema shouldn't be too difficult. A table that contains two fields, both foreign keys
to word.id, where a single record identifies two words that are similar to each other in either 
meaning or appearance. The difficult part here is coming up with those words that fit that description.

The first two have been implemented by the following stored procedure:
```
CREATE PROCEDURE `GET_QUIZ_ANSWERS` (IN quizKanji VARCHAR(1), IN quizWord VARCHAR(10), IN answerCount INT)
BEGIN
    SELECT w.word, w.reading
        FROM word w
        JOIN kanji_in_word kiw ON kiw.word_id = w.id
        JOIN kanji k ON k.id = kiw.kanji_id
        WHERE k.kanji = quizKanji AND NOT w.word = quizWord
    UNION
    SELECT w.word, w.reading
        FROM word w
        JOIN kanji_in_word kiw ON kiw.word_id = w.id
        JOIN kanji k ON k.id = kiw.kanji_id
        WHERE k.source_id = (SELECT source_id FROM kanji WHERE kanji=quizKanji) AND NOT w.word = quizWord
    ORDER BY RAND()
    LIMIT answerCount;
END
```
Where quizKanji is the kanji to be quizzed in a question, and quizWord is the word that will be 
presented in the question. The first two categories of distractors are implemented as separate SELECT 
statements, then UNIONed together. The resulting set is randomized and LIMITed to answerCount. With
this set up, it will be easy to add the final category once the necessary task have been complete. 

As of this moment I see two issue, one of which is immediately relevant. There is no precedence made to 
either of the SELECTs. The latter SELECT will produce higher quality distractors, but the distractors 
returned are randomly selected from the whole resulting set. I believe I can fix this, but for now this
will suffice. The other issue will be relevant once I explain the next query. It retrieves the kanji
and words to quiz the student on:
```
CREATE PROCEDURE `GET_QUIZ_QUESTIONS` (IN username VARCHAR(30), IN quizLength INT)
BEGIN
    SELECT qKanji, qWord, qReading
        FROM
            (SELECT k.kanji AS qKanji, w.word AS qWord, w.reading AS qReading, sk.retention_score AS qRetention
                FROM student s
                JOIN student_kanji sk ON s.id = sk.student_id
                JOIN kanji k ON sk.kanji_id = k.id
                JOIN kanji_in_word kiw ON kiw.kanji_id = k.id
                JOIN word w ON kiw.word_id = w.id
                WHERE s.name = username
                ORDER BY RAND()) AS q
        GROUP BY qKanji
        ORDER BY qRetention
        LIMIT quizLength;
END
```
Here the kanji with the N lowest retention scores are SELECTed with a random word that associated with 
it. To ensure only one kanji is SELECTed, GROUP BY is used. I mentioned that there was a problem with 
the previous query. This problem persist in this query as well. That is, words that contain kanji from 
future chapters that the student may not be studying could be SELECTed. This is problem since it would
be unreasonable to quiz a student on a kanji they don't know, either through the question itself or 
the choices presented. I am not sure at this moment how I will fix this, but I will find a solution.

There is also one more problem with the GET_QUIZ_QUESTIONS procedure. That it is possible for the same
word to be chosen if the kanji contained within that word are both being quizzed. For example, if 八 and
千 are both being quizzed, it is possible for this query to choose 八千 for both questions. From the 
perspective of the student this is essentially asking the question twice. I am not immediately sure
how to fix this problem either, but I predict it won't be too difficult to solve.

Getting quizzing to this point, even with the minor issues, is a huge milestone for this project. As 
such I will putting further development on quizzing logic on hold for a bit while get a better picture
of what the site as a whole will look like. This primarily mean figuring out a layout, but through this
I will get a better picture of what is left to do, and I can better visualize what the final product 
will look like.