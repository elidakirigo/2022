<?php
// creating a login
$db_hostname = 'localhost';
$db_database = 'dummy';
$db_username = 'root';
$db_password = '';

// connecting to mySQL

$db_server = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);
