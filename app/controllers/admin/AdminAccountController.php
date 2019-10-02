<?php

namespace App\controllers\admin;

use App\models\admin\AdminAccount;
use App\services\core\Request;
use App\services\core\Session;
use App\services\core\URL;

class AdminAccountController extends AdminAccount
{
    public function index()
    {
        $title = 'Account beheer';
        $id = intval(Session::get('id'));
        $account = $this->getAccount($id);

        if (!empty($account)) {
            return view('admin/account/index', compact('title', 'account'));
        }

        Session::flash('error', 'Account kan om onbekende redenen niet worden bekeken.');
        URL::redirect('/admin');
        exit();
    }

    public function create()
    {
        $title = 'Account aanmaken';

        return view('admin/account/create', compact('title'));
    }

    public function store()
    {
        $request = new Request();
        $rights = intval($request->post('rights'));

        $insertedAccount = $this->makeAccount(
            $request->post('name'),
            $request->post('email'),
            $request->post('password'),
            $request->post('confirmPassword'),
            $rights
        );

        if ($insertedAccount) {
            URL::redirect('/admin/accounts/show');
            exit();
        }

        URL::redirect('/admin/account/create');
        exit();
    }

    public function show()
    {
        if (!empty($this->getAccounts())) {
            $title = 'Accounts beheren';
            $accounts = $this->getAccounts();

            return view('admin/account/accounts', compact('title', 'accounts'));
        }

        Session::flash('error', 'Accounts kunnen niet worden bekeken.');
        URL::redirect('/admin/account');
        exit();
    }

    public function edit()
    {
        $request = new Request();
        $id = intval($request->post('id'));
        $account = $this->getAccount($id);

        if (!empty($account)) {
            $title = 'Account aanpassen';

            return view('admin/account/edit', compact('title', 'account'));
        }

        Session::flash('error', "Account {$id} kan niet worden bekeken.");
        URL::redirect('/admin/account');
        exit();
    }

    public function update()
    {
        $request = new Request();
        $id = intval(Session::get('id'));
        $rights = intval(AdminAccount::getRights($id));
        $requestRights = intval($request->post('rights'));

        if (!empty($requestRights) && $requestRights !== $rights) {
            Session::flash('error', 'Je kan niet je eigen rechten aanpassen.');
            URL::redirect('/admin/account');
            exit();
        }

        $updatedAccount = $this->updateAccount(
            $id,
            $request->post('name'),
            $request->post('email'),
            $request->post('password'),
            $request->post('confirmPassword'),
            $requestRights
        );

        if ($updatedAccount) {
            URL::redirect('/admin/account');
            exit();
        }

        Session::flash('error', 'Account updaten is mislukt.');
        URL::redirect('/admin/account');
        exit();
    }

    public function updateOtherAccount()
    {
        $request = new Request();
        $id = intval($request->post('id'));
        $rights = intval($request->post('rights'));

        $updatedAccount = $this->updateAccount(
            $id,
            $request->post('name'),
            $request->post('email'),
            $request->post('password'),
            $request->post('confirmPassword'),
            $rights
        );

        if ($updatedAccount) {
            URL::redirect('/admin/accounts/show');
            exit();
        }

        Session::flash('error', 'Account updaten is mislukt.');
        URL::redirect('/admin/accounts/show');
        exit();
    }

    public function destroy()
    {
        $request = new Request();
        $id = intval($request->post('id'));
        $softDeleted = $this->softDeleteAccount($id);

        if ($softDeleted) {
            $this->logout();
            exit();
        }

        Session::flash('error', 'Account verwijderen is mislukt.');
        URL::redirect('/admin/account');
        exit();
    }

    public function destroyOtherAccount()
    {
        $request = new Request();
        $softDeleted = $this->softDeleteAccount($request->post('id'));

        if ($softDeleted) {
            URL::redirect('/admin/accounts/show');
            exit();
        }

        URL::redirect('/admin/accounts/show');
        exit();
    }

    public function logout()
    {
        $id = $_SESSION['id'];
        unset($_SESSION['id']);
        unset($_SESSION['loggedIn']);

        if (!isset($_SESSION['id']) && !isset($_SESSION['loggedIn'])) {
            Session::flash('success', 'Succesvol uitgelogd.');
            URL::redirect('/admin');
            exit();
        }

        session_unset();
        session_destroy();
        Session::flash('success', 'Succesvol uitgelogd.');
        URL::redirect('/admin');
        exit();
    }
}