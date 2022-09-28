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

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    </head>
    <body>
        <div class="container" style="margin-top:5em;">
            
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">create my list</h3>
                </div>
                <div class="panel-body">
                    <form action="../auth/auth.php" method="POST" role="form">
                
                        <div class="form-group">
                            <label for="">name</label>
                            <input type="text" class="form-control" id="" placeholder="Input name">
                        </div>
                        <div class="form-group">
                            <label for="">favourite cat</label>
                            <input type="text" class="form-control" id="" placeholder="Input cat">
                        </div>
                        <div class="form-group">
                            <label for="">score</label>
                            <input type="text" class="form-control" id="" placeholder="Input score">
                        </div>
                        <div class="form-group">
                            <label for="">city</label>
                            <input type="text" class="form-control" id="" placeholder="Input city">
                        </div>
                        <div class="form-group">
                            <label for="">meal</label>
                            <input type="text" class="form-control" id="" placeholder="Input meal">
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
            
            
            
        </div>
        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Bootstrap JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>
