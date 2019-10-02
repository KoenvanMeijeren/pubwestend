<?php

namespace App\models\admin;

use App\services\database\DB;
use App\services\core\Session;

abstract class AdminTable
{
    public static function convertActiveState(int $state)
    {
        if ($state == '1') {
            return 'Actief';
        }

        return 'Inactief';
    }

    public static function convertOccupiedState(int $state)
    {
        if ($state == '0') {
            return 'Onbezet';
        }

        return 'Bezet';
    }

    protected function makeTable()
    {
        $id = DB::table('tables')
            ->insert([
                'Table_enabled' => '1'
            ])
            ->execute()
            ->getLastInsertedId();

        if (!empty($id) && !empty($this->getTable($id))) {
            Session::flash('success', "Tafel is succesvol aangemaakt.");
            return true;
        }

        Session::flash('error', "Tafel kon niet worden aangemaakt.");
        return false;
    }

    protected function makeInvoice(string $tableID, string $totalCosts)
    {
        $totalCosts = str_replace(',', '.', $totalCosts);
        $lastInsertedId = DB::table('invoice')
            ->insert([
                'Table_id' => $tableID,
                'Invoice_costs' => $totalCosts,
            ])
            ->execute()
            ->getLastInsertedId();

        if (!empty($lastInsertedId) && !empty($this->getInvoice($lastInsertedId))) {
            $orders = $this->getOrders($tableID);

            $insertedConnection = false;
            if (!empty($orders)) {
                foreach ($orders as $order) {
                    $insertedConnection = DB::table('connection_table_invoice_orders')
                        ->insert([
                            'Invoice_id' => $lastInsertedId,
                            'Order_id' => $order->ID
                        ])
                        ->execute()
                        ->getSuccessful();
                }
            }

            if ($insertedConnection) {
                return true;
            }
        }

        return false;
    }

    protected function getInvoiceByNumber(string $invoiceNumber)
    {
        $invoice = DB::table('invoice')
            ->select('*')
            ->where('Invoice_number', '=', $invoiceNumber)
            ->where('Invoice_is_deleted', '=', '0')
            ->execute()
            ->first();

        return $invoice;
    }

    protected function getInvoice(string $id)
    {
        $invoice = DB::table('invoice')
            ->select('*')
            ->where('ID', '=', $id)
            ->where('Invoice_is_deleted', '=', '0')
            ->execute()
            ->first();

        return $invoice;
    }

    protected function getLastInvoice()
    {
        $invoice = DB::table('invoice')
            ->select('*')
            ->where('Invoice_is_deleted', '=', '0')
            ->orderBy('DESC', 'ID')
            ->execute()
            ->first();

        return $invoice;
    }

    protected function getTable(int $id)
    {
        $table = DB::table('tables')
            ->select('*')
            ->where('ID', '=', $id)
            ->where('Table_is_deleted', '=', '0')
            ->execute()
            ->first();

        return $table;
    }

    protected function getTables()
    {
        $tables = DB::table('tables')
            ->select('*')
            ->where('Table_is_deleted', '=', '0')
            ->execute()
            ->toArray();

        return $tables;
    }

    public static function getMenuPrice(int $id)
    {
        $menu = DB::table('menu')
            ->select('Menu_price')
            ->where('ID', '=', $id)
            ->execute()
            ->first();

        return isset($menu->Menu_price) && !empty($menu->Menu_price) ? $menu->Menu_price : '';
    }

    protected function getTotalOrdersPrice(int $tableID)
    {
        $orders = $this->getOrders($tableID);

        $totalPrice = 0;
        if (!empty($orders)) {
            foreach ($orders as $order) {
                $price = self::getMenuPrice($order->menu_id);
                $increase = $order->Order_ammount;

                $price = $price * $increase;
                $totalPrice += number_format($price, 2);
            }
        }

        return $totalPrice;
    }

    protected function getOrders(string $id)
    {
        $ids = DB::table('connection_table_tables_orders')
            ->select('Order_id')
            ->where('Table_id', '=', $id)
            ->execute()
            ->toArray();

        if (empty($ids)) {
            return false;
        }

        $orders = [];
        foreach ($ids as $id) {
            $order = DB::table('orders')
                ->select('*')
                ->where('ID', '=', $id['Order_id'])
                ->where('Order_paid', '=', '0')
                ->where('Order_is_deleted', '=', '0')
                ->execute()
                ->first();

            if (!empty($order)) {
                $orders[] = $order;
            }
        }

        return $orders;
    }

