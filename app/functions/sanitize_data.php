<?php

/**
 * Strip the data to prevent XSS or something like that
 *
 * @param $data
 * @param string $type
 * @return mixed|bool $data
 */
function sanitize_data($data, string $type)
{
    try {
        $data = htmlspecialchars($data, ENT_NOQUOTES, 'UTF-8');

        switch ($type) {
            case 'string':
                $data = filter_var($data, FILTER_SANITIZE_STRING);
                break;
            case 'integer':
                $data = filter_var($data, FILTER_SANITIZE_NUMBER_INT);
                break;
            case 'float':
                $data = filter_var($data, FILTER_SANITIZE_NUMBER_FLOAT);
                break;
            case 'double':
                $data = filter_var($data, FILTER_SANITIZE_NUMBER_FLOAT);
                break;
            case 'boolean':
                $data = filter_var($data);
                break;
            case 'null':
                $data = filter_var($data);
                break;
            default:
                throw new \App\services\exceptions\customException("Could not sanitize the given data " . gettype($data));
        }

        return $data;
    } catch (\App\services\exceptions\customException $customException) {
        \App\services\exceptions\customException::handle($customException);
        return false;
    }
}

/**
 * Validate the given input
 *
 * @param mixed $variable
 * @return bool
 */
function validate_input($variable)
{

    // check the variable
    if ($variable != '0' || $variable != 0) {
        if (empty($variable)) {
            return false;
        }
    }

    return true;

}
