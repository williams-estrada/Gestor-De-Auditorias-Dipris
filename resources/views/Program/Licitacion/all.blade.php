@extends('Layout')

@section('title')
Todas las Auditorias
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-secondary">
                    <tr>
                        <th class="align-middle text-center table-font-size-titulo">Propietario</th>
                        <th class="align-middle text-center table-font-size-titulo">Auditoria</th>
                        <th class="align-middle text-center table-font-size-titulo">Progreso</th>
                        <th class="align-middle text-center table-font-size-titulo">Porcentaje</th>
                        <th class="align-middle text-center table-font-size-titulo">Folio</th>
                        <th class="align-middle text-center table-font-size-titulo">Area</th>
                        <th class="align-middle text-center table-font-size-titulo">Estado</th>
                        <th class="align-middle text-center table-font-size-titulo">Fecha de elaboración</th>
                        <th class="align-middle text-center table-font-size-titulo">Fecha de recepción</th>
                        <th class="align-middle text-center table-font-size-titulo">Fecha de culminación</th>
                        <th class="align-middle text-center table-font-size-titulo"colspan="4">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($datos as $item)
                        <tr>
                            <td class="table-font-size align-middle">
                                @if($item->usuario)
                                    {{ $item->usuario->usuario }}
                                @else
                                    Sin usuario
                                @endif
                            </td>

                            <td class="table-font-size align-middle">{{$item->nombre}}</td>

                            <td class="table-font-size align-middle text-center">
                                @if ($item->progreso_aplica > 0)
                                    @if($item->cantidad_aplica > 0)
                                        <progress max="100" value="{{((100/$item->cantidad_aplica) * $item->progreso_aplica)}}" class="php">
                                    @endif
                                @endif
                                @if ($item->progreso_aplica < 0)

                                @endif
                            </td>

                            <td class="table-font-size align-middle text-center">
                                @if ($item->cantidad_aplica != 0)
                                    {{ round((100 / $item->cantidad_aplica) * $item->progreso_aplica) }}%
                                @else
                                    Sin Envíos De Documentos
                                @endif
                            </td>


                            <td class="table-font-size align-middle text-center">{{$item->folio}}</td>
                            <td class="table-font-size align-middle text-center">{{$item->area}}</td>

                            <td class="align-middle text-center">
                                @if ($item->estado == 'completada')
                                    <span class="badge bg-success text-white rounded-pill fw-bold">{{$item->estado}}</span>
                                @elseif ($item->estado == 'pendiente' or $item->estado == 'pendiente_out')
                                    <span class="badge bg-warning text-white rounded-pill fw-bold">{{$item->estado === 'pendiente_out' ? 'pendiente' :  $item->estado }}</span>
                                @elseif ($item->estado == 'expirada')
                                    <span class="badge bg-danger text-white rounded-pill fw-bold">
                                        {{$item->estado}}
                                    </span>
                                    <form action="{{route('licitacion.update',$item->id)}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-secondary btn-sm" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" title="Habilitar Auditoria" onclick="return confirm('¿Desea habilitar la auditoría?')">
                                            Habilitar
                                        </button>
                                    </form>
                                @elseif ($item->estado == 'completada_out')
                                    <span class="badge bg-primary text-white rounded-pill fw-bold" style="background-color: #7311e2 !important">
                                        {{ $item->estado === 'completada_out' ? 'completada fuera de tiempo' :  $item->estado }}
                                    </span>
                                @else
                                    <span class="badge rounded-pill fw-bold">{{$item->estado}}</span>
                                @endif
                            </td>


                            </td>
                            <td class="table-font-size align-middle text-center">{{$item->fecha_elaboracion}}</td>
                            <td class="table-font-size align-middle text-center">{{$item->fecha_recepcion}}</td>
                            <td class="table-font-size align-middle text-center">{{$item->fecha_culminacion}}</td>
                            <td class="table-font-size align-middle text-center">
                                <form action="{{route('documentos.anexos',$item->area)}}">
                                    @csrf
                                    <button type="submit" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" id="add_document" class="btn btn-info btn-sm text-white">Ver Anexos</button>
                                </form>
                            </td>
                            <td class="table-font-size align-middle text-center">
                                <form action="{{route('documentos.create',$item->id)}}">
                                    @csrf
                                    <button type="submit" id="add_document" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" class="btn btn-primary btn-sm">Ver Progreso</button>
                                </form>
                            </td>
                            <td class="table-font-size align-middle text-center">
                                <form action="{{route('licitacion.delete',$item->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" id="add_document" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" class="btn btn-danger btn-sm" onclick="return confirm('¿Desea eliminar la auditoría?')">Eliminar Auditoria</button>
                                </form>
                            </td>
                            <td class="table-font-size align-middle text-center">
                                <form action="{{route('licitacion.edit',$item->id)}}" method="GET">
                                    @csrf
                                    <button type="submit" id="add_document" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" class="btn btn-success btn-sm">Actualizar Auditoria</button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
