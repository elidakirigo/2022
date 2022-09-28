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
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">home</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
            <li class="active"><a href="#">employees <span class="sr-only">(current)</span></a></li>
            <li><a href="login.php">login</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <div class="container">
        <div class="panel panel-primary">
          <div class="panel-heading">
                <h3 class="panel-title">employees information</h3>
          </div>
          <div class="panel-body">
                <table class="table table-light">
                    <thead class="thead-light">
                        <tr>
                            <th>id</th>
                            <th>name</th>
                            <th>number</th>
                            <th>gender</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
          </div>
        </div>
    </div>
    
    <button type="button" style="margin-left:230px;" class="btn btn-success"><a href="employees.php" style="color:white;text-decoration:none;">create task</a></button>
    
  <script src="employees.js"></script>
  
  <script src="bootstrap-3.3.7/js/jquery.js"></script>
    <script src="bootstrap-3.3.7/js/bootstrap.min.js"></script>
</body>
</html>


<?php 

?>