    protected function updateEnabledState(int $id)
    {
        $table = $this->getTable($id);
        if (!empty($table)) {
            $occupiedState = $table->Table_occupied;
            $enabledState = $table->Table_enabled;
        }

        if (isset($occupiedState) && $occupiedState === '1') {
            Session::flash('error', "Tafel {$id} kan niet op inactief worden gezet omdat die bezet is.");
            return false;
        }

        $state = '0';
        if (isset($enabledState) && $enabledState === '0') {
            $state = '1';
        }

        $result = DB::table('tables')
            ->update([
                'Table_enabled' => $state
            ])
            ->where('ID', '=', $id)
            ->where('Table_is_deleted', '=', '0')
            ->execute()
            ->getSuccessful();

        if ($result) {
            Session::flash('success', "Tafel {$id} is succesvol bijgewerkt.");
            return true;
        }

        Session::flash('error', "Tafel {$id} kon niet worden bijgewerkt.");
        return false;
    }

    protected function updateOccupiedState(int $id)
    {
        $table = $this->getTable($id);
        if (!empty($table)) {
            $enabledState = $table->Table_enabled;
            $tableOccupied = $table->Table_occupied;
        }

        $occupiedState = '1';
        if (isset($tableOccupied) && $tableOccupied === '1') {
            $occupiedState = '0';
        }

        // update the occupied state
        $reservation = DB::table('reservations')
            ->select('ID')
            ->where('Table_id', '=', $id)
            ->where('Reservation_is_deleted', '=', '0')
            ->execute()
            ->first();

        if (!empty($reservation)) {
            DB::table('reservations')
                ->update([
                    'Table_id' => '0',
                    'Reservation_state' => $occupiedState
                ])
                ->where('ID', '=', $reservation->ID)
                ->where('Reservation_is_deleted', '=', '0')
                ->execute()
                ->getSuccessful();
        }

        // is the table active?
        if (isset($enabledState) && $enabledState === '0') {
            Session::flash('error', "Tafel {$id} is niet actief.");
            return false;
        }

        $result = DB::table('tables')
            ->update([
                'Table_occupied' => $occupiedState
            ])
            ->where('ID', '=', $id)
            ->where('Table_is_deleted', '=', '0')
            ->execute()
            ->getSuccessful();

        if ($result) {
            Session::flash('success', "Tafel {$id} is succesvol bijgewerkt.");
            return true;
        }

        Session::flash('error', "Tafel {$id} kon niet worden bijgewerkt.");
        return false;
    }

    protected function updateOrdersPayState(string $tableID)
    {
        $ids = DB::table('connection_table_tables_orders')
            ->select('Order_id')
            ->where('Table_id', '=', $tableID)
            ->execute()
            ->toArray();

        if (!empty($ids)) {
            foreach ($ids as $id) {
                DB::table('orders')
                    ->update([
                        'Order_paid' => '1'
                    ])
                    ->where('ID', '=', $id['Order_id'])
                    ->where('Order_is_deleted', '=', '0')
                    ->execute();
            }

            return true;
        }

        return false;
    }

    protected function updateReservationState(string $tableID)
    {
        $result = DB::table('reservations')
            ->update([
                'Reservation_state' => '2'
            ])
            ->where('Table_id', '=', $tableID)
            ->where('Reservation_is_deleted', '=', '0')
            ->execute()
            ->getSuccessful();

        if ($result) {
            $result = DB::table('tables')
                ->update([
                    'Table_occupied' => '0'
                ])
                ->where('ID', '=', $tableID)
                ->where('Table_is_deleted', '=', '0')
                ->execute()
                ->getSuccessful();

            if ($result) {
                return true;
            }
        }

        return false;
    }

    protected function softDeleteTable(int $id)
    {
        $occupiedState = $this->getTable($id);
        $occupiedState = $occupiedState->Table_occupied;

        // is the table already occupied?
        if ($occupiedState === '1') {
            Session::flash('error', "Tafel {$id} is bezet en kan niet verwijderd worden.");
            return false;
        }

        $result = DB::table('tables')
            ->update([
                'Table_is_deleted' => '1'
            ])
            ->where('ID', '=', $id)
            ->execute()
            ->getSuccessful();

        if ($result && empty($this->getTable($id))) {
            Session::flash('success', "Tafel {$id} is succesvol verwijderd.");
            return true;
        }

        Session::flash('error', "Tafel {$id} verwijderen is mislukt.");
        return false;
    }

    protected function softDeleteOrder(int $id)
    {
        $isSoftDeleted = DB::table('orders')
            ->update([
                'Order_is_deleted' => '1'
            ])
            ->where('ID', '=', $id)
            ->execute()
            ->getSuccessful();

        if ($isSoftDeleted) {
            DB::table('connection_table_tables_orders')
                ->delete()
                ->where('Order_id', '=', $id)
                ->execute();

            Session::flash('success', "Bestelling {$id} is succesvol verwijderd.");
            return true;
        }

        Session::flash('error', "Bestelling {$id} kon niet worden verwijderd.");
        return false;
    }
}