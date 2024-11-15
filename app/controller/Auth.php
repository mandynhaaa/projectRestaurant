<?php

namespace App\Controller;

use App\Service\AuthService;

class Auth {

    protected $container;
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

    public function login(array $data): void
    {
        $userName = $data['userName'];
        $password = $data['password'];

        if ($this->authService->login($userName, $password)) {
            header("Location: /home");
            exit;
        } else {
            $this->render('login', ['error' => 'Email ou senha inválida']);
        }
    }

    public function createAccount(array $data): void
    {
        $userName = $data['userName'];
        $password = $data['password'];
        $confirmPassword = $data['confirmPassword'];

        if ($password != $confirmPassword) {
            $this->render('createAccount', ['error' => 'As senhas são diferentes']);
            return;
        }

        if ($this->authService->createAccount($userName, $password)) {
            header("Location: /home");
            exit;
        } else {
            $this->render('login', ['error' => 'Username não disponível']);
        }
    }

    public function logout() {
        header("Location: /login");
        exit;
    }

    public function render(string $view, array $data = []): void
    {
        extract($data);

        ob_start();
        require __DIR__ . "/../view/{$view}.php";
        $content = ob_get_clean();

        require __DIR__ . '/../view/layout.php';
    }
}