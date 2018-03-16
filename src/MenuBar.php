<?php
session_start();
if(isset($_SESSION["username"]))
    $username = $_SESSION["username"];
else
    $username = "Login";

print <<<MENU
<ul>
    <li><a class="active" href="index.php">Home</a></li>
    <li class="dropdown" style="float:right">
        <a href="#" class="dropbtn">$username</a>
        <div class="dropdown-content">
            <a href="profile.html">Profile</a>
            <a href="#">Logout</a>
        </div>
    </li>
</ul>
MENU;

?>