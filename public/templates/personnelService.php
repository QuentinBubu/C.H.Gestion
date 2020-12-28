<?php
    include '../App/personnelRequest.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="./assets/picture/favicon.jpg" type="image/x-icon" />
    <title>Espace personnel soignant</title>
</head>
<body>

    <header>
        <h1>Bonjour <?= $user->getInformation('username') ?>!</h1>
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

        <section>
            <h1>Afficher une fiche patient:</h1>
            <h3>Par Nom et Prénom</h3>
            <form method="post">
                <label for="name">Nom:</label>
                <input type="text" id="name" name="name" placeholder="Nom" />
                <label for="firstName">Prénom:</label>
                <input type="text" id="firstName" name="firstName" placeholder="Prénom" />
                <button>Voir la fiche</button>
            </form>
            <h3>Par identifiant</h3>
            <form method="get">
                <label for="patient_id">Identifiant:</label>
                <input type="number" id="patient_id" name="patient_id" placeholder="Identifiant" />
                <button>Voir la fiche</button>
            </form>
            <?php
                if (isset($patient)) {
                    echo '<pre>';
                    var_dump($patient);
                    echo '</pre>';
                }
            ?>
        </section>
        <section>
            <?php if (isset($patient)): ?>
                <h3>Ajouter un incident</h3>
                <form method="post">
                    <input type="hidden" name="name" value="<?= $patient['nom'] ?>" />
                    <input type="hidden" name="firstName" value="<?= $patient['prénom'] ?>" />
                    <label for="category">Catégorie:</label>
                    <select name="incidentCategory" id="category" required>
                        <option selected disabled>--Séléctionnez une option--</option>
                        <option value="Violences physiques">Violences physiques</option>
                        <option value="Violences verbales">Violences verbales</option>
                        <option value="Degradation">Dégradations</option>
                        <option value="Autre">Autre</option>
                    </select>
                    <label for="incidentDetails">Détails</label>
                    <input type="text" name="incidentDetails" id="incidentDetails" required />
                    <button>Enregistrer</button>
                </form>
            <?php endif; ?>
        </section>
    </main>
    <br><br><br><br><br><br><br><br><br>
</body>
</html>