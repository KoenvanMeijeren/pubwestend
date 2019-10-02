<?php

namespace App\models\admin;

use App\services\database\DB;
use App\services\core\Session;

abstract class AdminKitchenList
{
    protected function getOrder(int $id)
    {
        $order = DB::table('orders')
            ->select('*')
            ->where('Order_is_deleted', '=', '0')
            ->where('Order_paid', '=', '0')
            ->where('Order_state', '!=', '2')
            ->where('ID', '=', $id)
            ->execute()
            ->first();

        return $order;
    }

    protected function getTables()
    {
        $tables = DB::table('tables')
            ->select('*')
            ->where('Table_is_deleted', '=', '0')
            ->where('Table_occupied', '=', '1')
            ->execute()
            ->toArray();

        return $tables;
    }

    protected function getConnections(int $id)
    {
        $tables = DB::table('connection_table_tables_orders')
            ->select('*')
            ->where('Table_id', '=', $id)
            ->execute()
            ->toArray();

        return $tables;
    }

    protected function getMenuIngredientConnection(int $id)
    {
        $menuIngredientConnection = DB::table('connection_table_menu_ingr')
            ->select('*')
            ->where('Menu_id', '=', $id)
            ->execute()
            ->toArray();

        return $menuIngredientConnection;
    }

    protected function getIngredient(int $id)
    {
        $ingredient = DB::table('ingredient')
            ->select('*')
            ->where('ID', '=', $id)
            ->execute()
            ->first();

        return $ingredient;
    }


    protected function getKitchenList()
    {
        $tables = $this->getTables();
        $array = [];
        $orders = [];
        if (!empty($tables) && is_array($tables)) {
            foreach ($tables as $table) {
                $connections = $this->getConnections($table['ID']);
                foreach ($connections as $connection) {
                    if (!empty($connection)) {
                        $order = $this->getOrder($connection['Order_id']);
                        if (!empty($order)) {
                            $orders += [
                                $order->ID => [
                                    'Menu_id' => $order->menu_id,
                                    'Menu_item' => $order->Order_menu_item,
                                    'Menu_amount' => $order->Order_ammount,
                                    'Created_at' => $order->Order_created_at,
                                    'Order_state' => $order->order_state
                                ]
                            ];
                        }
                    }
                }
                $array += [$table['ID'] => $orders];
                $orders = [];
            }
        }
        return $array;
    }

    public function updateKitchen(array $ids)
    {
        $isUpdated = false;
        foreach ($ids as $id) {
            $isUpdated = DB::table('orders')
                ->update([
                    'order_state' => '2'
                ])
                ->where('ID', '=', $id)
                ->execute()
                ->getSuccessful();
        }

        if ($isUpdated) {
            Session::flash('success', "Keukenlijst bijwerken is gelukt.");
            return true;
        }

        Session::flash('error', "Keukenlijst bijwerken is mislukt");
        return false;
    }
}