<?php

require_once('inc/session.php');

// unsets the user form the session variable (logs the user out) and redirects the user to the homepage
unset($_SESSION['user']);
echo "<script>
    alert('Successfully logged out!');
    window.location.href= 'index.php'; </script>";