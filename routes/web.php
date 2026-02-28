<?php

use Illuminate\Support\Facades\Route;
use App\Mail\PagoRecibido;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

Route::get('/', fn() => view('home'));

Route::get('/contrato/descargar/{id}', [ContratoController::class, 'generar'])->name('contrato.descargar');
Route::post('/contrato/confirmar/{id}', [ContratoController::class, 'confirmar'])->name('contrato.confirmar');

require __DIR__ . '/breeze/routes.php';
require __DIR__ . '/breeze/auth.php';

foreach (glob(app_path('Modules/*/routes.php')) as $route) {
    require $route;
}


