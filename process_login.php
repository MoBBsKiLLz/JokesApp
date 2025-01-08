<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db_connect.php";

$username = addslashes($_POST['username']);
$password = $_POST['password'];

echo "You attempted to login with " . $username . " and " . $password . "<br>";

// Use placeholders in the query
$stmt = $mysqli->prepare("SELECT user_id, user_name, password FROM users WHERE user_name = ?");

// Bind the username to the placeholder
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

// Bind the result variables
$stmt->bind_result($userid, $fetched_name, $fetched_pass);

// Check if a match is found
if ($stmt->num_rows == 1) {
    echo "Found 1 person with that username<br>";
    $stmt->fetch();
    if (password_verify($password, $fetched_pass)) {
        echo "Password matches<br>";
        echo "<p>Login success</p>";
        $_SESSION['username'] = $username;
        $_SESSION['userid'] = $userid;
    } else {
        echo "Password does not match<br>";
    }
} else {
    echo "0 results. Not logged in<br>";
    $_SESSION = [];
    session_destroy();
}

echo "Session variable = ";
print_r($_SESSION);

echo "<br>";
echo "<a href='index.php'>Return to main page</a>";
?>
