<?php

namespace App\services\database;

use App\services\core\Config;
use App\services\core\Validate;
use App\services\exceptions\customException;
use \PDO;
use \PDOException;

class ConnectDB
{
    /**
     * @var ConnectDB
     */
    private static $instance = null;

    /**
     * @var PDO|null
     */
    private $pdo = null;

    private function __construct()
    {
        try {
            $this->pdo = new PDO(
                Config::get('databaseServer') .
                ';dbname=' . Config::get('databaseName') .
                ';port=' . Config::get('databasePort') .
                ';charset=' . Config::get('databaseCharset'),
                Config::get('databaseUsername'),
                Config::get('databasePassword'),
                Config::get('databaseOptions')
            );

            if (Validate::variable($this->pdo, Validate::IS_OBJECT)) {
                return $this->pdo;
            }

            throw new customException('Could not connect with the database.');
        } catch (PDOException $error) {
            try {
                throw new customException('Connection failed: ' . $error->getMessage());
            } catch (customException $error) {
                customException::handle($error);
            }
        } catch (customException $error) {
            customException::handle($error);
        }

        return false;
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new ConnectDB();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->pdo;
    }

    public function __destruct()
    {
        $this->pdo = null;
        self::$instance = null;
    }
}
