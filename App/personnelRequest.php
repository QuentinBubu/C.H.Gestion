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

/* UPDATE SECTIONS */

// Update bed available
if (isset($_POST['departure']) && isset($_POST['arrival'])) {
    $user->updateBed($_POST['departure'], $_POST['arrival']);
}

// Add incident to patient folder
if (
    isset(
        $_POST['name'],
        $_POST['firstName'],
        $_POST['incidentCategory'],
        $_POST['incidentDetails']
    )
) {
    $user->addIncident(
        $_POST['name'],
        $_POST['firstName'],
        $_POST['incidentCategory'],
        $_POST['incidentDetails']
    );
}

/* SHOW SECTIONS */

// Show bed in other center of current service
if (isset($_GET['showAll'])) {
    $locations = $user->showAllBedInOther();
}

// Search hôpital center
if (isset($_POST['searchMediacalCenter'])) {
    $locations = $user->showBedInSpecificCenter($_POST['searchMediacalCenter']);
    $locations[0] = $locations;
    if (is_bool($locations) || is_null($locations)) {
        echo 'Erreur';
    }
}


if (isset($_GET['showAllThis'])) {
    $bed = $user->showAllBedHere();
}

if (isset($_POST['name'], $_POST['firstName'])) {
    $patient = $user->getPatientFolderByName($_POST['name'], $_POST['firstName']);
}

if (isset($_POST['patient_id'])) {
    $patient = $user->getPatientFolderById($_POST['patient_id']);
}

if (isset($patient) && is_bool($patient)) {
    $patient = 'Erreur: patient introuvable!';
}

$all = $user->getRequest(
    "SELECT *
    FROM `{$user->getInformation('location')}`
    WHERE `service` = \"{$user->getInformation('service')}\"",
    [],
    'fetch'
);
