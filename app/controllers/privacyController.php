<?php

namespace App\controllers;

class privacyController
{
    public function index()
    {
        $title = 'Privacy';

        return view('privacy', compact('title'));
    }
}
