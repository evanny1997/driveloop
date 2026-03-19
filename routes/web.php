<?php

use Illuminate\Support\Facades\Route;
use App\Modules\PagoDigital\Controllers\PagoDigitalController;
use App\Modules\PagoDigital\Controllers\PaymentController;

// require app_path('Modules/PagoDigital/routes.php'); // Esto ya se hace en el loop de abajo

Route::get('/', fn() => view('home'))->name('home');

require __DIR__ . '/breeze/routes.php';
require __DIR__ . '/breeze/auth.php';
require app_path('Modules/PagoDigital/routes.php');

foreach (glob(app_path('Modules/*/routes.php')) as $route) {
    require $route;
}
