<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init the game and redirect to play the game
 */
$app->router->get("guess/init", function () use ($app) {
    // Init the game
    $game = new Ebam18\Guess\Guess();
    $_SESSION["number"] = $game->number();
    $_SESSION["tries"] = $game->tries();

    return $app->response->redirect("guess/play");
});



/**
 * Play the game - show game status
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Play the game";

    $number = $_SESSION["number"] ?? null;
    $tries = $_SESSION["tries"] ?? null;
    $guess = $_SESSION["guess"] ?? null;
    $res = $_SESSION["res"] ?? null;
    $doCheat = $_SESSION["doCheat"] ?? null;

    $_SESSION["guess"] = null;
    $_SESSION["doCheat"] = null;

    $data = [
        "tries" => $tries,
        "guess" => $guess ?? null,
        "res" => $res,
        "number" => $number ?? null, #för cheat
        "doCheat" => $doCheat ?? null #för cheat
    ];
    if (($res === "CORRECT!") || ($res === "YOU LOSE!")) {
        return $app->response->redirect("guess/end-game");
    } else {
        $_SESSION["res"] = null;

        $app->page->add("guess/play", $data);
        // $app->page->add("guess/debug", $data);

        return $app->page->render([
            "title" => $title,
        ]);
    }
});



/**
 * Play the game - Recive form data and redirect
 */
$app->router->post("guess/form-response", function () use ($app) {

    // Deal with the incoming variables
    $guess = $_POST["guess"] ?? null;
    $doInit = $_POST["doInit"] ?? null;
    $doGuess = $_POST["doGuess"] ?? null;
    $doCheat = $_POST["doCheat"] ?? null;

    if ($doGuess) {
        // Redirect to make guess
        $_SESSION["guess"] = $guess;
        return $app->response->redirect("guess/make-guess");
    } elseif ($doInit) {
        // Redirect to init new game
        return $app->response->redirect("guess/init");
    } elseif ($doCheat) {
        $_SESSION["doCheat"] = $doCheat;
        return $app->response->redirect("guess/play");
    }
});



/**
 * Play the game - make a guess
 */
$app->router->get("guess/make-guess", function () use ($app) {

    // Deal with the neededsession variables
    $guess = $_SESSION["guess"];
    $number = $_SESSION["number"];
    $tries = $_SESSION["tries"];

    // Make guess
    $game = new Ebam18\Guess\Guess($number, $tries);
    $res = $game->makeGuess($guess);
    $_SESSION["tries"] = $game->tries();
    $_SESSION["res"] = $res;

    return $app->response->redirect("guess/play");
});



/**
 * End the game
 */
$app->router->get("guess/end-game", function () use ($app) {
    $title = "Game finished!";

    $res = $_SESSION["res"];
    $number = $_SESSION["number"];
    $tries = $_SESSION["tries"];

    $_SESSION["res"] = null;

    $data = [
        "res" => $res,
        "number" => $number,
        "tries" => $tries
    ];


    $app->page->add("guess/result", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});
