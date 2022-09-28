<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="index.php" method="get">
        <input type="text" name="newName" id="">
        <input type="submit" value="submit">
    </form><br><br>
    <form action="index.php" method="post">
        <input type="text" name="newName" id="">
        <input type="password" name="password" id="">
        <input type="submit" value="submit">
    </form>
</body>
</html>

<?php

    $name = "elida";
    echo "hello : " .$name;
    echo '<br>';
    echo '<br>';
    $arrayName = array('wallow'=>56,'swallow','kill');
    echo '<br>';
    echo 'weight of wallow is ' .$arrayName['wallow'];
    echo '<br>';
    echo '<br>';
    $arrayName[3]="sindy";
     print_r($arrayName);
    echo '<br>';
    echo '<br>';
    if (isset($_GET['newName']) && !empty($_GET['newName'])) {
        echo $_GET['newName'];
    }
    else {
        echo ' enter fields';
    };
    
    echo '<br>';
    if (isset($_POST['newName']) && !empty($_POST['newName']) && !empty($_POST['password'])) {
        echo $_POST['newName'];
    }
    else {
        echo ' enter fields';
    };
    echo '<br>';
    echo '<br>';

    function add($one,$two){
        $result = $one + $two .'<br>';
        echo $result;
    }
    add(70,50);
    $date = date('Y-m-D');
    echo '<br>';
    echo '<br>';
    $time= date('H:i:s');
    echo $date ;
    echo '<br>';
    echo '<br>';

    echo $time;


?>