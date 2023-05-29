<?php

namespace app\controllers;

use Exception;
use app\models\Database;
use app\models\User;
use PDOException;

require_once __DIR__ . '/../../vendor/autoload.php';

class UserController
{
    public function index()
    {
        $users = User::getAll();

        echo json_encode($users);
    }

    public function show($id)
    {
        $user = User::getByID($id["id"]);

        if (!$user) {
            echo json_encode(['Message' => 'User not found']);
            exit;
        }

        echo json_encode($user);
    }

    public function create($dados)
    {
        $user = new User($dados["name"], $dados["email"], $dados["phone"], $dados["password"]);

        $result = $user->save();

        if ($result) {

            echo json_encode(['Message' => 'User created successfully']);
            exit;
        }
    }

    public function update($id)
    {
    }

    public function delete($id)
    {
        $result = User::delete($id["id"]);

        if (!$result) {
            echo json_encode(['Message' => 'User not found']);
            exit;
        }
    }
}
