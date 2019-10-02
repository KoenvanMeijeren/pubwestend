<?php

namespace App\controllers\admin;

use App\models\admin\AdminDashboard;

class AdminDashboardController extends AdminDashboard
{
    public function index()
    {
        $title = 'Dashboard';
        $reservations = $this->getReservations();
        $orders = $this->getOrders();

        return view('admin/dashboard/index', compact('title', 'reservations', 'orders'));
    }
}