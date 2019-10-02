<?php

namespace App\controllers\admin;

use App\models\admin\AdminTable;
use App\services\core\Request;
use App\services\core\Session;
use App\services\core\URL;

class AdminTableController extends AdminTable
{
    public function index()
    {
        $title = 'Overzicht tafels';
        $tables = $this->getTables();

        return view('admin/table/table', compact('title', 'tables'));
    }

    public function store()
    {
        $request = new Request();
        $amountTables = $request->post('amountTables');

        for ($x = 1; $x <= $amountTables; $x++) {
            $this->makeTable();
        }

        URL::redirect('/admin/table');
        exit();
    }

    public function updateEnabled()
    {
        $request = new Request();
        $this->updateEnabledState($request->post('id'));

        URL::redirect('/admin/table');
        exit();
    }

    public function updateOccupied()
    {
        $request = new Request();
        $this->updateOccupiedState($request->post('id'));

        URL::redirect('/admin/table');
        exit();
    }

    public function pay()
    {
        $request = new Request();
        $tableID = $request->post('id');
        $title = "Tafel {$tableID} afrekenen";
        $orders = $this->getOrders($tableID);
        $totalOrdersPrice = $this->getTotalOrdersPrice($tableID);

        if (!$orders || empty($orders)) {
            Session::flash('error',
                "Tafel {$tableID} kan niet worden afgerekend omdat er nog geen bestellingen zijn geplaatst op tafel {$tableID}");
            URL::redirect('/admin/table');
            exit();
        }

        return view('admin/table/pay', compact('title', 'tableID', 'orders', 'totalOrdersPrice'));
    }

    public function payTable()
    {
        $request = new Request();
        $makeInvoice = $this->makeInvoice($request->post('table'), $request->post('totalCosts'));
        $this->updateReservationState($request->post('table'));

        if ($makeInvoice) {
            $updateOrdersPayState = $this->updateOrdersPayState($request->post('table'));

            if ($updateOrdersPayState) {
                Session::flash('success', "Tafel {$request->post('table')} is succesvol afgerekend.");
                URL::redirect('/admin/table');
                exit();
            }
        }

        Session::flash('error', "Tafel {$request->post('table')}. kon niet worden afgerekend.");
        URL::redirect('/admin/table');
        exit();
    }

    public function destroy()
    {
        $request = new Request();
        $this->softDeleteTable($request->post('id'));

        URL::redirect('/admin/table');
        exit();
    }

    public function destroyOrder()
    {
        $request = new Request();
        $this->softDeleteOrder($request->post('orderID'));

        $this->pay();
        exit();
    }
}