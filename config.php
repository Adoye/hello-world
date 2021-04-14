<?php
/* Database credentials */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', "");
define('DB_NAME', 'itec311');

/* Attempt to connect to database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

//check connection
if($link === false){
    die("ERROR: Could not connect."  .mysqli_connect_error());
}
?>