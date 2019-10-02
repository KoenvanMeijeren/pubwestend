<?php

namespace App\models\admin;

use App\services\database\DB;
use App\services\core\Session;

abstract class AdminAccount
{
    /**
     * Make a new account
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $confirmPassword
     * @param int $rights
     * @return bool
     */
    protected function makeAccount(
        string $name,
        string $email,
        string $password,
        string $confirmPassword,
        int $rights
    ) {
        if ($this->validateInput($email, $password, $confirmPassword, $rights)) {
            // encrypt the password
            $encryptedPassword = password_hash($password, PASSWORD_BCRYPT);

            // insert the account
            $lastInsertedId = DB::table('account')
                ->insert([
                    'account_name' => $name,
                    'account_email' => $email,
                    'account_password' => $encryptedPassword,
                    'account_level' => $rights
                ])
                ->execute()
                ->getLastInsertedId();

            if (!empty($lastInsertedId) && !empty($this->getAccount($lastInsertedId))) {
                Session::flash('success', "Account {$lastInsertedId} is succesvol aangemaakt.");
                return true;
            }

            Session::flash('error', "Er is iets fout gegaan met het aanmaken van een nieuw account.");
            return false;
        }

        return false;
    }

    /**
     * Get a specific account
     *
     * @param int $id
     * @return object
     */
    protected function getAccount(int $id)
    {
        $account = DB::table('account')
            ->select('*')
            ->where('ID', '=', $id)
            ->where('account_is_deleted', '=', '0')
            ->execute()
            ->first();

        return $account;
    }

    /**
     * Get an specific account by an given email
     *
     * @param string $email
     * @return object
     */
    protected function getAccountByEmail(string $email)
    {
        $account = DB::table('account')
            ->select('*')
            ->where('account_email', '=', $email)
            ->where('account_is_deleted', '=', '0')
            ->execute()
            ->first();

        return $account;
    }

    /**
     * Get all the stored accounts
     *
     * @return array
     */
    protected function getAccounts()
    {
        $accounts = DB::table('account')
            ->select('ID', 'account_name', 'account_email', 'account_level')
            ->where('account_is_deleted', '=', '0')
            ->execute()
            ->toArray();

        return $accounts;
    }

    /**
     * Update a specific account
     *
     * @param int $id
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $confirmPassword
     * @param int $rights
     * @return bool
     */
    protected function updateAccount(
        int $id,
        string $name,
        string $email,
        string $password,
        string $confirmPassword,
        int $rights
    ) {
        // if name must be updated
        if (!empty($name)) {
            DB::table('account')
                ->update([
                    'account_name' => $name
                ])
                ->where('ID', '=', $id)
                ->where('account_is_deleted', '=', '0')
                ->execute();
        }

        // if email must be updated
        if (!empty($name)) {
            DB::table('account')
                ->update([
                    'account_email' => $email
                ])
                ->where('ID', '=', $id)
                ->where('account_is_deleted', '=', '0')
                ->execute();
        }

        // if password must be updated
        if (!empty($password) && !empty($confirmPassword)) {
            if ($password !== $confirmPassword) {
                Session::flash('error', "De wachtwoorden zijn niet hetzelfde.");
                return false;
            }

            // encrypt the password
            $encryptedPassword = password_hash($password, PASSWORD_BCRYPT);

            // update the password
            DB::table('account')
                ->update([
                    'account_password' => $encryptedPassword
                ])
                ->where('ID', '=', $id)
                ->where('account_is_deleted', '=', '0')
                ->execute();
        }

        // if rights must be updated
        if (!empty($rights)) {
            if ($this->getAmountLevel5Accounts() < 2) {
                Session::flash('error',
                    "De rechten van account {$id} kon niet worden bijgewerkt omdat er anders geen accounts meer zijn om accounts te kunnen beheren.");
                return true;
            }

            DB::table('account')
                ->update([
                    'account_level' => $rights
                ])
                ->where('ID', '=', $id)
                ->where('account_is_deleted', '=', '0')
                ->execute();
        }

        Session::flash('success', "Account {$id} updaten is gelukt.");
        return true;
    }

