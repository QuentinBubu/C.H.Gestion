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

    public function __construct($dns, $login, $password)
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
        $request = $this->pdo->prepare($request);
        $request->execute($values);
        if ($type === 'fetchAll') {
            return $request->fetchAll(PDO::FETCH_OBJ);
        } elseif ($type === 'fetch') {
            return $request->fetch();
        } else {
            return $request;
        }
    }

    public function getRequest($request, $values, $type = '')
    {
        return $this->request($request, $values, $type);
    }
}
