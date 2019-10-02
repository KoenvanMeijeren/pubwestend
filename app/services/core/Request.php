<?php


namespace App\services\core;


class Request
{
    /**
     * Get a specific post item.
     *
     * @param string $key
     * @return string|array
     */
    public function post(string $key)
    {
        if (isset($_POST[$key]) && !empty($_POST[$key])) {
            if (is_scalar($_POST[$key])) {
                return sanitize_data($_POST[$key], gettype($_POST[$key]));
            }

            if (is_array($_POST[$key])) {
                $newArray = [];
                foreach ($_POST[$key] as $post) {
                    if (is_scalar($post)) {
                        $newArray[] = sanitize_data($post, gettype($post));
                    }
                }

                return $newArray;
            }
        }

        return '';
    }

    /**
     * Get a specific get item.
     *
     * @param string $key
     * @return string|array
     */
    public function get(string $key)
    {
        if (isset($_GET[$key]) && !empty($_GET[$key])) {
            if (is_scalar($_GET[$key])) {
                return sanitize_data($_GET[$key], gettype($_GET[$key]));
            }

            if (is_array($_GET[$key])) {
                $newArray = [];
                foreach ($_GET[$key] as $get) {
                    if (is_scalar($get)) {
                        $newArray[] = sanitize_data($get, gettype($get));
                    }
                }

                return $newArray;
            }
        }

        return '';
    }

    /**
     * @param string $key
     * @return array
     */
    public function file(string $key)
    {
        if (isset($_FILES[$key]) && !empty($_FILES[$key])) {
            return $_FILES[$key];
        }

        return [];
    }

    /**
     * Get all post items which are matching with the given parameters.
     *
     * @param array $parameters
     * @return array
     */
    public function postAll(array $parameters)
    {
        $posts = [];

        foreach ($parameters as $parameter) {
            $posts += [$parameter => $this->post($parameter)];
        }

        return $posts;
    }

    /**
     * Get all get items which are matching with the given parameters.
     *
     * @param array $parameters
     * @return array
     */
    public function getAll(array $parameters)
    {
        $gets = [];

        foreach ($parameters as $parameter) {
            $gets += [$parameter => $this->get($parameter)];
        }

        return $gets;
    }
}