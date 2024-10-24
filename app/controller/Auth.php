<?php

namespace App\Controller;

require __DIR__ . '/../../vendor/autoload.php';

use App\Controller\Main;
use App\Model\User;

class Auth  {

    public function isLoggedIn()
    {
        session_start();
        return !empty($_SESSION['user']);
    }

    public function login()
    {
        $userName = Main::validateParameter($_POST['userName']);
        $password = Main::validateParameter($_POST['password']);
        $user = new User($userName, $password, 0);
        $user->insert();
    }

    public function logout()
    {
        session_start();
        session_destroy();
    }
    
}

?>
