<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection
include "db_connect.php";

// Get user inputs
$new_username = addslashes($_GET['username']);
$new_password1 = addslashes($_GET['password']);
$new_password2 = addslashes($_GET['password-confirm']);

$hashed_password = password_hash($new_password1, PASSWORD_DEFAULT);

// Debugging output
echo "<h2>Trying to add a new user: " .$new_username . " pw = " . $new_password1 . " and " . $new_password2 . "</h2>";

if ($new_password1 != $new_password2) {
    echo "The passwords do not match. Please try again.";
    exit;
}

preg_match('/[0-9]+/', $new_password1, $matches);
if (sizeof($matches) == 0) {
    echo "The password must have at least one number <br>";
    exit;
}

preg_match('/[!@#$%^&*()]+/', $new_password1, $matches);
if (sizeof($matches) == 0) {
    echo "The password must have at least one specail character like !@#$%^&*()<br>";
    exit;
}

if (strlen($new_password1) < 8) {
    echo "The password must be at least 8 characters long <br>";
}

// Check to see if the user already has registered
$sql = "SELECT * FROM users where user_name = '$new_username'";

$result = $mysqli->query($sql) or die (mysqli_error($mysqli));

if ($result->num_rows > 0) {
    // oops. already someone with that name.
    echo "The username " . $new_username . " is alredy in the database. Can't register twice!";
    exit;
} else {
    // Inser the new user into the database
    $insert_stmt = $mysqli->prepare("INSERT INTO users (user_name, password) VALUES (?, ?)");
    $insert_stmt->bind_param("ss", $new_username, $hashed_password);

    if ($insert_stmt->execute()) {
        echo "New user " . htmlspecialchars($new_username) . " added successfully!";
    } else {
        echo "Error: " . $insert_stmt->error . "<br>";
    }

    $insert_stmt-> close();
}

// Close the database connection
$mysqli->close();

// Link to return to the main page
echo "<br><a href='index.php'>Return to main</a>";
?>
