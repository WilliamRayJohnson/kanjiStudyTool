<!DOCTYPE html>

<html>
    <head>
        <title>Hello, World</title>
        <meta charset="utf-8" />
        
        <link rel="stylesheet" type="text/css" href="index.css" />
    </head>

    <body>
        <?php
            include 'src/Greeting.php';
            
            $greeter = new Greeting(); 
        
            echo '<h1>Hello, World</h1>';
            echo Greeting::sayHello();
            echo $greeter->sayGreeting('こんにちは!');
        ?>
    </body>
</html>
