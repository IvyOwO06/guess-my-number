<?php
// this file will contain all the functions we need for our game

// start the session to store game state
// because we want to use sessions in our game, we need to start the session at the beginning of our script
// because this file will be included in index.php, we can start the session here and it will be available in index.php as well

function handleRequest()
{
    // function handles three different post requests:
    // 1. start game (with, amongst other min and max values)
    // 2. make a guess (with the guessed number)
    // 3. reset game (with a reset button)
    // switch case to check which request was made and call the appropriate function to handle the request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        switch ($_POST['action']) {
            case 'start':
                handleStart();
                break;
            case 'guess':
                handleGuess();
                break;
            case 'reset':
                handleReset();
                break;
        }
        // redirect to index.php after handling the request to prevent form resubmission
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

/**
 * This function will initialize the game state.
 * Sets all kind of session data to their default values if they are not already set. This function will be called at the beginning of our script to ensure that the game state is properly initialized before we start handling requests or displaying forms.
 */
function init()
{
    if (!isset($_SESSION['game'])) {
        $_SESSION['game'] = [
            'gameStarted' => false,
            'min' => 0,
            'max' => 100,
            'target' => 0,
            'attempts' => 0,
            'timer' => 0,
            'startTime' => 0,
            'endTime' => 0,
            'elapsedTime' => 0,
            'message' => '',
            'history' => [],
            'difficulty' => 0,
            'maxTime' => 0,
            'finalTime' => 0
        ];
    }
}

/**
 * This function will check if the game has been started.
 * Returns true if the game has been started, false otherwise.
 * @return bool
 */
function gameStarted()
{
    return isset($_SESSION['game']['gameStarted']) && $_SESSION['game']['gameStarted'];
}

/**
 * This function will handle the start game request.
 */
function handleStart()
{
    // start game logic
    $_SESSION['game']['gameStarted'] = true;
    $_SESSION['game']['min'] = $_POST['min'];
    $_SESSION['game']['max'] = $_POST['max'];
    $_SESSION['game']['maxAttempts'] = $_POST['attempts'];
    $_SESSION['game']['maxTime'] = $_POST['time'];
    $difficulty = $_SESSION['game']['difficulty'] = $_POST['difficulty'];

    switch ($difficulty) {
        case '1': // Easy
            $_SESSION['game']['min'] = 1;
            $_SESSION['game']['max'] = 50;
            break;
        case '2': // Medium
            $_SESSION['game']['min'] = 1;
            $_SESSION['game']['max'] = 100;
            break;
        case '3': // Hard
            $_SESSION['game']['min'] = 1;
            $_SESSION['game']['max'] = 500;
            break;
    }

    $_SESSION['game']['target'] = mt_rand($_SESSION['game']['min'], $_SESSION['game']['max']);
    // set start time for timer
    $_SESSION['game']['startTime'] = time();
    $_SESSION['game']['attempts'] = 0;
    $_SESSION['game']['history'] = [];
    $_SESSION['message'] = '';
}

/**
 * This function will handle the guess game request.
 */
function handleGuess()
{
    updateTimer();
    // guess game logic
    $guess = $_POST['guess'];
    // increase attempts
    $_SESSION['game']['attempts']++;
    // compare secret number with user input
    if ($guess < $_SESSION['game']['target'] && $_SESSION['game']['attempts'] < $_SESSION['game']['maxAttempts'] && $_SESSION['game']['elapsedTime'] <= $_SESSION['game']['maxTime']) {
        $_SESSION['message'] = 'Too low!';
        // add some time penalty for wrong guess
        addToHistory($guess . ' (too low)');
        $_SESSION['game']['maxTime'] += $_SESSION['game']['elapsedTime'];
    } elseif ($guess > $_SESSION['game']['target'] && $_SESSION['game']['attempts'] < $_SESSION['game']['maxAttempts'] && $_SESSION['game']['elapsedTime'] <= $_SESSION['game']['maxTime']) {
        $_SESSION['message'] = 'Too high!';
        // add some time penalty for wrong guess
        addToHistory($guess . ' (too high)');
        $_SESSION['game']['maxTime'] += $_SESSION['game']['elapsedTime'];
    } elseif ($guess == $_SESSION['game']['target'] && $_SESSION['game']['attempts'] <= $_SESSION['game']['maxAttempts'] && $_SESSION['game']['elapsedTime'] <= $_SESSION['game']['maxTime']) {
        $_SESSION['game']['finalTime'] = time() - $_SESSION['game']['startTime'];
        $_SESSION['message'] = 'Congratulations! You guessed the number in ' . $_SESSION['game']['attempts'] . ' attempts and ' . $_SESSION['game']['finalTime'] . ' seconds!';

        // instead of destroying the whole session, only remove the game data
        $message = $_SESSION['game']['message'];
        unset($_SESSION['game']);
        init();
        $_SESSION['game']['message'] = $message;
    } elseif ($_SESSION['game']['attempts'] >= $_SESSION['game']['maxAttempts']) {
        $_SESSION['message'] = 'Game over! You have used all your attempts. The number was ' . $_SESSION['game']['target'] . '.';
        unset($_SESSION['game']);

    } elseif ($_SESSION['game']['elapsedTime'] > $_SESSION['game']['maxTime']) {
        $_SESSION['message'] = 'Game over! You have used all your time. The number was ' . $_SESSION['game']['target'] . '.';
        unset($_SESSION['game']);
    }
}

