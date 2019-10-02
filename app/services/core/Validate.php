<?php

namespace App\services\core;

use App\services\exceptions\customException;

class Validate
{
    const IS_ARRAY = 1;
    const IS_STRING = 2;
    const IS_INT = 3;
    const IS_OBJECT = 4;
    const IS_EMAIL = 5;
    const IS_POSTAL = 6;
    const IS_READABLE = 7;
    const IS_WRITABLE = 8;
    const FILE_EXISTS = 9;
    const ARRAY_KEY_EXISTS = 10;
    const METHOD_EXISTS = 11;
    const IS_EMPTY = 12;

    /**
     * Validate the given variable.
     *
     * @param  mixed $variable
     * @param  int $filter
     * @param bool $throwException
     * @return bool
     */
    public static function variable($variable, int $filter, bool $throwException = true)
    {
        try {
            if (empty($filter)) {
                return false;
            }

            switch ($filter) {
                case self::IS_ARRAY:
                    if ($variable === 0 || $variable === '0') {
                        if (is_array($variable)) {
                            return true;
                        }
                    }

                    if ($variable != 0 || $variable != '0') {
                        if (!empty($variable)) {
                            if (is_array($variable)) {
                                return true;
                            }
                        }
                    }

                    if ($throwException) {
                        throw new customException(gettype($variable) . ' given. The variable must be an array.');
                    }

                    return false;
                    break;

                case self::IS_STRING:
                    if ($variable === 0 || $variable === '0') {
                        if (is_string($variable)) {
                            return true;
                        }
                    }

                    if ($variable != 0 || $variable != '0') {
                        if (!empty($variable)) {
                            if (is_string($variable)) {
                                return true;
                            }
                        }
                    }

                    if ($throwException) {
                        throw new customException(gettype($variable) . ' given. The variable must be a string.');
                    }

                    return false;
                    break;

                case self::IS_INT:
                    if ($variable === 0 || $variable === '0') {
                        if (is_int($variable)) {
                            return true;
                        }
                    }

                    if ($variable != 0 || $variable != '0') {
                        if (!empty($variable)) {
                            if (is_int($variable)) {
                                return true;
                            }
                        }
                    }

                    if ($throwException) {
                        throw new customException(gettype($variable) . ' given. The variable must be an int.');
                    }

                    return false;
                    break;

                case self::IS_OBJECT:
                    if (is_object($variable)) {
                        return true;
                    }

                    if ($throwException) {
                        throw new customException(gettype($variable) . ' given. The variable must be an object.');
                    }

                    return false;
                    break;

                case self::IS_READABLE:
                    if (is_readable($variable)) {
                        return true;
                    }

                    if ($throwException) {
                        throw new customException("The file {$variable} is not readable.");
                    }

                    return false;
                    break;

                case self::IS_WRITABLE:
                    if (is_writeable($variable) && file_exists($variable)) {
                        return true;
                    }

                    if ($throwException) {
                        throw new customException("The file {$variable} is not writable or does not exist.");
                    }

                    return false;
                    break;

                case self::FILE_EXISTS:
                    if (file_exists($variable)) {
                        return true;
                    }

                    if ($throwException) {
                        throw new customException("The file {$variable} does not exist.");
                    }

                    return false;
                    break;

                case self::ARRAY_KEY_EXISTS:
                    if (isset($variable['key']) && isset($variable['array'])) {
                        if (array_key_exists($variable['key'], $variable['array'])) {
                            return true;
                        }

                        if ($throwException) {
                            throw new customException("The array key " . $variable['key'] . " and " . serialize($variable['array']) . " does not exist.");
                        }
                    }

                    if ($throwException) {
                        throw new customException('The array key $array["key"] and $array["array"] does not exist.');
                    }

                    return false;
                    break;

                case self::METHOD_EXISTS:
                    if (isset($variable['object']) && isset($variable['method_name'])) {
                        if (method_exists($variable['object'], $variable['method_name'])) {
                            return true;
                        }

                        if ($throwException) {
                            throw new customException("The called method {$variable['method_name']} does not exist in the object " . serialize($variable['object']) . ".");
                        }
                    }

                    if ($throwException) {
                        throw new customException('The array key $array["object"] and $array["method_name"] does not exist.');
                    }

                    return false;
                    break;

                case self::IS_EMPTY:
                    if ($variable != '0' || $variable != 0) {
                        if (empty($variable)) {
                            return true;
                        }
                    }

                    return false;
                    break;

                default:
                    if ($throwException) {
                        throw new customException('Could not validate the input. Invalid input or filter given.');
                    }

                    return false;
                    break;
            }
        } catch (customException $customException) {
            if ($throwException) {
                customException::handle($customException);
            }

            return false;
        }
    }
}
