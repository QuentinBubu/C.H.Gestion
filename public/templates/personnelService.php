<?php
    include '../App/personnelRequest.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./assets/css/reset.css" />
    <link rel="stylesheet" href="../assets/css/soignants.css">
    <link rel="shortcut icon" href="./assets/picture/favicon.jpg" type="image/x-icon" />
    <script src="./assets/js/event.js" defer></script>
    <title>Espace personnel soignant</title>
</head>
<body>

    <header>
        <h1>Bonjour <span class="titre-w"><?= $user->getInformation('username') ?></span>!</h1>
        <h2>Service <span class="titre-w"><?= $user->getInformation('service') ?></span>, hôpital de <span class="titre-w"><?= $user->getInformation('location') ?></span></h2>
    </header>

    <main>
        <section class="Lits-section">
            <h3>Lits:</h3>

            <div class="grid-lits">
                <div class="lits-section">
                    <p>Lits disponibles: <h1 class="nbr-lits"><?= $all['lits_total'] - $all['lits_occupes'] ?></h1></p>
                </div>

                <div class="lits-section">
                    <p>Lits occupés: <h1 class="nbr-lits"><?= $all['lits_occupes'] ?></h1></p>
                </div>

                <div class="lits-section">
                    <p>Lits total: <h1 class="nbr-lits"><?= $all['lits_total'] ?></h1> </p>
                </div>
            </div>
        </section>

        <section>
            <h3>Départs / Arrivées:</h3>
            <div class="center-content">
                <form class="form-dp" action="<?= $router->generate('soignantsPOST') ?>" method="post">
                    <label for="departure">Départ(s):</label>
                    <input type="number" name="departure" id="departure" min="0" value="0"/>
                    <label for="arrival">Arrivée(s):</label>
                    <input type="number" name="arrival" id="arrival" min="0" value="0"/>
                    <button class="register-dp">Enregistrer</button>
                </form>
            </div>
        </section>

        <section>
            <h1>Voir tout les lits du service <?= $user->getInformation('service') ?> dans les autres hôpitaux</h1>
            <form>
                <button class="btn-aff-tout" name="showAll">Afficher tout</button><span class="cross">&cross;</span>
            </form><br>
            <form class="search-bar" method="post">
            <div class="container-search">
                <label for="searchMediacalCenter">Nom de l'hôpital :</label>
                <input class="search-input-hpt" type="search" name="searchMediacalCenter" id="searchMediacalCenter" placeholder="Recherche"/>
                <button class="register-dp">Rechercher</button> 
            </div>
            </form><br><br>
            <?php
                if (isset($locations)):
                    foreach ($locations as $key => $value):
                        ?>
                        <div class="list-card">
                            <h3>
                                Hôpital <?= $value['location'] ??
                                    htmlspecialchars(
                                        ucfirst(
                                            strtolower($_POST['searchMediacalCenter'])
                                        )
                                    )
                                ?>:</h3>
                            <p>Lits disponibles: <?= $value[0]['lits_total'] - $value[0]['lits_occupes'] ?></p>
                            <p>Lits occupés: <?= $value[0]['lits_occupes'] ?></p>
                            <p>Lits total: <?= $value[0]['lits_total'] ?></p> <br>
                        </div>
                        <?php
                    endforeach;
                endif;
            ?>
        </section>

        <section>
            <h1>Voir tout les lits de cet hôpital</h1>
            <form>
                <button class="btn-aff-tout" name="showAllThis">Afficher tout</button><span class="cross">&cross;</span> <br><br>
            </form>
            <?php
                if (isset($bed)):
                    foreach ($bed as $key => $value):
                        ?>
                        <div class="list-card">
                        <h3>Service <?= $value['service'] ?>:</h3>
                        <p>Lits disponibles: <?= $value['lits_total'] - $value['lits_occupes'] ?></p>
                        <p>Lits occupés: <?= $value['lits_occupes'] ?></p>
                        <p>Lits total: <?= $value['lits_total'] ?></p>
                    </div>
                        <?php
                    endforeach;
                endif;
            ?>
        </section>

        <section>
            <h1>Afficher une fiche patient:</h1>
            <div class="ajout-patient">
            <h3>Par Nom et Prénom :</h3>
            <form method="post" autocomplete="off">
                <label for="name">Nom:</label>
                <input class="element" type="text" id="name" name="name" placeholder="Nom" /> <br>
                <label for="firstName">Prénom:</label>
                <input class="element" type="text" id="firstName" name="firstName" placeholder="Prénom" /> <br>
                <button id="element" class="register-dp">Voir la fiche</button> <br>
            </form><br><br>
            <h3>Par identifiant :</h3>
            <form method="POST" autocomplete="off">
                <label for="patient_id">Identifiant:</label>
                <input type="number" min="0" id="patient_id" name="patient_id" placeholder="Identifiant" /> <br>
                <button id='element' class="register-dp" >Voir la fiche</button>
            </form>
            </div>
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
                    <input type="hidden" name="name" value="<?= $patient['informations']['nom'] ?>" />
                    <input type="hidden" name="firstName" value="<?= $patient['informations']['prénom'] ?>" />
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
                    <button class="register-dp">Enregistrer</button>
                </form>
            <?php endif; ?>
        </section>
    </main>

    <br><br><br><br><br><br><br><br><br>
</body>
</html>