<?Php

// the database connection
require_once('db.php');

require_once('session.php');

// print_r($_POST);

// retrieves the variables from the ajax request
$username = htmlspecialchars($_POST['username']);
$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);

// checks the database if the username already exists
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($con, $sql);
$count_user = mysqli_num_rows($result);

// checks the database if the email already exists
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($con, $sql);
$count_email = mysqli_num_rows($result);

// encrypts the password
$hash = password_hash($password, PASSWORD_DEFAULT);

// if the username and email don't already exist in the database will execute the sql query
if ($count_user == 0 && $count_email == 0) {
    // executes the sql query
    $signupUser = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hash')";
    if (mysqli_query($con, $signupUser)) {
        echo "Succesfully signed up!";
    } else {
        // error handling
        echo "Oops," . mysqli_error($con);
    }
} else {
    // if the username already exists gives this alert back instead of executing the sql query
    if ($count_user > 0) {
        echo "Username is already taken.";
        // if the email already exists gives this alert back instead of executing the sql query
    } else if ($count_email > 0) {
        echo "Email is already taken.";
    }
}