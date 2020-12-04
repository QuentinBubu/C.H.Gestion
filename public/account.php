<?php

if (!isset($_SESSION['user'])) {
    header('Location: /');
    exit();
} else {
    $user = json_decode($_SESSION['user'], true);
}

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="./assets/css/reset.css" />
        <link rel="stylesheet" href="./assets/css/login.css" />
        <link
            rel="shortcut icon"
            href="./assets/picture/favicon.jpg"
            type="image/x-icon"
        />
        <title>Votre compte</title>
    </head>
    <body>
        <?php
            var_dump($user);
            /*if ($user->getInformation('service') === 'administration') {
                require 'templates/admin.php';
            }*/
        ?>
    </body>
</html>
