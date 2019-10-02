<?php

namespace App\models\admin;

use App\services\database\DB;

abstract class AdminDashboard
{
    protected function getReservations()
    {
        $reservations = DB::table('reservations')
            ->select('*')
            ->where('Reservation_state', '!=', '2')
            ->where('Reservation_is_deleted', '=', '0')
            ->execute()
            ->toArray();

        return $reservations;
    }

    protected function getOrders()
    {
        $orders = DB::table('orders')
            ->select('*')
            ->where('Order_paid', '=', '0')
            ->where('order_state', '!=', '2')
            ->where('Order_is_deleted', '=', '0')
            ->execute()
            ->toArray();

        return $orders;
    }
}