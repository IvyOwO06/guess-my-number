<?php

require_once('session.php');

define("HOST", "localhost");
define("USERNAME", "root");
define("PASSWORD", "");
define("DATABASE", "guess_my_number");

$con = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);

if (mysqli_connect_errno()) {
	echo "Failed to connect to database" . mysqli_connect_error();
}
?>