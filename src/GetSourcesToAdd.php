<?php
session_start();
include '../src/DBAccessor.php';
$dbInfo = include('../config/config.php');
$accessor = new DBAccessor($dbInfo);

$sources = $accessor->getSourcesNotTracked($_SESSION["username"]);
foreach($sources as $source)
    echo "<option value\"" . $source ."\">" . $source . "</option>"
?>