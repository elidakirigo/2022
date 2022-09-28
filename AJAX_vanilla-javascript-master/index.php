<?php
echo "processing";

// check for get variable
if(isset($_GET["name"]))
{
    echo "GET : YOUR name is ". $_GET["name"];
}