<?php

use App\User;

use function PHPSTORM_META\type;

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

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../assets/picture/favicon.jpg" type="image/x-icon" />
    <title>Espace personnel soignant</title>
</head>
<body>

    <header>
        <h1>Bonjour <?= $user->getInformation('username') ?></h1>
        <h2>Service <?= $user->getInformation('service') ?>, hôpital <?= $user->getInformation('location') ?></h2>
    </header>

    <main>
    <section>
            <h3>Lits:</h3>
            <p>Lits disponibles: <?= $all['lits_total'] - $all['lits_occupes'] ?></p>
            <p>Lits occupés: <?= $all['lits_occupes'] ?></p>
            <p>Lits total: <?= $all['lits_total'] ?></p>
        </section>

        <section>
            <h3>Départ / arrivés:</h3>
            <form action="<?= $router->generate('soignantsPOST') ?>" method="post">
                <label for="departure">Départ(s):</label>
                <input type="number" name="departure" id="departure" min="0" value="0"/>
                <label for="arrival">Arrivée(s):</label>
                <input type="number" name="arrival" id="arrival" min="0" value="0"/>
                <button>Enregistrer</button>
            </form>
        </section>

        <section>
            <h1>Voir tout les lits du service <?= $user->getInformation('service') ?> dans les autres hôpitaux</h1>
            <form method="get">
                <button name="showAll">Afficher tout</button>
            </form>
            <?php
                if (isset($locations)):
                    foreach ($locations as $key => $value):
                        ?>
                        <h3>Hôpital <?= $value['location'] ?>:</h3>
                        <p>Lits disponibles: <?= $value[0]['lits_total'] - $value[0]['lits_occupes'] ?></p>
                        <p>Lits occupés: <?= $value[0]['lits_occupes'] ?></p>
                        <p>Lits total: <?= $value[0]['lits_total'] ?></p>
                        <?php
                    endforeach;
                endif;
            ?>
        </section>

        <section>
            <h1>Voir tout les lits de cet hôpital</h1>
            <form method="get">
                <button name="showAllThis">Afficher tout</button>
            </form>
            <?php
                if (isset($bed)):
                    foreach ($bed as $key => $value):
                        ?>
                        <h3>Service <?= $value['service'] ?>:</h3>
                        <p>Lits disponibles: <?= $value['lits_total'] - $value['lits_occupes'] ?></p>
                        <p>Lits occupés: <?= $value['lits_occupes'] ?></p>
                        <p>Lits total: <?= $value['lits_total'] ?></p>
                        <?php
                    endforeach;
                endif;
            ?>
        </section>
    </main>
</body>
</html>