<x-page>
    <div class="container py-4">
        <h1 class="mb-4">Módulo de Contratos y Garantías</h1>

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Listado de Reservas y Contratos</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th># Reserva</th>
                                <th>Cliente</th>
                                <th>Vehículo</th>
                                <th>Fechas</th>
                                <th>Estado Contrato</th>
                                <th>Referencia</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reservas as $reserva)
                            <tr>
                                <td><strong>#{{ $reserva->cod }}</strong></td>
                                <td>{{ $reserva->user->nom ?? 'N/A' }} {{ $reserva->user->ape ?? '' }}</td>
                                <td>
                                    {{ $reserva->vehiculo->marca->des ?? 'N/A' }} {{ $reserva->vehiculo->linea->des ?? '' }}
                                </td>
                                <td>
                                    <small class="d-block text-muted">Inicio: {{ $reserva->fecini }}</small>
                                    <small class="d-block text-muted">Fin: {{ $reserva->fecfin }}</small>
                                </td>
                                <td>
                                    @if ($reserva->contrato)
                                    <span class="badge bg-success">Generado</span>
                                    <br>
                                    <small class="text-muted">Cod: {{ $reserva->contrato->codigo_verificacion }}</small>
                                    @else
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($reserva->contrato)
                                    {{ $reserva->contrato->codigo_verificacion }}
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>
                                    @if ($reserva->contrato)
                                    <a href="{{ route('contrato.descargar', $reserva->cod) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        Ver PDF
                                    </a>
                                    <form action="{{ route('contrato.enviar', $reserva->cod) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-secondary">
                                            Enviar por Email
                                        </button>
                                    </form>
                                    @else
                                    <form action="{{ route('contrato.enviar', $reserva->cod) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            Generar y Enviar
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No hay reservas registradas.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-page>