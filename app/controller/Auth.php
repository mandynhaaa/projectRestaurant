<?php

namespace App\Controller;

use App\Service\AuthService;

class Auth extends Controller {

    private $authService;

    public function __construct($container) {
        $this->container = $container;
        $this->authService = new AuthService();
    }

    public function viewCreateAccount() {
        $this->render('createAccount');
    }

    public function viewLogin() {
        $this->authService->logout();
        $this->render('login');
    }

    public function viewHome() {
        $this->render('home');
    }

    public function createAccount(array $data): void
    {
        $userEmail = $data['userEmail'];
        $password = $data['password'];
        $confirmPassword = $data['confirmPassword'];

        if ($password != $confirmPassword) {
            $this->render('createAccount', ['error' => 'As senhas são diferentes']);
            return;
        }

        if ($this->authService->createAccount($userEmail, $password)) {
            header("Location: /home");
            exit;
        } else {
            $this->render('login', ['error' => 'Username não disponível']);
        }
    }

    public function login(array $data): void
    {
        $userEmail = $data['userEmail'];
        $password = $data['password'];

        if ($this->authService->login($userEmail, $password)) {
            header("Location: /home");
            exit;
        } else {
            $this->render('login', ['error' => 'Email ou senha inválida']);
        }
    }

    public function logout() {
        header("Location: /login");
        exit;
    }
}