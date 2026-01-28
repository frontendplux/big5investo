<?php
include __DIR__ . '/config.php';
$host = $_SERVER['HTTP_HOST'];
// Local settings
if (in_array($host, ['localhost:3000', '127.0.0.1:3000', '192.168.8.129:3000', '172.20.10.10:3000','172.20.10.2:3000','192.168.8.110:3000'])) {
    $db_host = db_host;
    $db_user = db_user;
    $db_pass = db_pass;
    $db_name = db_name;

    // Connect without DB to create it if missing
    $conn = new mysqli($db_host, $db_user, $db_pass);
    if ($conn->connect_error) {
        die('Unable to connect: ' . $conn->connect_error);
    }
    $conn->query("CREATE DATABASE IF NOT EXISTS `$db_name`");
} 
// Production settings
else {
    $db_host = 'localhost';
    $db_user = 'if0_41012169';
    $db_pass = 'ToffSgotZpULRRU';
    $db_name = 'if0_41012169_big5';

    $conn = new mysqli($db_host, $db_user, $db_pass);
    if ($conn->connect_error) {
        die('Unable to connect: ' . $conn->connect_error);
    }
}

// Always select DB after creation
$conn->select_db($db_name);
?>
