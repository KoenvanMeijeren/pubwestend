<?php


namespace App\services\core;

abstract class Session
{
    /**
     * Save data in the session based on the given key.
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public static function save(string $key, $value)
    {
        if (!isset($_SESSION[$key])) {
            $value = sanitize_data($value, gettype($value));
            $_SESSION[$key] = Encrypt::encrypt($value);
        }

        if (isset($_SESSION[$key])) {
            return true;
        }

        return false;
    }

    /**
     * Flash data in the session based on the given key.
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public static function flash(string $key, $value)
    {
        $value = sanitize_data($value, gettype($value));
        $_SESSION[$key] = Encrypt::encrypt($value);

        if ($key === 'error') {
            Log::info("Failed " . URL::method() . " request for page '" . URL::getUrl() . "' with message '{$value}'");
        }

        if ($key === 'success') {
            Log::info("Successful " . URL::method() . " request for page '" . URL::getUrl() . "' with message '{$value}'");
        }


        if (isset($_SESSION[$key])) {
            return true;
        }

        return false;
    }

    /**
     * Get data which is stored in the session. And unset it if specified.
     *
     * @param string $key
     * @param bool $unset
     * @return array|bool|mixed|string
     */
    public static function get(string $key, bool $unset = false)
    {
        $returnValue = '';
        if (isset($_SESSION[$key]) && !empty($_SESSION[$key])) {
            if (is_scalar($_SESSION[$key])) {
                $value = sanitize_data($_SESSION[$key], gettype($_SESSION[$key]));
                $returnValue = Encrypt::decrypt($value);
            }

            if (is_array($_SESSION[$key])) {
                $newArray = [];
                foreach ($_SESSION[$key] as $session) {
                    if (is_scalar($session)) {
                        $value = sanitize_data($session, gettype($_SESSION[$key]));
                        $newArray[] = Encrypt::decrypt($value);
                    }

                    $newArray[] = $session;
                }

                $returnValue = $newArray;
            }

            if ($unset) {
                unset($_SESSION[$key]);
            }
        }

        return $returnValue;
    }
}