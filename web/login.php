<?php
$dbInfo = require_once('../config/config.php');
require_once $phpcas_path . '/CAS.php';

phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);

phpCAS::setNoCasServerValidation();

phpCAS::forceAuthentication();

session_start();
$_SESSION["username"] = phpCAS::getUser();

include '../src/DBAccessor.php';
$accessor = new DBAccessor($dbInfo);
if(!$accessor->hasAccount($_SESSION["username"]))
    $accessor->createUser($_SESSION["username"]);
else
    $accessor->logUserLogin($_SESSION["username"]);
header('Location: index.php');
?>
