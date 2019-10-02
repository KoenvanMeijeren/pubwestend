<?php

namespace App\models;

use App\services\database\DB;
use App\services\core\Session;
use App\services\parsers\ParserFactory;
use App\services\Settings;

abstract class Reservation
{
    protected function makeReservation(
        string $name,
        string $email,
        string $phone,
        string $date,
        string $time,
        int $quantityPersons,
        string $notes = ''
    ) {
        if (!$this->isRestaurantFull($date, $time, $quantityPersons)) {
            $result = DB::table('reservations')
                ->insert([
                    'Reservation_customer_name' => $name,
                    'Reservation_customer_email' => $email,
                    'Reservation_customer_phone' => $phone,
                    'Reservation_date' => $date,
                    'Reservation_time' => $time,
                    'Reservation_quantity_persons' => $quantityPersons,
                    'Reservation_customer_notes' => $notes,
                ])
                ->execute()
                ->getSuccessful();

            if ($result && !empty($this->getReservation($email))) {
                return true;
            }
        }

        return false;
    }

    protected function isRestaurantOpen(string $date)
    {
        if (!$this->getOpeningHours($date) || $this->getOpeningHours($date) === null) {
            Session::flash('error', "Restaurant is gesloten op {$date}.");
            return false;
        }

        return true;
    }

    protected function getOpeningHours(string $date)
    {
        // get the page opening hours data
        $openingHours = $this->getPage('opening-hours');
        $openingHours = htmlspecialchars_decode($openingHours->Page_description);

        $factory = new ParserFactory();
        $json = $factory->createJsonParser();
        $openingHours = $json->parse($openingHours);

        if (!empty($openingHours)) {
            // get the opening hours from a specific day
            $day = strtolower(date('l', strtotime($date)));
            $openingHours = $this->convertOpeningHours($day, $openingHours);
        }

        return $openingHours;
    }

    private function isRestaurantFull($date, $time, $quantityPersons)
    {
        $reservations = $this->getReservationsByDate($date);
        $array = [];
        if (!empty($reservations)) {
            foreach ($reservations as $reservation) {
                $startTime = strtotime($reservation['Reservation_time']);
                $spendingTime = (intval(!empty(Settings::get('spendingTimeRestaurant')) ? Settings::get('spendingTimeRestaurant') : 2));
                $endTime = $startTime + (1 * $spendingTime * 60 * 60); // days / hours / minutes / seconds
                $totalPersons = $reservation['Reservation_quantity_persons'];
                while ($startTime < $endTime) {
                    $readableStartTime = date('H:i', $startTime);
                    if (!isset($array[$readableStartTime])) {
                        $array += [
                            date('H:i', $startTime) => [
                                'totalPersonsInRestaurant' => 0,
                                'endTime' => date('H:i', $endTime)
                            ]
                        ];
                    }

                    if (isset($array[$readableStartTime])) {
                        $array[$readableStartTime]['totalPersonsInRestaurant'] += $totalPersons;
                    }

                    $startTime = $startTime + (1 * 1 * 30 * 60); // days / hours / minutes / seconds
                }
            }

            if (isset($array[$time])) {
                $totalPersonsInRestaurant = $array[$time]['totalPersonsInRestaurant'];

                if (($totalPersonsInRestaurant + $quantityPersons) > Settings::get('capacityRestaurant')) {
                    Session::flash('error', "Het restaurant is vol om {$time} uur.");
                    return true;
                }
            }
        }

        return false;
    }

    private function getReservationsByDate(string $date)
    {
        $reservation = DB::table('reservations')
            ->select('*')
            ->where('Reservation_date', '=', $date)
            ->where('Reservation_is_deleted', '=', '0')
            ->where('Reservation_state', '!=', '2')
            ->orderBy('ASC', 'Reservation_time')
            ->execute()
            ->toArray();

        return $reservation;
    }

    protected function getReservation(string $email)
    {
        $reservation = DB::table('reservations')
            ->select('*')
            ->where('Reservation_customer_email', '=', $email)
            ->where('Reservation_is_deleted', '=', '0')
            ->where('Reservation_state', '!=', '2')
            ->execute()
            ->first();

        return $reservation;
    }

    protected function getReservations()
    {
        $reservations = DB::table('reservations')
            ->select('*')
            ->where('Reservation_is_deleted', '=', '0')
            ->where('Reservation_state', '!=', '2')
            ->execute()
            ->toArray();

        return $reservations;
    }

