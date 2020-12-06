<?php

session_start();

require '../vendor/autoload.php';

$router = new AltoRouter();

require '../App/roads.php';

if ($results != null) {
    if (is_callable($results['target'])){
        call_user_func_array($results['target'], $results['params']);
    } else {
        require "./{$results['target']}.php";
    }
} else {
    require './error.php';
    printError('Page introuvable');
}