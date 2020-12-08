<?php

use App\User;

if (!isset($_SESSION['user'])) {
    header('Location: /');
    exit();
} else {
    $user = new User();
    $user->setInformation(json_decode($_SESSION['user'], true));
}

if (!isset($user)) {
    require_once 'error.php';
    printError('Erreur: vous n\'avez pas les droits!');
    exit();
}

if (isset($_POST['departure']) && isset($_POST['arrival'])) {
    $user->getRequest(
        "UPDATE `{$user->getInformation('location')}`
        SET `lits_occupes` = `lits_occupes` - :occupe
        WHERE `service` = \"{$user->getInformation('service')}\"",
        [
            'occupe' => $_POST['departure'] - $_POST['arrival']
        ]
    );
}

$all = $user->getRequest(
    "SELECT *
    FROM `{$user->getInformation('location')}`
    WHERE `service` = \"{$user->getInformation('service')}\"",
    [],
    'fetch'
);

if (isset($_GET['showAll'])) {
    $tables = $user->getRequest(
        'SHOW TABLES FROM `c.h.gestion`',
        [],
        'fetchAll'
    );
    $locations = [];
    foreach ($tables as $value) {
        if (
            $value['Tables_in_c.h.gestion'] === 'patients'
            || $value['Tables_in_c.h.gestion'] === 'users'
        ) {
            continue;
        }
        $data = $user->getRequest(
            "SELECT *
            FROM {$value['Tables_in_c.h.gestion']}
            WHERE `service` = :service",
            [
                'service' => $user->getInformation('service')
            ],
            'fetch'
        );
        $push = [
            'location' => $value['Tables_in_c.h.gestion']
        ];
        if (is_bool($data)) {
            continue;
        }
        array_push($push, $data);
        array_push($locations, $push);
    }
}

if (isset($_GET['showAllThis'])) {
    $bed = $user->getRequest(
        "SELECT *
        FROM {$user->getInformation('location')}",
        [],
        'fetchAll'
    );
}