<?php

// require_once '../login/login.php';
// require_once 'conn.php';


// if ($db_server) echo "sucess".$db_database;
if (!$db_server) die("Unable to connect to MySQL: " . mysqli_error());

// creating a database

$sql = 'CREATE DATABASE nodemysql';


// Accessing theDatabase
$db_query = mysqli_select_db($db_server , $db_database);
// if ($db_query) echo "sucess query";




// Building and executing a query

 $sql = 'CREATE TABLE user (id int AUTO_INCREMENT, userName VARCHAR(255), pwd VARCHAR(255), PRIMARY KEY (id) )';

 $createTable = mysqli_query($db_server , $sql);
// if ($createTable) echo "sucess create";

// login in to account
// if (isset($_POST["user"])) {

//     $username = $_POST['user'];

//     $userpwd = $_POST['userPwd'];

//     $db_user = "INSERT INTO user VALUES(NULL, '$username', '$userpwd')";

//     $insert_data = mysqli_query($db_server, $db_user);




// // Fetching a result
//     $user_login = "SELECT * FROM user ";
//     $result = mysqli_query($db_server , $user_login);

//     if ($result) echo "sucess fetch";

//     $row = json_encode($result);
//     echo $row;
//     session_start();
//     $_SESSION['username'] = $row;

//     // echo 'hello : ';

// }


// $login_user = 1;

// if ($login_user ==1) {

//     // header('location : index.php');
//     echo 'done';
// } elseif($login_user==2) {

//     include('../admin/admin.php');
// } else {
//     echo 'session expired';
// }

// Fetching a row

// closing a connection

mysqli_close($db_server);