<?php

namespace App\controllers\admin;

use App\models\admin\AdminStock;
use App\services\core\Request;
use App\services\core\Session;
use App\services\core\URL;

class AdminStockController extends AdminStock
{
    public function index()
    {
        $title = 'Voorraad beheer';
        $ingredients = $this->getIngredients();

        return view('admin/stock/stock', compact('title', 'ingredients'));
    }

    public function create()
    {
        $title = 'Ingrediënt toevoegen';

        return view('admin/stock/create-stock', compact('title'));
    }

    public function store()
    {
        $request = new Request();
        $result = $this->makeIngredient(
            $request->post('name'),
            $request->post('description'),
            $request->post('quantity'),
            $request->post('unity'),
            $request->post('price'),
            $request->post('btw')
        );

        if ($result) {
            URL::redirect('/admin/stock');
            exit();
        }

        $this->create();
        exit();
    }

    public function edit()
    {
        $title = 'Ingredient bewerken';
        $request = new Request();
        $ingredient = $this->getIngredient($request->post('id'));

        if (!empty($ingredient)) {
            return view('admin/stock/edit-stock', compact('title', 'ingredient'));
        }

        Session::flash('error', 'Ingredient kan niet worden bewerkt.');
        URL::redirect('/admin/stock');
        exit();
    }

    public function update()
    {
        $request = new Request();
        $isUpdated = $this->updateIngredient(
            $request->post('id'),
            $request->post('name'),
            $request->post('description'),
            $request->post('quantity'),
            $request->post('unity'),
            $request->post('price'),
            $request->post('btw')
        );

        if ($isUpdated) {
            URL::redirect('/admin/stock');
            exit();
        }

        $this->edit();
        exit();
    }

    public function destroy()
    {
        $request = new Request();
        $this->softDeleteIngredient($request->post('id'));

        URL::redirect('/admin/stock');
        exit();
    }
}