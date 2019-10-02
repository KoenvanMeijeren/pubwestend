<?php

namespace App\models\admin;

use App\services\database\DB;
use App\services\core\Session;

abstract class AdminStock
{
    protected function makeIngredient(
        string $name,
        string $description,
        int $quantity,
        string $unit,
        float $price,
        int $btw
    ) {
        if (!empty($this->getIngredientByName($name))) {
            Session::flash('error', "Ingredient {$name} dat je probeert aan te maken bestaat al.");
            return false;
        }

        if (!$this->validateInput($name, $description, $quantity, $unit, $price, $btw)) {
            return false;
        }

        $priceWithOutVat = $price;
        $btwPrice = $price / 100;
        $btwPrice = $btwPrice * $btw;
        $price += $btwPrice;
        $price = number_format($price, 2);

        $lastInsertedId = DB::table('ingredient')
            ->insert([
                'Ingredient_name' => $name,
                'Ingredient_description' => $description,
                'Ingredient_quantity' => $quantity,
                'ingredient_unit' => $unit,
                'Ingredient_price' => $price,
                'Ingredient_price_without_vat' => $priceWithOutVat,
                'Ingredient_btw' => $btw
            ])
            ->execute()
            ->getLastInsertedId();

        if (empty($this->getIngredient($lastInsertedId))) {
            Session::flash('error', "Ingredient {$name} aanmaken is mislukt.");
            return false;
        }

        Session::flash('success', "Ingredient {$name} is succesvol aangemaakt.");
        return true;
    }

    protected function getIngredientByName(string $name)
    {
        $ingredient = DB::table('ingredient')
            ->select('*')
            ->where('Ingredient_name', '=', $name)
            ->where('Ingredient_is_deleted', '=', '0')
            ->execute()
            ->first();

        return $ingredient;
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

    protected function updateIngredient(
        int $id,
        string $name,
        string $description,
        int $quantity,
        string $unit,
        float $price,
        int $btw
    ) {
        $currentIngredient = $this->getIngredient($id);
        $priceWithOutVat = $price;
        if (!empty($currentIngredient)) {
            if ($currentIngredient->Ingredient_price !== $price) {
                $btwPrice = $price / 100;
                $btwPrice = $btwPrice * $btw;
                $price += $btwPrice;
                $price = number_format($price, 2);
            }

            if ($currentIngredient->Ingredient_btw !== $btw) {
                $btwPrice = $priceWithOutVat / 100;
                $btwPrice = $btwPrice * $btw;
                $price += $btwPrice;
                $price = number_format($price, 2);
            }
        }

        if (!$this->validateInput($name, $description, $quantity, $unit, $price, $btw)) {
            Session::flash('error', "Niet alle velden zijn juist ingevuld.");
            return false;
        }

        if (!empty($id)) {
            $updatedIngredient = DB::table('ingredient')
                ->update([
                    'Ingredient_name' => $name,
                    'Ingredient_description' => $description,
                    'Ingredient_quantity' => $quantity,
                    'ingredient_unit' => $unit,
                    'Ingredient_price' => $price,
                    'Ingredient_price_without_vat' => $priceWithOutVat,
                    'Ingredient_btw' => $btw
                ])
                ->where('ID', '=', $id)
                ->where('Ingredient_is_deleted', '=', '0')
                ->execute()
                ->getSuccessful();

            if ($updatedIngredient) {
                Session::flash('success', "Ingredient {$id} is succesvol bijgewerkt.");
                return true;
            }
        }

        Session::flash('error', "Ingredient {$id} kon niet worden bijgewerkt.");
        return false;
    }

    protected function softDeleteIngredient(int $id)
    {
        if (!empty($id)) {
            $softDeletedIngredient = DB::table('ingredient')
                ->update([
                    'Ingredient_is_deleted' => '1'
                ])
                ->where('ID', '=', $id)
                ->execute()
                ->getSuccessful();

            if ($softDeletedIngredient && empty($this->getIngredient($id))) {
                Session::flash('success', "Ingredient {$id} is succesvol verwijderd.");
                return true;
            }
        }

        Session::flash('error', "Ingredient {$id} verwijderen is mislukt.");
        return false;
    }

    private function validateInput(
        string $name,
        string $description,
        int $quantity,
        string $unit,
        float $price,
        int $btw
    ) {
        $error = false;
        if (empty($name)) {
            $error = true;
        }

        if (empty($quantity)) {
            $error = true;
        }

        if (empty($unit)) {
            $error = true;
        }

        if (empty($price)) {
            $error = true;
        }

        if (empty($btw)) {
            $error = true;
        }

        if (!is_int($quantity)) {
            Session::flash('error', 'Aantal moet een getal zijn.');
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