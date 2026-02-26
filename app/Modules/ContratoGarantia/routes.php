<?php

use Illuminate\Support\Facades\Route;
use App\Modules\ContratoGarantia\Controllers\ContratoGarantiaController;

Route::prefix('contrato-garantia')->group(function () {
    Route::get('/', [ContratoGarantiaController::class, 'index'])->name('contrato.garantia');
    Route::get('/generar/{codReserva}', [ContratoGarantiaController::class, 'generarContrato'])->name('contrato.generar');
    Route::post('/enviar/{codReserva}', [ContratoGarantiaController::class, 'enviarContrato'])->name('contrato.enviar');
});
