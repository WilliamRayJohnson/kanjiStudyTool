---
layout: post
title: "How to POST and Updating the Database"
date: 2018-03-13
---
## Sending JSON to a PHP script
Sending a JSON in this application turned out to be a bit more difficult that anticipated. The first problem was to figure out
the best method for the job. The POST request could either be done through PHP or Javascript. At first Javascript seemed like 
the best solution since I had already implemented something similar in the QuizPage logic. However since Javascript has to be 
executed client side, it seemed silly to generate the JSON in PHP, send it to the browser, then POST via Javascript. So I attempted
to POST in PHP by way of the code described [here](https://stackoverflow.com/questions/6213509/send-json-post-using-php). Though
I was unable to get this to work. After an hour or so fumbling with it, I opted to go with my original idea. While this method is
quite silly as I already explained, at least it works. All I did was define a new method:
```
function sendQuizResults(results) {
    $.post("scripts/ProcessQuizResults.php", results);
    return false;
}
```
Then I had PHP add the following tag once the quiz was complete.
```
<script type="text/javascript">
window.onload = sendQuizResults($quizResults);
</script>
```
So the the data would be sent once the new page was rendered. From this point I can process the results of a quiz and update the database.
I would like to change this method of sending JSON, but for now it will suffice.

## Updating the Database
Processing the results wasn't too difficult, but in writing this code it was difficult to see if anything was working as I don't get any feedback
from it. So I've opted to add some logging to this system. I followed this [guide](https://adayinthelifeof.nl/2011/01/12/using-syslog-for-your-php-applications/)
and logged when a quiz was submitted and what the new retention score of a kanji was calculated to be. The messages may or may not be in the final product, but I 
do plan to integrate more sophisticated logging into the system.