<?php

namespace App\models\admin;

use App\services\database\DB;
use App\services\core\Session;

abstract class AdminOrder
{
    public static function convertOrderState(string $state)
    {
        if ($state == '0') {
            return 'Nieuwe bestelling';
        } elseif ($state == '1') {
            return 'In behandeling';
        }

        return 'Klaar';
    }

    public static function convertOrderPaid(string $paid)
    {
        if ($paid == '0') {
            return 'Onbetaald';
        }

        return 'Betaald';
    }

    public static function getTableId(string $orderId)
    {
        $table = DB::table('connection_table_tables_orders')
            ->select('Table_id')
            ->where('Order_id', '=', $orderId)
            ->execute()
            ->first();

        return isset($table->Table_id) && !empty($table->Table_id) ? $table->Table_id : '';
    }

    protected function makeOrder(
        string $table,
        string $menuId,
        string $menuItem,
        string $menuItemAmount
    ) {
        if (empty($table) || empty($menuId) || empty($menuItem) || empty($menuItemAmount)) {
            Session::flash('error', 'Niet alle velden zijn juist ingevuld');
            return false;
        }

        $connections = $this->getMenuIngredientConnection($menuId);
        $updatedStock = false;
        if (!empty($connections)) {
            foreach ($connections as $connection) {
                $ingredient = $this->getIngredient($connection['Ingredient_id']);
                $currentQuantity = $ingredient->Ingredient_quantity;
                $newQuantity = $currentQuantity - $menuItemAmount;

                if ($newQuantity < '0') {
                    Session::flash('error',
                        "Menu {$menuItem} kan niet meer worden besteld omdat een van de ingrediënten niet voldoende voorraad heeft.");
                    return false;
                }

                $updatedStock = DB::table('ingredient')
                    ->update([
                        'Ingredient_quantity' => $newQuantity
                    ])
                    ->where('ID', '=', $connection['Ingredient_id'])
                    ->where('Ingredient_is_deleted', '=', '0')
                    ->execute();
            }
        }

        $lastInsertedId = DB::table('orders')
            ->insert([
                'menu_id' => $menuId,
                'Order_menu_item' => $menuItem,
                'Order_ammount' => $menuItemAmount,
                'order_state' => '0',
                'Order_paid' => '0'
            ])
            ->execute()
            ->getLastInsertedId();

        if (!empty($lastInsertedId) && !empty($this->getOrder($lastInsertedId))) {
            $isInserted = DB::table('connection_table_tables_orders')
                ->insert([
                    'Table_id' => $table,
                    'Order_id' => $lastInsertedId
                ])
                ->execute()
                ->getSuccessful();

            if ($isInserted && $updatedStock) {
                Session::flash('success', "Nieuwe bestelling tafel {$table} is succesvol aangemaakt.");
                return true;
            }
        }

        Session::flash('error', "Nieuwe bestelling tafel {$table} kon niet worden aangemaakt.");
        return false;
    }

    protected function getTables()
    {
        $tables = DB::table('tables')
            ->select('*')
            ->where('Table_is_deleted', '=', '0')
            ->where('Table_enabled', '=', '1')
            ->where('Table_occupied', '=', '1')
            ->execute()
            ->toArray();

        return $tables;
    }

    protected function getMenuIngredientConnection(string $menuId)
    {
        $menuIngredientConnection = DB::table('connection_table_menu_ingr')
            ->select('*')
            ->where('Menu_id', '=', $menuId)
            ->execute()
            ->toArray();

        return $menuIngredientConnection;
    }

    protected function getIngredient(string $id)
    {
        $ingredient = DB::table('ingredient')
            ->select('*')
            ->where('ID', '=', $id)
            ->where('Ingredient_is_deleted', '=', '0')
            ->execute()
            ->first();

        return $ingredient;
    }

    protected function getMenu(int $id)
    {
        $menu = DB::table('menu')
            ->select('*')
            ->where('ID', '=', $id)
            ->execute()
            ->first();

        return $menu;
    }

