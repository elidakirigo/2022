<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>employees data table</title>
    <link rel="stylesheet" href="bootstrap-3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
    input , button{
        margin-top: 20px;
    }
    </style>
</head>
<body>
<div class="container" style="margin-top:120px;">
        <div class="panel panel-primary">
          <div class="panel-heading">
                <h3 class="panel-title">tasks</h3>
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
<div class="container">
<div class="panel panel-primary">
          <div class="panel-heading">
                <h3 class="panel-title">create tasks</h3>
          </div>
    <div class="panel-body">
       
       <form action="" method="POST" role="form">
            <input type="email" class="form-control" id="" placeholder="enter employee name">
            <input type="email" class="form-control" id="" placeholder="enter task">
            <input type="email" class="form-control" id="" placeholder="activity">
            <input type="check" class="form-control" id="" placeholder="activity">
           <button type="submit" class="btn btn-primary">Submit</button>
       </form>
    </div></div>
</div>
<?php
$result = mysqli_query($query); 
if (!$result) die ("Database access failed: " . mysql_error()); $rows = mysql_num_rows($result);

$db_server = mysql_connect($db_hostname, $db_username, $db_password); if (!$db_server) die("Unable to connect to MySQL: " . mysql_error()); mysql_select_db($db_database)    or die("Unable to select database: " . mysql_error());
$query = "UPDATE cats SET name='Charlie' WHERE name='Charly'";
$result = mysql_query($query); if (!$result) die ("Database access failed: " . mysql_error()); 
?>
    <script src="bootstrap-3.3.7/js/jquery.js"></script>
    <script src="bootstrap-3.3.7/js/bootstrap.min.js"></script>
</body>
</html>