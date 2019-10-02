<?php

namespace App\controllers\admin;

use App\models\admin\AdminMenu;
use App\services\core\Request;
use App\services\core\Session;
use App\services\core\URL;

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
class AdminMenuController extends AdminMenu
{
    /**
     * Show all menu items.
     *
     * @return mixed
     */
    public function index()
    {
        $title = 'Overzicht menu';
        $menus = $this->getMenus();

        return view('admin/menu/menu-cart', compact('title', 'menus'));
    }

    /**
     * Show the form that create menu items.
     *
     * @return mixed
     */
    public function create()
    {
        $title = 'Menu item toevoegen';
        $ingredients = $this->getIngredients();

        if (!empty($ingredients)) {
            return view('admin/menu/create-menu', compact('title', 'ingredients'));
        }

        Session::flash('error', 'Menu kan niet worden aangemaakt omdat er geen ingrediënten beschikbaar zijn.');
        URL::redirect('/admin/menu');
        exit();
    }

    public function store()
    {
        $request = new Request();

        if (!$this->validateInput(
            $request->post('titel'),
            $request->post('category'),
            $request->post('ingredients'),
            $request->post('description'),
            $request->post('price'),
            $request->post('btw'))) {
            $this->create();
            exit();
        }

        $inputIngredients = $request->post('ingredients');
        $ingredients = [];
        if (!empty($inputIngredients)) {
            foreach ($inputIngredients as $inputIngredient) {
                $ingredient = $this->getIngredient($inputIngredient);

                $ingredients[] = [
                    'ID' => $ingredient->ID,
                    'Name' => $ingredient->Ingredient_name,
                    'quantity' => $request->post('quantity' . ucfirst($ingredient->Ingredient_name))
                ];
            }
        }

        if (!empty($ingredients)) {
            $inserted = $this->makeMenu(
                $request->post('titel'),
                $request->post('category'),
                $ingredients,
                $request->post('description'),
                $request->post('price'),
                $request->post('btw')
            );

            if ($inserted) {
                URL::redirect('/admin/menu');
                exit();
            }
        }

        $this->create();
        exit();
    }

    public function edit()
    {
        $request = new Request();
        $title = 'Menu item bewerken';
        $menu = $this->getMenu($request->post('id'));
        $ingredients = $this->getIngredients();

        if (!empty($menu) && !empty($ingredients)) {
            return view('admin/menu/edit-menu', compact('title', 'menu', 'ingredients'));
        }

        Session::flash('error', 'Menu kan niet worden bewerkt.');
        URL::redirect('/admin/menu');
        exit();
    }

    public function update()
    {
        $request = new Request();

        if (!$this->validateInput(
            $request->post('titel'),
            $request->post('category'),
            $request->post('ingredients'),
            $request->post('description'),
            $request->post('price'),
            $request->post('btw'))) {
            $this->edit();
            exit();
        }

        $inputIngredients = $request->post('ingredients');
        $ingredients = [];
        if (!empty($inputIngredients)) {
            foreach ($inputIngredients as $inputIngredient) {
                $ingredient = $this->getIngredient($inputIngredient);

                $ingredients[] = [
                    'ID' => $ingredient->ID,
                    'Name' => $ingredient->Ingredient_name,
                    'quantity' => $request->post('quantity' . ucfirst($ingredient->Ingredient_name))
                ];
            }
        }

        $updated = $this->updateMenu(
            $request->post('id'),
            $request->post('titel'),
            $request->post('category'),
            $ingredients,
            $request->post('description'),
            $request->post('price'),
            $request->post('btw')
        );

        if ($updated) {
            URL::redirect('/admin/menu');
            exit();
        }

        $this->edit();
        exit();
    }

    public function destroy()
    {
        $request = new Request();
        $this->softDeleteMenu($request->post('id'));

        URL::redirect('/admin/menu');
        exit();
    }

    public function print()
    {
        $title = 'Menu afdrukken';
        $menus = $this->getPrintMenus();

        if (!empty($menus)) {
            return view('print-menu', compact('title', 'menus'));
        }

        exit('Menu kan niet worden afgedrukt.');
    }
}