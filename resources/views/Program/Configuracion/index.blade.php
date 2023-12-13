
@extends('Layout')

@section('title')
Registro de Feriados Anuales
@endsection

@section('content')
    
    <div class="container">
        <div class="card">
            <div class="card-header" style="font-size: 15px; font-family:courier;">
                @if (session('status'))
                    <div class="alert alert-warning" role="alert" style="opacity: 0.5">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{route('configuracion.busquedaAnio')}}" method="GET">
                    @csrf
                    <div class="row mb-4" style="font-size: 12px; font-family:courier;">
                        <div class="col-md-4">
                            Selecionar Año:
                            <select name="anio" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                                <option value="2028">2028</option>
                                <option value="2029">2029</option>
                                <option value="2030">2030</option>
                            </select>
                        </div>
                        <div class="col-md-4 mt-4">
                            <button type="submit" class="btn btn-secondary" style="font-family:courier;">BUSCAR</button>
                        </div>
                    </div>
                </form>
                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalRegistrar" style="font-family:courier;">NUEVO REGISTRO</button>
            </div>

            <div class="card-body">
                <table class="table table-striped table-responsive" style="font-size: 14px">
                    <thead class="table-secondary" style="text-align: center;">
                        <tr style="font-family:courier;">
                            <th style="text-align: left;">Año</th>
                            <th style="text-align: left;">Fecha</th>
                            <th style="text-align: left;">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lista_feriados as $item)
                            <tr>
                                <td>{{date('Y', strtotime($item->feriados))}}</td>
                                <td>{{date('d-m-Y', strtotime($item->feriados))}}</td>
                                <td>
                                    <a href="{{ route('configuracion.anular', $item->id) }}" class="btn btn-sm btn-danger"
                                        onclick="return confirm('¿ Desea anular el feriado ?')">Eliminar</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<!-- Modal de Registro-->
<div class="modal fade" id="modalRegistrar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel" style="font-family:courier;">Registrar fecha</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="font-family:courier;">
                <form action="{{ route('configuracion.create') }}" method="POST">
                    @csrf
                    <div class="row mb-4" style="font-size: 13px; font-family:courier;">
                        <div class="col-md-4">
                            <label>FECHA</label>
                            <input type="date" name="fecha" class="form-control start_date" value="" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Registrar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Salir</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal de Registro-->
@endsection