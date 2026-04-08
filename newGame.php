<?php

require_once('inc/functions.php');
require_once('inc/session.php');

continueGame();
$_SESSION['message'] = "Time's up! Starting a new game.";
header('Location: index.php');