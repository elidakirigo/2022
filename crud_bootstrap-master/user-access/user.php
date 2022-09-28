<?php
session_start();
?>
<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Title Page</title>

        <!-- Bootstrap CSS -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    </head>
    <body>
    <div class="container" style="margin-top:5em;">
        
      
      <a class="btn btn-success btn-lg" href="create.php" role="button">edit details</a><br><br>
      
      <div class="panel panel-success">
            <div class="panel-heading">
                  <h3 class="panel-title">my details : user</h3>
            </div>
            <div class="panel-body">
                  <div class="col-md-3">
                  <img src="#" class="img-responsive" alt="Image">
                  </div>
                  <div class="col-md-9">
                    <span>my name is: </span> <br><br>
                    <span>my favourite cat is :</span><br><br>
                    <span>my best score is :</span><br><br>
                    <span>my best city is :</span><br><br>
                    <span>my favourite meal is :</span>
                  </div>
            </div>
      </div>
      
        
    </div>
        
        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Bootstrap JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>

