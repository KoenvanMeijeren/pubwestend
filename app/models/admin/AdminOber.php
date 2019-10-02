<?php

namespace App\models\admin;

use App\services\database\DB;
use App\services\core\Session;

abstract class AdminOber
{
    protected function getTables()
    {
        $tables = DB::table('tables')
            ->select('ID')
            ->where('Table_occupied', '=', '1')
            ->where('Table_enabled', '=', '1')
            ->execute()
            ->toArray();

        return $tables;
    }

    protected function getAllDishes()
    {
        $allDishes = DB::table('menu')
            ->select('*')
            ->execute()
            ->toArray();

        return $allDishes;
    }

    protected function getMenu(int $id)
    {
        $menu = DB::table('menu')
            ->select('*')
            ->where('ID', '=', $id)
            ->execute()
            ->toArray();

        return $menu;
    }

    protected function getMenus()
    {
        $menus = DB::table('menu')->select('Menu_category')
            ->where('Menu_is_deleted', '=', '0')
            ->orderBy('ASC', 'Menu_category')
            ->execute()
            ->toArray();

        $categories = [];
        $menuItems = [];
        $previousCategory = '';
        foreach ($menus as $menu) {
            // set the current category
            $currentCategory = $menu['Menu_category'];

            // check if the current menu category is unique and if so store him in the array
            if ($currentCategory !== $previousCategory && !in_array($menu['Menu_category'], $categories)) {
                $categories[] = $menu['Menu_category'];
            }

            $items = DB::table('menu')
                ->select('*')
                ->where('Menu_category', '=', $menu['Menu_category'])
                ->where('Menu_is_deleted', '=', '0')
                ->execute()
                ->toArray();

            if (!empty($items)) {
                $newItems = [];
                foreach ($items as $item) {
                    $isOnStock = $this->isOnStock($item['ID']);
                    $item += ['isOnStock' => $isOnStock];

                    $newItems[] = $item;
                }

                $menuItems += [$menu['Menu_category'] => $newItems];
            }

            // set the previous category
            $previousCategory = $menu['Menu_category'];
        }

        // set the return array
        $array = [
            'categories' => $categories,
            'items' => $menuItems
        ];
        
        return $array;
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

    public static function convertCategory(string $category)
    {
        switch ($category) {
            case '1.1':
                return 'VoorgerechtWarm';
                break;

            case '1.2':
                return 'VoorgerechtKoud';
                break;

            case '2.1':
                return 'HoofdgerechtWarm';
                break;

            case '2.2':
                return 'HoofdgerechtKoud';
                break;

            case '3.1':
                return 'NagerechtWarm';
                break;

            case '3.2':
                return 'NagerechtKoud';
                break;

            case '4.1':
                return 'DrankenWarm';
                break;

            case '4.2':
                return 'DrankenKoud';
                break;

            case '4.3':
                return 'DrankenAlcoholisch';
                break;

            default:
                return "Onbekend";
                break;
        }
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

    protected function makeOrder(
        int $table,
        int $menuId,
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
                $currentQuantity = isset($ingredient->Ingredient_quantity) ? $ingredient->Ingredient_quantity : 0;
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
}