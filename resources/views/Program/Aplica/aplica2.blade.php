
@extends('Layout')

@section('title')
Auditoria de contratación de personal
@endsection
<link href="{{ asset('css/documentos.css') }}" rel="stylesheet">
@section('content')
<div class="container">
    <div class="card">
        
        <div class="card-header" style="font-size: 15px; font-family:courier;">
            <a href=" {{route('documentos.adjuntar', $licitacion_id) }}" class="btn btn-sm btn-Dark float-end" style="font-family:courier;">
            Adjuntar Documentos
            </a>
        </div>

        <div class="card-body">
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
                @foreach ($resultado1 as $item )
                <tr>
                    <form method="POST" action="{{route('documentos.aplica-store',$item->id)}}" enctype="multipart/form-data">
                        @method("PUT")
                        @csrf
                        <td>{{$item->requisito}}</td>
                        <td>
                            @if ($item->aplica == "")
                            <select name="aplica">
                                <option value="" disabled selected>Seleccionar</option>
                                <option value="si">si</option>
                            </select>
                            @endif
                            @if ($item->aplica == "si")
                            <select name="aplica">
                                <option value="" disabled selected>si</option>
                                <option value="no">no</option>
                            </select>
                            @endif
                            @if ($item->aplica == "no")
                            <select name="aplica">
                                <option value="" disabled selected>no</option>
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
                @foreach ($resultado2 as $item )
                <tr>
                    <form method="POST" action="{{route('documentos.aplica-store',$item->id)}}" enctype="multipart/form-data">
                        @method("PUT")
                        @csrf
                        <td>{{$item->requisito}}</td>
                        <td>
                            @if ($item->aplica == "")
                            <select name="aplica">
                                <option value="" disabled selected>Seleccionar</option>
                                <option value="si">si</option>
                            </select>
                            @endif
                            @if ($item->aplica == "si")
                            <select name="aplica">
                                <option value="" disabled selected>si</option>
                                <option value="no">no</option>
                            </select>
                            @endif
                            @if ($item->aplica == "no")
                            <select name="aplica">
                                <option value="" disabled selected>no</option>
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
                    <th rowspan="2">Rendicion de la cuenta publica</th>
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
                            <select name="aplica">
                                <option value="" disabled selected>Seleccionar</option>
                                <option value="si">si</option>
                            </select>
                            @endif
                            @if ($item->aplica == "si")
                            <select name="aplica">
                                <option value="" disabled selected>si</option>
                                <option value="no">no</option>
                            </select>
                            @endif
                            @if ($item->aplica == "no")
                            <select name="aplica">
                                <option value="" disabled selected>no</option>
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
@endsection