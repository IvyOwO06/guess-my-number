<?php
// functions.php - fully Bootstrap 5 integrated

require_once 'inc/session.php';

/**
 * Initialize the game state
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
            'history' => [],
            'difficulty' => 0,
            'maxTime' => 0,
            'finalTime' => 0,
            'maxAttempts' => 0
        ];
    }
}

/**
 * Check if game has started
 */
function gameStarted()
{
    return isset($_SESSION['game']['gameStarted']) && $_SESSION['game']['gameStarted'];
}

/**
 * Handle POST requests
 */
function handleRequest()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
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
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

/**
 * Start game logic
 */
function handleStart()
{
    $_SESSION['game']['gameStarted'] = true;
    $_SESSION['game']['maxAttempts'] = $_POST['attempts'] ?? 5;
    $_SESSION['game']['maxTime'] = $_POST['time'] ?? 15;
    $_SESSION['game']['difficulty'] = $_POST['difficulty'] ?? 1;

    // set ranges based on difficulty
    switch ($_SESSION['game']['difficulty']) {
        case '1':
            $_SESSION['game']['min'] = 1;
            $_SESSION['game']['max'] = 10;
            break;
        case '2':
            $_SESSION['game']['min'] = 1;
            $_SESSION['game']['max'] = 25;
            break;
        case '3':
            $_SESSION['game']['min'] = 1;
            $_SESSION['game']['max'] = 50;
            break;
        case '4':
            $_SESSION['game']['min'] = 1;
            $_SESSION['game']['max'] = 100;
            break;
        case '5':
            $_SESSION['game']['min'] = 1;
            $_SESSION['game']['max'] = 250;
            break;
        case '6':
            $_SESSION['game']['min'] = 1;
            $_SESSION['game']['max'] = 500;
            break;
        default:
            $_SESSION['game']['min'] = 1;
            $_SESSION['game']['max'] = 10;
            break;
    }

    $_SESSION['game']['target'] = mt_rand($_SESSION['game']['min'], $_SESSION['game']['max']);
    $_SESSION['game']['startTime'] = time();
    $_SESSION['game']['attempts'] = 0;
    $_SESSION['game']['history'] = [];
    $_SESSION['message'] = '';
}

/**
 * Continue game (reset timer and target)
 */
function continueGame()
{
    $_SESSION['game']['gameStarted'] = true;
    $_SESSION['game']['target'] = mt_rand($_SESSION['game']['min'], $_SESSION['game']['max']);
    $_SESSION['game']['startTime'] = time();
    $_SESSION['game']['elapsedTime'] = 0;
    $_SESSION['game']['attempts'] = 0;
    $_SESSION['game']['history'] = [];
}

/**
 * Handle guess
 */
function handleGuess()
{
    updateTimer();
    $guess = $_POST['guess'];
    $_SESSION['game']['attempts']++;

    if (!is_numeric($guess) || $guess < $_SESSION['game']['min'] || $guess > $_SESSION['game']['max']) {
        $_SESSION['message'] = "Invalid guess! Enter a number between {$_SESSION['game']['min']} and {$_SESSION['game']['max']}.";
        return;
    }

    addToHistory($guess);

    if ($guess < $_SESSION['game']['target'] && $_SESSION['game']['attempts'] < $_SESSION['game']['maxAttempts'] && $_SESSION['game']['elapsedTime'] <= $_SESSION['game']['maxTime']) {
        $_SESSION['message'] = "Too low!";
    } elseif ($guess > $_SESSION['game']['target'] && $_SESSION['game']['attempts'] < $_SESSION['game']['maxAttempts'] && $_SESSION['game']['elapsedTime'] <= $_SESSION['game']['maxTime']) {
        $_SESSION['message'] = "Too high!";
    } elseif ($guess == $_SESSION['game']['target']) {
        $_SESSION['game']['finalTime'] = time() - $_SESSION['game']['startTime'];
        if (!isset($_SESSION['user'])) {
            $_SESSION['message'] = "Congrats! You guessed it in {$_SESSION['game']['attempts']} attempts and {$_SESSION['game']['finalTime']}s. <a href='login.php'>Log in</a> to save your score.";
        } else {
            addToLeaderboard();
            $_SESSION['message'] = "Congrats! You guessed it in {$_SESSION['game']['attempts']} attempts and {$_SESSION['game']['finalTime']}s.";
        }
        continueGame();
    } elseif ($_SESSION['game']['attempts'] >= $_SESSION['game']['maxAttempts']) {
        $_SESSION['message'] = "Game over! Number was {$_SESSION['game']['target']}.";
        unset($_SESSION['game']);
    } elseif ($_SESSION['game']['elapsedTime'] > $_SESSION['game']['maxTime']) {
        $_SESSION['message'] = "Game over! Time exceeded. Number was {$_SESSION['game']['target']}.";
        unset($_SESSION['game']);
    }
}

/**
 * Add guess to history
 */
function addToHistory($guess)
{
    $_SESSION['game']['history'][] = $guess;
}

/**
 * Add to leaderboard
 */
