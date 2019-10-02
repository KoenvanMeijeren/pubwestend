<?php

namespace App\controllers;

class forbiddenController
{
    public function index()
    {
        $error = '403';
        $title = 'Verboden toegang.';
        $description = '<button type="button" onclick="return goBack()">Ga terug naar waar je vandaan kwam.</button>';

        return view('errors/403', compact('error', 'title', 'description'));
    }
}
