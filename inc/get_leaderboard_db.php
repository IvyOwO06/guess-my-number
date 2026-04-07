<?php
header('Content-Type: application/json');

require_once('db.php'); // ensure $con is available

// fetch all leaderboard entries
$query = "SELECT * FROM leaderboard ORDER BY date DESC"; // newest first
$result = mysqli_query($con, $query);

$leaderboard = [];

if ($result) {
	while ($row = mysqli_fetch_assoc($result)) {
		$leaderboard[] = $row;
	}
}

echo json_encode($leaderboard);
?>