function addToLeaderboard()
{
    if (!isset($_SESSION['user']) || !isset($_SESSION['game']))
        return;

    $con = mysqli_connect("localhost", "root", "", "guess_my_number");
    if (!$con) {
        $_SESSION['message'] .= " Could not save leaderboard.";
        return;
    }

    $stmt = mysqli_prepare($con, "INSERT INTO leaderboard (userId, username, difficulty, `maxTime(s)`, attempts, guesses, date) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $guesses = implode(", ", $_SESSION['game']['history']);
    $date = date('Y-m-d H:i:s');
    mysqli_stmt_bind_param($stmt, "isiiiss", $_SESSION['user']['id'], $_SESSION['user']['username'], $_SESSION['game']['difficulty'], $_SESSION['game']['elapsedTime'], $_SESSION['game']['attempts'], $guesses, $date);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($con);
}

/**
 * Reset game
 */
function handleReset()
{
    unset($_SESSION['game'], $_SESSION['message']);
}

/**
 * Update timer
 */
function updateTimer()
{
    if (isset($_SESSION['game']['startTime'])) {
        $_SESSION['game']['elapsedTime'] = time() - $_SESSION['game']['startTime'];
    }
}

/**
 * Display start form
 */
function startForm()
{
    ?>
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <form class="card p-4 shadow-sm w-100" style="max-width: 500px;" method="post">
            <h3 class="mb-4 text-center">Start Game</h3>

            <?php if (!empty($_SESSION['message'])): ?>
                <div class="alert alert-info"><?= $_SESSION['message'] ?></div>
            <?php endif; ?>

            <div class="mb-3">
                <label class="form-label">Name:</label>
                <?php if (isset($_SESSION['user'])): ?>
                    <input type="text" class="form-control" value="<?= $_SESSION['user']['username'] ?>" disabled>
                <?php else: ?>
                    <input type="text" class="form-control" name="name" placeholder="Enter your name">
                <?php endif; ?>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">Max Attempts:</label>
                    <input type="number" class="form-control" name="attempts" min="1" value="5">
                </div>
                <div class="col">
                    <label class="form-label">Time per Game (seconds):</label>
                    <input type="number" class="form-control" name="time" min="1" value="15">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Choose Difficulty:</label>
                <select name="difficulty" class="form-select">
                    <option value="1" selected>Easy (1-10)</option>
                    <option value="2">Average (1-25)</option>
                    <option value="3">Tough (1-50)</option>
                    <option value="4">Hard (1-100)</option>
                    <option value="5">Harder (1-250)</option>
                    <option value="6">Extreme (1-500)</option>
                </select>
            </div>

            <input type="hidden" name="action" value="start">

            <div class="d-flex gap-2 mt-3">
                <button class="btn btn-primary flex-fill">Start Game</button>
                <a href="leaderboard.php" class="btn btn-secondary flex-fill">View Leaderboard</a>
            </div>
        </form>
    </div>
    <?php
}

/**
 * Display game form
 */
function gameForm()
{
    updateTimer();
    ?>
    <div class="d-flex justify-content-center align-items-start mt-5">
        <div class="card p-4 shadow-sm w-100" style="max-width: 500px;">
            <h3 class="text-center mb-3">Guess the Number</h3>
            <p class="text-center">Guess between <?= $_SESSION['game']['min'] ?> and <?= $_SESSION['game']['max'] ?>!</p>

            <?php if (!empty($_SESSION['message'])): ?>
                <div class="alert alert-info"><?= $_SESSION['message'] ?></div>
            <?php endif; ?>

            <p><strong>Elapsed Time:</strong> <span id="timeText">0</span></p>
            <div class="progress" style="height: 25px;">
                <div class="progress-bar progress-bar-striped progress-bar-animated" id="progressbar" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div><br>

            <form method="post" class="mb-3">
                <div class="input-group">
                    <input type="number" name="guess" class="form-control" min="<?= $_SESSION['game']['min'] ?>"
                        max="<?= $_SESSION['game']['max'] ?>" required placeholder="Enter your guess">
                    <button class="btn btn-primary">Guess</button>
                </div>
                <input type="hidden" name="action" value="guess">
            </form>

            <?php if (!empty($_SESSION['game']['history'])): ?>
                <ul class="list-group mb-3">
                    <?php foreach ($_SESSION['game']['history'] as $g): ?>
                        <li class="list-group-item p-1">
                            <?= $g ?>
                            <?php if ($g < $_SESSION['game']['target']): ?>(too
                                low)<?php elseif ($g > $_SESSION['game']['target']): ?>(too high)<?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <form method="post">
                <input type="hidden" name="action" value="reset">
                <button class="btn btn-danger w-100">Reset Game</button>
            </form>
        </div>
    </div>
    <?php

    global $remaining;
    $remaining = $_SESSION['game']['maxTime'] - (time() - $_SESSION['game']['startTime']);
    $remaining = max(0, min($_SESSION['game']['maxTime'], $remaining));
    $percentage = ($remaining / $_SESSION['game']['maxTime']) * 100;

}

function dump($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

// Initialize
init();
?>