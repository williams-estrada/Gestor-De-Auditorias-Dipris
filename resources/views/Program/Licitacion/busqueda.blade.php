
@extends('Layout')

@section('title')
Búsqueda y descargas de documentos por Auditoría
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

                <form action="{{route('licitacion.busqueda')}}">
                    @csrf

                    <div class="row mb-4" style="font-size: 12px; font-family:courier;">
                        <div class="col-md-4">
                            Selecionar Usuario:
                            <select name="usuario_id" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                                @foreach ($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}">{{ $usuario->usuario }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            Selecionar Area:
                            <select name="area" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                                <option value="Documentos a integrar">Documentos a integrar</option>
                                <option value="Contratacion de personal">Contratacion de personal</option>
                                <option value="Compras menores">Compras menores</option>
                                <option value="Invitacion restringida">Invitacion restringida</option>
                                <option value="Adjudicacion directa">Adjudicacion directa</option>
                                <option value="Licitacion publica">Licitacion publica</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4" style="font-size: 12px; font-family:courier;">
                        <div class="col-md-4">
                            <label>Desde</label>
                            <input type="date" name="start_date" class="form-control start_date" value="{{ $fecha_ini }}">
                        </div>
                        <div class="col-md-4">
                            <label>Hasta</label>
                            <input type="date" name="end_date" class="form-control end_date" value="{{ $fecha_fin }}">
                        </div>
                        <div class="col-md-4 mt-4">
                            <button type="submit" class="btn btn-secondary" style="font-family:courier;">FILTRAR</button>
                        </div>
                    </div>
                </form>

                <form action="{{route('licitacion.busquedaFolio')}}" method="POST">
                    @csrf
                    <div class="row mb-4" style="font-size: 12px; font-family:courier;">
                        <div class="col-md-4">
                            <label>Busqueda Por Folio</label>
                            <input type="text" name="folio" class="form-control" value="">
                        </div>
                        <div class="col-md-4 mt-4">
                            <button type="submit" class="btn btn-secondary" style="font-family:courier;">BUSCAR</button>
                        </div>
                    </div>
                </form>
                

            </div>

            <div class="card-body">
                <table class="table table-striped table-responsive" style="font-size: 14px">
                    <thead class="table-secondary" style="text-align: center;">
                        <tr>
                            <th rowspan="1">Folio</th>
                            <th rowspan="1">Usuario</th>
                            <th colspan="1">Nombre</th>
                            <th rowspan="1">Area</th>
                            <th rowspan="1">F. Elab.</th>
                            <th rowspan="1">F. Recep.</th>
                            <th rowspan="1">F. Culmin.</th>
                            <th rowspan="1">Estado</th>
                            <th rowspan="1">Descarga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($licitaciones as $licitacion)
                        <tr>
                            <td>{{$licitacion->folio}}</td>
                            <td>{{$licitacion->usuario->usuario}}</td>
                            <td>{{$licitacion->nombre}}</td>
                            <td>{{$licitacion->area}}</td>
                            <td>{{$licitacion->fecha_elaboracion}}</td>
                            <td>{{$licitacion->fecha_recepcion}}</td>
                            <td>{{$licitacion->fecha_culminacion}}</td>
                            <td>{{$licitacion->estado}}</td>
                            <td>
                                <a href=" {{route('descargar.licitacion', $licitacion->id) }}" class="btn btn-sm btn-secondary float-end" style="font-family:courier;">
                                    Descargar
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if ($licitaciones->count() == 0)
                    <center>No existen registros en tu búsqueda</center> 
                @endif
            </div>
        </div>
    </div>
    </div>
@endsection