---
layout: post
title: "Calculating Retention Scores"
date: 2018-03-11
---
The retention score of a kanji is the most important part of this system. It is how the system will
measure a student's ability to use a kanji. So naturally the calculation of the score should have 
quite a bit of thought put into it. As such score calculation will require several iterations. For
this first iteration, it will be kept some what simple per how it is lined out in the Basic section 
of the [README](https://github.com/WilliamRayJohnson/kanjiStudyTool/blob/master/README.md).  The basic
idea is that correct/incorrect response ratio that favors correct answers will raise retention score
and a ratio that favors incorrect responses will lower it.

## The Variables
As the system is now, the following values could be used in retention score caculation on a per kanji
basis:
* Past correct response count
* Past incorrect response count
* Correct response count of current quiz
* Incorrect response count of current quiz
* Current retention score
* Date last quizzed
* Date kanji added (started tracking)

For this basic caculation, I will only be using response counts. The current retention score will also be used,
but it will only serve as the basis for the newly calculated score.

## The Calculation
A new retention score will be based on two ratios. One is between past correct and incorrect response count; 
I will call this pastRatio. And two is between correct and incorrect response count of current quiz; I will
call this quizRatio. Both of these values will contribute to the new retention score. Whether they raise or 
lower the score, and how much they change it will determined based on code simlar to what follows:
```
if(correct > incorrect)
    ratio = incorrect/correct;
else if(incorrect >= correct)
    ratio = -correct/incorrect;
```
This ensures the "ratio" value is always between 0.0 and 1.0. 

From here the ratio values will modify the value that will raise or lower the score. I will dub these quizMaxChange
and pastMaxChange as these are the maximum values the ratios can change the retention score up or down. These values
will be constants defined as 0.1 and 0.02 respectively for now. It is important that quizMaxChange is higher than pastMaxChange
as the quizRatio will more acturally show that the student is learning (so it should have greater weight), but past
response should still be taken into account albeit a small amount. So the final calculation will look similar to the 
pseudocode that follows:
```
float QUIZ_MAX_CHANGE = 0.1;
float PAST_MAX_CHANGE = 0.02;

def calcNewRetentionScore(pastCR, pastIR, quizCR, quizIR, retentionScore)
    float quizRatio;
    float pastRatio;
    float newRetentionScore;
    
    if(pastCR > pastIR)
        pastRatio = pastIR/pastCR;
    else if(pastIR >= pastCR)
        pastRatio = -pastCR/pastIR;
        
    if(quizCR > quizIR)
        quizRatio = quizIR/quizCR;
    else if(quizIR >= quizCR)
        quizRatio = -quizCR/quizIR;
    
    newRetentionScore = retentionScore + (QUIZ_MAX_CHANGE * quizRatio) + (PAST_MAX_CHANGE * pastRatio);
    
    if(newRetentionScore > 1.0)
        newRetentionScore = 1.0;
    
    return newRetentionScore;
```
There is one final check at the end to ensure the retention score is never raised past 1.0. 