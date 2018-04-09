<?php
session_start();
if(isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    $userHref = "#";
    $dropdownStatus = "";
}
else {
    $username = "Login";
    $userHref = "login.php";
    $dropdownStatus = "none";
}

print <<<MENU
<h1 class="siteHeader">The Kanji Studier</h1>
    
<ul class="menu">
    <li class="menu"><a href="index.php">Home</a></li>
    <li class="dropdown" style="float:right">
        <a href="$userHref" class="dropbtn">$username</a>
        <div class="dropdown-content" style="display:$dropdownStatus">
            <a href="#">Logout</a>
        </div>
    </li>
</ul>
MENU;

?>
