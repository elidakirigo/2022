<?php
require_once '../auth/conn.php';
$username = 'admin';
$password = 'letmein';
// if (isset($_SERVER['PHP_AUTH_USER']) &&   isset($_SERVER['PHP_AUTH_PW']))
// {   
//      if ($_SERVER['PHP_AUTH_USER'] == $username && $_SERVER['PHP_AUTH_PW']   == $password)       
//       echo "You are now logged in";    
//    else die("Invalid username / password combination");
// }else{   
//     header('WWW-Authenticate: Basic realm="Restricted Section"');    header('HTTP/1.0 401 Unauthorized');    die ("Please enter your username and password");
// }
$token = md5('mypassword');
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
    
    <div class="panel panel-success">
          <div class="panel-heading">
                <h3 class="panel-title">Panel title</h3>
          </div>
          <div class="panel-body">
            <form action="login.php" method="POST" role="form">
    
                <div class="form-group">
                    <label for="userName">userName</label>
                    <input name="user" type="email" class="form-control" id="userName" placeholder="Input email">
                </div>
            
                <div class="form-group">
                    <label for="password">password</label>
                    <input name="userPwd" type="password" class="form-control" id="password" placeholder="Input pwd">
                </div>
    
        <button type="submit" class="btn btn-success">Submit</button>
        <?php
        function add($user){
            $element = '<';

            return $element;
        };
        if(isset($_POST['user']) && isset($_POST['userPwd'])){
            $sql = 'SELECT * FROM user';
            $query = mysqli_query($db_server, $sql);
            $confirm;
            while ($results = mysqli_fetch_assoc($query)) {
               $confirm = $results['userName'];
            }
             if($confirm == $_POST['user']){
                    // echo 'successful login' .$confirm;
                    // echo '<script>window.location = "../index.php" </script>';

                } else {
                    echo 'username/email is invalid';
                }
                setcookie('email', $_POST["user"], time() + 60 * 60 * 24 * 7, '/');
                if (isset($_COOKIE['email']))   
                 {
                     $username = $_COOKIE['email'];
                 echo $username;
                 echo '<script>document.querySelector(".container").style.display="none";</script>';
                 echo '<script>console.log(document.querySelector(".container").display) </script>';
                    echo '<script>window.location = "../index.php" </script>';
                 }
            }
            ?>
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
