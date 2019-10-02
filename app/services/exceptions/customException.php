<?php

namespace App\services\exceptions;

use App\services\core\URL;
use App\services\core\Log;

class customException extends \Exception
{
    /**
     * Handle the exception that has been thrown.
     *
     * @param \Exception $exception
     * @return void
     */
    public static function handle(\Exception $exception)
    {
        // log the request for a page from the server
        Log::info("Failed " . URL::method() . " Request for page " . URL::getUrl());

        $error = "<h2>{$exception->getMessage()}</h2>";
        $error .= "On line {$exception->getLine()} <br>";
        $error .= "In file {$exception->getFile()} <br>";
        $error .= "In code {$exception->getCode()} <br><hr>";
        $trace = 0;

        foreach ($exception->getTrace() as $singleTrace) {
            $error .= "<b>Error trace #{$trace}</b><br>";
            $error .= "On line {$singleTrace['line']} <br>";
            $error .= "In file {$singleTrace['file']} <br>";
            $error .= "In function {$singleTrace['function']} ";
            $error .= "in class {$singleTrace['class']} <br><br>";
            $trace++;
        }

        // Log the error
        Log::error($exception);

        if (error_reporting() !== 0) {
            if (error_reporting() !== -1) {
                echo $error;
                die();
            }
        }

        view('errors/500');
        exit();
    }
}
