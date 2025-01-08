<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// modify these settings according to the account on your database server.
/* $host = "localhost";
$port = "3306";
$username = "root";
$user_pass = "root";
$database_in_use = "JokesPart1"; */
$host = "sh4ob67ph9l80v61.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$port = "3306";
$username = "lrz97ndowos9jbc6";
$user_pass = "keomp3j8xt48u8c6";
$database_in_use = "jov5w2p9oxirozx6";


$mysqli = new mysqli($host, $username, $user_pass, $database_in_use);
if ($mysqli->connect_error) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
echo $mysqli->host_info . "<br>";

?>