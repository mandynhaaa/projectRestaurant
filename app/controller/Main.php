<?php

namespace App\Controller;

class Main
{
    /**
     * Validates a parameter to avoid injection vulnerabilities.
     *
     * @param mixed $input The value to be validated.
     * @return mixed The validated value.
     */
    public static function validateParameter($param)
    {
        return htmlspecialchars(trim($param), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Validates an email to ensure it is in the correct format.
     *
     * @param string $email The email to be validated.
     * @return bool Returns true if the email is valid, false otherwise.
     */
    public static function validateEmail($email) : bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Generates a secure hash for passwords.
     *
     * @param string $password The password to be hashed.
     * @return string The hashed password.
     */
    public static function hashPassword($password) : string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

}
