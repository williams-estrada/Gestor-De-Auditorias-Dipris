@extends('Layout')

@section('title')
Actualizar Auditoria
@endsection
<!--<link href="{{ asset('css/Licitacion/create.css') }}" rel="stylesheet">-->
@section('content')
<div class="container"> 
<div class="card"> 
<div class="card-body">
    <form id="contact" action="{{route('licitacion.update',$licitacion->id)}}" method="post">
        @csrf
        @method("PUT")
        <h3>Actualizar Auditoria</h3>
        <div class="row mt-4">
            <div class="col">
                <label>Nombre: 
                </label>
            <input value="{{$licitacion->nombre}}" name="nombre" placeholder="Nombre de la licitacion" type="text" tabindex="1" required autofocus class="form-control">
            </div>
            <div class="col">
                <label>Folio: 
                </label>
            <input value="{{$licitacion->folio}}" name="folio" placeholder="Folio" type="text" tabindex="2" required class="form-control">
            </div>
        </div>
        <div class="row mt-4">
            <div class="col">
            <label class="form-label">Fecha de elaboración: </label>
            <input value="{{$licitacion->fecha_elaboracion}}" name="fecha_elaboracion"type="date" tabindex="4" required class="form-control">
            </div>
    
            <div class="col">
            <label>Fecha de recepción: </label>
            <input value="{{$licitacion->fecha_recepcion}}" name="fecha_recepcion" type="date" tabindex="4" required class="form-control">
            </div>
        </div>
        <div class="row mt-4">
            <div class="col">
            <label for="plazo_dias"> Plazo de dias</label>
            <input value="{{$licitacion->plazo_dias}}" name="plazo_dias" placeholder="Plazo de dias" type="text" tabindex="2" required class="form-control">
            </div>
       
            <div class="col">
            <label>Formato de fecha: 
            </label>
                <select name="formato_fecha" class="form-select">
                    <option value="Habiles"   @if($licitacion->formato_fecha == 'Habiles') selected="selected"@endif>Habiles</option>
                    <option value="Naturales" @if($licitacion->formato_fecha == 'Naturales') selected="selected"@endif>Naturales</option>
                </select>
            </div>
        
        <div>
            <div class="text-center">    
            <button name="guardar" type="submit" class="btn  btn-primary mt-4">Guardar</button>
        </div>
    </form>
</div>
</div>
@endsection