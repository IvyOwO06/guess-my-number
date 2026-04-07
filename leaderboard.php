<?php

require_once 'inc/functions.php';
require_once 'inc/session.php';
require_once 'inc/headerFunctions.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php htmlHead(); ?>
    <style>
        html, body {
            height: 100%;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <?php displayHeader(); ?>

    <main class="flex-grow-1 container py-4">

        <!-- Sort options -->
        <div class="mb-3">
            <label class="form-label me-3">Sort by:</label>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="sortBy" id="sortByAttempts" value="attempts" checked>
                <label class="form-check-label" for="sortByAttempts">Attempts</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="sortBy" id="sortByTime" value="time">
                <label class="form-check-label" for="sortByTime">Time</label>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle" id="leaderboard-table">
                <thead class="table-dark">
                    <tr>
                        <th>Rank</th>
                        <th>Name</th>
                        <th>Difficulty</th>
                        <th>Attempts</th>
                        <th>Time (seconds)</th>
                        <th>Guesses</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

    </main>

    <!-- Mustache template -->
    <script id="leaderboard-template" type="x-tmpl-mustache">
        <tr>
            <td>{{entry.rank}}.</td>
            <td>{{entry.username}}</td>
            <td>{{entry.difficulty}}</td>
            <td>{{entry.attempts}}</td>
            <td>{{entry.maxTime(s)}}</td>
            <td>{{entry.guesses}}</td>
            <td>{{entry.date}}</td>
        </tr>
    </script>

    <?php displayFooter(); ?>

    <!-- jQuery (optional if your JS needs it) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Bootstrap 5 ONLY -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Mustache -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.js"></script>

    <script src="js/leaderboard.js"></script>

</body>
</html>