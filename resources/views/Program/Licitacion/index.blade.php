
@extends('Layout')

@section('title')
Mis Auditorias
@endsection

@section('content')
<div class="container">  
    <div class="table">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-responsive" style="font-size: 13px">
                    <thead class="table-secondary" style="text-align: center;">
        <tr>
            <th>Nombre</th>
            <th>Progreso</th>
            <th>Porcentaje</th>
            <th>Folio</th>
            <th>Area</th>
            <th>Fecha de elaboración</th>
            <th>Fecha de recepción</th>
            <th>Plazo de dias</th>
            <th>Formato de fecha</th>
            <th>Fecha de culmminación</th>
            <th colspan="3">Acciones</th>
        </tr>
    </thead>
        @foreach($datos as $item)
        <tr>
            <td>{{$item->nombre}}</td>
            <td>
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
            <td style="text-align: center;">{{$item->fecha_elaboracion}}</td>
            <td style="text-align: center;">{{$item->fecha_recepcion}}</td>
            <td style="text-align: center;">{{$item->plazo_dias}}</td>
            <td style="text-align: center;">{{$item->formato_fecha}}</td>
            <td style="text-align: center;">{{$item->fecha_culminacion}}</td>
            <td>
                <form action="{{route('documentos.anexos',$item->area)}}">
                @csrf
                <button type="submit" id="add_document" class="btn btn-info btn-sm">Ver anexos</button>
            </form>
            </td>
            <td>
                <form action="{{route('documentos.aplica',$item->id)}}">
                @csrf
                <button type="submit" id="add_document " class="btn btn-warning btn-sm">Aplica</button>
                </form>
            </td>
            <td>
                <form action="{{route('documentos.create',$item->id)}}">
                @csrf
                <button type="submit" id="add_document" class="btn btn-primary btn-sm">Añadir documentos</button>
                </form>
                
            </td>
        </tr>
        @endforeach
    </table>
</div>
</div>
</div>
</div>
@endsection