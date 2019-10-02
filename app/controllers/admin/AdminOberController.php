<?php

namespace App\controllers\admin;

use App\models\admin\AdminOber;
use App\services\core\Request;
use App\services\core\Session;
use App\services\core\URL;

class AdminOberController extends AdminOber
{
    public function index()
    {
        if (isset($_SESSION['cart']) && isset($_SESSION['tafelID'])) {
            unset($_SESSION['cart']);
            unset($_SESSION['tafelID']);
        }
        $title = 'Ober';
        $table = $this->getTables();

        return view('admin/ober/ober', compact('title', 'table'));
    }

    public function menuChart()
    {
        $title = 'Menu kaart';
        $request = new Request();
        $tableID = $request->post('id');
        $_SESSION['tafelID'] = $tableID;
        $alldishes = $this->getAllDishes();
        $menus = $this->getMenus();

        return view('admin/ober/menuchart', compact('title', 'alldishes', 'menus'));
    }

    public function store()
    {
        $request = new Request();
        $ids = $request->post('cart');
        $orders = [];
        if (!empty($ids)) {
            foreach ($ids as $id) {
                $menus = $this->getMenu($id);
                foreach ($menus as $menu) {
                    $orders += [
                        $menu['ID'] => [
                            'Menu_name' => $menu['Menu_name'],
                            'Menu_description' => $menu['Menu_description'],
                            'Menu_price' => $menu['Menu_price'],
                            'Quantity' => $request->post('quantity' . $menu['ID'])
                        ]
                    ];
                }
            }
        }

        if (!empty($orders)) {
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                $_SESSION['cart'] = $orders;
            }

            if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                $_SESSION['cart'] += $orders;
            }
        }

        URL::redirect('/admin/ober/cart');
        exit();
    }

    public function cart()
    {
        $title = 'Winkelwagen';
        $orders = Session::get('cart', false);

        return view('admin/ober/cart', compact('title', 'orders'));
    }

    public function deleteOrder()
    {
        $request = new Request();
        $id = $request->post('id');

        if (array_key_exists($id, $_SESSION['cart'])) {
            unset($_SESSION['cart'][$id]);
            if (!isset($_SESSION['cart'][$id])) {
                Session::flash('success', "Bestelling is succesvol verwijderd.");
                URL::redirect('/admin/ober/cart');
                exit();
            }
        }

        Session::flash('error', "Bestelling kon niet worden verwijderd.");
        URL::redirect('/admin/ober/cart');
        exit();
    }

    public function updateOrder()
    {
        $request = new Request();

        $id = $request->post('id');

        $quantity = $request->post('quantity' . $id);

        if (array_key_exists($id, $_SESSION['cart'])) {
            if (isset($_SESSION['cart'][$id]) && isset($_SESSION['cart'][$id]['Quantity'])) {
                $_SESSION['cart'][$id]['Quantity'] = $quantity;
                Session::flash('success', "Bestelling is succesvol bijgewerkt.");

                URL::redirect('/admin/ober/cart');
                exit();
            }
        }

        Session::flash('error', "Bestelling kon niet worden bijgwerkt.");
        URL::redirect('/admin/ober/cart');
        exit();
    }

    public function storeCart()
    {
        $request = new Request();
        $orders = $_SESSION['cart'];
        $tableID = $request->post('tableid');

        $result = false;
        if (!empty($orders) && $tableID) {
            foreach ($orders as $menuID => $order) {
                $result = $this->makeOrder(
                    $tableID,
                    $menuID,
                    $order['Menu_name'],
                    $order['Quantity']
                );
            }
        }

        if ($result) {
            if (isset($_SESSION['cart']) && isset($_SESSION['tafelID'])) {
                unset($_SESSION['cart']);
                unset($_SESSION['tafelID']);
            }

            if (!isset($_SESSION['cart']) && !isset($_SESSION['tafelID'])) {
                URL::redirect('/admin/ober');
                exit();
            }
        }

        URL::redirect('/admin/ober/cart');
        exit();
    }
}