<?php

namespace App\controllers;

use App\models\Home;
use App\services\database\DB;

class HomeController extends Home
{
    public function index()
    {
        // set the page title
        $title = 'Home';

        // get the page data
        $ourStory = $this->getOurStory();
        $openingHours = $this->getConvertedOpeningHours();
        $menus = $this->getConvertedMenus();

        return view('home', compact('title', 'ourStory', 'openingHours', 'menus'));
    }

    public function test()
    {
        $products = DB::table('products')
            ->select('*')
            ->where('category_id', '=', '0')
            ->getQuery();

        dd($products);
    }
}
