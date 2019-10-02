<?php

namespace App\controllers\admin;

use App\model\admin\Admin;
use App\models\admin\AdminAccount;
use App\services\Login;
use App\services\core\Request;
use App\services\core\URL;
use App\services\core\CSRF;
use App\services\core\Session;

class AdminController extends Admin
{
    /**
     * Show the login form.
     *
     * @return mixed
     */
    public function index()
    {
        $title = 'Inloggen';
        $loggedIn = boolval(Session::get('loggedIn'));
        $id = intval(Session::get('id'));

        if ($loggedIn === true && intval(AdminAccount::getRights($id)) >= 1) {
            URL::redirect('/admin/dashboard');
            exit();
        }

        return view('admin/login/index', compact('title'));
    }

    /**
     * Proceed the login call from the user.
     *
     * @return void
     */
    public function login()
    {
        $request = new Request();
        $email = $request->post('email');
        $password = $request->post('password');

        if ($this->validateInput($email, $password) && CSRF::checkFormToken() && new Login($email, $password)) {
            URL::redirect('/admin/dashboard');
            exit();
        }

        URL::redirect('/admin');
        exit();
    }
}