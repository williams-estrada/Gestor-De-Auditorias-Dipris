
@extends('Layout')

@section('title')
Nueva Auditoria
@endsection

@section('content')

<!--<link href="{{ asset('css/Licitacion/create.css') }}" rel="stylesheet">-->
<div class="container">
<div class="card">
    @if(auth()->user()->tipo_usuario == 'Administrador')  
    <form id="contact" action="{{route('licitacion.store_admin')}}" method="post" class="form">
    @endif
    @if(auth()->user()->tipo_usuario == 'Cliente')  
    <form id="contact" action="{{route('licitacion.store')}}" method="post" class="form">
    @endif
    <div class="card-body">
        @csrf
        <h3>Registro de Auditorias</h3>
        <div class="row mt-4">
            @if(auth()->user()->tipo_usuario == 'Administrador')
            <div class="col">
                <label class="form-label">Usuario:</label>
                <select name="usuario_id" class="form-select">
                    <option value="" disabled selected>Seleccionar</option>
                    @foreach($datos as $item)
                    <option value="{{$item->id}}">{{$item->usuario}}</option>
                    @endforeach
                </select>
            </div>
            @endif
            
            <div class="col">
                <label class="form-label">Nombre: </label>
                <input name="nombre" placeholder="Nombre de la licitación" type="text" tabindex="1" required autofocus class="form-control">
            </div>

            <div class="col">
                <label class="form-label">Folio: </label> 
                <input name="folio" placeholder="Folio" type="text" tabindex="2" required class="form-control">

            </div>
        </div><!--./row-->
        
        <div class="row mt-4">
            <div class="col">
                <label class="form-label">Area de la licitación: </label>
                <select name="area" class="form-select">
                    <option value="" disabled selected>Seleccionar</option>
                    <option value="Documentos a integrar">Documentos a integrar</option>
                    <option value="Contratacion de personal">Contratacion de personal</option>
                    <option value="Compras menores">Compras menores</option>
                    <option value="Invitacion restringida">Invitacion restringida</option>
                    <option value="Adjudicacion directa">Adjudicacion directa</option>
                    <option value="Licitacion publica">Licitacion publica</option>
                </select> 
            </div>   
            <div class="col">
            <label class="form-label">Fecha de elaboración: </label>
            <input name="fecha_elaboracion" type="date" tabindex="4" required class="form-control">
            </div>

            <div class="col">
            <label class="form-label">Fecha de recepción: </label>
            <input name="fecha_recepcion" type="date" tabindex="4" required class="form-control">
            </div>
        </div><!--./row-->

        <div class="row  mt-4">
            <div class="col">
                <label class="form-label">Fecha de documentos: </label>
                <select name="fecha_documentos" class="form-select">
                    <option value="" disabled selected>Seleccionar</option>
                    <option value="Fecha de elaboracion">Fecha de elaboración</option>
                    <option value="Fecha de recepcion">Fecha de recepción</option>
                </select>
            </div>
            <div class="col">
                <label class="form-label">Plazo de días: </label>
                <input name="plazo_dias" placeholder="Plazo de días" type="text" tabindex="2" required autofocus class="form-control">
            </div>

            <div class="col">
                <label class="form-label">Formato de fecha: </label>
                <select name="formato_fecha" class="form-select">
                    <option value="" disabled selected>Seleccionar</option>
                    <option value="Habiles">Habiles</option>
                    <option value="Naturales">Naturales</option>
                </select>
            </div>
            
        </div><!--./row-->
        <div class="text-center">
        <button name="guardar" type="submit" class="btn  btn-primary mt-4">Guardar</button>
        </div>

    </div>
    </form>
</div><!--./card-->
</div>
@endsection