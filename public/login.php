<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="./assets/css/reset.css" />
        <link rel="stylesheet" href="./assets/css/login.css" />
        <link rel="shortcut icon" href="./assets/picture/favicon.jpg" type="image/x-icon" />
        <title>Espace connexion</title>
    </head>

    <body>
        <header>
            <h1>Bienvenue sur votre espace de connexion!</h1>
        </header>
        <main>
            <form action="<?= $router->generate('loginBack') ?>" method="POST">
                <label for="username">Nom d'utilisateur:</label>
                <input
                    type="text"
                    name="username"
                    id="username"
                    minlength="3"
                    placeholder="Votre nom d'utilisateur"
                    required
                />
                <label for="pass">Mot de passe:</label>
                <input
                    type="password"
                    name="password"
                    id="pass"
                    minlength="10"
                    placeholder="Votre mot de passe"
                    required
                />
                <button>Se connecter</button>
            </form>
        </main>
    </body>
</html>
