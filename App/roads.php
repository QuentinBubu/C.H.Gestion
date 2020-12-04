<?php

$router->map('GET', '/', 'home', 'login');
$router->map('GET', '/home', 'login');
$router->map('GET', '/index', 'login');
$router->map('GET', '/login', 'login');

$router->map('POST', '/login', '../App/php/LoginSignup/login', 'login-back');

$results = $router->match();