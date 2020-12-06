<?php

namespace App;

class User extends Database
{
    public $globalAccountInformation;

    private function setNewAccount($username, $password, $passwordConfirm, $location, $service)
    {
        $accountNumber =
        $this->getRequest(
            'SELECT *
                FROM `users`
                WHERE `username` = :username',
            [
                'userName' => $username,
            ],
            'fetchAll'
        );
        if (
            count($accountNumber) !== 0
        ) {
            return 'Nom d\'utilisateur déjà existant! ';
        } elseif (
            $password !== $passwordConfirm
        ) {
            return 'Les mots de passe ne correspondent pas!';
        } elseif (
            strlen($password) < 10
            || strlen($password) > 30
        ) {
            return 'Saisissez un mot de passe entre 10 et 30 caractères!';
        } elseif (
            strlen($username) <= 3
        ) {
            return 'Votre identifiant doit contenir au moins 3 caractères inclus!';
        } else {
            if (
                $this->getRequest(
                    'INSERT INTO `users` (
                        `username`,
                        `password`,
                        `location`,
                        `service`
                    ) VALUES (
                        :username,
                        :password,
                        :location,
                        :service
                    )',
                    [
                        'username' => $username,
                        'password' => password_hash($password, PASSWORD_ARGON2ID),
                        'location' => $location,
                        'service' => $service,
                    ]
                )
            ) {
                return true;
            } else {
                return 'Une erreur s\'est produite!';
            }
        }
    }

    private function setConnexion(string $username, string $password)
    {
        $request = $this->getRequest(
            'SELECT *
            FROM `users`
            WHERE `username` = :username',
            [
                'username' => $username,
            ],
            'fetch'
        );

        if (!$request) {
            return 'Compte introuvable';
        } elseif (!password_verify($password, $request['password'])) {
            return 'Mot de passe incorrect';
        } else {
            $this->globalAccountInformation = $request;
            return true;
        }
    }

    public function getNewAccount(string $username, string $password, string $passwordConfirm, string $location, string $service)
    {
        return $this->setNewAccount($username, $password, $passwordConfirm, $location, $service);
    }

    public function getConnexion(string $username, string $password)
    {
        return $this->setConnexion($username, $password);
    }

    public function getInformation(string $info)
    {
        return $this->globalAccountInformation[$info];
    }

    public function getAllInformation(): array
    {
        return $this->globalAccountInformation;
    }

    public function setInformation($informations)
    {
        foreach ($informations['globalAccountInformation'] as $key => $value) {
            $this->globalAccountInformation[$key] = $value;
        }
    }
}
