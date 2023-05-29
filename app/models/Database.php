<?php

namespace app\models;

require __DIR__ . '/../../config.php';

use PDO;
use PDOException;

class Database
{
    private $host = DB_HOST;
    private $port = DB_PORT;
    private $dbName = DB_NAME;
    private $user = DB_USER;
    private $password = DB_PASSWORD;
    private $connection;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        $dsn = "pgsql:host=$this->host;port=$this->port;dbname=$this->dbName";
        try {
            $this->connection = new PDO($dsn, $this->user, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo json_encode(["Falha na conexão" => $e->getMessage()]);
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function closeConnection()
    {
        $this->connection = null;
    }
}
