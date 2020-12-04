<?php

session_start();

require '../vendor/autoload.php';

use App\User;

$user = new User('root', '', 'localhost', 'c.h.gestion');
$router = new AltoRouter();

require '../App/roads.php';

if ($results != null) {
    if (is_callable($results['target'])){
        call_user_func_array($results['target'], $results['params']);
    } else {
        require "./{$results['target']}.php";
    }
} else {
    require './assets/errorPage/404.html';
}