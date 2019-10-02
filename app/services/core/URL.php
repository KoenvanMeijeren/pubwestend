<?php

namespace App\services\core;

use App\contracts\URLInterface;
use League\Uri\Parser;

abstract class URL implements URLInterface
{
    /**
     * Get the url.
     *
     * @return mixed|string
     */
    public static function getUrl()
    {
        $parser = new Parser();
        $url = $parser->parse($_SERVER['REQUEST_URI']);
        $url = trim($url['path'], '/');

        return $url;
    }

    /**
     * Get the previous url.
     *
     * @return mixed|string
     */
    public static function getPreviousUrl()
    {
        $url = '/';
        if (isset($_SERVER['HTTP_REFERER'])) {
            $parser = new Parser();
            $url = $parser->parse($_SERVER['HTTP_REFERER']);
            $url = trim($url['path'], '/');
        }

        return $url;
    }

    /**
     * Redirect to an specific url.
     *
     * @param $url
     */
    public static function redirect($url)
    {
        $parser = new Parser();
        $url = $parser->parse($url);

        header('Location: ' . $url['path']);
        exit();
    }

    /**
     * Refresh the page.
     */
    public static function refresh()
    {
        self::redirect(self::getUrl());
        exit();
    }

    /**
     * Get the request method.
     *
     * @return mixed
     */
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}
