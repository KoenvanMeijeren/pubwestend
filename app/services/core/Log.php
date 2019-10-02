<?php

namespace App\services\core;


use App\services\exceptions\customException;
use Monolog\ErrorHandler;
use Monolog\Formatter\HtmlFormatter;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\WebProcessor;

/**
 * Class Log
 * @package App\services\core
 *
 * TODO: find out how i can display errors and stop the script.
 */
class Log
{
    /**
     * @var Log
     */
    private static $instance = null;

    /**
     * @var Logger|null
     */
    private static $logger = null;

    private function __construct()
    {
        try {
            self::$logger = new Logger('Pub Westend');
            self::$logger->pushHandler(new RotatingFileHandler(START_PATH . '/storage/logs/app.log', 365,
                Logger::DEBUG));
            self::$logger->pushHandler(new FirePHPHandler());
            self::$logger->pushProcessor(new WebProcessor());
        } catch (\Exception $exception) {
            customException::handle($exception);
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Log();
        }

        return self::$instance;
    }

    /**
     * Log debug info
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function debug(string $message, array $context = [])
    {
        self::getInstance();
        self::$logger->debug($message, $context);
    }

    /**
     * Log info
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function info(string $message, array $context = [])
    {
        self::getInstance();
        self::$logger->info($message, $context);
    }

    /**
     * Log notice info
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function notice(string $message, array $context = [])
    {
        self::getInstance();
        self::$logger->notice($message, $context);
    }

    /**
     * Log warning info
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function warning(string $message, array $context = [])
    {
        self::getInstance();
        self::$logger->warning($message, $context);
    }

    /**
     * Log error info
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function error(string $message, array $context = [])
    {
        self::getInstance();
        self::$logger->error($message, $context);
    }

    /**
     * Log critical info
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function critical(string $message, array $context = [])
    {
        self::getInstance();
        self::$logger->critical($message, $context);
    }

    /**
     * Log alert info
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function alert(string $message, array $context = [])
    {
        self::getInstance();
        self::$logger->alert($message, $context);
    }

    /**
     * Log emergency info
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function emergency(string $message, array $context = [])
    {
        self::getInstance();
        self::$logger->emergency($message, $context);
    }

    /**
     * Set the error handling.
     *
     * @return void
     */
    public static function setErrorHandling()
    {
        try {
            $logger = new Logger('Pub westend');
            $logger->pushHandler(new RotatingFileHandler(START_PATH . '/storage/logs/app.log', 365, Logger::DEBUG));

            if (ENV === 'development') {
                $stream = new StreamHandler('php://output', Logger::DEBUG);
                $stream->setFormatter(new HtmlFormatter());
                $logger->pushHandler($stream);
                $logger->pushProcessor(new WebProcessor());
            }

            $handler = new ErrorHandler($logger);
            $handler->registerErrorHandler([], false);
            $handler->registerExceptionHandler();
            $handler->registerFatalHandler();
        } catch (\Exception $exception) {
            customException::handle($exception);
        }

        if (ENV === 'production') {
            view('errors/500');
            exit();
        }
    }
}
