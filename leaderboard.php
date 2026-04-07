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
        html,
        body {
            height: 100%;
        }

        .main-wrapper {
            min-height: calc(100vh - 120px);
            /* adjust based on header/footer height */
        }
    </style>
</head>

<body>

    <body class="d-flex flex-column min-vh-100">

        <?php displayHeader(); ?>

        <main class="flex-grow-1 container py-4">
            <table class="table" id="leaderboard-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Difficulty</th>
                        <th>Attempts</th>
                        <th>Time</th>
                        <th>Guesses</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                    <tr></tr>
                </tfoot>
            </table>
        </main>

        <script id="leaderboard-template" type="x-tmpl-mustache">
            <tr>
                <td>{{entry.username}}</td>
                <td>{{entry.difficulty}}</td>
                <td>{{entry.attempts}}</td>
                <td>{{entry.maxTime(s)}}</td>
                <td>{{entry.guesses}}</td>
                <td>{{entry.date}}</td>
            </tr>
        </script>

        <?php
        displayFooter();
        ?>

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

        <!-- Bootstrap -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"
            integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf"
            crossorigin="anonymous"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>

        <!-- Mustache JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.js"></script>

        <script src="js/leaderboard.js"></script>
    </body>

</html>