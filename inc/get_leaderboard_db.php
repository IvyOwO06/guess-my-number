<?php
header('Content-Type: application/json');

require_once('db.php');

// allowed columns
$allowedSorts = ['attempts', 'maxTime(s)'];

// get input
$sortBy = $_GET['sortBy'] ?? 'attempts';

// validate input
if (!in_array($sortBy, $allowedSorts)) {
    $sortBy = 'attempts';
}

// query
$query = "SELECT * FROM leaderboard ORDER BY `$sortBy` ASC";
$result = mysqli_query($con, $query);

$leaderboard = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $leaderboard[] = $row;
    }
}

echo json_encode($leaderboard);
?>