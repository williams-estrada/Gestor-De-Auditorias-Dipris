@extends('Layout')

@section('title')
Todas las Auditorias
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-secondary" style="text-align: center;">
                    <tr>
                        <th>Propietario</th>
                        <th>Auditoria</th>
                        <th width="20">Progreso</th>
                        <th>Porcentaje</th>
                        <th>Folio</th>
                        <th>Area</th>
                        <th>Estado</th>
                        <th>Fecha de elaboración</th>
                        <th>Fecha de recepción</th>
                        <th>Fecha de culminación</th>
                        <th colspan="4">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($datos as $item)
                        <tr>
                            <td>
                                @if($item->usuario)
                                    {{ $item->usuario->usuario }}
                                @else
                                    Sin usuario
                                @endif
                            </td>
                            
                            <td>{{$item->nombre}}</td>
                            
                            <td width="20">
                                @if ($item->progreso_aplica > 0)
                                    @if($item->cantidad_aplica > 0)
                                        <progress max="100" value="{{((100/$item->cantidad_aplica) * $item->progreso_aplica)}}" class="php"> 
                                    @endif
                                @endif
                                @if ($item->progreso_aplica < 0)
                                    
                                @endif
                            </td>

                            <td style="text-align: center;">
                                @if ($item->cantidad_aplica != 0)
                                    {{ round((100 / $item->cantidad_aplica) * $item->progreso_aplica) }}%
                                @else
                                    Sin Envíos De Documentos
                                @endif
                            </td>
                            

                            <td style="text-align: center;">{{$item->folio}}</td>
                            <td style="text-align: center;">{{$item->area}}</td>
                            
                            <td class="align-middle text-center">
                                @if ($item->estado == 'completada')
                                    <span class="badge bg-success text-white rounded-pill fw-bold">{{$item->estado}}</span>
                                @elseif ($item->estado == 'pendiente')
                                    <span class="badge bg-warning text-white rounded-pill fw-bold">{{$item->estado}}</span>
                                @elseif ($item->estado == 'expirada')
                                    <span class="badge bg-danger text-white rounded-pill fw-bold">{{$item->estado}}</span>
                                @elseif ($item->estado == 'completada_fuera_de_tiempo')
                                    <span class="badge bg-purple text-white rounded-pill fw-bold">{{$item->estado}}</span>
                                @else
                                    <span class="badge rounded-pill fw-bold">{{$item->estado}}</span>
                                @endif
                            </td>                            
                        
                                
                            </td>
                            <td style="text-align: center;">{{$item->fecha_elaboracion}}</td>
                            <td style="text-align: center;">{{$item->fecha_recepcion}}</td>
                            <td style="text-align: center;">{{$item->fecha_culminacion}}</td>
                            <td>
                                <form action="{{route('documentos.anexos',$item->area)}}">
                                @csrf
                                <button type="submit" id="add_document" class="btn btn-info btn-sm">Ver Anexos</button>
                                </form>
                            </td>
                            <td>
                                <form action="{{route('documentos.create',$item->id)}}">
                                @csrf
                                <button type="submit" id="add_document" class="btn btn-primary btn-sm">Ver Progreso</button>
                                </form>
                            </td>
                            <td>
                                <form action="{{route('licitacion.delete',$item->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" id="add_document" class="btn btn-danger btn-sm" onclick="return confirm('¿Desea eliminar la auditoría?')">Eliminar Auditoria</button>
                            </form>
                            </td>
                            <td>
                                <form action="{{route('licitacion.edit',$item->id)}}" method="GET">
                                @csrf
                                <button type="submit" id="add_document" class="btn btn-success btn-sm">Actualizar Auditoria</button>
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
