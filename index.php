<?php
// get the functions
require_once 'inc/functions.php';
require_once 'inc/session.php';
require_once 'inc/headerFunctions.php';

// check post request (which form was used?)
handleRequest();

// quick dump to show session contents

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php htmlHead() ?>
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

<body class="bg-light d-flex flex-column">

    <?php displayHeader(); ?>

    <div class="main-wrapper d-flex align-items-center justify-content-center">
        <div class="container" style="max-width: 700px;">

            <?php
            if (!gameStarted()) {
                startForm();
            } else {
                gameForm();
            }
            ?>

        </div>
    </div>

    <?php displayFooter(); ?>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

</body>

</html>

<?php
// dump($_SESSION);