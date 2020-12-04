<?php

if ($user->getInformation('service') !== 'administration') {
    require_once '../error.php';
    printError('Erreur: vous n\'avez pas les droits!');
    exit();
}

echo 2;