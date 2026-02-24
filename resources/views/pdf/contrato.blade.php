<!DOCTYPE html>
<html>

<head>
    <title>Contrato de Alquiler</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            text-transform: uppercase;
        }

        .section {
            margin-bottom: 20px;
            border: 1px solid #eee;
            padding: 10px;
        }

        .bold {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Contrato de Arrendamiento de Vehículo</h1>
        <p>ID Reserva: {{ $reserva->cod }}</p>
    </div>

    <div class="section">
        <h3>1. PARTES DEL CONTRATO</h3>
        <p><span class="bold">Arrendatario:</span> {{ $reserva->user->nom ?? 'N/A' }} {{ $reserva->user->ape ?? '' }}</p>
        <p><span class="bold">Vehículo:</span> {{ $reserva->vehiculo->marca->des ?? 'N/A' }} {{ $reserva->vehiculo->linea->des ?? 'N/A' }}</p>
    </div>

    <div class="section">
        <h3>2. CONDICIONES</h3>
        <p>El vehículo se entrega el día {{ $reserva->fecini ?? 'N/A' }} y debe ser devuelto el {{ $reserva->fecfin ?? 'N/A' }}.</p>
    </div>
</body>

</html>