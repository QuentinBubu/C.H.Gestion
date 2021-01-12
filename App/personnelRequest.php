<?php

use App\User;

/*
 * Redirect to index if user is disconnected
 * Else, create user class
 */

if (!isset($_SESSION['user'])) {
    header('Location: /');
    exit();
} else {
    $user = new User();
    $user->setInformation(json_decode($_SESSION['user'], true));
}

// If user has not authorization
if (!isset($user)) {
    require_once 'error.php';
    printError('Erreur: vous n\'avez pas les droits!');
    exit();
}

// Update bed available
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

if (isset($_GET['name'], $_GET['firstName'])) {
    $patient = $user->getRequest(
        'SELECT *
        FROM `patients`
        WHERE `name` = :name
        AND `firstName` = :firstName',
        [
            'name' => $_GET['name'],
            'firstName' => $_GET['firstName']
        ],
        'fetch'
    );
    $patient = json_decode($patient['informations'], true);
}

if (isset($_GET['patient_id'])) {
    $patient = $user->getRequest(
        'SELECT *
        FROM `patients`
        WHERE `id` = :id',
        [
            'id' => $_GET['patient_id'],
        ],
        'fetch'
    );
    $patient = json_decode($patient['informations'], true);
}

if (isset($patient) && is_bool($patient)) {
    $patient = 'Erreur: patient introuvable!';
}

if (
    isset(
        $_POST['name'],
        $_POST['firstName'],
        $_POST['incidentCategory'],
        $_POST['incidentDetails']
    )
) {

    $patient = $user->getRequest(
        'SELECT *
        FROM `patients`
        WHERE `name` = :name
        AND `firstName` = :firstName',
        [
            'name' => $_POST['name'],
            'firstName' => $_POST['firstName']
        ],
        'fetch'
    );

    $patient = json_decode($patient['informations'], true);

    $patient['incidents'] = array_merge(
        $patient['incidents'],
        [
            $_POST['incidentCategory'] => $_POST['incidentDetails']
        ]
    );

    $user->getRequest(
        'UPDATE `patients`
        SET `informations` = :fiche',
        [
            'fiche' => json_encode($patient)
        ]
    );
}