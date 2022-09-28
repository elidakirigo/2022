<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap-3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <title>login details</title>
    <style>
        form {
            top: 50px;
            left: 50px;
        }
    </style>
</head>
<body>
<div class="container" style="margin-top:120px;">
    <form action="" method="post">
        <h1>login</h1>
        <input type="email" name="" id="input" style="margin:10px;"class="form-control" value="" required="required" placeholder="enter email">
        
        
        <input type="password" name="" id="input" style="margin:10px;"class="form-control" placeholder="enter password" required="required" >
        <input type="button" style="margin:20px; padding:10px; " value="enter" class="btn btn-success">
        
    </form>
    </div>

    <script src="bootstrap-3.3.7/js/jquery.js"></script>
    <script src="bootstrap-3.3.7/js/bootstrap.min.js"></script>
</body>
<?php
$conn = mysqli_connect('localhost','root','','employees-data');

echo 'proccessing';
if(isset($_POST['name'])){
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    echo 'your name is '.$_POST['name'];

    $query = "INSERT INTO users(name) VALUES('$name')";

    if(mysqli_query($conn, $query)){
        echo 'user added';
    } else {
        echo 'error : '.myqli_error($conn);
    }
}
require_once 'login.php'; $db_server = mysql_connect($db_hostname, $db_username, $db_password); if (!$db_server) die("Unable to connect to MySQL: " . mysql_error()); mysql_select_db($db_database)    or die("Unable to select database: " . mysql_error());
$query = "INSERT INTO users VALUES(NULL, 'Lion', 'Leo', 4)";
$result = mysql_query($query); if (!$result) die ("Database access failed: " . mysql_error());
?>
</html>