    /**
     * Soft delete a specific account
     *
     * @param int $id
     * @return bool
     */
    protected function softDeleteAccount(int $id)
    {
        $isSoftDeleted = DB::table('account')
            ->softDelete('account_is_deleted', '1')
            ->where('ID', '=', $id)
            ->execute()
            ->getSuccessful();

        if ($this->getAmountLevel5Accounts() >= 1) {
            if ($isSoftDeleted && empty($this->getAccount($id))) {
                Session::flash('success', "Account {$id} verwijderen is gelukt.");
                return true;
            }
        }

        $rollBackSoftDeletedAccount = DB::table('account')
            ->update([
                'account_is_deleted' => '0'
            ])
            ->where('ID', '=', $id)
            ->execute()
            ->getSuccessful();

        if ($rollBackSoftDeletedAccount) {
            Session::flash('error',
                "Account {$id} kon niet worden verwijderd omdat er anders daarna niet meer ingelogd kan worden.");
            return false;
        }

        Session::flash('error', "Account {$id} verwijderen is mislukt.");
        return false;
    }

    /**
     * Get the amount level 5 accounts
     *
     * @return int
     */
    private function getAmountLevel5Accounts()
    {
        $numberOfItems = DB::table('account')
            ->select('*')
            ->where('account_level', '=', '5')
            ->where('account_is_deleted', '=', '0')
            ->execute()
            ->getNumberOfItems();

        return $numberOfItems;
    }

    /**
     * Get the rights of an account based on the id
     *
     * @param int $id
     * @return int
     */
    public static function getRights(int $id)
    {
        $rights = DB::table('account')
            ->select('account_level')
            ->where('ID', '=', $id)
            ->where('account_is_deleted', '=', '0')
            ->execute()
            ->first();

        return isset($rights->account_level) && !empty($rights->account_level) ? intval($rights->account_level) : 0;
    }

    /**
     * Convert the given rights into a string
     *
     * @param int $rights
     * @return string
     */
    public static function convertRights(int $rights)
    {
        switch ($rights) {
            case 1:
                return 'Niveau 1 - Lees rechten';
                break;

            case 2:
                return 'Niveau 2 - Lees en schrijf rechten';
                break;

            case 3:
                return 'Niveau 3 - Lees, schrijf en update rechten';
                break;

            case 4:
                return 'Niveau 4 - Lees, schrijf, update en verwijder rechten';
                break;

            case 5:
                return 'Niveau 5 - Lees, schrijf, update, verwijder en account beheer rechten';
                break;

            default:
                return "Niveau onbekend - onbekende rechten";
                break;
        }
    }

    /**
     * Is the given account unique?
     *
     * @param string $email
     * @return bool
     */
    private function isAccountUnique(string $email)
    {
        if (empty($this->getAccountByEmail($email))) {
            return true;
        }

        return false;
    }

    /**
     * Validate the given input.
     *
     * @param $email
     * @param $password
     * @param $confirmPassword
     * @param $rights
     * @return bool
     */
    private function validateInput($email, $password, $confirmPassword, $rights)
    {
        if (!$this->isAccountUnique($email)) {
            Session::flash('error', "Het account met email {$email} bestaat al.");
            return false;
        }

        // check if the passwords are the same
        if ($password !== $confirmPassword) {
            Session::flash('error', "De wachtwoorden zijn niet hetzelfde.");
            return false;
        }

        // check if the rights are correct
        if ($rights !== 1 && $rights !== 2 && $rights !== 3 && $rights !== 4 && $rights !== 5) {
            Session::flash('error', "Ongeldige rechten opgegeven.");
            return false;
        }

        return true;
    }
}