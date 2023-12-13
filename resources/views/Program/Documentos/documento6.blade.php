@extends('Layout')

@section('title')
Auditoria de Licitación Pública
@endsection
<link href="{{ asset('css/documentos.css') }}" rel="stylesheet">
@section('content')
<div class="container">
<h1>Progreso de los anexos:{{session("porcentaje")}}%
        <progress max="100" value="{{session("porcentaje")}}" class="php">
            @if (intval(session("porcentaje")) <= 25)
            <style>
                .progress-bar-custom {
                    background-image: -moz-linear-gradient(135deg, transparent, transparent 33%, rgba(0, 0, 0, .1) 33%, rgba(0, 0, 0, .1) 66%, transparent 66%), -moz-linear-gradient(top, rgba(255, 255, 255, .25), rgba(0, 0, 0, .2)), -moz-linear-gradient(left, red, red);
                    background-size: 35px 20px, 100% 100%, 100% 100%;
                    border-radius: 3px;
                }
            </style>
        @endif
        
        @if (intval(session("porcentaje")) > 25 && intval(session("porcentaje")) <= 50)
            <style>
                .progress-bar-custom {
                    background-image: -moz-linear-gradient(135deg, transparent, transparent 33%, rgba(0, 0, 0, .1) 33%, rgba(0, 0, 0, .1) 66%, transparent 66%), -moz-linear-gradient(top, rgba(255, 255, 255, .25), rgba(0, 0, 0, .2)), -moz-linear-gradient(left, orange, orange);
                    background-size: 35px 20px, 100% 100%, 100% 100%;
                    border-radius: 3px;
                }
            </style>
        @endif
        
        @if (intval(session("porcentaje")) > 50 && intval(session("porcentaje")) <= 75)
            <style>
                .progress-bar-custom {
                    background-image: -moz-linear-gradient(135deg, transparent, transparent 33%, rgba(0, 0, 0, .1) 33%, rgba(0, 0, 0, .1) 66%, transparent 66%), -moz-linear-gradient(top, rgba(255, 255, 255, .25), rgba(0, 0, 0, .2)), -moz-linear-gradient(left, yellow, yellow);
                    background-size: 35px 20px, 100% 100%, 100% 100%;
                    border-radius: 3px;
                }
            </style>
        @endif
        
        @if (intval(session("porcentaje")) > 75 && intval(session("porcentaje")) <= 100)
            <style>
                .progress-bar-custom {
                    background-image: -moz-linear-gradient(135deg, transparent, transparent 33%, rgba(0, 0, 0, .1) 33%, rgba(0, 0, 0, .1) 66%, transparent 66%), -moz-linear-gradient(top, rgba(255, 255, 255, .25), rgba(0, 0, 0, .2)), -moz-linear-gradient(left, green, green);
                    background-size: 35px 20px, 100% 100%, 100% 100%;
                    border-radius: 3px;
                }
            </style>
        @endif
        
    </h1>
    <table class="table">
        <tr>
            <th rowspan="2">SOLICITUD DE ADQUISICIÓN</th>
            <th rowspan="2">Se cuenta con informacion</th>
            <th colspan="3">Acciones</th>
            <th rowspan="2">Area que genera la informacion</th>
        </tr>
        <tr>
            <th>Añadir archivo</th>
            <th>Añadir comentario</th>
            <th>Enviar</th>
        </tr>
        @foreach ($resultado1 as $item )
        <tr>
            <form method="POST" action="{{route('documentos.store',$item->id)}}" enctype="multipart/form-data">
                @csrf
                <td>{{$item->requisito}}</td>
                <td>
                    @if ($item->informacion_estado == "")
                    <select name="informacion_estado" required onchange="evaluarEstado(this)">
                        <option value="" disabled selected>Seleccionar</option>
                        <option value="si">si</option>
                        <option value="no">no</option>
                    </select>
                    @endif
                    @if ($item->informacion_estado == "si")
                    <select name="informacion_estado" onchange="evaluarEstado(this)">
                        <option value="si">si</option>
                        <option value="no">no</option>
                    </select>
                    @endif
                    @if ($item->informacion_estado == "no")
                    <select name="informacion_estado" onchange="evaluarEstado(this)">
                        <option value="no">no</option>
                        <option value="si">si</option>
                    </select>
                    @endif
                </td>
                <td>
                    @if ($item->ruta_documento == "")
                        @if($item->informacion_estado == "no")
                            @if($item->habilitado == 1)
                                <input type="file" id="add_document" name="documento"><br><br>
                            @else
                                <label for="">Enviado Sin Documento</label>
                            @endif
                            
                        @else
                            <input type="file" id="add_document" name="documento"><br><br>
                        @endif
                    @elseif($item->ruta_documento != "")
                        <label for="">Su documento se encuentra en revision</label>
                    @endif
                </td>
                <td><input type="text" name="comentario" value="{{$item->comentario}}"></td>
                <td>
                    @if(auth()->user()->tipo_usuario == 'Administrador')
                        @if($item->ruta_documento == "")
                            @if($item->informacion_estado == "no")
                                @if($item->habilitado == 1)
                                    <input type="text" hidden name="devolver" value="0">
                                    <input type="text" hidden name="habilitado" value="0">
                                    <button>Enviar</button>
                                @else
                                    <input type="text" hidden name="devolver" value="0">
                                    <input type="text" hidden name="habilitado" value="1">
                                    <button>Habilitar</button>
                                @endif
                            @elseif($item->informacion_estado == "si")
                                <input type="text" hidden name="devolver" value="1">
                                <input type="text" hidden name="habilitado" value="1">
                                <button>Devolver</button>
                            @else
                                <input type="text" hidden name="devolver" value="0">
                                <input type="text" hidden name="habilitado" value="0">
                                <button>Enviar</button>
                            @endif
                        @else 
                            @if($item->informacion_estado == "si")
                                <input type="text" hidden name="devolver" value="1">
                                <input type="text" hidden name="habilitado" value="1">
                                <button>Devolver</button>
                            @endif
                        @endif
                        
    
                    @elseif(auth()->user()->tipo_usuario == 'Cliente')
                        @if($item->ruta_documento == "")
                            @if($item->informacion_estado == "no")
                                @if($item->habilitado == 0)
                                    <button disabled>Enviar</button>
                                @else
                                    <input type="text" hidden name="devolver" value="0">
                                    <input type="text" hidden name="habilitado" value="0">
                                    <button>Enviar</button>
                                @endif
                            @elseif($item->informacion_estado == "si")
                                @if($item->habilitado == 0)
                                    <button disabled>Enviar</button>
                                @else
                                    <input type="text" hidden name="devolver" value="0">
                                    <input type="text" hidden name="habilitado" value="0">
                                    <button>Enviar</button>
                                @endif
                            @else
                                <input type="text" hidden name="devolver" value="0">
                                <input type="text" hidden name="habilitado" value="0">
                                <button>Enviar</button>
                            @endif
                        @else
                            @if($item->informacion_estado == "si")
                                <button disabled>Enviar</button>
                            @endif
                        @endif
                    @endif
                    </td>
                <td>{{$item->area}}</td>
            </form>
        </tr>
        @endforeach
        <tr>
            <th rowspan="2">ADQUISICIONES DE BIENES Y SERVICIOS MEDIANTE LICITACIÓN PÚBLICA:</th>
            <th rowspan="2">Se cuenta con informacion</th>
            <th colspan="3">Acciones</th>
            <th rowspan="2">Area que genera la informacion</th>
        </tr>
        <tr>
            <th>Añadir archivo</th>
            <th>Añadir comentario</th>
            <th>Enviar</th>
        </tr>
        @foreach ($resultado2 as $item )
        <tr>
            <form method="POST" action="{{route('documentos.store',$item->id)}}" enctype="multipart/form-data">
                @csrf
                <td>{{$item->requisito}}</td>
                <td>
                    @if ($item->informacion_estado == "")
                    <select name="informacion_estado" required onchange="evaluarEstado(this)">
                        <option value="" disabled selected>Seleccionar</option>
                        <option value="si">si</option>
                        <option value="no">no</option>
                    </select>
                    @endif
                    @if ($item->informacion_estado == "si")
                    <select name="informacion_estado" onchange="evaluarEstado(this)">
                        <option value="si">si</option>
                        <option value="no">no</option>
                    </select>
                    @endif
                    @if ($item->informacion_estado == "no")
                    <select name="informacion_estado" onchange="evaluarEstado(this)">
                        <option value="no">no</option>
                        <option value="si">si</option>
                    </select>
                    @endif
                </td>
                <td>
                    @if ($item->ruta_documento == "")
                        @if($item->informacion_estado == "no")
                            @if($item->habilitado == 1)
                                <input type="file" id="add_document" name="documento"><br><br>
                            @else
                                <label for="">Enviado Sin Documento</label>
                            @endif
                            
                        @else
                            <input type="file" id="add_document" name="documento"><br><br>
                        @endif
                    @elseif($item->ruta_documento != "")
                        <label for="">Su documento se encuentra en revision</label>
                    @endif
                </td>
                <td><input type="text" name="comentario" value="{{$item->comentario}}"></td>
                <td>
                    @if(auth()->user()->tipo_usuario == 'Administrador')
                        @if($item->ruta_documento == "")
                            @if($item->informacion_estado == "no")
                                @if($item->habilitado == 1)
                                    <input type="text" hidden name="devolver" value="0">
                                    <input type="text" hidden name="habilitado" value="0">
                                    <button>Enviar</button>
                                @else
                                    <input type="text" hidden name="devolver" value="0">
                                    <input type="text" hidden name="habilitado" value="1">
                                    <button>Habilitar</button>
                                @endif
                            @elseif($item->informacion_estado == "si")
                                <input type="text" hidden name="devolver" value="1">
                                <input type="text" hidden name="habilitado" value="1">
                                <button>Devolver</button>
                            @else
                                <input type="text" hidden name="devolver" value="0">
                                <input type="text" hidden name="habilitado" value="1">
                                <button>Enviar</button>
                            @endif
                        @else 
                            @if($item->informacion_estado == "si")
                                <input type="text" hidden name="devolver" value="1">
                                <input type="text" hidden name="habilitado" value="1">
                                <button>Devolver</button>
                            @endif
                        @endif
                        
    
                    @elseif(auth()->user()->tipo_usuario == 'Cliente')
                        @if($item->ruta_documento == "")
                            @if($item->informacion_estado == "no")
                                @if($item->habilitado == 0)
                                    <button disabled>Enviar</button>
                                @else
                                    <input type="text" hidden name="devolver" value="0">
                                    <input type="text" hidden name="habilitado" value="0">
                                    <button>Enviar</button>
                                @endif
                            @elseif($item->informacion_estado == "si")
                                @if($item->habilitado == 0)
                                    <button disabled>Enviar</button>
                                @else
                                    <input type="text" hidden name="devolver" value="0">
                                    <input type="text" hidden name="habilitado" value="0">
                                    <button>Enviar</button>
                                @endif
                            @else
                                <input type="text" hidden name="devolver" value="0">
                                <input type="text" hidden name="habilitado" value="0">
                                <button>Enviar</button>
                            @endif
                        @else
                            @if($item->informacion_estado == "si")
                                <button disabled>Enviar</button>
                            @endif
                        @endif
                    @endif
                    </td>
                <td>{{$item->area}}</td>
            </form>
        </tr>
        @endforeach
        <tr>
            <th rowspan="2">RECEPCIÓN DE INSUMOS MEDICOS, ADMINISTRATIVOS Y ACTIVOS FIJOS</th>
            <th rowspan="2">Se cuenta con informacion</th>
            <th colspan="3">Acciones</th>
            <th rowspan="2">Area que genera la informacion</th>
        </tr>
        <tr>
            <th>Añadir archivo</th>
            <th>Añadir comentario</th>
            <th>Enviar</th>
        </tr>
        @foreach ($resultado3 as $item )
        <tr>
            <form method="POST" action="{{route('documentos.store',$item->id)}}" enctype="multipart/form-data">
                @csrf
                <td>{{$item->requisito}}</td>
                <td>
                    @if ($item->informacion_estado == "")
                    <select name="informacion_estado" required onchange="evaluarEstado(this)">
                        <option value="" disabled selected>Seleccionar</option>
                        <option value="si">si</option>
                        <option value="no">no</option>
                    </select>
                    @endif
                    @if ($item->informacion_estado == "si")
                    <select name="informacion_estado" onchange="evaluarEstado(this)">
                        <option value="si">si</option>
                        <option value="no">no</option>
                    </select>
                    @endif
                    @if ($item->informacion_estado == "no")
                    <select name="informacion_estado" onchange="evaluarEstado(this)">
                        <option value="no">no</option>
                        <option value="si">si</option>
                    </select>
                    @endif
                </td>
                <td>
                    @if ($item->ruta_documento == "")
                        @if($item->informacion_estado == "no")
                            @if($item->habilitado == 1)
                                <input type="file" id="add_document" name="documento"><br><br>
                            @else
                                <label for="">Enviado Sin Documento</label>
                            @endif
                            
                        @else
                            <input type="file" id="add_document" name="documento"><br><br>
                        @endif
                    @elseif($item->ruta_documento != "")
                        <label for="">Su documento se encuentra en revision</label>
                    @endif
                </td>
                <td><input type="text" name="comentario" value="{{$item->comentario}}"></td>
                <td>
                    @if(auth()->user()->tipo_usuario == 'Administrador')
                        @if($item->ruta_documento == "")
                            @if($item->informacion_estado == "no")
                                @if($item->habilitado == 1)
                                    <input type="text" hidden name="devolver" value="0">
                                    <input type="text" hidden name="habilitado" value="0">
                                    <button>Enviar</button>
                                @else
                                    <input type="text" hidden name="devolver" value="0">
                                    <input type="text" hidden name="habilitado" value="1">
                                    <button>Habilitar</button>
                                @endif
                            @elseif($item->informacion_estado == "si")
                                <input type="text" hidden name="devolver" value="1">
                                <input type="text" hidden name="habilitado" value="1">
                                <button>Devolver</button>
                            @else
                                <input type="text" hidden name="devolver" value="0">
                                <input type="text" hidden name="habilitado" value="1">
                                <button>Enviar</button>
                            @endif
                        @else 
                            @if($item->informacion_estado == "si")
                                <input type="text" hidden name="devolver" value="1">
                                <input type="text" hidden name="habilitado" value="1">
                                <button>Devolver</button>
                            @endif
                        @endif
                        
    
                    @elseif(auth()->user()->tipo_usuario == 'Cliente')
                        @if($item->ruta_documento == "")
                            @if($item->informacion_estado == "no")
                                @if($item->habilitado == 0)
                                    <button disabled>Enviar</button>
                                @else
                                    <input type="text" hidden name="devolver" value="0">
                                    <input type="text" hidden name="habilitado" value="0">
                                    <button>Enviar</button>
                                @endif
                            @elseif($item->informacion_estado == "si")
                                @if($item->habilitado == 0)
                                    <button disabled>Enviar</button>
                                @else
                                    <input type="text" hidden name="devolver" value="0">
                                    <input type="text" hidden name="habilitado" value="0">
                                    <button>Enviar</button>
                                @endif
                            @else
                                <input type="text" hidden name="devolver" value="0">
                                <input type="text" hidden name="habilitado" value="0">
                                <button>Enviar</button>
                            @endif
                        @else
                            @if($item->informacion_estado == "si")
                                <button disabled>Enviar</button>
                            @endif
                        @endif
                    @endif
                    </td>
                <td>{{$item->area}}</td>
            </form>
        </tr>
        @endforeach
        <tr>
            <th rowspan="2">TRÁMITE DE PAGO</th>
            <th rowspan="2">Se cuenta con informacion</th>
            <th colspan="3">Acciones</th>
            <th rowspan="2">Area que genera la informacion</th>
        </tr>
        <tr>
            <th>Añadir archivo</th>
            <th>Añadir comentario</th>
            <th>Enviar</th>
        </tr>
        @foreach ($resultado4 as $item )
        <tr>
            <form method="POST" action="{{route('documentos.store',$item->id)}}" enctype="multipart/form-data">
                @csrf
                <td>{{$item->requisito}}</td>
                <td>
                    @if ($item->informacion_estado == "")
                    <select name="informacion_estado" required onchange="evaluarEstado(this)">
                        <option value="" disabled selected>Seleccionar</option>
                        <option value="si">si</option>
                        <option value="no">no</option>
                    </select>
                    @endif
                    @if ($item->informacion_estado == "si")
                    <select name="informacion_estado" onchange="evaluarEstado(this)">
                        <option value="si">si</option>
                        <option value="no">no</option>
                    </select>
                    @endif
                    @if ($item->informacion_estado == "no")
                    <select name="informacion_estado" onchange="evaluarEstado(this)">
                        <option value="no">no</option>
                        <option value="si">si</option>
                    </select>
                    @endif
                </td>
                <td>
                    @if ($item->ruta_documento == "")
                        @if($item->informacion_estado == "no")
                            @if($item->habilitado == 1)
                                <input type="file" id="add_document" name="documento"><br><br>
                            @else
                                <label for="">Enviado Sin Documento</label>
                            @endif
                            
                        @else
                            <input type="file" id="add_document" name="documento"><br><br>
                        @endif
                    @elseif($item->ruta_documento != "")
                        <label for="">Su documento se encuentra en revision</label>
                    @endif
                </td>
                <td><input type="text" name="comentario" value="{{$item->comentario}}"></td>
                <td>
                    @if(auth()->user()->tipo_usuario == 'Administrador')
                        @if($item->ruta_documento == "")
                            @if($item->informacion_estado == "no")
                                @if($item->habilitado == 1)
                                    <input type="text" hidden name="devolver" value="0">
                                    <input type="text" hidden name="habilitado" value="0">
                                    <button>Enviar</button>
                                @else
                                    <input type="text" hidden name="devolver" value="0">
                                    <input type="text" hidden name="habilitado" value="1">
                                    <button>Habilitar</button>
                                @endif
                            @elseif($item->informacion_estado == "si")
                                <input type="text" hidden name="devolver" value="1">
                                <input type="text" hidden name="habilitado" value="1">
                                <button>Devolver</button>
                            @else
                                <input type="text" hidden name="devolver" value="0">
                                <input type="text" hidden name="habilitado" value="1">
                                <button>Enviar</button>
                            @endif
                        @else 
                            @if($item->informacion_estado == "si")
                                <input type="text" hidden name="devolver" value="1">
                                <input type="text" hidden name="habilitado" value="1">
                                <button>Devolver</button>
                            @endif
                        @endif
                        
    
                    @elseif(auth()->user()->tipo_usuario == 'Cliente')
                        @if($item->ruta_documento == "")
                            @if($item->informacion_estado == "no")
                                @if($item->habilitado == 0)
                                    <button disabled>Enviar</button>
                                @else
                                    <input type="text" hidden name="devolver" value="0">
                                    <input type="text" hidden name="habilitado" value="0">
                                    <button>Enviar</button>
                                @endif
                            @elseif($item->informacion_estado == "si")
                                @if($item->habilitado == 0)
                                    <button disabled>Enviar</button>
                                @else
                                    <input type="text" hidden name="devolver" value="0">
                                    <input type="text" hidden name="habilitado" value="0">
                                    <button>Enviar</button>
                                @endif
                            @else
                                <input type="text" hidden name="devolver" value="0">
                                <input type="text" hidden name="habilitado" value="0">
                                <button>Enviar</button>
                            @endif
                        @else
                            @if($item->informacion_estado == "si")
                                <button disabled>Enviar</button>
                            @endif
                        @endif
                    @endif
                    </td>
                <td>{{$item->area}}</td>
            </form>
        </tr>
        @endforeach
        <tr>
            <th rowspan="2">GENERALIDADES EN EL CASO DE PENALIZACIONES AL PROVEDOR:</th>
            <th rowspan="2">Se cuenta con informacion</th>
            <th colspan="3">Acciones</th>
            <th rowspan="2">Area que genera la informacion</th>
        </tr>
        <tr>
            <th>Añadir archivo</th>
            <th>Añadir comentario</th>
            <th>Enviar</th>
        </tr>
        @foreach ($resultado5 as $item )
        <tr>
            <form method="POST" action="{{route('documentos.store',$item->id)}}" enctype="multipart/form-data">
                @csrf
                <td>{{$item->requisito}}</td>
                <td>
                    @if ($item->informacion_estado == "")
                    <select name="informacion_estado" required onchange="evaluarEstado(this)">
                        <option value="" disabled selected>Seleccionar</option>
                        <option value="si">si</option>
                        <option value="no">no</option>
                    </select>
                    @endif
                    @if ($item->informacion_estado == "si")
                    <select name="informacion_estado" onchange="evaluarEstado(this)">
                        <option value="si">si</option>
                        <option value="no">no</option>
                    </select>
                    @endif
                    @if ($item->informacion_estado == "no")
                    <select name="informacion_estado" onchange="evaluarEstado(this)">
                        <option value="no">no</option>
                        <option value="si">si</option>
                    </select>
                    @endif
                </td>
                <td>
                    @if ($item->ruta_documento == "")
                        @if($item->informacion_estado == "no")
                            @if($item->habilitado == 1)
                                <input type="file" id="add_document" name="documento"><br><br>
                            @else
                                <label for="">Enviado Sin Documento</label>
                            @endif
                            
                        @else
                            <input type="file" id="add_document" name="documento"><br><br>
                        @endif
                    @elseif($item->ruta_documento != "")
                        <label for="">Su documento se encuentra en revision</label>
                    @endif
                </td>
                <td><input type="text" name="comentario" value="{{$item->comentario}}"></td>
                <td>
                    @if(auth()->user()->tipo_usuario == 'Administrador')
                        @if($item->ruta_documento == "")
                            @if($item->informacion_estado == "no")
                                @if($item->habilitado == 1)
                                    <input type="text" hidden name="devolver" value="0">
                                    <input type="text" hidden name="habilitado" value="0">
                                    <button>Enviar</button>
                                @else
                                    <input type="text" hidden name="devolver" value="0">
                                    <input type="text" hidden name="habilitado" value="1">
                                    <button>Habilitar</button>
                                @endif
                            @elseif($item->informacion_estado == "si")
                                <input type="text" hidden name="devolver" value="1">
                                <input type="text" hidden name="habilitado" value="1">
                                <button>Devolver</button>
                            @else
                                <input type="text" hidden name="devolver" value="0">
                                <input type="text" hidden name="habilitado" value="1">
                                <button>Enviar</button>
                            @endif
                        @else 
                            @if($item->informacion_estado == "si")
                                <input type="text" hidden name="devolver" value="1">
                                <input type="text" hidden name="habilitado" value="1">
                                <button>Devolver</button>
                            @endif
                        @endif
                        
    
                    @elseif(auth()->user()->tipo_usuario == 'Cliente')
                        @if($item->ruta_documento == "")
                            @if($item->informacion_estado == "no")
                                @if($item->habilitado == 0)
                                    <button disabled>Enviar</button>
                                @else
                                    <input type="text" hidden name="devolver" value="0">
                                    <input type="text" hidden name="habilitado" value="0">
                                    <button>Enviar</button>
                                @endif
                            @elseif($item->informacion_estado == "si")
                                @if($item->habilitado == 0)
                                    <button disabled>Enviar</button>
                                @else
                                    <input type="text" hidden name="devolver" value="0">
                                    <input type="text" hidden name="habilitado" value="0">
                                    <button>Enviar</button>
                                @endif
                            @else
                                <input type="text" hidden name="devolver" value="0">
                                <input type="text" hidden name="habilitado" value="0">
                                <button>Enviar</button>
                            @endif
                        @else
                            @if($item->informacion_estado == "si")
                                <button disabled>Enviar</button>
                            @endif
                        @endif
                    @endif
                    </td>
                <td>{{$item->area}}</td>
            </form>
        </tr>
        @endforeach
        <tr>
            <th rowspan="2">SEGUIMIENTO</th>
            <th rowspan="2">Se cuenta con informacion</th>
            <th colspan="3">Acciones</th>
            <th rowspan="2">Area que genera la informacion</th>
        </tr>
        <tr>
            <th>Añadir archivo</th>
            <th>Añadir comentario</th>
            <th>Enviar</th>
        </tr>
        @foreach ($resultado6 as $item )
        <tr>
            <form method="POST" action="{{route('documentos.store',$item->id)}}" enctype="multipart/form-data">
                @csrf
                <td>{{$item->requisito}}</td>
                <td>
                    @if ($item->informacion_estado == "")
                    <select name="informacion_estado" required onchange="evaluarEstado(this)">
                        <option value="" disabled selected>Seleccionar</option>
                        <option value="si">si</option>
                        <option value="no">no</option>
                    </select>
                    @endif
                    @if ($item->informacion_estado == "si")
                    <select name="informacion_estado" onchange="evaluarEstado(this)">
                        <option value="si">si</option>
                        <option value="no">no</option>
                    </select>
                    @endif
                    @if ($item->informacion_estado == "no")
                    <select name="informacion_estado" onchange="evaluarEstado(this)">
                        <option value="no">no</option>
                        <option value="si">si</option>
                    </select>
                    @endif
                </td>
                <td>
                    @if ($item->ruta_documento == "")
                        @if($item->informacion_estado == "no")
                            @if($item->habilitado == 1)
                                <input type="file" id="add_document" name="documento"><br><br>
                            @else
                                <label for="">Enviado Sin Documento</label>
                            @endif
                            
                        @else
                            <input type="file" id="add_document" name="documento"><br><br>
                        @endif
                    @elseif($item->ruta_documento != "")
                        <label for="">Su documento se encuentra en revision</label>
                    @endif
                </td>
                <td><input type="text" name="comentario" value="{{$item->comentario}}"></td>
                <td>
                    @if(auth()->user()->tipo_usuario == 'Administrador')
                        @if($item->ruta_documento == "")
                            @if($item->informacion_estado == "no")
                                @if($item->habilitado == 1)
                                    <input type="text" hidden name="devolver" value="0">
                                    <input type="text" hidden name="habilitado" value="0">
                                    <button>Enviar</button>
                                @else
                                    <input type="text" hidden name="devolver" value="0">
                                    <input type="text" hidden name="habilitado" value="1">
                                    <button>Habilitar</button>
                                @endif
                            @elseif($item->informacion_estado == "si")
                                <input type="text" hidden name="devolver" value="1">
                                <input type="text" hidden name="habilitado" value="1">
                                <button>Devolver</button>
                            @else
                                <input type="text" hidden name="devolver" value="0">
                                <input type="text" hidden name="habilitado" value="1">
                                <button>Enviar</button>
                            @endif
                        @else 
                            @if($item->informacion_estado == "si")
                                <input type="text" hidden name="devolver" value="1">
                                <input type="text" hidden name="habilitado" value="1">
                                <button>Devolver</button>
                            @endif
                        @endif
                        
    
                    @elseif(auth()->user()->tipo_usuario == 'Cliente')
                        @if($item->ruta_documento == "")
                            @if($item->informacion_estado == "no")
                                @if($item->habilitado == 0)
                                    <button disabled>Enviar</button>
                                @else
                                    <input type="text" hidden name="devolver" value="0">
                                    <input type="text" hidden name="habilitado" value="0">
                                    <button>Enviar</button>
                                @endif
                            @elseif($item->informacion_estado == "si")
                                @if($item->habilitado == 0)
                                    <button disabled>Enviar</button>
                                @else
                                    <input type="text" hidden name="devolver" value="0">
                                    <input type="text" hidden name="habilitado" value="0">
                                    <button>Enviar</button>
                                @endif
                            @else
                                <input type="text" hidden name="devolver" value="0">
                                <input type="text" hidden name="habilitado" value="0">
                                <button>Enviar</button>
                            @endif
                        @else
                            @if($item->informacion_estado == "si")
                                <button disabled>Enviar</button>
                            @endif
                        @endif
                    @endif
                    </td>
                <td>{{$item->area}}</td>
            </form>
        </tr>
        @endforeach
        <tr>
            <th rowspan="2">RENDICION DE CUENTA PUBLICA</th>
            <th rowspan="2">Se cuenta con informacion</th>
            <th colspan="3">Acciones</th>
            <th rowspan="2">Area que genera la informacion</th>
        </tr>
        <tr>
            <th>Añadir archivo</th>
            <th>Añadir comentario</th>
            <th>Enviar</th>
        </tr>
        @foreach ($resultado7 as $item )
        <tr>
            <form method="POST" action="{{route('documentos.store',$item->id)}}" enctype="multipart/form-data">
                @csrf
                <td>{{$item->requisito}}</td>
                <td>
                    @if ($item->informacion_estado == "")
                    <select name="informacion_estado" required onchange="evaluarEstado(this)">
                        <option value="" disabled selected>Seleccionar</option>
                        <option value="si">si</option>
                        <option value="no">no</option>
                    </select>
                    @endif
                    @if ($item->informacion_estado == "si")
                    <select name="informacion_estado" onchange="evaluarEstado(this)">
                        <option value="si">si</option>
                        <option value="no">no</option>
                    </select>
                    @endif
                    @if ($item->informacion_estado == "no")
                    <select name="informacion_estado" onchange="evaluarEstado(this)">
                        <option value="no">no</option>
                        <option value="si">si</option>
                    </select>
                    @endif
                </td>
                <td>
                    @if ($item->ruta_documento == "")
                        @if($item->informacion_estado == "no")
                            @if($item->habilitado == 1)
                                <input type="file" id="add_document" name="documento"><br><br>
                            @else
                                <label for="">Enviado Sin Documento</label>
                            @endif
                            
                        @else
                            <input type="file" id="add_document" name="documento"><br><br>
                        @endif
                    @elseif($item->ruta_documento != "")
                        <label for="">Su documento se encuentra en revision</label>
                    @endif
                </td>
                <td><input type="text" name="comentario" value="{{$item->comentario}}"></td>
                <td>
                    @if(auth()->user()->tipo_usuario == 'Administrador')
                        @if($item->ruta_documento == "")
                            @if($item->informacion_estado == "no")
                                @if($item->habilitado == 1)
                                    <input type="text" hidden name="devolver" value="0">
                                    <input type="text" hidden name="habilitado" value="0">
                                    <button>Enviar</button>
                                @else
                                    <input type="text" hidden name="devolver" value="0">
                                    <input type="text" hidden name="habilitado" value="1">
                                    <button>Habilitar</button>
                                @endif
                            @elseif($item->informacion_estado == "si")
                                <input type="text" hidden name="devolver" value="1">
                                <input type="text" hidden name="habilitado" value="1">
                                <button>Devolver</button>
                            @else
                                <input type="text" hidden name="devolver" value="0">
                                <input type="text" hidden name="habilitado" value="1">
                                <button>Enviar</button>
                            @endif
                        @else 
                            @if($item->informacion_estado == "si")
                                <input type="text" hidden name="devolver" value="1">
                                <input type="text" hidden name="habilitado" value="1">
                                <button>Devolver</button>
                            @endif
                        @endif
                        
    
                    @elseif(auth()->user()->tipo_usuario == 'Cliente')
                        @if($item->ruta_documento == "")
                            @if($item->informacion_estado == "no")
                                @if($item->habilitado == 0)
                                    <button disabled>Enviar</button>
                                @else
                                    <input type="text" hidden name="devolver" value="0">
                                    <input type="text" hidden name="habilitado" value="0">
                                    <button>Enviar</button>
                                @endif
                            @elseif($item->informacion_estado == "si")
                                @if($item->habilitado == 0)
                                    <button disabled>Enviar</button>
                                @else
                                    <input type="text" hidden name="devolver" value="0">
                                    <input type="text" hidden name="habilitado" value="0">
                                    <button>Enviar</button>
                                @endif
                            @else
                                <input type="text" hidden name="devolver" value="0">
                                <input type="text" hidden name="habilitado" value="0">
                                <button>Enviar</button>
                            @endif
                        @else
                            @if($item->informacion_estado == "si")
                                <button disabled>Enviar</button>
                            @endif
                        @endif
                    @endif
                    </td>
                <td>{{$item->area}}</td>
            </form>
        </tr>
        @endforeach
    </table>
</div>
<script>
    function evaluarEstado(select){
        let fila = select.closest('tr');
        let campoFile = fila.querySelector('input[type="file"]');
        if(select.value == "no"){
            campoFile.disabled = true;
        }
        else{
            campoFile.disabled = false;
        }
    }
</script>
@endsection

