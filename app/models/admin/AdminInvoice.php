<?php


namespace App\model\admin;


use App\services\database\DB;
use App\services\core\Session;

abstract class AdminInvoice
{
    protected function getInvoices()
    {
        $invoices = DB::table('invoice')
            ->select('*')
            ->execute()
            ->toArray();

        return $invoices;
    }

    protected function getInvoice(int $id)
    {
        $invoice = DB::table('invoice')
            ->select('*')
            ->where('ID', '=', $id)
            ->execute()
            ->first();

        return $invoice;
    }

    protected function getOrders(int $id)
    {
        $orders = DB::table('connection_table_invoice_orders', 2)
            ->select('*')
            ->innerJoin('orders', 'Order_id', 'orders.ID')
            ->innerJoin('menu', 'orders.menu_id', 'menu.ID')
            ->where('Invoice_id', '=', $id)
            ->where('Order_paid', '=', '1')
            ->execute()
            ->all();

        return $orders;
    }

    public static function getMenu(int $id)
    {
        $menu = DB::table('menu')
            ->select('*')
            ->where('ID', '=', $id)
            ->execute()
            ->first();

        return $menu;
    }

    public static function calculatePrice(float $price, int $amount, int $btw)
    {
        $btwPrice = $price / 100 * $btw;
        $price = $price + $btwPrice;
        $totalPrice = $price * $amount;
        $totalPrice = number_format($totalPrice, 2, ',', '.');

        return $totalPrice;
    }

    protected function calculateBtwCosts(int $id)
    {
        $btwCosts = 0;
        $orders = $this->getOrders($id);
        if (!empty($orders)) {
            foreach ($orders as $order) {
                $menu = self::getMenu($order->menu_id);
                $btwDiff = $menu->Menu_price - $menu->Menu_price_without_vat;
                $btwDiff = $order->Order_ammount * $btwDiff;

                $btwCosts += $btwDiff;
            }
        }

        return $btwCosts;
    }

    protected function calculateTotalCosts(int $id)
    {
        $totalCosts = 0;
        $orders = $this->getOrders($id);
        if (!empty($orders)) {
            foreach ($orders as $order) {
                $menu = self::getMenu($order->menu_id);
                $price = $menu->Menu_price * $order->Order_ammount;

                $totalCosts += $price;
            }
        }

        return $totalCosts;
    }

    protected function softDeleteInvoice(int $id)
    {
        $isDeleted = DB::table('invoice')
            ->update([
                'Invoice_is_deleted' => '1'
            ])
            ->where('ID', '=', $id)
            ->execute()
            ->getSuccessful();

        if ($isDeleted) {
            Session::flash('success', "Factuur {$id} is succesvol verwijderd.");
            return true;
        }

        Session::flash('error', "Factuur {$id} kon niet worden verdwijderd.");
        return false;
    }
}