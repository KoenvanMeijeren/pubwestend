<?php

namespace App\controllers;

class notFoundController
{
    public function index()
    {
        $error = '404';
        $title = 'Pagina niet gevonden.';
        $description = '<button type="button" onclick="return goBack()">Ga terug naar waar je vandaan kwam.</button>';

        return view('errors/404', compact('error', 'title', 'description'));
    }
}
