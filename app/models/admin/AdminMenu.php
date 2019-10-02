<?php

namespace App\models\admin;

use App\services\database\DB;
use App\services\core\Session;

/**
 * Category.
 *
 * 1 = Voorgerecht
 * 1.1 = Warm
 * 1.2 = Koud
 * 2 = Hoofdgerecht
 * 2.1 = Warm
 * 2.2 = Koud
 * 3 = Nagerecht
 * 3.1 = Warm
 * 3.2 = Koud
 * 4 = Drinken
 * 4.1 = Warm
 * 4.2 = Koud
 * 4.3 = Alcoholisch
 */
abstract class AdminMenu
{
    public static function convertCategory(string $category)
    {
        switch ($category) {
            case '1.1':
                return 'Voorgerechten - warm';
                break;

            case '1.2':
                return 'Voorgerechten - koud';
                break;

            case '2.1':
                return 'Hoofdgerechten - warm';
                break;

            case '2.2':
                return 'Hoofdgerechten - koud';
                break;

            case '3.1':
                return 'Nagerechten - warm';
                break;

            case '3.2':
                return 'Nagerechten - koud';
                break;

            case '4.1':
                return 'Dranken - warm';
                break;

            case '4.2':
                return 'Dranken - koud';
                break;

            case '4.3':
                return 'Dranken - alcoholisch';
                break;

            default:
                return "Onbekend";
                break;
        }
    }

    protected function makeMenu(
        string $name,
        string $category,
        $ingredients,
        string $description,
        float $price,
        int $btw
    ) {
        // is the given menu unique?
        if (!empty($this->getMenuByName($name))) {
            Session::flash('error', "Het menu {$name} bestaat al.");
            return false;
        }

        if (empty($ingredients)) {
            Session::flash('error', "Menu {$name} moet ingredient bevatten.");
            return false;
        }

        $priceWithOutVat = $price;
        $btwPrice = $price / 100;
        $btwPrice = $btwPrice * $btw;
        $price += $btwPrice;
        $price = number_format($price, 2);

        // insert the given menu
        $lastInsertedId = DB::table('menu')
            ->insert([
                'Menu_name' => $name,
                'Menu_category' => $category,
                'Menu_description' => $description,
                'Menu_price' => $price,
                'Menu_price_without_vat' => $priceWithOutVat,
                'Menu_btw' => $btw
            ])
            ->execute()
            ->getLastInsertedId();

        if (!empty($lastInsertedId)) {
            foreach ($ingredients as $ingredient) {
                if (
                    !empty($ingredient['ID']) && !empty($this->getIngredient($ingredient['ID'])) &&
                    !empty($ingredient['quantity'])
                ) {
                    DB::table('connection_table_menu_ingr')
                        ->insert([
                            'Menu_id' => $lastInsertedId,
                            'Ingredient_id' => $ingredient['ID'],
                            'Aantal' => $ingredient['quantity'],
                        ])
                        ->execute();
                }
            }
        }

        // is the given menu inserted?
        if (!empty($this->getMenu($lastInsertedId))) {
            Session::flash('success', "Menu {$name} is succesvol aangemaakt.");
            return true;
        }

        Session::flash('error', "Menu {$name} aanmaken is mislukt.");
        return false;
    }

    public static function getStoredIngredientByMenuId(int $menuId, int $ingredientId)
    {
        // check if the given menu id and ingredient id exists...
        $id = DB::table('connection_table_menu_ingr')
            ->select('*')
            ->where('Menu_id', '=', $menuId)
            ->where('Ingredient_id', '=', $ingredientId)
            ->execute()
            ->first();

        if (empty($id)) {
            return false;
        }

        // if it exists return the ingredient
        $ingredient = DB::table('ingredient')
            ->select('*')
            ->where('ID', '=', $ingredientId)
            ->where('Ingredient_is_deleted', '=', '0')
            ->execute()
            ->first();

        if (!empty($ingredient)) {
            return isset($id->Aantal) && !empty($id->Aantal) ? $id->Aantal : 1;
        }

        return false;
    }

    public static function getStoredIngredientsByName(int $id)
    {
        // get al the ids that matches with the given id
        $ids = DB::table('connection_table_menu_ingr')
            ->select('*')
            ->where('Menu_id', '=', $id)
            ->execute()
            ->toArray();

        // get all ingredients that matches with the given ingredient ids
        if (!empty($ids)) {
            $ingredients = [];
            foreach ($ids as $id) {
                $ingredient = DB::table('ingredient')
                    ->select('*')
                    ->where('ID', '=', $id['Ingredient_id'])
                    ->where('Ingredient_is_deleted', '=', '0')
                    ->execute()
                    ->first();

                if (!empty($ingredient)) {
                    $ingredients[] = $ingredient->Ingredient_name;
                }
            }

            // convert it to a string
            $ingredients = implode(' - ', $ingredients);

            return $ingredients;
        }

        return false;
    }

    protected function getIngredient(int $id)
    {
        $ingredient = DB::table('ingredient')
            ->select('*')
            ->where('ID', '=', $id)
            ->where('Ingredient_is_deleted', '=', '0')
            ->execute()
            ->first();

        return $ingredient;
    }

