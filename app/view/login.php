<?php namespace App\View;
$title = 'Login';
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
    <form action="/login" method="POST">
        <input type="email" id="userEmail" name="userEmail" required>
        <input type="password" id="password" name="password" required>
        <button type="submit">Confirmar</button>
    </form>
</body>
</html>