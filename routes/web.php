<?php

use Illuminate\Support\Facades\Route;



Route::get('/', fn() => view('home'));

Route::get('/contrato/descargar/{id}', [ContratoController::class, 'generar'])->name('contrato.descargar');

require __DIR__ . '/breeze/routes.php';
require __DIR__ . '/breeze/auth.php';

foreach (glob(app_path('Modules/*/routes.php')) as $route) {
    require $route;
}
