<?php

namespace App\View;

require __DIR__ . '/../../vendor/autoload.php';

use App\Controller\Auth;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new Auth();
    $auth->login();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="login.php" method="POST">
        <input type="text" id="userName" name="userName">
        <input type="password" id="password" name="password">
        <button type="submit">Confirmar</button>
    </form>
</body>
</html>