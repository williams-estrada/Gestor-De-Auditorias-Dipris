
@extends('Layout')

@section('title', 'Usuarios registrados')


@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-responsive" style="font-size: 14px">
                <thead class="table-secondary text-center">
                    <tr>
                        <th>Nombre</th>
                        <th>Correo electrónico</th>
                        <th>Tipo de usuario</th>
                        <th>Contraseña</th>
                        <th colspan="5" class="text-center">Acciones</th>
                    </tr>
                </thead>
                @foreach($datos as $item)
                    <tr>
                        <td style="text-align: center;">{{$item->usuario}}</td>
                        <td style="text-align: center;">{{$item->correo_electronico}}</td>
                        <td style="text-align: center;">{{$item->tipo_usuario}}</td>
                        <td style="text-align: center;">**********</td>
                        <td style="text-align: center;">
                            <td class="text-center">
                                <form action="{{route('usuarios.edit', $item->id)}}" method="GET" class="d-flex justify-content-center">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Actualizar datos</button>
                                </form>
                            </td>
                            <td class="text-center">
                                <form action="{{route('usuarios.delete', $item->id)}}" method="POST" class="d-flex justify-content-center">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Desea eliminar el usuario?')">Borrar usuario</button>
                                </form>
                            </td>
                            
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection
