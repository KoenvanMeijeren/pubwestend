<?php

namespace App\controllers\admin;

use App\models\admin\AdminTableReservation;
use App\services\core\Request;
use App\services\core\URL;

class AdminTableReservationController extends AdminTableReservation
{
    public function index()
    {
        $title = 'Overzicht reserveringen';
        $reservations = $this->getReservations();

        return view('admin/table/table-reservations', compact('title', 'reservations'));
    }

    public function edit()
    {
        $request = new Request();
        $title = 'Reservering beheren';
        $reservation = $this->getReservation($request->post('id'));
        $tables = $this->getTables();

        return view('admin/table/edit-reservation', compact('title', 'reservation', 'tables'));
    }

    public function update()
    {
        $request = new Request();
        $this->updateReservation(
            $request->post('id'),
            $request->post('name'),
            $request->post('email'),
            $request->post('phone'),
            $request->post('date'),
            $request->post('time'),
            $request->post('quantityPersons'),
            $request->post('note'),
            $request->post('table'),
            $request->post('previousTable')
        );

        URL::redirect('/admin/reservations');
        exit();
    }

    public function destroy()
    {
        $request = new Request();
        $this->softDeleteReservation($request->post('id'));

        URL::redirect('/admin/reservations');
        exit();
    }
}