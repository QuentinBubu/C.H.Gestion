<?php

namespace App;

use PDO;
use Exception;

class Database
{
    private $dns;
    private $login;
    private $password;
    private $pdo;

    public function __construct($dns = 'mysql:host=localhost;dbname=c.h.gestion;charset=utf8', $login = 'root', $password = '')
    {
        $this->login = $login;
        $this->password = $password;
        $this->dns = $dns;
        $this->setPDO();
    }
    
    private function setPDO()
    {
        if ($this->pdo === null) {
            try {
                $pdo = new PDO($this->dns, $this->login, $this->password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->pdo = $pdo;
            } catch (Exception $e) {
                echo 'Exception reçue : ' . $e->getMessage() . "\n";
            }
        }
    }

    private function request($request, $values, $type)
    {
        try {
            $request = $this->pdo->prepare($request);
            $request->execute($values);
            if ($type === 'fetchAll') {
                return $request->fetchAll(PDO::FETCH_ASSOC);
            } elseif ($type === 'fetch') {
                return $request->fetch();
            } else {
                return $request;
            }
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    public function getRequest($request, $values, $type = '')
    {
        return $this->request($request, $values, $type);
    }
}
