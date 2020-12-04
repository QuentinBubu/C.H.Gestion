<?php

function printError($error) { ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="./assets/css/reset.css" />
        <link rel="stylesheet" href="./assets/css/login.css" />
        <link rel="shortcut icon" href="./assets/picture/favicon.jpg" type="image/x-icon" />
        <title>Erreur</title>
    </head>
    <body>
        <h1>Oh non...</h1>
        <h3><?= $error ?></h3>
        <a href="/">Retour à la page principale</a>
    </body>
    </html>
<?php } ?>