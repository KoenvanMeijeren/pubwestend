<?php

namespace App\models\admin;

use App\services\database\DB;
use App\services\core\Session;

abstract class AdminTableReservation
{
    public static function convertState(int $state)
    {
        if ($state == '0') {
            return 'Onbevestigd';
        }

        if ($state == '1') {
            return 'In behandeling';
        }

        if ($state == '2') {
            return 'Afgerond';
        }

        return 'Onbekend';
    }

    protected function getTables()
    {
        $tables = DB::table('tables')
            ->select('*')
            ->where('Table_is_deleted', '=', '0')
            ->where('Table_enabled', '=', '1')
            ->where('Table_occupied', '=', '0')
            ->execute()
            ->toArray();

        return $tables;
    }

    protected function getReservation(int $id)
    {
        $reservation = DB::table('reservations')
            ->select('*')
            ->where('ID', '=', $id)
            ->where('Reservation_is_deleted', '=', '0')
            ->execute()
            ->first();

        return $reservation;
    }

    protected function getReservations()
    {
        $reservations = DB::table('reservations')
            ->select('*')
            ->where('Reservation_is_deleted', '=', '0')
            ->execute()
            ->toArray();

        return $reservations;
    }

    protected function updateReservation(
        int $id,
        string $name,
        string $email,
        string $phone,
        string $date,
        string $time,
        int $quantityPersons,
        string $notes,
        string $table,
        string $previousTable
    ) {
        $tableOccupied = '1';
        if (!is_numeric($table)) {
            $tableOccupied = '0';
        }

        $state = '0';
        if (empty($state) && $tableOccupied == '1') {
            $state = '1';
        }

        if (!is_numeric($table)) {
            $table = 0;
        }

        if (!is_numeric($previousTable)) {
            $previousTable = 0;
        }

        // update the reservation information
        $result1 = DB::table('reservations')
            ->update([
                'Table_id' => $table,
                'Reservation_customer_name' => $name,
                'Reservation_customer_email' => $email,
                'Reservation_customer_phone' => $phone,
                'Reservation_date' => $date,
                'Reservation_time' => $time,
                'Reservation_quantity_persons' => $quantityPersons,
                'Reservation_customer_notes' => $notes,
                'Reservation_state' => $state,
            ])
            ->where('ID', '=', $id)
            ->where('Reservation_is_deleted', '=', '0')
            ->execute()
            ->getSuccessful();

        // set the current table to occupied
        $result2 = DB::table('tables')
            ->update([
                'Table_occupied' => $tableOccupied
            ])
            ->where('ID', '=', $table)
            ->where('Table_is_deleted', '=', '0')
            ->execute()
            ->getSuccessful();

        // set the previous table to occupied
        $result3 = DB::table('tables')
            ->update([
                'Table_occupied' => '0'
            ])
            ->where('ID', '=', $previousTable)
            ->where('Table_is_deleted', '=', '0')
            ->execute()
            ->getSuccessful();

        if ($result1 && $result2 && $result3) {
            Session::flash('success', "Reservering {$id} is succesvol bijgewerkt.");
            return true;
        }

        Session::flash('error', "Reservering {$id} kon niet worden bijgewerkt.");
        return false;
    }

    protected function softDeleteReservation(int $id)
    {
        $result = DB::table('reservations')
            ->update([
                'Reservation_is_deleted' => '1'
            ])
            ->where('ID', '=', $id)
            ->execute()
            ->getSuccessful();

        if ($result && empty($this->getReservation($id))) {
            Session::flash('success', "Reservering {$id} is succesvol verwijderd.");
            return true;
        }

        Session::flash('error', "Reservering {$id} kon niet worden verwijderd.");
        return false;
    }
}