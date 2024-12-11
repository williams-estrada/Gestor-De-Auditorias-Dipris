
@extends('Layout')

@section('title')
Auditoria de compras menores
@endsection
<link href="{{ asset('css/documentos.css') }}" rel="stylesheet">
@section('content')
<div class="container"> 
    <div class="card">
        
        <div class="card-header" style="font-size: 15px; font-family:courier;">
            <div class="float-end">
                <a class="btn btn-sm btn-primary" id="aplica-todos-3" style="font-family:courier;">
                    Enviar Todos
                </a>
    
                <a href=" {{route('documentos.adjuntar', $licitacion_id) }}" class="btn btn-sm btn-dark" style="font-family:courier;">
                    Adjuntar Documentos
                </a>
            </div>
        </div>

        <div class="card-body">
        <div id="contenedor-1" data-mi-objeto-1="{{ $resultado1 }}"></div>
        <div id="contenedor-2" data-mi-objeto-2="{{ $resultado2 }}"></div>
        <div id="contenedor-3" data-mi-objeto-3="{{ $resultado3 }}"></div>
        <div id="contenedor-4" data-mi-objeto-4="{{ $resultado4 }}"></div>
        <div id="contenedor-5" data-mi-objeto-5="{{ $resultado5 }}"></div>
            <table class="table">
                <tr>
                    <th rowspan="2">Solicitud de adquisición</th>
                    <th rowspan="2">Aplica</th>
                    <th colspan="1">Acciones</th>
                    <th rowspan="2">Area que genera la información</th>
                </tr>
                <tr>
                    <th>Enviar</th>
                </tr>
                @foreach ($resultado1 as $item )
                <tr>
                    <form method="POST" action="{{route('documentos.aplica-store',$item->id)}}" enctype="multipart/form-data">
                        @method("PUT")
                        @csrf
                        <td>{{$item->requisito}}</td>
                        <td>
                            @if ($item->aplica == "")
                            <select name="aplica" id="aplica-{{$item->id}}">
                                <option value="" disabled selected>Seleccionar</option>
                                <option value="si">si</option>
                            </select>
                            @endif
                            @if ($item->aplica == "si")
                            <select name="aplica" id="aplica-{{$item->id}}">
                                <option value="si" disabled selected>si</option>
                                <option value="no">no</option>
                            </select>
                            @endif
                            @if ($item->aplica == "no")
                            <select name="aplica" id="aplica-{{$item->id}}">
                                <option value="no" disabled selected>no</option>
                                <option value="si">si</option>
                            </select>
                            @endif
                        </td>
                        <td><button class="btn btn-Secondary btn-sm">Enviar</button></td>
                        <td>{{$item->area}}</td>
                    </form>
                </tr>
                @endforeach
                <tr>
                    <th rowspan="2">Recepción de insumos medicos, administrativos y activos fisicos</th>
                    <th rowspan="2">Aplica</th>
                    <th colspan="1">Acciones</th>
                    <th rowspan="2">Area que genera la información</th>
                </tr>
                <tr>
                    <th>Enviar</th>
                </tr>
                @foreach ($resultado2 as $item )
                <tr>
                    <form method="POST" action="{{route('documentos.aplica-store',$item->id)}}" enctype="multipart/form-data">
                        @method("PUT")
                        @csrf
                        <td>{{$item->requisito}}</td>
                        <td>
                            @if ($item->aplica == "")
                            <select name="aplica" id="aplica-{{$item->id}}">
                                <option value="" disabled selected>Seleccionar</option>
                                <option value="si">si</option>
                            </select>
                            @endif
                            @if ($item->aplica == "si")
                            <select name="aplica" id="aplica-{{$item->id}}">
                                <option value="si" disabled selected>si</option>
                                <option value="no">no</option>
                            </select>
                            @endif
                            @if ($item->aplica == "no")
                            <select name="aplica" id="aplica-{{$item->id}}">
                                <option value="no" disabled selected>no</option>
                                <option value="si">si</option>
                            </select>
                            @endif
                        </td>
                        <td><button class="btn btn-Secondary btn-sm">Enviar</button></td>
                        <td>{{$item->area}}</td>
                    </form>
                </tr>
                @endforeach
                <tr>
                    <th rowspan="2">Trámite de pago</th>
                    <th rowspan="2">Aplica</th>
                    <th colspan="1">Acciones</th>
                    <th rowspan="2">Area que genera la información</th>
                </tr>
                <tr>
                    <th>Enviar</th>
                </tr>
                @foreach ($resultado3 as $item )
                <tr>
                    <form method="POST" action="{{route('documentos.aplica-store',$item->id)}}" enctype="multipart/form-data">
                        @method("PUT")
                        @csrf
                        <td>{{$item->requisito}}</td>
                        <td>
                            @if ($item->aplica == "")
                            <select name="aplica" id="aplica-{{$item->id}}">
                                <option value="" disabled selected>Seleccionar</option>
                                <option value="si">si</option>
                            </select>
                            @endif
                            @if ($item->aplica == "si")
                            <select name="aplica" id="aplica-{{$item->id}}">
                                <option value="si" disabled selected>si</option>
                                <option value="no">no</option>
                            </select>
                            @endif
                            @if ($item->aplica == "no")
                            <select name="aplica" id="aplica-{{$item->id}}">
                                <option value="no" disabled selected>no</option>
                                <option value="si">si</option>
                            </select>
                            @endif
                        </td>
                        <td><button class="btn btn-Secondary btn-sm">Enviar</button></td>
                        <td>{{$item->area}}</td>
                    </form>
                </tr>
                @endforeach
                <tr>
                    <th rowspan="2">Seguimiento</th>
                    <th rowspan="2">Aplica</th>
                    <th colspan="1">Acciones</th>
                    <th rowspan="2">Area que genera la información</th>
                </tr>
                <tr>
                    <th>Enviar</th>
                </tr>
                @foreach ($resultado4 as $item )
                <tr>
                    <form method="POST" action="{{route('documentos.aplica-store',$item->id)}}" enctype="multipart/form-data">
                        @method("PUT")
                        @csrf
                        <td>{{$item->requisito}}</td>
                        <td>
                            @if ($item->aplica == "")
                            <select name="aplica" id="aplica-{{$item->id}}">
                                <option value="" disabled selected>Seleccionar</option>
                                <option value="si">si</option>
                            </select>
                            @endif
                            @if ($item->aplica == "si")
                            <select name="aplica" id="aplica-{{$item->id}}">
                                <option value="si" disabled selected>si</option>
                                <option value="no">no</option>
                            </select>
                            @endif
                            @if ($item->aplica == "no")
                            <select name="aplica" id="aplica-{{$item->id}}">
                                <option value="no" disabled selected>no</option>
                                <option value="si">si</option>
                            </select>
                            @endif
                        </td>
                        <td><button class="btn btn-Secondary btn-sm">Enviar</button></td>
                        <td>{{$item->area}}</td>
                    </form>
                </tr>
                @endforeach
                <tr>
                    <th rowspan="2">Rendición de la cuenta pública</th>
                    <th rowspan="2">Aplica</th>
                    <th colspan="1">Acciones</th>
                    <th rowspan="2">Area que genera la información</th>
                </tr>
                <tr>
                    <th>Enviar</th>
                </tr>
                @foreach ($resultado5 as $item )
                <tr>
                    <form method="POST" action="{{route('documentos.aplica-store',$item->id)}}" enctype="multipart/form-data">
                        @method("PUT")
                        @csrf
                        <td>{{$item->requisito}}</td>
                        <td>
                            @if ($item->aplica == "")
                            <select name="aplica" id="aplica-{{$item->id}}">
                                <option value="" disabled selected>Seleccionar</option>
                                <option value="si">si</option>
                            </select>
                            @endif
                            @if ($item->aplica == "si")
                            <select name="aplica" id="aplica-{{$item->id}}">
                                <option value="si" disabled selected>si</option>
                                <option value="no">no</option>
                            </select>
                            @endif
                            @if ($item->aplica == "no")
                            <select name="aplica" id="aplica-{{$item->id}}">
                                <option value="no" disabled selected>no</option>
                                <option value="si">si</option>
                            </select>
                            @endif
                        </td>
                        <td><button class="btn btn-Secondary btn-sm">Enviar</button></td>
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
        $('#aplica-todos-3').on('click', function() {
            var datos = [];
            var contenedor1 = $('#contenedor-1').data('mi-objeto-1');
            var contenedor2 = $('#contenedor-2').data('mi-objeto-2');
            var contenedor3 = $('#contenedor-3').data('mi-objeto-3');
            var contenedor4 = $('#contenedor-4').data('mi-objeto-4');
            var contenedor5 = $('#contenedor-5').data('mi-objeto-5');
            
            contenedor1.forEach(element => {
                var tmp = {};
                var aplica = $('#aplica-' + element.id).val();
                
                tmp.id = element.id;
                tmp.aplica = aplica;
                datos.push(tmp);
            });

            contenedor2.forEach(element => {
                var tmp = {};
                var aplica = $('#aplica-' + element.id).val();
                
                tmp.id = element.id;
                tmp.aplica = aplica;
                datos.push(tmp);
            });            

            contenedor3.forEach(element => {
                var tmp = {};
                var aplica = $('#aplica-' + element.id).val();
                
                tmp.id = element.id;
                tmp.aplica = aplica;
                datos.push(tmp);
            });

            contenedor4.forEach(element => {
                var tmp = {};
                var aplica = $('#aplica-' + element.id).val();
                
                tmp.id = element.id;
                tmp.aplica = aplica;
                datos.push(tmp);
            });

            contenedor5.forEach(element => {
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