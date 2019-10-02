<?php

namespace App\contracts;

interface URLInterface
{
    public static function getUrl();

    public static function getFullUrl();

    public static function redirect($url);

    public static function refresh();
}
