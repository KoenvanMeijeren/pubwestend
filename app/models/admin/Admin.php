<?php


namespace App\model\admin;


use App\services\core\Session;

abstract class Admin
{
    /**
     * Validate the given input
     *
     * @param $email
     * @param $password
     * @return bool
     */
    protected function validateInput($email, $password)
    {
        if (empty($email) || empty($password)) {
            Session::flash('error', 'Email en/of wachtwoord is onjuist.');
            return false;
        }

        if (!empty($email)) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Session::flash('error', 'Ongeldige email opgegeven.');
                return false;
            }
        }

        if (!empty($password)) {
            if (!is_string($password)) {
                Session::flash('error', 'Ongeldig wachtwoord opgegeven.');
                return false;
            }
        }

        return true;
    }
}