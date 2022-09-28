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
        <div class="form-group">
            <label for="my-textarea">email</label>
                <input type="email" name="email" class="form-control" placeholder="email" >
            </div>
            <div class="form-group">
            <label for="pwd">password</label>
                <input type="password" name="pwd" class="form-control" placeholder="password" >
            </div>
            
            <button type="submit" class="btn btn-large btn-primary">submit</button>
            
    </form>
    </div>
    <footer style="padding:2em; background:black; text-align:center; margin-top:16em; color:white;">made with love by @the chick </footer>

    <script src="bootstrap-3.3.7/js/jquery.js"></script>
    <script src="bootstrap-3.3.7/js/bootstrap.min.js"></script>
</body>
<?php
$conn = mysqli_connect('localhost','root','','mydatabase');




?>
</html>