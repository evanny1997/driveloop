<?php

namespace App\Modules\ContratoGarantia\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MER\Contrato;
use App\Models\MER\Reserva;
use App\Mail\ContratoAlquilerMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ContratoGarantiaController extends Controller
{
    public function index()
    {
        // Obtener todas las reservas con sus contratos (si tienen) y datos relacionados
        $reservas = Reserva::with(['user', 'vehiculo.marca', 'vehiculo.linea', 'contrato'])
            ->orderBy('fecrea', 'desc')
            ->get();

        return view("modules.ContratoGarantia.index", compact('reservas'));
    }

    public function generarContrato($codReserva)
    {
        $reserva = Reserva::with(['user', 'vehiculo.marca', 'vehiculo.linea'])->findOrFail($codReserva);

        // Generar código único de verificación
        $codigo = strtoupper(bin2hex(random_bytes(4)));

        // Generar PDF
        $pdf = Pdf::loadView('pdf.contrato', compact('reserva', 'codigo'));

        // Registrar en base de datos
        Contrato::create([
            'reserva_id' => $reserva->cod,
            'codigo_verificacion' => $codigo,
            'ruta_pdf' => "contratos/contrato_{$reserva->cod}.pdf"
        ]);

        // Guardar el archivo físicamente (opcional pero recomendado para el adjunto)
        $pdfOutput = $pdf->output();
        Storage::put("public/contratos/contrato_{$reserva->cod}.pdf", $pdfOutput);

        // Enviar el correo al cliente
        if ($reserva->user && $reserva->user->email) {
            Mail::to($reserva->user->email)->send(new ContratoAlquilerMail($reserva, $pdfOutput));
        }

        return $pdf->stream("contrato_{$reserva->cod}.pdf");
    }
}
