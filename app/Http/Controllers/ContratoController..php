<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Contrato;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class ContratoController extends Controller
{
    public function generar($reservaId)
    {
        // 1. Traer los datos de la reserva
        $reserva = Reserva::with(['usuario', 'vehiculo'])->findOrFail($reservaId);

        // 2. Crear el registro en la tabla contratos (si no existe)
        $contrato = Contrato::firstOrCreate([
            'reserva_id' => $reservaId
        ], [
            'codigo_verificacion' => Str::upper(Str::random(10))
        ]);

        // 3. Cargar la vista y generar el PDF
        $pdf = Pdf::loadView('pdf.contrato', compact('reserva', 'contrato'));

        // 4. Retornar el PDF al navegador
        return $pdf->stream('Contrato_' . $reservaId . '.pdf');
    }
}
