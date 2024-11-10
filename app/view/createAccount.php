<?php namespace App\View;
$title = 'Create Account';
if (isset($error)) echo "<div class='alert alert-danger'>{$error}</div>"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="/createAccount" method="POST">
        <input type="text" id="userName" name="userName">
        <input type="password" id="password" name="password">
        <input type="password" id="confirmPassword" name="confirmPassword">
        <button type="submit">Confirmar</button>
    </form>
</body>
</html>