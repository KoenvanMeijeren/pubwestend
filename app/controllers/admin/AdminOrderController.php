<?php

namespace App\controllers\admin;

use App\models\admin\AdminOrder;
use App\services\core\Request;
use App\services\core\URL;

class AdminOrderController extends AdminOrder
{
    /**
     * Overview of all the orders.
     *
     * @return mixed
     */
    public function index()
    {
        $title = 'Overzicht bestellingen';
        $orders = $this->getOrders();

        return view('admin/order/index', compact('title', 'orders'));
    }

    public function create()
    {
        $title = 'Bestelling aanmaken';
        $tables = $this->getTables();
        $menus = $this->getMenus();

        return view('admin/order/create', compact('title', 'tables', 'menus'));
    }

    public function store()
    {
        $request = new Request();
        $ids = $request->post('menus');
        $tableID = $request->post('table');
        $orders = [];
        if (!empty($ids)) {
            foreach ($ids as $id) {
                if (!empty($id)) {
                    $menu = $this->getMenu($id);
                    $orders[] = [
                        'Menu_id' => $menu->ID,
                        'Menu_item' => $menu->Menu_name,
                        'Menu_amount' => $request->post('quantity' . $menu->ID)
                    ];
                }
            }
        }

        $result = false;
        if (!empty($orders) && !empty($tableID) && is_numeric($tableID)) {
            foreach ($orders as $order) {
                $result = $this->makeOrder(
                    $tableID,
                    $order['Menu_id'],
                    $order['Menu_item'],
                    $order['Menu_amount']
                );
            }
        }

        if ($result) {
            URL::redirect('/admin/order');
            exit();
        }

        URL::redirect('/admin/order/create');
        exit();
    }

    public function update()
    {
        $request = new Request();
        $this->updateOrder(
            $request->post('id'),
            $request->post('amount'),
            $request->post('previousAmount')
        );

        URL::redirect('/admin/order');
        exit();
    }

    public function destroy()
    {
        $request = new Request();
        $this->softDeleteOrder($request->post('id'));

        URL::redirect('/admin/order');
        exit();
    }
}