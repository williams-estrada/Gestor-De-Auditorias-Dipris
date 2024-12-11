
@extends('Layout')

@section('title')
Auditoria de documentos a integrar al expediente del proyecto
@endsection
<link href="{{ asset('css/documentos.css') }}" rel="stylesheet">
@section('content')
<div class="container">
    <div class="card">
        
        <div class="card-header" style="font-size: 15px; font-family:courier;">

            <div class="float-end">
                <a class="btn btn-sm btn-primary" id="aplica-todos" style="font-family:courier;">
                    Enviar Todos
                </a>
    
                <a href=" {{route('documentos.adjuntar', $licitacion_id) }}" class="btn btn-sm btn-dark" style="font-family:courier;">
                    Adjuntar Documentos
                </a>
            </div>
        </div>

        <div class="card-body">
            <div id="contenedor" data-mi-objeto="{{ $documento1 }}"></div>

            <table class="table">
                <tr>
                    <th rowspan="2">Planeación</th>
                    <th rowspan="2">Aplica</th>
                    <th colspan="1">Acciones</th>
                    <th rowspan="2">Area que genera la información</th>
                </tr>
                <tr>
                    <th>Enviar</th>
                </tr>
                @foreach ($documento1 as $item )
                <tr>
                    <form method="POST" id="frm-documentos-aplicar-{{ $item->id }}" action="{{route('documentos.aplica-store',$item->id)}}" enctype="multipart/form-data">
                        @method("PUT")
                        @csrf
                        <td>{{$item->requisito}}</td>
                        <td>
                            @if ($item->aplica == "")
                            <select name="aplica" id="aplica-{{$item->id}}">
                                <option value="" selected>Seleccionar</option>
                                <option value="si">si</option>
                                <option value="no">no</option>
                            </select>
                            @endif
                            @if ($item->aplica == "si")
                            <select name="aplica" id="aplica-{{$item->id}}">
                                <option value="si" selected>si</option>
                                <option value="no">no</option>
                            </select>
                            @endif
                            -@if ($item->aplica == "no")
                            <select name="aplica" id="aplica-{{$item->id}}">
                                <option value="no" selected>no</option>
                                <option value="si">si</option>
                            </select>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-Secondary btn-sm">Enviar</button>
                        </td>
                        <td>{{$item->area}}</td>
                    </form>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#aplica-todos').on('click', function() {
            var datos = [];
            var miObjetoJSON = $('#contenedor').data('mi-objeto');
            
            miObjetoJSON.forEach(element => {
                
                var tmp = {};
                var aplica = $('#aplica-' + element.id).val();
                
                tmp.id = element.id;
                tmp.aplica = aplica;
                datos.push(tmp);
            });

            const url = '{{ route('documentos.aplica-todos-store') }}';
        
            const token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: url,
                type: 'POST',
                data: { datos: datos, _token: token }, 
                dataType: 'json',
                success: function(data) {
                    location.reload();
                },
                error: function(error) {
                    console.error('Error al realizar la solicitud:', error);
                }
            });

        });
    });
</script>

@endsection