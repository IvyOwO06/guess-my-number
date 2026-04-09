<?php

require_once('inc/session.php');
require_once('inc/headerFunctions.php');

// check if user array is in the session variable. if so send user to index.php
if (isset($_SESSION['user'])) {
    header("location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php htmlHead(); ?>
</head>

<body class="d-flex flex-column min-vh-100 bg-light">

    <?php displayHeader(); ?>

    <main class="flex-grow-1 d-flex align-items-center justify-content-center py-4">
        <div class="card shadow p-4 col-12 col-sm-8 col-md-6 col-lg-4">

            <h2 class="text-center mb-4">Login</h2>

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Enter username">
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
            </div>

            <button class="btn btn-primary w-100 mb-3" id="login-btn" type="submit">
                Login
            </button>

            <div class="text-center">
                <a href="register.php" class="link-primary text-decoration-none">
                    Don't have an account? Sign Up
                </a>
            </div>

        </div>
    </main>

    <?php displayFooter(); ?>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

    <script src="js/login.js"></script>

</body>

</html>