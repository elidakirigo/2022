<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>home</title>
    <link rel="stylesheet" href="bootstrap-3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar navbar-inverse" style="border-radius:0px; padding:1em;">
        <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">task agent</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
            <li class="active"><a href="#">home <span class="sr-only">(current)</span></a></li>
            <li><a href="login.php">login</a></li>
            <li><a href="signup.php">signup</a></li>
            <li><a href="createTask.php">create task</a></li>
            <li><a href="employees.php">employees</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <div class="container">
    <div class="btn-group btn-group-justified" role="group" aria-label="...">
  <div class="btn-group" role="group">
  
  <a class="btn btn-large btn-block btn-success" href="createTask.php" role="button">create task</a>
  
  </div>
  <div class="btn-group" role="group">
  <a class="btn btn-large btn-block btn-success" href="#" role="button">employees list</a>
  </div>
  <div class="btn-group" role="group">
  <a class="btn btn-large btn-block btn-success" href="tasks.php" role="button">task created</a>
   
  </div>
</div>
</div>
<footer style="padding:2em; background:black; text-align:center; margin-top:16em; color:white;">made with love by @the chick </footer>
  <script src="employees.js"></script>
  
  <script src="bootstrap-3.3.7/js/jquery.js"></script>
    <script src="bootstrap-3.3.7/js/bootstrap.min.js"></script>
</body>
</html>


<?php 

?>