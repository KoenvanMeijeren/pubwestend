<?php

use App\services\core\Router;

/**
 * Rights:
 * 0 = Accessible for everyone
 * 1 = read
 * 2 = read and write
 * 3 = read, write and update
 * 4 = read, write, update and destroy
 * 5 = account management
 *
 * Website.
 */
Router::get('', 'HomeController@index');
Router::get('menu/print', 'admin\AdminMenuController@print');
Router::get('reserveren', 'ReservationController@create');
Router::post('reserveren/stap2', 'ReservationController@step2');
Router::post('reserveren/store', 'ReservationController@store');
Router::get('reservering-verzonden', 'ReservationController@sent');

/**
 * Privacy statement.
 */
Router::get('privacy-verklaring', 'privacyController@index');

// admin
Router::get('admin', 'admin\AdminController@index');
Router::post('admin/login', 'admin\AdminController@login');

// admin/dashboard
Router::get('admin/dashboard', 'admin\AdminDashboardController@index', 1);

// admin/our-story
Router::get('admin/our-story', 'admin\AdminOurStoryController@index', 2);
Router::post('admin/our-story/store', 'admin\AdminOurStoryController@storeOrUpdate', 2);

// admin/opening-hours
Router::get('admin/opening-hours', 'admin\AdminOpeningHoursController@index', 2);
Router::post('admin/opening-hours/store', 'admin\AdminOpeningHoursController@storeOrUpdate', 2);

// admin/menu
Router::get('admin/menu', 'admin\AdminMenuController@index', 1);
Router::get('admin/menu/print', 'admin\AdminMenuController@print', 1);
Router::get('admin/menu/create', 'admin\AdminMenuController@create', 2);
Router::post('admin/menu/store', 'admin\AdminMenuController@store', 2);
Router::post('admin/menu/edit', 'admin\AdminMenuController@edit', 3);
Router::post('admin/menu/update', 'admin\AdminMenuController@update', 3);
Router::post('admin/menu/delete', 'admin\AdminMenuController@destroy', 4);

// admin/order
Router::get('admin/order', 'admin\AdminOrderController@index', 1);
Router::get('admin/order/create', 'admin\AdminOrderController@create', 2);
Router::post('admin/order/store', 'admin\AdminOrderController@store', 2);
Router::post('admin/order/update', 'admin\AdminOrderController@update', 3);
Router::post('admin/order/delete', 'admin\AdminOrderController@destroy', 4);

// admin/invoice
Router::get('admin/invoices', 'admin\AdminInvoiceController@index', 1);
Router::post('admin/invoice/orders', 'admin\AdminInvoiceController@orders', 1);
Router::post('admin/invoice/print', 'admin\AdminInvoiceController@print', 1);

// admin/table
Router::get('admin/table', 'admin\AdminTableController@index', 1);
Router::post('admin/table/store', 'admin\AdminTableController@store', 2);
Router::post('admin/table/updateEnabled', 'admin\AdminTableController@updateEnabled', 3);
Router::post('admin/table/updateOccupied', 'admin\AdminTableController@updateOccupied', 3);
Router::post('admin/table/pay', 'admin\AdminTableController@pay', 3);
Router::post('admin/table/pay/store', 'admin\AdminTableController@payTable', 3);
Router::post('admin/table/delete', 'admin\AdminTableController@destroy', 4);
Router::post('admin/table/deleteOrder', 'admin\AdminTableController@destroyOrder', 4);

// admin/reservation
Router::get('admin/reservations', 'admin\AdminTableReservationController@index', 1);
Router::post('admin/reservation/edit', 'admin\AdminTableReservationController@edit', 3);
Router::post('admin/reservation/update', 'admin\AdminTableReservationController@update', 3);
Router::post('admin/reservation/delete', 'admin\AdminTableReservationController@destroy', 4);

// admin/stock
Router::get('admin/stock', 'admin\AdminStockController@index', 1);
Router::get('admin/stock/create', 'admin\AdminStockController@create', 2);
Router::post('admin/stock/store', 'admin\AdminStockController@store', 2);
Router::post('admin/stock/edit', 'admin\AdminStockController@edit', 3);
Router::post('admin/stock/update', 'admin\AdminStockController@update', 3);
Router::post('admin/stock/delete', 'admin\AdminStockController@destroy', 4);

// admin/ober
Router::get('admin/ober', 'admin\AdminOberController@index', 2);
Router::post('admin/ober/menuchart', 'admin\AdminOberController@menuChart', 2);
Router::post('admin/ober/store', 'admin\AdminOberController@store', 2);
Router::get('admin/ober/cart', 'admin\AdminOberController@cart', 2);
Router::post('admin/ober/cart/update', 'admin\AdminOberController@updateOrder', 2);
Router::post('admin/ober/cart/delete', 'admin\AdminOberController@deleteOrder', 2);
Router::post('admin/ober/cart/store', 'admin\AdminOberController@storeCart', 2);

// admin/kitchenList
Router::get('admin/kitchen/list', 'admin\AdminKitchenController@index', 1);
Router::post('admin/kitchen/list/update', 'admin\AdminKitchenController@update', 2);

// admin/settings
Router::get('admin/settings', 'admin\AdminSettingsController@index', 1);
Router::post('admin/settings/store', 'admin\AdminSettingsController@storeOrUpdate', 3);

// admin/account
Router::get('admin/account', 'admin\AdminAccountController@index', 1);
Router::post('admin/account/update', 'admin\AdminAccountController@update', 1);
Router::post('admin/account/delete', 'admin\AdminAccountController@destroy', 1);
Router::get('admin/accounts/show', 'admin\AdminAccountController@show', 5);
Router::post('admin/account/edit', 'admin\AdminAccountController@edit', 5);
Router::post('admin/account/edit/update', 'admin\AdminAccountController@updateOtherAccount', 5);
Router::get('admin/account/create', 'admin\AdminAccountController@create', 5);
Router::post('admin/account/store', 'admin\AdminAccountController@store', 5);
Router::post('admin/accounts/delete', 'admin\AdminAccountController@destroy', 5);
Router::post('admin/accounts/show/delete', 'admin\AdminAccountController@destroyOtherAccount', 5);

// admin/logout
Router::get('admin/account/logout', 'admin\AdminAccountController@logout', 1);

// admin/developer
Router::get('admin/developer', 'admin\AdminDeveloperController@index', 5);
Router::get('admin/developer/create', 'admin\AdminDeveloperController@create', 5);
Router::post('admin/developer/store', 'admin\AdminDeveloperController@store', 5);

/**
 * If a route is not found.
 */
Router::get('404', 'notFoundController@index');

/**
 * If a route is forbidden.
 */
Router::get('403', 'forbiddenController@index');