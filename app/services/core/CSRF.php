<?php


namespace App\services\core;


use App\services\exceptions\customException;
use ParagonIE\AntiCSRF\AntiCSRF;

abstract class CSRF
{
    /**
     * @var string
     */
    private static $csrf = null;

    /**
     * Set the token to protect the form against CSRF.
     *
     * @param string $lockTo
     * @param bool $echo
     * @return bool|string
     */
    private static function setToken(string $lockTo, bool $echo = false)
    {
        try {
            if (self::$csrf === null) {
                self::$csrf = new AntiCSRF();
            }

            return self::$csrf->insertToken($lockTo, $echo);
        } catch (\Exception $exception) {
            customException::handle($exception);
            return false;
        }
    }

    /**
     * Check if the posted token is valid.
     *
     * @return bool
     */
    public static function checkFormToken()
    {
        if (!empty($_POST)) {
            $antiCSRF = new AntiCSRF();
            if ($antiCSRF->validateRequest()) {
                return true;
            }
        }

        Session::flash('error', 'De sessie is verlopen.');
        return false;
    }

    /**
     * Add the token to the form and lock it to an URL.
     *
     * @param string $lockTo
     * @param bool $echo
     * @return bool|string
     */
    public static function formToken(string $lockTo, bool $echo = false)
    {
        return self::setToken($lockTo, $echo);
    }
}