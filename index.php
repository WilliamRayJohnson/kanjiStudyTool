<!DOCTYPE html>

<html>
    <head>
        <title>Hello, World</title>
        
        <link rel="stylesheet" type="text/css" href="index.css" />
    </head>

    <body>
        <?php
            include 'src/Greeting.php';
        
            echo '<h1>Hello, World</h1>';
            echo Greeting::sayHello();
        ?>
    </body>
</html>