    protected function getPage(string $slug)
    {
        $page = DB::table('page')
            ->select('*')
            ->where('Page_slug', '=', $slug)
            ->where('Page_is_deleted', '=', '0')
            ->execute()
            ->first();

        return $page;
    }

    protected function convertReservationTimes(string $openingTime, string $closingTime)
    {
        // set the openingHours array
        $openingHours = [];

        // set the first item
        $openingHours[] = $openingTime;

        // set the numeric values
        $numericOpeningTime = strtotime($openingTime);
        $numericClosingTime = strtotime($closingTime);

        // add new items to the array for as long the opening time is not the closing time
        for ($numericIncrease = $numericOpeningTime; $numericIncrease < $numericClosingTime;) {
            // set the new numeric time
            $numericIncrease = $numericIncrease + (1 * 1 * 30 * 60); // days / hours / minutes / seconds

            // convert the new numeric time to a readable time
            $newTime = date('H:i', $numericIncrease);

            // add the new time to the array
            $openingHours[] = $newTime;
        }

        return $openingHours;
    }

    /**
     * Convert opening hours per day to string
     *
     * @param array $openingHours
     * @param string $day
     * @return bool|array
     */
    private function convertOpeningHours(string $day, array $openingHours)
    {
        if (
            isset($openingHours[$day . 'AfternoonOpeningTime']) &&
            isset($openingHours[$day . 'EveningOpeningTime']) &&
            isset($openingHours[$day . 'AfternoonClosingTime']) &&
            isset($openingHours[$day . 'EveningClosingTime'])
        ) {
            // closed
            if (
                empty($openingHours[$day . 'AfternoonOpeningTime']) &&
                empty($openingHours[$day . 'EveningOpeningTime']) &&
                empty($openingHours[$day . 'AfternoonClosingTime']) &&
                empty($openingHours[$day . 'EveningClosingTime'])
            ) {
                return false;
            }

            // 2 of 2 open
            if (
                !empty($openingHours[$day . 'AfternoonOpeningTime']) &&
                !empty($openingHours[$day . 'EveningOpeningTime']) &&
                !empty($openingHours[$day . 'AfternoonClosingTime']) &&
                !empty($openingHours[$day . 'EveningClosingTime'])
            ) {
                $array = [
                    $day => [
                        'afternoonOpeningTime' => $openingHours[$day . 'AfternoonOpeningTime'],
                        'afternoonClosingTime' => $openingHours[$day . 'AfternoonClosingTime'],
                        'eveningOpeningTime' => $openingHours[$day . 'EveningOpeningTime'],
                        'eveningClosingTime' => $openingHours[$day . 'EveningClosingTime']
                    ]
                ];

                return $array;
            }

            // 1 of 2 open, afternoon
            if (
                !empty($openingHours[$day . 'AfternoonOpeningTime']) &&
                !empty($openingHours[$day . 'AfternoonClosingTime']) &&
                empty($openingHours[$day . 'EveningOpeningTime']) &&
                empty($openingHours[$day . 'EveningClosingTime'])
            ) {
                $array = [
                    $day => [
                        'afternoonOpeningTime' => $openingHours[$day . 'AfternoonOpeningTime'],
                        'afternoonClosingTime' => $openingHours[$day . 'AfternoonClosingTime']
                    ]
                ];

                return $array;
            }

            // 1 of 2 open, evening
            if (
                empty($openingHours[$day . 'AfternoonOpeningTime']) &&
                empty($openingHours[$day . 'AfternoonClosingTime']) &&
                !empty($openingHours[$day . 'EveningOpeningTime']) &&
                !empty($openingHours[$day . 'EveningClosingTime'])
            ) {
                $array = [
                    $day => [
                        'eveningOpeningTime' => $openingHours[$day . 'EveningOpeningTime'],
                        'eveningClosingTime' => $openingHours[$day . 'EveningClosingTime']
                    ]
                ];

                return $array;
            }
        }

        // default
        return false;
    }

    protected function validateInputStep1($name, $email, $phone, $date)
    {
        if (empty($name) || empty($email) || empty($phone) || empty($date)) {
            Session::flash('error', 'Niet alle verplichten velden zijn ingevuld.');
            return false;
        }

        // is the given date not earlier than today?
        $numericDate = strtotime($date);
        $numericNowDate = strtotime(date("Y-m-d"));
        if ($numericDate < $numericNowDate) {
            Session::flash('error', 'Je kan reserveren vanaf vandaag of later.');
            return false;
        }

        if (!is_string($name)) {
            Session::flash('error', 'Ongeldige naam opgegeven.');
            return false;
        }

        if (strlen($name) > 100) {
            Session::flash('error', 'Naam kan niet meer dan 100 tekens bevatten.');
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Session::flash('error', 'Je moet een geldige email opgegeven.');
            return false;
        }

        $filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
        $phone_to_check = str_replace("-", "", $filtered_phone_number);
        if (strlen($phone_to_check) < 10 || strlen($phone_to_check) > 14) {
            Session::flash('error', 'Ongeldige telefoonnummer opgegeven.');
            return false;
        }

        if (!is_numeric($phone_to_check)) {
            Session::flash('error', 'Ongeldige telefoonnummer opgegeven.');
            return false;
        }

        if (!is_string($date)) {
            Session::flash('error', 'Ongeldige datum opgegeven.');
            return false;
        }

        return true;
    }

    protected function validateInputStep2($date, $time, $persons, $notes)
    {
        if (empty($time) || empty($persons)) {
            Session::flash('error', 'Niet alle verplichten velden zijn ingevuld.');
            return false;
        }

        if (!is_string($time)) {
            Session::flash('error', 'Ongeldige tijd opgegeven.');
            return false;
        }

        if (strlen($time) > 5) {
            Session::flash('error', 'Ongeldige tijd opgegeven.');
            return false;
        }

        if (!is_numeric($persons)) {
            Session::flash('error', 'Ongeldige aantal personen opgegeven.');
            return false;
        }

        if ($persons > Settings::get('capacityRestaurant')) {
            Session::flash('error',
                "Je kan met maximaal " . Settings::get('capacityRestaurant') . " personen reserveren.");
            return false;
        }

        if ($persons < 0) {
            Session::flash('error', 'Aantal personen moet minimaal meer dan 1 zijn.');
            return false;
        }

        $numericInputTime = strtotime($date . $time);
        $numericTime = strtotime(date('d-m-Y H:i'));
        $now = date('H:i');

        if ($numericInputTime <= $numericTime) {
            Session::flash('error', "Je kan niet eerder reserveren dan {$now} uur.");
            return false;
        }

        if (!empty($notes)) {
            if (!is_string($notes)) {
                Session::flash('error', 'Ongeldige opmerking opgegeven.');
                return false;
            }
        }

        return true;
    }

    protected function setOpeningHours(array $openingHours, string $date)
    {
        $day = strtolower(date('l', strtotime($date)));
        $openingHours = $openingHours[$day];
        // set the afternoon opening hours
        if (isset($openingHours['afternoonOpeningTime']) && !empty($openingHours['afternoonClosingTime'])) {
            $afternoonOpeningTimes = $this->convertReservationTimes($openingHours['afternoonOpeningTime'],
                $openingHours['afternoonClosingTime']);
        }

        // set the evening opening hours
        if (isset($openingHours['eveningOpeningTime']) && !empty($openingHours['eveningClosingTime'])) {
            $eveningOpeningTimes = $this->convertReservationTimes($openingHours['eveningOpeningTime'],
                $openingHours['eveningClosingTime']);
        }

        // store the opening hours in the array
        $openingHours = [];
        if (isset($afternoonOpeningTimes) || isset($eveningOpeningTimes)) {
            if (isset($afternoonOpeningTimes)) {
                $openingHours += ['afternoon' => $afternoonOpeningTimes];
            }

            if (isset($eveningOpeningTimes)) {
                $openingHours += ['evening' => $eveningOpeningTimes];
            }
        }

        return $openingHours;
    }

    protected function validateRecaptcha($recaptchaResponse)
    {
        $recaptcha = http_build_query(
            array(
                'secret' => '6LeNC5YUAAAAAIZcmuHccr8-bqOh1oQOPoR8pht1',
                'response' => $recaptchaResponse,
                'remoteip' => $_SERVER['REMOTE_ADDR']
            )
        );

        $opts = array(
            'http' =>
                array(
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $recaptcha
                )
        );

        $context = stream_context_create($opts);
        $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
        $recaptchaResult = json_decode($response);

        if (!$recaptchaResult->success) {
            Session::flash('error', 'Er is iets fout gegaan. Probeer het opnieuw.');
            return false;
        }

        return true;
    }
}
