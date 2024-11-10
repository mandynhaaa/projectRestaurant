<?php

namespace App\Service;

use App\Controller\Main;
use App\Model\User;

class AuthService
{
    public function createAccount(string $userName, string $password): bool
    {
        $userName = Main::validateParameter($userName);
        $password = Main::validateParameter($password);

        $hashedPassword = Main::hashPassword($password);
        $user = new User($userName, $hashedPassword);

        if ($user->selectByUsername()) {
            return false;
        }
        $user->insert();

        return true;
    }

    public function login(string $userName, string $password): bool
    {
        $userName = Main::validateParameter($userName);
        $password = Main::validateParameter($password);

        $hashedPassword = Main::hashPassword($password);
        $user = new User($userName, $hashedPassword);

        $selectByUsername = $user->selectByUsername();
        if (!$selectByUsername) {
            return false;
        }

        foreach($selectByUsername[0] as $column => $value) {
            $$column = $value;
            \Connection\Log::addLog($column . ': ' . $value);
        }

        if ($user && password_verify($password, $userPassword)) {
            $_SESSION['user_id'] = $userName;
            return true;
        }
        return false;
    }

    public function logout(): void
    {
        unset($_SESSION['user_id']);
        session_destroy();
    }
}