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
    
    <a class="btn btn-success" href="createEmployees.php" role="button">create employees</a>
    
    <div class="panel panel-primary" style="margin-top:20px;">
        <!-- Default panel contents -->
        <div class="panel-heading">employees data</div>
            <table class="table">
                <thead>
                    <tr>
                        <th>category</th>
                        <th>employees name</th>
                        <th>phone number</th>
                        <th>task</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Content 1</td>
                        <td>Content 1</td>
                        <td>Content 1</td>
                        <td>Content 1</td>
                    </tr>
                </tbody>
            </table>
    </div>
    
</div>
<footer style="padding:2em; background:black; text-align:center; margin-top:16em; color:white;">made with love by @the chick </footer>

    <script src="bootstrap-3.3.7/js/jquery.js"></script>
    <script src="bootstrap-3.3.7/js/bootstrap.min.js"></script>
</body>
</html>