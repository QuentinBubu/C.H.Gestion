<?php

namespace App;

use PDO;
use Exception;

class Database
{
    private $login;
    private $password;
    private $host;
    private $db_name;
    private $pdo;

    public function __construct($login = "root", $password = "", $host = "localhost", $db_name = "example")
    {
        $this->login = $login;
        $this->password = $password;
        $this->host = $host;
        $this->db_name = $db_name;
        $this->pdo = $this->setPDO();
    }
    
    private function setPDO()
    {
        try {
            $pdo = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name .';charset=utf8', $this->login, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            echo 'Exception reçue : ',  $e->getMessage(), "\n";
        }
        return $pdo;
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