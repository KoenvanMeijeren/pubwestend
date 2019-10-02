<?php

namespace App\controllers\admin;

use App\models\admin\AdminKitchenList;
use App\services\core\Request;
use App\services\core\URL;

class AdminKitchenController extends AdminKitchenList
{
    public function index()
    {
        $title = 'Keukenlijst';
        $kitchenList = $this->getKitchenList();

        return view('admin/kitchenlist/kitchenlist', compact('title', 'kitchenList'));
    }

    public function update()
    {
        $request = new Request();
        $this->updateKitchen($request->post('orders'));

        URL::redirect('/admin/kitchen/list');
        exit();
    }
}