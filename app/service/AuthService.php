<?php

namespace App\Service;

use App\Controller\Main;
use App\Model\User;

class AuthService
{
    public function createAccount(string $userEmail, string $password): bool
    {
        $userEmail = Main::validateEmail($userEmail);
        $password = Main::validateParameter($password);

        $hashedPassword = Main::hashPassword($password);
        $user = new User($userEmail, $hashedPassword);

        if ($user->selectByUsername()) {
            return false;
        }
        $user->insert();

        return true;
    }

    public function login(string $userEmail, string $password): bool
    {
        $userEmail = Main::validateEmail($userEmail);
        $password = Main::validateParameter($password);

        $hashedPassword = Main::hashPassword($password);
        $user = new User($userEmail, $hashedPassword);

        $selectByUsername = $user->selectByUsername();
        if (!$selectByUsername) {
            return false;
        }

        foreach($selectByUsername[0] as $column => $value) {
            $$column = $value;
            \Connection\Log::addLog($column . ': ' . $value);
        }

        if ($user && password_verify($password, $userPassword)) {
            $_SESSION['userId'] = $userEmail;
            return true;
        }
        return false;
    }

    public function logout(): void
    {
        unset($_SESSION['userId']);
        session_destroy();
    }
}