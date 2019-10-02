<?php

namespace App\controllers;

use App\models\Reservation;
use App\services\core\CSRF;
use App\services\core\Request;
use App\services\core\URL;

class ReservationController extends Reservation
{
    public function create()
    {
        $title = 'Reserveren - stap 1';

        return view('reservation', compact('title'));
    }

    public function step2()
    {
        $title = 'Reserveren - stap 2';

        $request = new Request();
        $name = $request->post('name');
        $email = $request->post('email');
        $phone = $request->post('phone');
        $date = $request->post('date');

        if (
            $this->validateInputStep1($name, $email, $phone, $date) &&
            $this->isRestaurantOpen($date)
        ) {
            // set the opening hours who can be selected in the form
            $openingHours = $this->getOpeningHours($date);
            if (!empty($openingHours)) {
                $openingHours = $this->setOpeningHours($openingHours, $date);

                // return the step 2 form
                return view('reservation-step2',
                    compact('title', 'name', 'email', 'phone', 'date', 'openingHours'));
            }
        }

        $this->create();
        exit();
    }

    public function store()
    {
        $request = new Request();

        if (
            $this->validateInputStep2(
                $request->post('date'), $request->post('time'),
                $request->post('quantityPersons'), $request->post('note')) &&
            $this->validateRecaptcha($request->post('g-recaptcha-response')) &&
            CSRF::checkFormToken()
        ) {
            $makeReservation = $this->makeReservation(
                $request->post('name'),
                $request->post('email'),
                $request->post('phone'),
                $request->post('date'),
                $request->post('time'),
                $request->post('quantityPersons'),
                $request->post('note')
            );

            if ($makeReservation) {
                URL::redirect('/reservering-verzonden');
                exit();
            }
        }

        $this->step2();
        exit();
    }

    public function sent()
    {
        $title = 'Reservering verzonden';

        return view('reservation-send', compact('title'));
    }
}