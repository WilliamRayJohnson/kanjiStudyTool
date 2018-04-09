<?php
error_reporting(E_ALL);
ini_set('display_error', 1);

$dbInfo = require_once('../config/config.php');
require_once $phpcas_path . '/CAS.php';

phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);

session_start();
session_destroy();
phpCAS::logout();

header('Location: index.php');
?>
