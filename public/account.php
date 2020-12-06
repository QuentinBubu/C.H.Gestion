<?php

use App\User;

if (!isset($_SESSION['user'])) {
    header('Location: /');
    exit();
} else {
    $user = new User();
    $user->setInformation(json_decode($_SESSION['user'], true));
}

if ($user->getInformation('service') === 'administration') {
    header('Location: ' . $router->generate('admin'));
} else {
    header('Location: ' . $router->generate('soignants'));
}
