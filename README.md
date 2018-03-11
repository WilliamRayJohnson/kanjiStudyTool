# The Kanji Study Tool
## Overview
The goal of this system is to improve Japanese student's retention of kanji they have learned. The system will do this
by gaining an understanding of how well the student know each kanji they have learned through quizzing sessions. Then in
following sessions the system will emphasize kanji determined to be known poorly by the student. These sessions will be a series
of questions that aim to improve how well the student recognizes learned kanji.

## Study Set
The kanji set the system will use in quizzing sessions is limited to the set of kanji the user has learned. For example if the user
has learned kanji through chapter 12, the system will only quiz on the kanji found in chapter 1 - 12. The reason for this is that 
the goal of this system is retention not learning/discovery.

## Sessions:
A session consist of multiple choice questions that will test the user's retention of learned kanji. The questions asked will be determined by
the system's internal measure of how well the user understands the set of kanji. Kanji with lower scores will be prioritized and presented in 
a quiz to improve rentention of kanji the student struggles with. If a question is answered incorrectly, it will be asked again towards the end
of the session. This will be repeated until all questions are answered correctly.

## Retention Measure (Heuristic):
Each kanji in the study set will have a measure of how well the user has retained that particular kanji. The retention measure of a kanji will be 
updated after a question containing that kanji is scored. If the user got the questions correct, the measure would increase. If the user answered
incorrectly, the measure would decrease. How much the measure is increased or decreased could be determined by a few 
different schemes of increasing complexity:

### Basic:
Retention scores increase and decrease based correctness and the correct and incorrect ratio of that particular kanji.
The specific amount is based on what correct and incorrect answer ratio tier that kanji is in. Kanji in a lower ratio
tier (more incorrect than correct) will increase the score more than the higher tiers.

### Intermediate:
Same as basic with the addition of a decay of retention scores in low correct/incorrect ratio tiers when the user does not
log in for a certain number of days. Also questions asked for the 2nd, 3rd, and so on in a single session will contribute 
less to the retention score.