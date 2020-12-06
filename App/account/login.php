<?php

use App\User;

if (isset($_SESSION['user'])) {
    header('Location: ' . $router->generate('account'));
    exit();
}

$user = new User();
$return = $user->getConnexion($_POST['username'], $_POST['password']);

if ($return === true) {
    $_SESSION['user'] = json_encode($user);
    header('Location: ' . $router->generate('account'));
} else {
    include '../public/error.php';
    printError($return);
    exit();
}