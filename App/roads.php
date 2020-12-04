<?php

// Index redirection
$router->map('GET', '/', 'login');
$router->map('GET', '/home', 'login');
$router->map('GET', '/index', 'login');
$router->map('GET', '/login', 'login');

// Account redirection
$router->map('POST', '/login', '../App/account/login', 'loginBack');
$router->map('GET', '/account', 'account', 'account');

$results = $router->match();