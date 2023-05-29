<?php

namespace app\models;

use app\models\Database;
use PDOException;
use Exception;

class User
{
    private $id;
    private $name;
    private $email;
    private $phone;
    private $password;


    public function __construct($name, $email, $phone, $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->phone = $phone;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }


    public function save()

    {
        try {
            $database = new Database();

            $connection = $database->getConnection();

            $sql = "INSERT INTO client (name, email, password, phone) VALUES (:name, :email, :password, :phone)";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':name', $this->name);
            $stmt->bindValue(':email', $this->email);
            $stmt->bindValue(':password', $this->password);
            $stmt->bindValue(':phone', $this->phone);
            $stmt->execute();

            $this->id = $connection->lastInsertId();

            return true;
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["Database error" =>  $e->getMessage()]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["Error" => $e->getMessage()]);
        }
    }

    static public function getAll()
    {
        try {
            $database = new Database();

            $connection = $database->getConnection();

            $sql = "SELECT * FROM client";

            return $connection->query($sql)->fetchAll();
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["Database error" =>  $e->getMessage()]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["Error" => $e->getMessage()]);
        }
    }

    static public function getByID($id)
    {
        try {
            $database = new Database();

            $connection = $database->getConnection();

            $sql = "SELECT * FROM client WHERE id = :id";


            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            $user = $stmt->fetch();

            return $user;
        } catch (PDOException $e) {
            echo json_encode(["Database error" =>  $e->getMessage()]);
        } catch (Exception $e) {
            echo json_encode(["Error" => $e->getMessage()]);
        }
    }


    public function update()
    {
        // Lógica para atualizar os dados do usuário no banco de dados
    }

    static public function delete($id)
    {
        try {
            $database = new Database();

            $connection = $database->getConnection();


            $sql = "DELETE FROM client WHERE id = :id";



            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            if (!$stmt->rowCount()) {
                return false;
            }

            return true;
        } catch (PDOException $e) {
            echo json_encode(["Database error" =>  $e->getMessage()]);
        } catch (Exception $e) {
            echo json_encode(["Error" => $e->getMessage()]);
        }
    }
}
