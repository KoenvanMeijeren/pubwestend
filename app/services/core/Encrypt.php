<?php


namespace App\services\core;


use App\services\exceptions\customException;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;

class Encrypt
{
    private static function loadKeyFromConfig()
    {
        try {
            $key = Config::get('encryptionToken');
            $key = Key::loadFromAsciiSafeString($key);

            return $key;
        } catch (\Exception $exception) {
            customException::handle($exception);
            return false;
        }
    }

    public static function encrypt($data)
    {
        try {
            $key = self::loadKeyFromConfig();

            return Crypto::encrypt($data, $key);
        } catch (\Exception $exception) {
            var_dump($data);

            customException::handle($exception);
            return false;
        }
    }

    public static function decrypt($data)
    {
        try {
            $key = self::loadKeyFromConfig();

            return Crypto::decrypt($data, $key);
        } catch (\Exception $exception) {
            var_dump($data);

            customException::handle($exception);
            return false;
        }
    }
}