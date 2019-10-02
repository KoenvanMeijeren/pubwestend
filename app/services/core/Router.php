<?php

namespace App\services\core;

use App\models\admin\AdminAccount;
use App\services\exceptions\customException;
use App\services\Login;

/**
 * TODO: Rewrite the router
 *
 * Example:
 * Router::insert('/post/insert', 'post@insert');
 * Router::update('/post/update', 'post@update');
 * Router::delete('/post/delete', 'post@delete');
 */
class Router
{
    /**
     * Rights:
     * 1 = read
     * 2 = read and write
     * 3 = read, write and update
     * 4 = read, write, update and destroy
     * 5 = account management
     *
     * @var array
     */
    protected static $routes = [
        'GET' => [],
        'POST' => []
    ];

    /**
     * Load the routes
     *
     * @param $file
     * @return Router|bool
     */
    public static function load($file)
    {
        if (Validate::variable($file, Validate::IS_STRING)) {
            $router = new static;
            $filename = ROUTES_PATH . "/" . $file;

            if (loadFile($filename)) {
                return $router;
            }
        }

        return false;
    }

    /**
     * Define the get routes.
     *
     * @param string $route
     * @param string $controller
     * @param int $rights
     * @return void
     */
    public static function get(string $route, string $controller, int $rights = 0)
    {
        if (empty($route)) {
            self::$routes['GET'][$rights][$route] = $controller;
        }

        self::$routes['GET'][$rights][$route] = $controller;
    }

    /**
     * Define the post routes.
     *
     * @param string $route
     * @param string $controller
     * @param int $rights
     * @return void
     */
    public static function post(string $route, string $controller, int $rights = 0)
    {
        if (empty($route)) {
            self::$routes['POST'][$rights][$route] = $controller;
        }

        self::$routes['POST'][$rights][$route] = $controller;
    }

