<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\GestionUsuario;

use App\Models\MER\Reserva;
use App\Models\MER\Contrato;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;        

class ContratoController extends Controller
{
public function index(Request $request)
    {
        // 1. Obtenemos el usuario logueado
        $user = $request->user();

        // 2. Obtenemos sus contratos (esto requiere que tengas la relación en el Modelo User)
        $contracts = $user->contracts()->orderBy('created_at', 'desc')->get();

        // 3. Retornamos la vista principal del panel pasando los contratos
        // Cambia 'tu.vista.panel' por la ruta real de tu archivo blade
        return view('modules.GestionUsuario.breeze.index', [
            'user' => $user,
            'contracts' => $contracts,
        ]);
    }
    public function generar($reservaId)
    {
        // 1. Traer los datos de la reserva
        // Relation in Reserva model is 'user', not 'usuario'
        $reserva = Reserva::with(['user', 'vehiculo'])->findOrFail($reservaId);

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

    public function confirmar($reservaId)
    {
        // 1. Traer la reserva
        $reserva = Reserva::findOrFail($reservaId);

        // 2. Cambiar el estado a "Confirmada" (asumiendo que 2 es el código para confirmada)
        // Puedes ajustar este código según tu tabla estados_reserva
        $reserva->update([
            'codestres' => 2
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reserva confirmada exitosamente.'
        ]);
    }
}
