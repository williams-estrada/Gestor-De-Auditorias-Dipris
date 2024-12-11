@extends('Layout')

@section('title')
Auditoria de Licitación Pública
@endsection

<link href="{{ asset('css/documentos.css') }}" rel="stylesheet">

@section('content')

<div class="container"> 
    <div class="grid">

        <div class="row">
            <div class="col">
                <h1>Progreso de los anexos:{{ session("porcentaje") }}%
                    <progress max="100" value="{{ session('porcentaje') }}" class="php"></progress>
                </h1>
            </div>

        </div>

        @if(count($resultado1) > 0 )
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2" class="align-middle text-center table-font-size-titulo">Solicitud de Adquisición</th>
                                <th rowspan="2" class="align-middle text-center table-font-size-titulo">¿Se cuenta con información?</th>
                                <th colspan="3" class="align-middle text-center table-font-size-titulo">Acciones</th>
                                <th rowspan="2" class="align-middle text-center table-font-size-titulo">Área que genera la información</th>
                            </tr>
                            <tr>
                                <th class="align-middle text-center table-font-size-titulo">Añadir archivo</th>
                                <th class="align-middle text-center table-font-size-titulo">Añadir comentario</th>
                                <th class="align-middle text-center table-font-size-titulo">Enviar</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach ($resultado1 as $item )
                            <tr>
                                <form method="POST" action="{{route('documentos.store',$item->id)}}" enctype="multipart/form-data">
                                    @csrf
                                    <td class="table-font-size align-middle">{{$item->requisito}}</td>
                                    <td class="align-middle text-center">
                                        @if ($item->informacion_estado == "")
                                        <select name="informacion_estado" class="form-select form-select-sm" required onchange="evaluarEstado(this)">
                                            <option value="" disabled selected>Seleccionar</option>
                                            <option value="si">si</option>
                                            <option value="no">no</option>
                                        </select>
                                        @endif
                                        @if ($item->informacion_estado == "si")
                                        <select name="informacion_estado" class="form-select form-select-sm" onchange="evaluarEstado(this)">
                                            <option value="si">si</option>
                                            <option value="no">no</option>
                                        </select>
                                        @endif
                                        @if ($item->informacion_estado == "no")
                                        <select name="informacion_estado" class="form-select form-select-sm" onchange="evaluarEstado(this)">
                                            <option value="no">no</option>
                                            <option value="si">si</option>
                                        </select>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        @if ($item->ruta_documento == "")
                                            @if($item->informacion_estado == "no")
                                                @if($item->habilitado == 1)
                                                    <input type="file" id="add_document" name="documento">
                                                @else
                                                    <label for="" class="table-font-size">Enviado Sin Documento</label>
                                                @endif
                                                
                                            @else
                                                <input type="file" id="add_document" name="documento">
                                            @endif
                                        @elseif($item->ruta_documento != "")
                                            <label for="" class="table-font-size">Su documento se encuentra en revision</label>
                                        @endif
                                    </td>

                                    <td class="align-middle text-center">
                                        <button type="button" class="btn btn-info btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editarComentario{{ $item->id }}">
                                            Comentario
                                        </button>
                        
                                        @include('Program.Documentos.comentario', ['datos' => $item])
                                    </td>

                                    <td class="align-middle text-center">
                                        @if(auth()->user()->tipo_usuario == 'Administrador')
                                            @if($item->ruta_documento == "")
                                                @if($item->informacion_estado == "no")
                                                    @if($item->habilitado == 1)
                                                        <input type="text" hidden name="devolver" value="0">
                                                        <input type="text" hidden name="habilitado" value="0">
                                                        <button class="btn btn-primary btn-sm">Enviar</button>
                                                    @else
                                                        <input type="text" hidden name="devolver" value="0">
                                                        <input type="text" hidden name="habilitado" value="1">
                                                        <button class="btn btn-secondary btn-sm">Habilitar</button>
                                                    @endif
                                                @elseif($item->informacion_estado == "si")
                                                    <input type="text" hidden name="devolver" value="1">
                                                    <input type="text" hidden name="habilitado" value="1">
                                                    <button class="btn btn-dark btn-sm">Devolver</button>
                                                @else
                                                    <input type="text" hidden name="devolver" value="0">
                                                    <input type="text" hidden name="habilitado" value="0">
                                                    <button class="btn btn-primary btn-sm">Enviar</button>
                                                @endif
                                            @else 
                                                @if($item->informacion_estado == "si")
                                                    <input type="text" hidden name="devolver" value="1">
                                                    <input type="text" hidden name="habilitado" value="1">
                                                    <button class="btn btn-dark btn-sm">Devolver</button>
                                                @endif
                                            @endif
                                            

                                        @elseif(auth()->user()->tipo_usuario == 'Cliente')
                                            @if($item->ruta_documento == "")
                                                @if($item->informacion_estado == "no")
                                                    @if($item->habilitado == 0)
                                                        <button class="btn btn-outline-secondary btn-sm" disabled>Enviar</button>
                                                    @else
                                                        <input type="text" hidden name="devolver" value="0">
                                                        <input type="text" hidden name="habilitado" value="0">
                                                        <button class="btn btn-primary btn-sm">Enviar</button>
                                                    @endif
                                                @elseif($item->informacion_estado == "si")
                                                    @if($item->habilitado == 0)
                                                        <button class="btn btn-primary btn-sm" disabled>Enviar</button>
                                                    @else
                                                        <input type="text" hidden name="devolver" value="0">
                                                        <input type="text" hidden name="habilitado" value="0">
                                                        <button class="btn btn-primary btn-sm">Enviar</button>
                                                    @endif
                                                @else
                                                    <input type="text" hidden name="devolver" value="0">
                                                    <input type="text" hidden name="habilitado" value="0">
                                                    <button class="btn btn-primary btn-sm">Enviar</button>
                                                @endif
                                            @else
                                                @if($item->informacion_estado == "si")
                                                    <button class="btn btn-outline-secondary btn-sm" disabled>Enviar</button>
                                                @endif
                                            @endif
                                        @endif
                                    </td>

                                    <td class="table-font-size align-middle">{{$item->area}}</td>
                                </form>
                            </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
        
        @if(count($resultado2) > 0 )
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered border-primary table-primary">
                        <thead>
                            <tr>
                                <th rowspan="2" class="align-middle text-center table-font-size-titulo">Adquisición de bienes y servicios mediante licitación pública</th>
                                <th rowspan="2" class="align-middle text-center table-font-size-titulo">¿Se cuenta con información?</th>
                                <th colspan="3" class="align-middle text-center table-font-size-titulo">Acciones</th>
                                <th rowspan="2" class="align-middle text-center table-font-size-titulo">Área que genera la información</th>
                            </tr>
                            <tr>
                                <th class="align-middle text-center table-font-size-titulo">Añadir archivo</th>
                                <th class="align-middle text-center table-font-size-titulo">Añadir comentario</th>
                                <th class="align-middle text-center table-font-size-titulo">Enviar</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach ($resultado2 as $item )
                            <tr>
                                <form method="POST" action="{{route('documentos.store',$item->id)}}" enctype="multipart/form-data">
                                    @csrf
                                    <td class="table-font-size align-middle">{{$item->requisito}}</td>
                                    <td class="align-middle text-center">
                                        @if ($item->informacion_estado == "")
                                        <select name="informacion_estado" class="form-select form-select-sm" required onchange="evaluarEstado(this)">
                                            <option value="" disabled selected>Seleccionar</option>
                                            <option value="si">si</option>
                                            <option value="no">no</option>
                                        </select>
                                        @endif
                                        @if ($item->informacion_estado == "si")
                                        <select name="informacion_estado" class="form-select form-select-sm" onchange="evaluarEstado(this)">
                                            <option value="si">si</option>
                                            <option value="no">no</option>
                                        </select>
                                        @endif
                                        @if ($item->informacion_estado == "no")
                                        <select name="informacion_estado" class="form-select form-select-sm" onchange="evaluarEstado(this)">
                                            <option value="no">no</option>
                                            <option value="si">si</option>
                                        </select>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        @if ($item->ruta_documento == "")
                                            @if($item->informacion_estado == "no")
                                                @if($item->habilitado == 1)
                                                    <input type="file" id="add_document" name="documento">
                                                @else
                                                    <label for="" class="table-font-size">Enviado Sin Documento</label>
                                                @endif
                                                
                                            @else
                                                <input type="file" id="add_document" name="documento">
                                            @endif
                                        @elseif($item->ruta_documento != "")
                                            <label for="" class="table-font-size">Su documento se encuentra en revision</label>
                                        @endif
                                    </td>

                                    <td class="align-middle text-center">
                                        <button type="button" class="btn btn-info btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editarComentario{{ $item->id }}">
                                            Comentario
                                        </button>
                        
                                        @include('Program.Documentos.comentario', ['datos' => $item])
                                    </td>

                                    <td class="align-middle text-center">
                                        @if(auth()->user()->tipo_usuario == 'Administrador')
                                            @if($item->ruta_documento == "")
                                                @if($item->informacion_estado == "no")
                                                    @if($item->habilitado == 1)
                                                        <input type="text" hidden name="devolver" value="0">
                                                        <input type="text" hidden name="habilitado" value="0">
                                                        <button class="btn btn-primary btn-sm">Enviar</button>
                                                    @else
                                                        <input type="text" hidden name="devolver" value="0">
                                                        <input type="text" hidden name="habilitado" value="1">
                                                        <button class="btn btn-secondary btn-sm">Habilitar</button>
                                                    @endif
                                                @elseif($item->informacion_estado == "si")
                                                    <input type="text" hidden name="devolver" value="1">
                                                    <input type="text" hidden name="habilitado" value="1">
                                                    <button class="btn btn-dark btn-sm">Devolver</button>
                                                @else
                                                    <input type="text" hidden name="devolver" value="0">
                                                    <input type="text" hidden name="habilitado" value="1">
                                                    <button class="btn btn-primary btn-sm">Enviar</button>
                                                @endif
                                            @else 
                                                @if($item->informacion_estado == "si")
                                                    <input type="text" hidden name="devolver" value="1">
                                                    <input type="text" hidden name="habilitado" value="1">
                                                    <button class="btn btn-dark btn-sm">Devolver</button>
                                                @endif
                                            @endif
                                            

                                        @elseif(auth()->user()->tipo_usuario == 'Cliente')
                                            @if($item->ruta_documento == "")
                                                @if($item->informacion_estado == "no")
                                                    @if($item->habilitado == 0)
                                                        <button class="btn btn-outline-secondary btn-sm" disabled>Enviar</button>
                                                    @else
                                                        <input type="text" hidden name="devolver" value="0">
                                                        <input type="text" hidden name="habilitado" value="0">
                                                        <button class="btn btn-primary btn-sm">Enviar</button>
                                                    @endif
                                                @elseif($item->informacion_estado == "si")
                                                    @if($item->habilitado == 0)
                                                        <button class="btn btn-primary btn-sm" disabled>Enviar</button>
                                                    @else
                                                        <input type="text" hidden name="devolver" value="0">
                                                        <input type="text" hidden name="habilitado" value="0">
                                                        <button class="btn btn-primary btn-sm">Enviar</button>
                                                    @endif
                                                @else
                                                    <input type="text" hidden name="devolver" value="0">
                                                    <input type="text" hidden name="habilitado" value="0">
                                                    <button class="btn btn-primary btn-sm">Enviar</button>
                                                @endif
                                            @else
                                                @if($item->informacion_estado == "si")
                                                    <button class="btn btn-outline-secondary btn-sm" disabled>Enviar</button>
                                                @endif
                                            @endif
                                        @endif
                                    </td>

                                    <td class="table-font-size align-middle">{{$item->area}}</td>
                                </form>
                            </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        @if(count($resultado3) > 0 )
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered border-info table-info">
                        <thead>
                            <tr>
                                <th rowspan="2" class="align-middle text-center table-font-size-titulo">Recepción de insumos médicos, administrativos y activos fijos</th>
                                <th rowspan="2" class="align-middle text-center table-font-size-titulo">¿Se cuenta con información?</th>
                                <th colspan="3" class="align-middle text-center table-font-size-titulo">Acciones</th>
                                <th rowspan="2" class="align-middle text-center table-font-size-titulo">Área que genera la información</th>
                            </tr>
                            <tr>
                                <th class="align-middle text-center table-font-size-titulo">Añadir archivo</th>
                                <th class="align-middle text-center table-font-size-titulo">Añadir comentario</th>
                                <th class="align-middle text-center table-font-size-titulo">Enviar</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach ($resultado3 as $item )
                            <tr>
                                <form method="POST" action="{{route('documentos.store',$item->id)}}" enctype="multipart/form-data">
                                    @csrf
                                    <td class="table-font-size align-middle">{{$item->requisito}}</td>
                                    <td class="align-middle text-center">
                                        @if ($item->informacion_estado == "")
                                        <select name="informacion_estado" class="form-select form-select-sm" required onchange="evaluarEstado(this)">
                                            <option value="" disabled selected>Seleccionar</option>
                                            <option value="si">si</option>
                                            <option value="no">no</option>
                                        </select>
                                        @endif
                                        @if ($item->informacion_estado == "si")
                                        <select name="informacion_estado" class="form-select form-select-sm" onchange="evaluarEstado(this)">
                                            <option value="si">si</option>
                                            <option value="no">no</option>
                                        </select>
                                        @endif
                                        @if ($item->informacion_estado == "no")
                                        <select name="informacion_estado" class="form-select form-select-sm" onchange="evaluarEstado(this)">
                                            <option value="no">no</option>
                                            <option value="si">si</option>
                                        </select>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        @if ($item->ruta_documento == "")
                                            @if($item->informacion_estado == "no")
                                                @if($item->habilitado == 1)
                                                    <input type="file" id="add_document" name="documento">
                                                @else
                                                    <label for="" class="table-font-size">Enviado Sin Documento</label>
                                                @endif
                                                
                                            @else
                                                <input type="file" id="add_document" name="documento">
                                            @endif
                                        @elseif($item->ruta_documento != "")
                                            <label for="" class="table-font-size">Su documento se encuentra en revision</label>
                                        @endif
                                    </td>

                                    <td class="align-middle text-center">
                                        <button type="button" class="btn btn-info btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editarComentario{{ $item->id }}">
                                            Comentario
                                        </button>
                        
                                        @include('Program.Documentos.comentario', ['datos' => $item])
                                    </td>

                                    <td class="align-middle text-center">
                                        @if(auth()->user()->tipo_usuario == 'Administrador')
                                            @if($item->ruta_documento == "")
                                                @if($item->informacion_estado == "no")
                                                    @if($item->habilitado == 1)
                                                        <input type="text" hidden name="devolver" value="0">
                                                        <input type="text" hidden name="habilitado" value="0">
                                                        <button class="btn btn-primary btn-sm">Enviar</button>
                                                    @else
                                                        <input type="text" hidden name="devolver" value="0">
                                                        <input type="text" hidden name="habilitado" value="1">
                                                        <button class="btn btn-secondary btn-sm">Habilitar</button>
                                                    @endif
                                                @elseif($item->informacion_estado == "si")
                                                    <input type="text" hidden name="devolver" value="1">
                                                    <input type="text" hidden name="habilitado" value="1">
                                                    <button class="btn btn-dark btn-sm">Devolver</button>
                                                @else
                                                    <input type="text" hidden name="devolver" value="0">
                                                    <input type="text" hidden name="habilitado" value="1">
                                                    <button class="btn btn-primary btn-sm">Enviar</button>
                                                @endif
                                            @else 
                                                @if($item->informacion_estado == "si")
                                                    <input type="text" hidden name="devolver" value="1">
                                                    <input type="text" hidden name="habilitado" value="1">
                                                    <button class="btn btn-dark btn-sm">Devolver</button>
                                                @endif
                                            @endif
                                            

                                        @elseif(auth()->user()->tipo_usuario == 'Cliente')
                                            @if($item->ruta_documento == "")
                                                @if($item->informacion_estado == "no")
                                                    @if($item->habilitado == 0)
                                                        <button class="btn btn-outline-secondary btn-sm" disabled>Enviar</button>
                                                    @else
                                                        <input type="text" hidden name="devolver" value="0">
                                                        <input type="text" hidden name="habilitado" value="0">
                                                        <button class="btn btn-primary btn-sm">Enviar</button>
                                                    @endif
                                                @elseif($item->informacion_estado == "si")
                                                    @if($item->habilitado == 0)
                                                        <button class="btn btn-primary btn-sm" disabled>Enviar</button>
                                                    @else
                                                        <input type="text" hidden name="devolver" value="0">
                                                        <input type="text" hidden name="habilitado" value="0">
                                                        <button class="btn btn-primary btn-sm">Enviar</button>
                                                    @endif
                                                @else
                                                    <input type="text" hidden name="devolver" value="0">
                                                    <input type="text" hidden name="habilitado" value="0">
                                                    <button class="btn btn-primary btn-sm">Enviar</button>
                                                @endif
                                            @else
                                                @if($item->informacion_estado == "si")
                                                    <button class="btn btn-outline-secondary btn-sm" disabled>Enviar</button>
                                                @endif
                                            @endif
                                        @endif
                                    </td>

                                    <td class="table-font-size align-middle">{{$item->area}}</td>
                                </form>
                            </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
        
        @if(count($resultado4) > 0 )
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered border-warning table-warning">
                        <thead>
                            <tr>
                                <th rowspan="2" class="align-middle text-center table-font-size-titulo">Trmáite de pago</th>
                                <th rowspan="2" class="align-middle text-center table-font-size-titulo">¿Se cuenta con información?</th>
                                <th colspan="3" class="align-middle text-center table-font-size-titulo">Acciones</th>
                                <th rowspan="2" class="align-middle text-center table-font-size-titulo">Área que genera la información</th>
                            </tr>
                            <tr>
                                <th class="align-middle text-center table-font-size-titulo">Añadir archivo</th>
                                <th class="align-middle text-center table-font-size-titulo">Añadir comentario</th>
                                <th class="align-middle text-center table-font-size-titulo">Enviar</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach ($resultado4 as $item )
                            <tr>
                                <form method="POST" action="{{route('documentos.store',$item->id)}}" enctype="multipart/form-data">
                                    @csrf
                                    <td class="table-font-size align-middle">{{$item->requisito}}</td>
                                    <td class="align-middle text-center">
                                        @if ($item->informacion_estado == "")
                                        <select name="informacion_estado" class="form-select form-select-sm" required onchange="evaluarEstado(this)">
                                            <option value="" disabled selected>Seleccionar</option>
                                            <option value="si">si</option>
                                            <option value="no">no</option>
                                        </select>
                                        @endif
                                        @if ($item->informacion_estado == "si")
                                        <select name="informacion_estado" class="form-select form-select-sm" onchange="evaluarEstado(this)">
                                            <option value="si">si</option>
                                            <option value="no">no</option>
                                        </select>
                                        @endif
                                        @if ($item->informacion_estado == "no")
                                        <select name="informacion_estado" class="form-select form-select-sm" onchange="evaluarEstado(this)">
                                            <option value="no">no</option>
                                            <option value="si">si</option>
                                        </select>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        @if ($item->ruta_documento == "")
                                            @if($item->informacion_estado == "no")
                                                @if($item->habilitado == 1)
                                                    <input type="file" id="add_document" name="documento">
                                                @else
                                                    <label for="" class="table-font-size">Enviado Sin Documento</label>
                                                @endif
                                                
                                            @else
                                                <input type="file" id="add_document" name="documento">
                                            @endif
                                        @elseif($item->ruta_documento != "")
                                            <label for="" class="table-font-size">Su documento se encuentra en revision</label>
                                        @endif
                                    </td>

                                    <td class="align-middle text-center">
                                        <button type="button" class="btn btn-info btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editarComentario{{ $item->id }}">
                                            Comentario
                                        </button>
                        
                                        @include('Program.Documentos.comentario', ['datos' => $item])
                                    </td>

                                    <td class="align-middle text-center">
                                        @if(auth()->user()->tipo_usuario == 'Administrador')
                                            @if($item->ruta_documento == "")
                                                @if($item->informacion_estado == "no")
                                                    @if($item->habilitado == 1)
                                                        <input type="text" hidden name="devolver" value="0">
                                                        <input type="text" hidden name="habilitado" value="0">
                                                        <button class="btn btn-primary btn-sm">Enviar</button>
                                                    @else
                                                        <input type="text" hidden name="devolver" value="0">
                                                        <input type="text" hidden name="habilitado" value="1">
                                                        <button class="btn btn-secondary btn-sm">Habilitar</button>
                                                    @endif
                                                @elseif($item->informacion_estado == "si")
                                                    <input type="text" hidden name="devolver" value="1">
                                                    <input type="text" hidden name="habilitado" value="1">
                                                    <button class="btn btn-dark btn-sm">Devolver</button>
                                                @else
                                                    <input type="text" hidden name="devolver" value="0">
                                                    <input type="text" hidden name="habilitado" value="1">
                                                    <button class="btn btn-primary btn-sm">Enviar</button>
                                                @endif
                                            @else 
                                                @if($item->informacion_estado == "si")
                                                    <input type="text" hidden name="devolver" value="1">
                                                    <input type="text" hidden name="habilitado" value="1">
                                                    <button class="btn btn-dark btn-sm">Devolver</button>
                                                @endif
                                            @endif
                                            

                                        @elseif(auth()->user()->tipo_usuario == 'Cliente')
                                            @if($item->ruta_documento == "")
                                                @if($item->informacion_estado == "no")
                                                    @if($item->habilitado == 0)
                                                        <button class="btn btn-outline-secondary btn-sm" disabled>Enviar</button>
                                                    @else
                                                        <input type="text" hidden name="devolver" value="0">
                                                        <input type="text" hidden name="habilitado" value="0">
                                                        <button class="btn btn-primary btn-sm">Enviar</button>
                                                    @endif
                                                @elseif($item->informacion_estado == "si")
                                                    @if($item->habilitado == 0)
                                                        <button class="btn btn-primary btn-sm" disabled>Enviar</button>
                                                    @else
                                                        <input type="text" hidden name="devolver" value="0">
                                                        <input type="text" hidden name="habilitado" value="0">
                                                        <button class="btn btn-primary btn-sm">Enviar</button>
                                                    @endif
                                                @else
                                                    <input type="text" hidden name="devolver" value="0">
                                                    <input type="text" hidden name="habilitado" value="0">
                                                    <button class="btn btn-primary btn-sm">Enviar</button>
                                                @endif
                                            @else
                                                @if($item->informacion_estado == "si")
                                                    <button class="btn btn-outline-secondary btn-sm" disabled>Enviar</button>
                                                @endif
                                            @endif
                                        @endif
                                    </td>

                                    <td class="table-font-size align-middle">{{$item->area}}</td>
                                </form>
                            </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        @if(count($resultado5) > 0 )
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered border-success table-success">
                        <thead>
                            <tr>
                                <th rowspan="2" class="align-middle text-center table-font-size-titulo">Generalidades en el caso de penalizaciones al proveedor.</th>
                                <th rowspan="2" class="align-middle text-center table-font-size-titulo">¿Se cuenta con información?</th>
                                <th colspan="3" class="align-middle text-center table-font-size-titulo">Acciones</th>
                                <th rowspan="2" class="align-middle text-center table-font-size-titulo">Área que genera la información</th>
                            </tr>
                            <tr>
                                <th class="align-middle text-center table-font-size-titulo">Añadir archivo</th>
                                <th class="align-middle text-center table-font-size-titulo">Añadir comentario</th>
                                <th class="align-middle text-center table-font-size-titulo">Enviar</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach ($resultado5 as $item )
                            <tr>
                                <form method="POST" action="{{route('documentos.store',$item->id)}}" enctype="multipart/form-data">
                                    @csrf
                                    <td class="table-font-size align-middle">{{$item->requisito}}</td>
                                    <td class="align-middle text-center">
                                        @if ($item->informacion_estado == "")
                                        <select name="informacion_estado" class="form-select form-select-sm" required onchange="evaluarEstado(this)">
                                            <option value="" disabled selected>Seleccionar</option>
                                            <option value="si">si</option>
                                            <option value="no">no</option>
                                        </select>
                                        @endif
                                        @if ($item->informacion_estado == "si")
                                        <select name="informacion_estado" class="form-select form-select-sm" onchange="evaluarEstado(this)">
                                            <option value="si">si</option>
                                            <option value="no">no</option>
                                        </select>
                                        @endif
                                        @if ($item->informacion_estado == "no")
                                        <select name="informacion_estado" class="form-select form-select-sm" onchange="evaluarEstado(this)">
                                            <option value="no">no</option>
                                            <option value="si">si</option>
                                        </select>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        @if ($item->ruta_documento == "")
                                            @if($item->informacion_estado == "no")
                                                @if($item->habilitado == 1)
                                                    <input type="file" id="add_document" name="documento">
                                                @else
                                                    <label for="" class="table-font-size">Enviado Sin Documento</label>
                                                @endif
                                                
                                            @else
                                                <input type="file" id="add_document" name="documento">
                                            @endif
                                        @elseif($item->ruta_documento != "")
                                            <label for="" class="table-font-size">Su documento se encuentra en revision</label>
                                        @endif
                                    </td>

                                    <td class="align-middle text-center">
                                        <button type="button" class="btn btn-info btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editarComentario{{ $item->id }}">
                                            Comentario
                                        </button>
                        
                                        @include('Program.Documentos.comentario', ['datos' => $item])
                                    </td>

                                    <td class="align-middle text-center">
                                        @if(auth()->user()->tipo_usuario == 'Administrador')
                                            @if($item->ruta_documento == "")
                                                @if($item->informacion_estado == "no")
                                                    @if($item->habilitado == 1)
                                                        <input type="text" hidden name="devolver" value="0">
                                                        <input type="text" hidden name="habilitado" value="0">
                                                        <button class="btn btn-primary btn-sm">Enviar</button>
                                                    @else
                                                        <input type="text" hidden name="devolver" value="0">
                                                        <input type="text" hidden name="habilitado" value="1">
                                                        <button class="btn btn-secondary btn-sm">Habilitar</button>
                                                    @endif
                                                @elseif($item->informacion_estado == "si")
                                                    <input type="text" hidden name="devolver" value="1">
                                                    <input type="text" hidden name="habilitado" value="1">
                                                    <button class="btn btn-dark btn-sm">Devolver</button>
                                                @else
                                                    <input type="text" hidden name="devolver" value="0">
                                                    <input type="text" hidden name="habilitado" value="1">
                                                    <button class="btn btn-primary btn-sm">Enviar</button>
                                                @endif
                                            @else 
                                                @if($item->informacion_estado == "si")
                                                    <input type="text" hidden name="devolver" value="1">
                                                    <input type="text" hidden name="habilitado" value="1">
                                                    <button class="btn btn-dark btn-sm">Devolver</button>
                                                @endif
                                            @endif
                                            

                                        @elseif(auth()->user()->tipo_usuario == 'Cliente')
                                            @if($item->ruta_documento == "")
                                                @if($item->informacion_estado == "no")
                                                    @if($item->habilitado == 0)
                                                        <button class="btn btn-outline-secondary btn-sm" disabled>Enviar</button>
                                                    @else
                                                        <input type="text" hidden name="devolver" value="0">
                                                        <input type="text" hidden name="habilitado" value="0">
                                                        <button class="btn btn-primary btn-sm">Enviar</button>
                                                    @endif
                                                @elseif($item->informacion_estado == "si")
                                                    @if($item->habilitado == 0)
                                                        <button class="btn btn-primary btn-sm" disabled>Enviar</button>
                                                    @else
                                                        <input type="text" hidden name="devolver" value="0">
                                                        <input type="text" hidden name="habilitado" value="0">
                                                        <button class="btn btn-primary btn-sm">Enviar</button>
                                                    @endif
                                                @else
                                                    <input type="text" hidden name="devolver" value="0">
                                                    <input type="text" hidden name="habilitado" value="0">
                                                    <button class="btn btn-primary btn-sm">Enviar</button>
                                                @endif
                                            @else
                                                @if($item->informacion_estado == "si")
                                                    <button class="btn btn-outline-secondary btn-sm" disabled>Enviar</button>
                                                @endif
                                            @endif
                                        @endif
                                    </td>

                                    <td class="table-font-size align-middle">{{$item->area}}</td>
                                </form>
                            </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        @if(count($resultado6) > 0 )
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-light">
                        <thead>
                            <tr>
                                <th rowspan="2" class="align-middle text-center table-font-size-titulo">Seguimiento</th>
                                <th rowspan="2" class="align-middle text-center table-font-size-titulo">¿Se cuenta con información?</th>
                                <th colspan="3" class="align-middle text-center table-font-size-titulo">Acciones</th>
                                <th rowspan="2" class="align-middle text-center table-font-size-titulo">Área que genera la información</th>
                            </tr>
                            <tr>
                                <th class="align-middle text-center table-font-size-titulo">Añadir archivo</th>
                                <th class="align-middle text-center table-font-size-titulo">Añadir comentario</th>
                                <th class="align-middle text-center table-font-size-titulo">Enviar</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach ($resultado6 as $item )
                            <tr>
                                <form method="POST" action="{{route('documentos.store',$item->id)}}" enctype="multipart/form-data">
                                    @csrf
                                    <td class="table-font-size align-middle">{{$item->requisito}}</td>
                                    <td class="align-middle text-center">
                                        @if ($item->informacion_estado == "")
                                        <select name="informacion_estado" class="form-select form-select-sm" required onchange="evaluarEstado(this)">
                                            <option value="" disabled selected>Seleccionar</option>
                                            <option value="si">si</option>
                                            <option value="no">no</option>
                                        </select>
                                        @endif
                                        @if ($item->informacion_estado == "si")
                                        <select name="informacion_estado" class="form-select form-select-sm" onchange="evaluarEstado(this)">
                                            <option value="si">si</option>
                                            <option value="no">no</option>
                                        </select>
                                        @endif
                                        @if ($item->informacion_estado == "no")
                                        <select name="informacion_estado" class="form-select form-select-sm" onchange="evaluarEstado(this)">
                                            <option value="no">no</option>
                                            <option value="si">si</option>
                                        </select>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        @if ($item->ruta_documento == "")
                                            @if($item->informacion_estado == "no")
                                                @if($item->habilitado == 1)
                                                    <input type="file" id="add_document" name="documento">
                                                @else
                                                    <label for="" class="table-font-size">Enviado Sin Documento</label>
                                                @endif
                                                
                                            @else
                                                <input type="file" id="add_document" name="documento">
                                            @endif
                                        @elseif($item->ruta_documento != "")
                                            <label for="" class="table-font-size">Su documento se encuentra en revision</label>
                                        @endif
                                    </td>

                                    <td class="align-middle text-center">
                                        <button type="button" class="btn btn-info btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editarComentario{{ $item->id }}">
                                            Comentario
                                        </button>
                        
                                        @include('Program.Documentos.comentario', ['datos' => $item])
                                    </td>

                                    <td class="align-middle text-center">
                                        @if(auth()->user()->tipo_usuario == 'Administrador')
                                            @if($item->ruta_documento == "")
                                                @if($item->informacion_estado == "no")
                                                    @if($item->habilitado == 1)
                                                        <input type="text" hidden name="devolver" value="0">
                                                        <input type="text" hidden name="habilitado" value="0">
                                                        <button class="btn btn-primary btn-sm">Enviar</button>
                                                    @else
                                                        <input type="text" hidden name="devolver" value="0">
                                                        <input type="text" hidden name="habilitado" value="1">
                                                        <button class="btn btn-secondary btn-sm">Habilitar</button>
                                                    @endif
                                                @elseif($item->informacion_estado == "si")
                                                    <input type="text" hidden name="devolver" value="1">
                                                    <input type="text" hidden name="habilitado" value="1">
                                                    <button class="btn btn-dark btn-sm">Devolver</button>
                                                @else
                                                    <input type="text" hidden name="devolver" value="0">
                                                    <input type="text" hidden name="habilitado" value="1">
                                                    <button class="btn btn-primary btn-sm">Enviar</button>
                                                @endif
                                            @else 
                                                @if($item->informacion_estado == "si")
                                                    <input type="text" hidden name="devolver" value="1">
                                                    <input type="text" hidden name="habilitado" value="1">
                                                    <button class="btn btn-dark btn-sm">Devolver</button>
                                                @endif
                                            @endif
                                            

                                        @elseif(auth()->user()->tipo_usuario == 'Cliente')
                                            @if($item->ruta_documento == "")
                                                @if($item->informacion_estado == "no")
                                                    @if($item->habilitado == 0)
                                                        <button class="btn btn-outline-secondary btn-sm" disabled>Enviar</button>
                                                    @else
                                                        <input type="text" hidden name="devolver" value="0">
                                                        <input type="text" hidden name="habilitado" value="0">
                                                        <button class="btn btn-primary btn-sm">Enviar</button>
                                                    @endif
                                                @elseif($item->informacion_estado == "si")
                                                    @if($item->habilitado == 0)
                                                        <button class="btn btn-primary btn-sm" disabled>Enviar</button>
                                                    @else
                                                        <input type="text" hidden name="devolver" value="0">
                                                        <input type="text" hidden name="habilitado" value="0">
                                                        <button class="btn btn-primary btn-sm">Enviar</button>
                                                    @endif
                                                @else
                                                    <input type="text" hidden name="devolver" value="0">
                                                    <input type="text" hidden name="habilitado" value="0">
                                                    <button class="btn btn-primary btn-sm">Enviar</button>
                                                @endif
                                            @else
                                                @if($item->informacion_estado == "si")
                                                    <button class="btn btn-outline-secondary btn-sm" disabled>Enviar</button>
                                                @endif
                                            @endif
                                        @endif
                                    </td>

                                    <td class="table-font-size align-middle">{{$item->area}}</td>
                                </form>
                            </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
        
        @if(count($resultado7) > 0 )
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered border-secondary table-secondary">
                        <thead>
                            <tr>
                                <th rowspan="2" class="align-middle text-center table-font-size-titulo">Rendición de la cuenta pública</th>
                                <th rowspan="2" class="align-middle text-center table-font-size-titulo">¿Se cuenta con información?</th>
                                <th colspan="3" class="align-middle text-center table-font-size-titulo">Acciones</th>
                                <th rowspan="2" class="align-middle text-center table-font-size-titulo">Área que genera la información</th>
                            </tr>
                            <tr>
                                <th class="align-middle text-center table-font-size-titulo">Añadir archivo</th>
                                <th class="align-middle text-center table-font-size-titulo">Añadir comentario</th>
                                <th class="align-middle text-center table-font-size-titulo">Enviar</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach ($resultado7 as $item )
                            <tr>
                                <form method="POST" action="{{route('documentos.store',$item->id)}}" enctype="multipart/form-data">
                                    @csrf
                                    <td class="table-font-size align-middle">{{$item->requisito}}</td>
                                    <td class="align-middle text-center">
                                        @if ($item->informacion_estado == "")
                                        <select name="informacion_estado" class="form-select form-select-sm" required onchange="evaluarEstado(this)">
                                            <option value="" disabled selected>Seleccionar</option>
                                            <option value="si">si</option>
                                            <option value="no">no</option>
                                        </select>
                                        @endif
                                        @if ($item->informacion_estado == "si")
                                        <select name="informacion_estado" class="form-select form-select-sm" onchange="evaluarEstado(this)">
                                            <option value="si">si</option>
                                            <option value="no">no</option>
                                        </select>
                                        @endif
                                        @if ($item->informacion_estado == "no")
                                        <select name="informacion_estado" class="form-select form-select-sm" onchange="evaluarEstado(this)">
                                            <option value="no">no</option>
                                            <option value="si">si</option>
                                        </select>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        @if ($item->ruta_documento == "")
                                            @if($item->informacion_estado == "no")
                                                @if($item->habilitado == 1)
                                                    <input type="file" id="add_document" name="documento">
                                                @else
                                                    <label for="" class="table-font-size">Enviado Sin Documento</label>
                                                @endif
                                                
                                            @else
                                                <input type="file" id="add_document" name="documento">
                                            @endif
                                        @elseif($item->ruta_documento != "")
                                            <label for="" class="table-font-size">Su documento se encuentra en revision</label>
                                        @endif
                                    </td>

                                    <td class="align-middle text-center">
                                        <button type="button" class="btn btn-info btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editarComentario{{ $item->id }}">
                                            Comentario
                                        </button>
                        
                                        @include('Program.Documentos.comentario', ['datos' => $item])
                                    </td>

                                    <td class="align-middle text-center">
                                        @if(auth()->user()->tipo_usuario == 'Administrador')
                                            @if($item->ruta_documento == "")
                                                @if($item->informacion_estado == "no")
                                                    @if($item->habilitado == 1)
                                                        <input type="text" hidden name="devolver" value="0">
                                                        <input type="text" hidden name="habilitado" value="0">
                                                        <button class="btn btn-primary btn-sm">Enviar</button>
                                                    @else
                                                        <input type="text" hidden name="devolver" value="0">
                                                        <input type="text" hidden name="habilitado" value="1">
                                                        <button class="btn btn-secondary btn-sm">Habilitar</button>
                                                    @endif
                                                @elseif($item->informacion_estado == "si")
                                                    <input type="text" hidden name="devolver" value="1">
                                                    <input type="text" hidden name="habilitado" value="1">
                                                    <button class="btn btn-dark btn-sm">Devolver</button>
                                                @else
                                                    <input type="text" hidden name="devolver" value="0">
                                                    <input type="text" hidden name="habilitado" value="1">
                                                    <button class="btn btn-primary btn-sm">Enviar</button>
                                                @endif
                                            @else 
                                                @if($item->informacion_estado == "si")
                                                    <input type="text" hidden name="devolver" value="1">
                                                    <input type="text" hidden name="habilitado" value="1">
                                                    <button class="btn btn-dark btn-sm">Devolver</button>
                                                @endif
                                            @endif
                                            

                                        @elseif(auth()->user()->tipo_usuario == 'Cliente')
                                            @if($item->ruta_documento == "")
                                                @if($item->informacion_estado == "no")
                                                    @if($item->habilitado == 0)
                                                        <button class="btn btn-outline-secondary btn-sm" disabled>Enviar</button>
                                                    @else
                                                        <input type="text" hidden name="devolver" value="0">
                                                        <input type="text" hidden name="habilitado" value="0">
                                                        <button class="btn btn-primary btn-sm">Enviar</button>
                                                    @endif
                                                @elseif($item->informacion_estado == "si")
                                                    @if($item->habilitado == 0)
                                                        <button class="btn btn-primary btn-sm" disabled>Enviar</button>
                                                    @else
                                                        <input type="text" hidden name="devolver" value="0">
                                                        <input type="text" hidden name="habilitado" value="0">
                                                        <button class="btn btn-primary btn-sm">Enviar</button>
                                                    @endif
                                                @else
                                                    <input type="text" hidden name="devolver" value="0">
                                                    <input type="text" hidden name="habilitado" value="0">
                                                    <button class="btn btn-primary btn-sm">Enviar</button>
                                                @endif
                                            @else
                                                @if($item->informacion_estado == "si")
                                                    <button class="btn btn-outline-secondary btn-sm" disabled>Enviar</button>
                                                @endif
                                            @endif
                                        @endif
                                    </td>

                                    <td class="table-font-size align-middle">{{$item->area}}</td>
                                </form>
                            </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>

<script>
    function evaluarEstado(select){
        var fila = select.closest('tr');
        var campoFile = fila.querySelector('input[type="file"]');
        if(select.value == "no"){
            campoFile.disabled = true;
        }
        else{
            campoFile.disabled = false;
        }
    }
</script>
@endsection

