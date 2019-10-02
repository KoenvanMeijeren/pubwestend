<?php


namespace App\services\core;

use App\services\exceptions\customException;

abstract class Config
{
    /**
     * @var array
     */
    private static $config = [];

    /**
     * Set a new config item.
     *
     * @param string $key
     * @param $value
     * @return void
     */
    public static function set(string $key, $value)
    {
        if (!isset(self::$config[$key])) {
            if (is_scalar($value)) {
                self::$config[$key] = sanitize_data($value, gettype($value));
            }

            self::$config[$key] = $value;
        }
    }

    /**
     * Get a specific stored config item.
     *
     * @param string $key
     * @return mixed|string|null
     */
    public static function get(string $key)
    {
        if (isset(self::$config[$key])) {
            if (is_scalar(self::$config[$key])) {
                return sanitize_data(self::$config[$key], gettype(self::$config[$key]));
            }

            return self::$config[$key];
        }

        return null;
    }

    /**
     * Set the error handling.
     *
     * @param string $log
     * @param string $errorHandlerFunction
     * @return void
     */
    protected function setErrorHandling(string $log, string $errorHandlerFunction)
    {
        if (Validate::variable($log, Validate::IS_STRING)) {
            $log = 'App\services\core\\' . $log;
            $log = new $log();

            if (
                Validate::variable($log, Validate::IS_OBJECT) &&
                Validate::variable($errorHandlerFunction, Validate::IS_STRING)
            ) {
                set_error_handler(array($log, $errorHandlerFunction));
            }
        }
    }

    /**
     * Set the error reporting based on the env.
     *
     * @param string $env
     * @return void
     */
    protected function setErrorReporting(string $env)
    {
        try {
            // set the state of displaying errors
            if (!ini_get('display_errors')) {
                if (ini_set('display_errors', ($env === 'development' ? 1 : 0)) === false) {
                    throw new customException('Unable to set display_errors.');
                }
            }

            // set the state of displaying startup errors
            if (!ini_get('display_startup_errors')) {
                if (ini_set('display_startup_errors', ($env === 'development' ? 1 : 0)) === false) {
                    throw new customException('Unable to set display_startup_errors.');
                }
            }

            // set the state of error reporting
            error_reporting(($env === 'development' ? E_ALL : -1));
        } catch (customException $customException) {
            customException::handle($customException);
        }
    }

    /**
     * Set the current env based on the url.
     *
     * @param string $liveUrl
     * @return void
     */
    protected function setEnv(string $liveUrl)
    {
        try {
            if (
                strpos(Config::get('host'), 'localhost') !== false ||
                strpos(Config::get('host'), '127.0.0.1') !== false
            ) {
                // define the environment stage
                define('ENV', 'development');

                // define the config file
                $filename = CONFIG_PATH . '/dev_config.php';

                loadFile($filename);

                session_set_cookie_params(
                    0,                 // Lifetime -- 0 means erase when browser closes
                    '/',               // Which paths are these cookies relevant?
                    '', // Only expose this to which domain?
                    false,              // Only send over the network when TLS is used
                    true               // Don't expose to Javascript
                );
            } elseif (strstr(Config::get('host'), $liveUrl)) {
                // define the environment stage
                define('ENV', 'development');

                // define the config file
                $filename = CONFIG_PATH . '/production_config.php';

                loadFile($filename);

                session_set_cookie_params(
                    0,                 // Lifetime -- 0 means erase when browser closes
                    '/',               // Which paths are these cookies relevant?
                    $liveUrl, // Only expose this to which domain?
                    false,              // Only send over the network when TLS is used
                    true               // Don't expose to Javascript
                );
            } else {
                throw new customException('Could not load the config.');
            }
        } catch (customException $customException) {
            customException::handle($customException);
        }
    }

    /**
     * Set the session with a specified expiring time.
     *
     * @param int $expiringTime
     * @param int $refreshTime
     * @return void
     */
    protected function setSession(int $expiringTime, int $refreshTime)
    {
        session_start();
        if (empty(Session::get('time'))) {
            Session::save('time', time());
        }

        $sessionCreatedAt = Session::get('time');
        $sessionExpiredAt = $sessionCreatedAt + ($expiringTime); // days / hours / minutes / seconds
        $now = time();

        if ($now >= $sessionExpiredAt) {
            Log::info("The session is destroyed.");
            session_unset();
            session_destroy();
        }

        header("Refresh: {$refreshTime}; URL=/" . URL::getUrl());
    }

    /**
     * Set the language.
     *
     * @return void
     */
    protected function setLanguage()
    {
        try {
            if (defined('LANGUAGE_ID') && defined('LANGUAGE_CODE')) {
                if (LANGUAGE_ID === 1 && LANGUAGE_CODE === 'nl') {
                    // define the language file
                    $filename = RESOURCES_PATH . '/languages/Dutch/main_translations.php';

                    loadFile($filename);
                } elseif (LANGUAGE_ID === 2 && LANGUAGE_CODE === 'en') {
                    // define the language file
                    $filename = RESOURCES_PATH . '/languages/English/main_translations.php';

                    loadFile($filename);
                } else {
                    throw new customException('Could not load the language.');
                }
            }
        } catch (customException $customException) {
            customException::handle($customException);
        }
    }
}