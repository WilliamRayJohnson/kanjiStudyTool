<?php
    class Greeting {
        function sayHello() {
            return '<p>Hello!</p>';
        }
        
        function sayGreeting($phrase) {
            return '<p>' + $phrase + '</p>';
        }
    }
?>