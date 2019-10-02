<?php


namespace App\services\core;

use App\services\exceptions\customException;

class App extends Config
{
    /**
     * @var App
     */
    private static $instance = null;

    private function __construct()
    {
        // Set the host
        Config::set('host', $_SERVER['HTTP_HOST']);

        // set the env and load the config file
        $this->setEnv('kvanmeijeren.realdesigner.nl');

        // set error reporting based on the env
        $this->setErrorReporting(ENV);

        // set the error handling
        Log::setErrorHandling();

        // Set the encryption token
        Config::set('encryptionToken',
            'def00000bf6a79439be74b32d34b4c00dcb528a02f654b34472d1ca02383fc0284804eaa8404d6d0af3c41f7651d7f5d424af236f0daee2eea3704d00af9b1f68b31317b');

        // set the default time zone
        date_default_timezone_set('Europe/Amsterdam');

        // the main mitigation against XXE attacks.
        libxml_disable_entity_loader(true);

        // set the session for 30 minutes
        $this->setSession(1 * 1 * 60 * 60, 3600);

        // set the language based on the domain extension and load the language file
        $this->setLanguage();
    }

    /**
     * Get the instance of the app.
     *
     * @return App
     */
    private static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new App();
        }

        return self::$instance;
    }

    /**
     * Load the website.
     *
     * @return void
     */
    public static function run()
    {
        try {
            // start the app
            self::getInstance();

            // load the controller based on the url, or throw an exception
            Router::load('web.php')->direct(URL::getUrl(), URL::method());
        } catch (customException $error) {
            customException::handle($error);
        }
    }
}