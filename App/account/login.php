<?php

use App\User;

$user = new User('mysql:host=localhost;dbname=c.h.gestion;charset=utf8', 'root', '');

if (isset($_SESSION['user'])) {
    header('Location: ' . $router->generate('account'));
    exit();
}

$return = $user->getConnexion($_POST['username'], $_POST['password']);

if ($return === true) {
    $_SESSION['user'] = json_encode($user);
    header('Location: ' . $router->generate('account'));
} else {
    include '../public/error.php';
    printError($return);
    exit();
}