    /**
     * Direct an url to a controller.
     *
     * @param string $url
     * @param string $requestType
     * @return bool
     * @throws customException
     */
    public function direct(string $url, string $requestType)
    {
        // log the request for a page from the server
        if (error_get_last() === null) {
            $logUrl = $url;

            if (empty($url)) {
                $logUrl = '/';
            }

            Log::info("Successful " . URL::method() . " Request for page '{$logUrl}' ");
        }

        // get the rights
        $id = intval(Session::get('id'));
        $rights = AdminAccount::getRights($id);

        switch ($rights) {
            // accessible for everyone
            case 0:
                // check the accessible for everyone routes
                if (array_key_exists($url, self::$routes[$requestType][0])) {
                    return $this->executeRoute($requestType, 0, $url);
                }

                // check the protected routes
                if (
                    isset(self::$routes[$requestType][1][$url]) ||
                    isset(self::$routes[$requestType][2][$url]) ||
                    isset(self::$routes[$requestType][3][$url]) ||
                    isset(self::$routes[$requestType][4][$url]) ||
                    isset(self::$routes[$requestType][5][$url])
                ) {
                    // check the login state
                    Login::isLoggedIn();
                }

                // load the 404 page
                return $this->executeRoute('GET', 0, '404');
                break;

            case 1:
                // check the accessible for everyone routes
                if (
                    isset(self::$routes[$requestType][0][$url]) &&
                    array_key_exists($url, self::$routes[$requestType][0])
                ) {
                    return $this->executeRoute($requestType, 0, $url);
                }

                // check the login state
                Login::isLoggedIn();

                // check read routes
                if (
                    isset(self::$routes[$requestType][1][$url]) &&
                    array_key_exists($url, self::$routes[$requestType][1])
                ) {
                    return $this->executeRoute($requestType, 1, $url);
                } // check write, update, destroy and account management routes, if here access is forbidden
                elseif (
                    isset(self::$routes[$requestType][2][$url]) ||
                    isset(self::$routes[$requestType][3][$url]) ||
                    isset(self::$routes[$requestType][4][$url]) ||
                    isset(self::$routes[$requestType][5][$url])
                ) {
                    return $this->executeRoute('GET', 0, '403');
                }

                // load the 404 page
                return $this->executeRoute('GET', 0, '404');
                break;

            case 2:
                // check the accessible for everyone routes
                if (
                    isset(self::$routes[$requestType][0][$url]) &&
                    array_key_exists($url, self::$routes[$requestType][0])
                ) {
                    return $this->executeRoute($requestType, 0, $url);
                }

                // check the login state
                Login::isLoggedIn();

                // check read routes
                if (
                    isset(self::$routes[$requestType][1][$url]) &&
                    array_key_exists($url, self::$routes[$requestType][1])
                ) {
                    return $this->executeRoute($requestType, 1, $url);
                } // check write routes
                elseif (
                    isset(self::$routes[$requestType][2][$url]) &&
                    array_key_exists($url, self::$routes[$requestType][2])
                ) {
                    return $this->executeRoute($requestType, 2, $url);
                } // check update, destroy and account management routes, if here access is forbidden
                elseif (
                    isset(self::$routes[$requestType][3][$url]) ||
                    isset(self::$routes[$requestType][4][$url]) ||
                    isset(self::$routes[$requestType][5][$url])
                ) {
                    return $this->executeRoute('GET', '0', '403');
                }

                // load the 404 page
                return $this->executeRoute('GET', 0, '404');
                break;

            case 3:
                // check the accessible for everyone routes
                if (
                    isset(self::$routes[$requestType][0][$url]) &&
                    array_key_exists($url, self::$routes[$requestType][0])
                ) {
                    return $this->executeRoute($requestType, 0, $url);
                }

                // check the login state
                Login::isLoggedIn();

                // check read routes
                if (
                    isset(self::$routes[$requestType][1][$url]) &&
                    array_key_exists($url, self::$routes[$requestType][1])
                ) {
                    return $this->executeRoute($requestType, 1, $url);
                } // check write routes
                elseif (
                    isset(self::$routes[$requestType][2][$url]) &&
                    array_key_exists($url, self::$routes[$requestType][2])
                ) {
                    return $this->executeRoute($requestType, 2, $url);
                } // check update routes
                elseif (
                    isset(self::$routes[$requestType][3][$url]) &&
                    array_key_exists($url, self::$routes[$requestType][3])
                ) {
                    return $this->executeRoute($requestType, 3, $url);
                } // check destroy and account managements routes, if here access is forbidden
                elseif (
                    isset(self::$routes[$requestType][4][$url]) ||
                    isset(self::$routes[$requestType][5][$url])
                ) {
                    return $this->executeRoute('GET', '0', '403');
                }

                // load the 404 page
                return $this->executeRoute('GET', 0, '404');
                break;

            case 4:
                // check the accessible for everyone routes
                if (
                    isset(self::$routes[$requestType][0][$url]) &&
                    array_key_exists($url, self::$routes[$requestType][0])
                ) {
                    return $this->executeRoute($requestType, 0, $url);
                }

                // check the login state
                Login::isLoggedIn();

                // check read routes
                if (
                    isset(self::$routes[$requestType][1][$url]) &&
                    array_key_exists($url, self::$routes[$requestType][1])
                ) {
                    return $this->executeRoute($requestType, 1, $url);
                } // check write routes
                elseif (
                    isset(self::$routes[$requestType][2][$url]) &&
                    array_key_exists($url, self::$routes[$requestType][2])
                ) {
                    return $this->executeRoute($requestType, 2, $url);
                } // check update routes
                elseif (
                    isset(self::$routes[$requestType][3][$url]) &&
                    array_key_exists($url, self::$routes[$requestType][3])
                ) {
                    return $this->executeRoute($requestType, 3, $url);
                } // check destroy routes
                elseif (
                    isset(self::$routes[$requestType][4][$url]) &&
                    array_key_exists($url, self::$routes[$requestType][4])
                ) {
                    return $this->executeRoute($requestType, 4, $url);
                } // check account management routes, if here access is forbidden
                elseif (isset(self::$routes[$requestType][5][$url])) {
                    return $this->executeRoute('GET', '0', '403');
                }

                // load the 404 page
                return $this->executeRoute('GET', 0, '404');
                break;

            case 5:
                // check the accessible for everyone routes
                if (
                    isset(self::$routes[$requestType][0][$url]) &&
                    array_key_exists($url, self::$routes[$requestType][0])
                ) {
                    return $this->executeRoute($requestType, 0, $url);
                }

                // check the login state
                Login::isLoggedIn();

                // check read routes
                if (
                    isset(self::$routes[$requestType][1][$url]) &&
                    array_key_exists($url, self::$routes[$requestType][1])
                ) {
                    return $this->executeRoute($requestType, 1, $url);
                } // check write routes
                elseif (
                    isset(self::$routes[$requestType][2][$url]) &&
                    array_key_exists($url, self::$routes[$requestType][2])
                ) {
                    return $this->executeRoute($requestType, 2, $url);
                } // check update routes
                elseif (
                    isset(self::$routes[$requestType][3][$url]) &&
                    array_key_exists($url, self::$routes[$requestType][3])
                ) {
                    return $this->executeRoute($requestType, 3, $url);
                } // check destroy routes
                elseif (
                    isset(self::$routes[$requestType][4][$url]) &&
                    array_key_exists($url, self::$routes[$requestType][4])
                ) {
                    return $this->executeRoute($requestType, 4, $url);
                } // check account management routes
                elseif (
                    isset(self::$routes[$requestType][5][$url]) &&
                    array_key_exists($url, self::$routes[$requestType][5])
                ) {
                    return $this->executeRoute($requestType, 5, $url);
                }

                // load the 404 page
                return $this->executeRoute('GET', 0, '404');
                break;

            default:
                // none existing rights given
                throw new customException('For the given rights are no matching routes.');
                break;
        }
    }

    /**
     * Execute the route and call the controller.
     *
     * @param string $requestType
     * @param int $rights
     * @param string $url
     * @return bool
     */
    private function executeRoute(string $requestType, int $rights, string $url)
    {
        try {
            if (array_key_exists($url, self::$routes[$requestType][$rights])) {
                $route = explode('@', self::$routes[$requestType][$rights][$url]);
                $controller = 'App\controllers\\' . $route[0];
                $controller = new $controller();
                $callFunction = $route[1] ?? 'index';

                return $this->executeController($controller, $callFunction);
            }

            throw new customException('No route is defined for this url.');
        } catch (customException $customException) {
            customException::handle($customException);
            return false;
        }
    }

    /**
     * Execute a specific function in a specific controller.
     *
     * @param $controller
     * @param $callFunction
     * @return bool
     * @throws customException
     */
    private function executeController($controller, string $callFunction)
    {
        if (
            Validate::variable($controller, Validate::IS_OBJECT) &&
            Validate::variable(['object' => $controller, 'method_name' => $callFunction], Validate::METHOD_EXISTS)
        ) {
            return $controller->$callFunction();
        }

        throw new customException("Could not execute the function {$callFunction} in the controller " . serialize($controller));
    }
}
