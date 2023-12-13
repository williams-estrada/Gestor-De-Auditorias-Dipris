@extends('Layout')

@section('title')
Auditoria de documentos a integrar al expediente del proyecto
@endsection

<link href="{{ asset('css/documentos.css') }}" rel="stylesheet">

@section('content')
<div class="container">
    <h1>Progreso de los anexos:{{ session("porcentaje") }}%
        <progress max="100" value="{{ session("porcentaje") }}" class="php">
            <!-- ... Código para estilos de la barra de progreso ... -->
        </progress>
    </h1>
    <table class="table">
        <thead>
            <tr>
                <th rowspan="2">Planeación</th>
                <th rowspan="2">Se cuenta con informacion</th>
                <th colspan="3">Acciones</th>
                <th rowspan="2">Área que genera la informacion</th>
            </tr>
            <tr>
                <th>Añadir archivo</th>
                <th>Añadir comentario</th>
                <th>Enviar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($documento1 as $item )
            <tr>
                <form method="POST" action="{{ route('documentos.store', $item->id) }}" enctype="multipart/form-data">
                    @csrf
                    <td>{{ $item->requisito }}</td>
                    <td>
                        <!-- Código para el campo de selección -->
                        @if ($item->informacion_estado == "")
                        <select name="informacion_estado" required onchange="evaluarEstado(this)">
                            <option value="" disabled selected>Seleccionar</option>
                            <option value="si">si</option>
                            <option value="no">no</option>
                        </select>
                        @elseif ($item->informacion_estado == "si")
                        <select name="informacion_estado" onchange="evaluarEstado(this)">
                            <option value="si">si</option>
                            <option value="no">no</option>
                        </select>
                        @elseif ($item->informacion_estado == "no")
                        <select name="informacion_estado" onchange="evaluarEstado(this)">
                            <option value="no">no</option>
                            <option value="si">si</option>
                        </select>
                        @endif
                    </td>
                    <td>
                        <!-- Código para subir archivos -->
                        @if ($item->ruta_documento == "")
                        @if ($item->informacion_estado == "no")
                        @if ($item->habilitado == 1)
                        <input type="file" id="add_document" name="documento"><br><br>
                        @else
                        <label for="">Enviado Sin Documento</label>
                        @endif
                        @else
                        <input type="file" id="add_document" name="documento"><br><br>
                        @endif
                        @elseif ($item->ruta_documento != "")
                        <label for="">Su documento se encuentra en revisión</label>
                        @endif
                    </td>
                    <td>
                        <!-- Modal para editar comentario -->
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editarComentario{{ $item->id }}">
                            Comentario
                        </button>

                        <div class="modal fade" id="editarComentario{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Editar Comentario</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text" class="form-control" name="comentario" value="{{ $item->comentario }}">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
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
                        <button disabled>Enviar</button>
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
                        <button disabled>Enviar</button>
                        @endif
                        @endif
                        @endif
                    </td>
                    <td>{{ $item->area }}</td>
                </form>
            </tr>
            @endforeach
        </tbody>
    </table>
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
