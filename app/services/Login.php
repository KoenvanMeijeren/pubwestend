<?php

namespace App\services;

use App\models\admin\AdminAccount;
use App\services\database\DB;
use App\services\core\Session;
use App\services\core\URL;
use App\services\core\Log;

class Login extends AdminAccount
{
    /**
     * Log the user in or send an error back.
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function __construct(string $email, string $password)
    {
        // if user is found
        if (!empty($this->getAccountByEmail($email))) {
            $account = $this->getAccountByEmail($email);

            // if password is verified
            if (password_verify($password, $account->account_password)) {
                Session::save('loggedIn', true);
                Session::save('id', $account->ID);

                // Authenticated.
                if (password_needs_rehash($account->account_password, PASSWORD_BCRYPT)) {
                    // Rehash, update database.
                    $encryptedPassword = password_hash($account->account_password, PASSWORD_BCRYPT);

                    // update the account
                    DB::table('account')
                        ->update([
                            'account_password' => $encryptedPassword
                        ])
                        ->where('ID', '=', $account->ID)
                        ->execute()
                        ->getSuccessful();
                }

                Session::flash('success', 'Succesvol ingelogd.');
                Log::info("Successful login for user {$email}");
                return true;
            }
        }

        Session::flash('error', 'Gebruikersnaam en/of wachtwoord is onjuist.');
        Log::info("Failed login for user {$email}");
        return false;
    }

    /**
     * Check if the user is logged in.
     *
     * @return bool
     */
    public static function isLoggedIn()
    {
        $loggedIn = boolval(Session::get('loggedIn'));
        $id = intval(Session::get('id'));

        if (
            !isset($_SESSION['loggedIn']) || $loggedIn !== true ||
            !isset($_SESSION['id']) || intval(AdminAccount::getRights($id)) < 1
        ) {
            unset($_SESSION['loggedIn']);
            unset($_SESSION['id']);
            URL::redirect('/admin');
            exit();
        }

        return true;
    }
}