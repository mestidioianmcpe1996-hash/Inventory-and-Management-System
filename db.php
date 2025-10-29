<?php
$username = "root";
$password = "root";
$dbname = "project(411)";
$Con = mysqli_connect("localhost", "$username", "$password", "$dbname");

if(!$Con){
    echo "no connection";
}

?>