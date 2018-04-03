<?php
session_start();
if(isset($_SESSION["username"]))
    $username = $_SESSION["username"];
else
    $username = "Login";

print <<<MENU
<h1 class="siteHeader">The Kanji Studier</h1>
    
<ul class="menu">
    <li class="menu"><a href="index.php">Home</a></li>
    <li class="dropdown" style="float:right">
        <a href="#" class="dropbtn">$username</a>
        <div class="dropdown-content">
            <a href="#">Profile</a>
            <a href="#">Logout</a>
        </div>
    </li>
</ul>
MENU;

?>