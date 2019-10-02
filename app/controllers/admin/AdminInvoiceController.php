<?php


namespace App\controllers\admin;


use App\model\admin\AdminInvoice;
use App\services\core\Request;
use App\services\core\Session;
use App\services\core\URL;

class AdminInvoiceController extends AdminInvoice
{
    /**
     * Overview of all the items.
     *
     * @return mixed
     */
    public function index()
    {
        $title = 'Facturen overzicht';
        $invoices = $this->getInvoices();

        return view('admin/invoices/index', compact('title', 'invoices'));
    }

    public function orders()
    {
        $request = new Request();
        $id = $request->post('id');
        $title = 'Bestellingen van factuur ' . $id;
        $orders = $this->getOrders($id);

        if (empty($orders)) {
            Session::flash('error', 'Factuur kan niet worden afgedrukt.');
            URL::redirect('/admin/invoices');
            exit();
        }

        return view('admin/invoices/orders', compact('title', 'orders'));
    }

    public function print()
    {

        $request = new Request();
        $id = $request->post('id');
        $title = "Factuur {$id} afdrukken";
        $invoice = $this->getInvoice($id);
        $orders = $this->getOrders($id);

        if (empty($invoice) || empty($orders)) {
            Session::flash('error', 'Factuur kan niet worden afgedrukt.');
            URL::redirect('/admin/invoices');
            exit();
        }

        $btwCosts = $this->calculateBtwCosts($id);
        $totalCosts = $this->calculateTotalCosts($id);

        return view('admin/invoices/print',
            compact('title', 'invoice', 'orders', 'btwCosts', 'totalCosts'));
    }

    public function destroy()
    {
        $request = new Request();
        $this->softDeleteInvoice($request->post('id'));

        URL::redirect('/admin/invoices');
        exit();
    }
}