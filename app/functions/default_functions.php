<?php

/**
 * Var dump the variable and die the script.
 *
 * @param array $expression
 * @return void
 */
function dd(...$expression)
{
    foreach ($expression as $item) {
        echo "<pre>";
        var_dump($item);
    }

    die();
}

if (!function_exists('array_key_last')) {
    /**
     * Polyfill for array_key_last() function added in PHP 7.3.
     *
     * Get the last key of the given array without affecting
     * the internal array pointer.
     *
     * @param array $array An array
     *
     * @return mixed The last key of array if the array is not empty; NULL otherwise.
     */
    function array_key_last($array)
    {
        $key = null;

        if (is_array($array)) {

            end($array);
            $key = key($array);
        }

        return $key;
    }
}

function view(string $viewName, $data = null)
{
    if (!empty($data)) {
        extract($data);
    }

    $filename = RESOURCES_PATH . "/views/{$viewName}.view.php";

    if (file_exists($filename)) {
        return require_once $filename;
    }

    return false;
}

function loadFile(string $filename)
{
    if (file_exists($filename)) {
        return require_once $filename;
    }

    return false;
}

function loadTable(string $filename, array $keys, array $rows = null)
{
    $filename = RESOURCES_PATH . "/partials/tables/{$filename}.view.php";

    if (file_exists($filename)) {
        return require_once $filename;
    }

    return false;
}