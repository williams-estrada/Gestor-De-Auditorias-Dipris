@extends('Layout')

@section('title')
Auditoria de adjudicacion directa
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
                    <th rowspan="2">SOLICITUD DE ADQUISICIÓN</th>
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
                    <th rowspan="2">PROCESO DE COMPRA</th>
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
                    <th rowspan="2">RECEPCIÓN DE INSUMOS MEDICOS, ADMINISTRATIVOS Y ACTIVOS FIJOS</th>
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
                <tr>
                    <th rowspan="2">TRÁMITE DE PAGO</th>
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
                    <th rowspan="2">GENERALIDADES EN EL CASO DE PENALIZACIONES AL PROVEDOR:</th>
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
                    <th rowspan="2">SEGUIMIENTO</th>
                    <th rowspan="2">Aplica</th>
                    <th colspan="1">Acciones</th>
                    <th rowspan="2">Area que genera la información</th>
                </tr>
                <tr>
                    <th>Enviar</th>
                </tr>
                @foreach ($resultado6 as $item )
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
                    <th rowspan="2">RENDICIÓN DE CUENTA PÚBLICA</th>
                    <th rowspan="2">Aplica</th>
                    <th colspan="1">Acciones</th>
                    <th rowspan="2">Area que genera la información</th>
                </tr>
                <tr>
                    <th>Enviar</th>
                </tr>
                @foreach ($resultado7 as $item )
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