function addToHistory($guess)
{
    // add guess to history
    $_SESSION['game']['history'][] = $guess;
}

/**
 * This function will handle the reset game request.
 */
function handleReset()
{
    // reset game logic
    unset($_SESSION['game']);
}

function updateTimer()
{
    // timer logic
    $_SESSION['game']['elapsedTime'] = (time() - $_SESSION['game']['startTime']);
}

/**
 * This function will display the form to start the game.
 */
function startForm()
{
    // html form to start the game
    // will always redirect to index.php after submission
    ?>
    <div class="container mt-5">
        <form class="card p-4 shadow-sm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <h3 class="mb-4">Start Game</h3>

            <?php if (!empty($_SESSION['message'])) { ?>
                <div class="alert alert-info">
                    <?php echo $_SESSION['message'];
                    ?>
                </div>
                <?php
            } ?>

            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <?php
                if (isset($_SESSION['user'])) {
                    ?>
                    <input type="text" class="form-control" name="name" id="name" value="<?= $_SESSION['user']['username'] ?>"
                        disabled>

                    <?php
                } else {
                    ?>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name">
                    <?php
                }
                ?>
            </div>

            <!-- Min & Max -->
            <div class="row mb-3">
                <div class="col">
                    <label for="min" class="form-label">Min:</label>
                    <input type="number" class="form-control" name="min" id="min" min="1" value="1">
                </div>
                <div class="col">
                    <label for="max" class="form-label">Max:</label>
                    <input type="number" class="form-control" name="max" id="max" min="1" value="100">
                </div>
            </div>

            <!-- Attempts & Time -->
            <div class="row mb-3">
                <div class="col">
                    <label for="attempts" class="form-label">Max Attempts:</label>
                    <input type="number" class="form-control" name="attempts" id="attempts" min="1" value="5">
                </div>
                <div class="col">
                    <label for="time" class="form-label">Time per Attempt (seconds):</label>
                    <input type="number" class="form-control" name="time" id="time" min="1" value="15">
                </div>
            </div>

            <div class="mb-3">
                <label for="difficulty" class="form-label">
                    Choose a difficulty (if left on default it will use the values you put in):
                </label>
                <select name="difficulty" id="difficulty" class="form-select">
                    <option value="0" selected>Default</option>
                    <option value="1">Easy (1-50)</option>
                    <option value="2">Medium (1-100)</option>
                    <option value="3">Hard (1-500)</option>
                </select>
            </div>

            <input type="hidden" name="action" value="start">

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill">
                    Start Game
                </button>
                <a href="leaderboard.php" class="btn btn-secondary flex-fill">
                    View Leaderboard
                </a>
            </div>
        </form>
    </div>
    <?php
}

/**
 * This function will display the form to play the game.
 */
function gameForm()
{
    // html form to play the game
    // will always redirect to index.php after submission

    // show message if there is one
    ?>
    <div class="container mt-5">
        <div class="card p-4 shadow-sm">

            <?php if (!empty($_SESSION['message'])): ?>
                <div class="alert alert-info">
                    <?php echo $_SESSION['message']; ?>
                </div>
            <?php endif; ?>

            <?php
            updateTimer();
            ?>
            <p class="mb-3">
                <strong>Elapsed Time:</strong>
                <?php echo $_SESSION['game']['elapsedTime']; ?> seconds
            </p>

            <!-- Guess Form -->
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mt-3">
                <div class="input-group">
                    <input type="number" name="guess" class="form-control" min="<?php echo $_SESSION['game']['min']; ?>"
                        max="<?php echo $_SESSION['game']['max']; ?>" placeholder="Enter your guess..." required>
                    <button type="submit" class="btn btn-primary">
                        Make your guess!
                    </button>
                </div>
                <input type="hidden" name="action" value="guess">
            </form>

            <?php if (!empty($_SESSION['game']['history'])): ?>
                <div class="mb-3">
                    <strong>Previous Guesses:</strong>
                    <div class="mt-2">
                        <?php echo implode('<br>', $_SESSION['game']['history']); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Reset Form -->
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mt-3">
                <input type="hidden" name="action" value="reset">
                <button type="submit" name="reset" class="btn btn-danger w-100">
                    Reset Game
                </button>
            </form>

        </div>
    </div>
    <?php
}

/**
 * This function will display the form to reset the game.
 */
function resetForm()
{
    ?>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mt-3">
        <input type="hidden" name="action" value="reset">
        <button type="submit" name="reset" class="btn btn-danger w-100">
            Reset Game
        </button>
    </form>
    <?php
}

/**
 * This function will dump the contents of a variable for debugging purposes.
 * @param mixed $var The variable to dump.
 */
function dump($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

// call the init function to initialize the game state
init();