    protected function getMenus()
    {
        $menus = DB::table('menu')->select('*')
            ->where('Menu_is_deleted', '=', '0')
            ->execute()
            ->toArray();

        foreach ($menus as $key => $menu) {
            $isOnStock = $this->isOnStock($menu['ID']);

            $menus[$key] += ['isOnStock' => $isOnStock];
        }

        return $menus;
    }

    protected function getOrder(int $id)
    {
        $order = DB::table('orders')
            ->select('*')
            ->where('ID', '=', $id)
            ->where('Order_paid', '=', '0')
            ->where('Order_is_deleted', '=', '0')
            ->execute()
            ->first();

        return $order;
    }

    protected function getOrders()
    {
        $orders = DB::table('orders')
            ->select('*')
            ->where('Order_is_deleted', '=', '0')
            ->execute()
            ->toArray();

        return $orders;
    }

    protected function isOnStock(int $menuID)
    {
        $ingredientMenuConnections = DB::table('connection_table_menu_ingr')
            ->select('*')
            ->where('Menu_id', '=', $menuID)
            ->execute()
            ->toArray();

        $isOnStock = true;
        if (!empty($ingredientMenuConnections)) {
            foreach ($ingredientMenuConnections as $key => $connection) {
                $ingredient = $this->getIngredient($connection['Ingredient_id']);

                if (!empty($ingredient)) {
                    if ($ingredient->Ingredient_quantity <= '0') {
                        $isOnStock = false;
                    }
                }
            }
        }

        return $isOnStock;
    }

    protected function updateOrder(
        string $id,
        string $menuItemAmount,
        string $previousAmount
    ) {
        $order = $this->getOrder($id);
        if (!empty($order)) {
            $connections = $this->getMenuIngredientConnection($order->menu_id);
            if (!empty($connections)) {
                foreach ($connections as $connection) {
                    $ingredient = $this->getIngredient($connection['Ingredient_id']);
                    $currentQuantity = $ingredient->Ingredient_quantity;
                    if ($menuItemAmount > $previousAmount) {
                        $decrease = $menuItemAmount - $previousAmount;
                        $newQuantity = $currentQuantity - $decrease;
                    } elseif ($menuItemAmount < $previousAmount) {
                        $increase = $previousAmount - $menuItemAmount;
                        $currentQuantity += $increase;
                        $newQuantity = $currentQuantity;
                    } else {
                        $newQuantity = $menuItemAmount;
                    }

                    if ($newQuantity < '0') {
                        Session::flash('error',
                            "Menu {$id} kan niet worden bijgewerkt omdat een van de ingrediënten niet voldoende voorraad heeft.");
                        return false;
                    }

                    if ($newQuantity != $menuItemAmount) {
                        DB::table('ingredient')
                            ->update([
                                'Ingredient_quantity' => $newQuantity
                            ])
                            ->where('ID', '=', $connection['Ingredient_id'])
                            ->where('Ingredient_is_deleted', '=', '0')
                            ->execute();
                    }
                }
            }
        }

        $isUpdated = DB::table('orders')
            ->update([
                'Order_ammount' => $menuItemAmount
            ])
            ->where('ID', '=', $id)
            ->where('Order_is_deleted', '=', '0')
            ->execute()
            ->getSuccessful();

        if ($isUpdated) {
            Session::flash('success', "Bestelling {$id} is succesvol bijgewerkt.");
            return true;
        }

        Session::flash('error', "Bestelling {$id} kon niet worden bijgewerkt.");
        return false;
    }

    protected function softDeleteOrder(int $id)
    {
        $isSoftDeleted = DB::table('orders')
            ->update([
                'Order_is_deleted' => '1'
            ])
            ->where('ID', '=', $id)
            ->execute()
            ->getSuccessful();

        if ($isSoftDeleted && empty($this->getOrder($id))) {
            Session::flash('success', "Bestelling {$id} is succesvol verwijderd.");
            return true;
        }

        Session::flash('error', "Bestelling {$id} kon niet worden verwijderd.");
        return false;
    }
}