    protected function getIngredients()
    {
        $ingredients = DB::table('ingredient')
            ->select('*')
            ->where('Ingredient_is_deleted', '=', '0')
            ->execute()
            ->toArray();

        return $ingredients;
    }

    private function getMenuByName(string $name)
    {
        $menu = DB::table('menu')
            ->select('*')
            ->where('Menu_name', '=', $name)
            ->where('Menu_is_deleted', '=', '0')
            ->execute()
            ->first();

        return $menu;
    }

    protected function getMenu(int $id)
    {
        $menu = DB::table('menu')
            ->select('*')
            ->where('ID', '=', $id)
            ->where('Menu_is_deleted', '=', '0')
            ->execute()
            ->first();

        return $menu;
    }

    protected function getMenus()
    {
        $menus = DB::table('menu')
            ->select('*')
            ->where('Menu_is_deleted', '=', '0')
            ->execute()
            ->toArray();

        return $menus;
    }

    protected function getPrintMenus()
    {
        $menus = DB::table('menu')->select('*')
            ->where('Menu_is_deleted', '=', '0')
            ->orderBy('ASC', 'Menu_category')
            ->execute()
            ->toArray();

        return $menus;
    }

    protected function updateMenu(
        int $id,
        string $name,
        string $category,
        $ingredients,
        string $description,
        float $price,
        int $btw
    ) {
        if (empty($ingredients)) {
            Session::flash('error', "Je moet ingrediënten toevoegen aan het menu.");
            return false;
        }

        $currentMenu = $this->getMenu($id);
        $priceWithOutVat = $price;
        if (!empty($currentMenu)) {
            if ($currentMenu->Menu_price !== $price) {
                $btwPrice = $price / 100;
                $btwPrice = $btwPrice * $btw;
                $price += $btwPrice;
                $price = number_format($price, 2);
            }

            if ($currentMenu->Menu_btw !== $btw) {
                $btwPrice = $priceWithOutVat / 100;
                $btwPrice = $btwPrice * $btw;
                $price += $btwPrice;
                $price = number_format($price, 2);
            }
        }

        $updatedMenu = DB::table('menu')
            ->update([
                'Menu_name' => $name,
                'Menu_category' => $category,
                'Menu_description' => $description,
                'Menu_price' => $price,
                'Menu_price_without_vat' => $priceWithOutVat,
                'Menu_btw' => $btw
            ])
            ->where('ID', '=', $id)
            ->where('Menu_is_deleted', '=', '0')
            ->execute()
            ->getSuccessful();

        $deletedConnections = DB::table('connection_table_menu_ingr')
            ->delete()
            ->where('Menu_id', '=', $id)
            ->execute()
            ->getSuccessful();

        $result = false;
        if ($updatedMenu && $deletedConnections) {
            foreach ($ingredients as $ingredient) {
                if (
                    !empty($ingredient['ID']) && !empty($this->getIngredient($ingredient['ID'])) &&
                    !empty($ingredient['quantity'])
                ) {
                    $result = DB::table('connection_table_menu_ingr')
                        ->insert([
                            'Menu_id' => $id,
                            'Ingredient_id' => $ingredient['ID'],
                            'Aantal' => $ingredient['quantity'],
                        ])
                        ->execute()
                        ->getSuccessful();
                }
            }
        }

        if ($result) {
            Session::flash('success', "Menu {$name} is succesvol bijgewerkt.");
            return true;
        }

        Session::flash('error', "Menu {$name} kon niet worden bijgewerkt.");
        return false;
    }

    protected function softDeleteMenu(int $id)
    {
        $softDeleted = DB::table('menu')
            ->update([
                'Menu_is_deleted' => '1'
            ])
            ->where('ID', '=', $id)
            ->execute()
            ->getSuccessful();

        if ($softDeleted && empty($this->getMenu($id))) {
            Session::flash('success', "Menu {$id} is succesvol verwijderd.");
            return true;
        }

        Session::flash('error', "Menu {$id} kon niet verwijderd worden.");
        return false;
    }

    protected function validateInput(
        string $name,
        string $category,
        $ingredients,
        string $description,
        float $price,
        int $btw
    ) {
        $error = false;
        if (empty($name)) {
            $error = true;
        }

        if (empty($category)) {
            $error = true;
        }

        if (empty($ingredients)) {
            $error = true;
        }

        if (empty($price)) {
            $error = true;
        }

        if (empty($btw)) {
            $error = true;
        }

        if (!is_array($ingredients)) {
            Session::flash('error', 'Ingrediënten toevoegen is verplicht.');
            return false;
        }

        if (!is_float($price)) {
            Session::flash('error', 'Prijs moet een komma getal zijn.');
            return false;
        }

        if (!is_int($btw)) {
            Session::flash('error', 'BTW moet een getal zijn.');
            return false;
        }

        if ($error) {
            Session::flash('error', 'Niet alle velden zijn juist ingevuld.');
            return false;
        }

        return true;
    }
}