---
layout: post
title: "Implementing Score Calculation and a Bit on Quiz Communication"
---
## Score Calculation
The implementation of basic retention score calculation as outlined in yesterday's [post](HTTPS://williamrayjohnson.github.io/kanjiStudyTool/2018/03/11/Determining-Retention-Score.html)
did not require much beyond was written in pseudocode. One bit that did need to change is that before
any division is performed, the a zero needs to be run on the dividend like so:
```php
if($pastCR > $pastIR) {
    if($pastIR == 0)
        $pastIR++;
    $pastRatio = (float)$pastIR/(float)$pastCR;
}
```
This needs to be done as if correct or incorrect responses is zero in situations where the opposite is 
greater, the ratio value would be zero, so that ratio wouldn't contribute to the new retention score when
it should. Incrementing the zero value by one fixes this.

The only other thing worth noting in this implementation is that this method is written as a static
method of the class QuizResultsProcessor. The idea here is QuizResultsProcessor will be able to process 
multiple kinds of quiz results and will have multiple variations of calculating score. Here we only have 
basic, but an intermediate and advanced calculation could be added. The methods shall be static as 
QuizResutlsProcessor has no need for state.  

## Quiz Communication
When a quiz complete the results (correct and incorrect response count) needs to be passed to the score
calculator and update those values in the database. This information will be passed to a script to do just
this in the form of a JSON in a POST request. So what will be discussed here is the where this JSON will be
created and what its format shall be.

The generation would be best done by the Quizer class which would then call upon the Question objects 
contained within it to generation the individual Question's JSON information. The structure of the JSON
itself will look similar to this:
```javascript
{
    "username" : "Joe",
    "questionCount" : 2,
    "questions" :  [{
                        "kanji" : "一",
                        "correct" : 1,
                        "incorrect" : 0
                    },
                    {
                        "kanji" : "二",
                        "correct" : 2,
                        "incorrect" : 3
                    }]
}
```
Using this, the calculation script will retrieve the old score for the particular kanji of that user,
calculate the new score given the correct and incorrect data, and update the database with the new score.

So the next thing the agenda is to get Quizer and Question to produce the appropriate JSON strings and write
the script to update the database.