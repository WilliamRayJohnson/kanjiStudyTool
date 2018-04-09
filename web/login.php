<?php
$dbInfo = require_once('../config/config.php');
require_once $phpcas_path . '/CAS.php';

phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);

phpCAS::forceAuthentication();

session_start();
$_SESSION["username"] = phpCAS::getUser();
?>