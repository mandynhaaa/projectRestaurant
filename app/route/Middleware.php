<?php

namespace App\Route;

class Middleware
{
    public function handle(array $request, callable $next)
    {
        if (!$this->isAuthenticated()) {
            header('Location: /login');
            exit();
        }
        return $next($request);
    }

    private function isAuthenticated()
    {
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }
}
