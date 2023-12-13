
@extends('Layout')

@section('title')
    Nuevo usuario
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form id="contact" action="{{ route('usuarios.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <h3 class="text-center mb-4">Registro de Usuarios</h3>
                            <div class="mb-3">
                                <label for="usuario" class="form-label">Nombre de usuario:</label>
                                <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Nombre de usuario" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo electrónico:</label>
                                <input type="email" class="form-control" name="correo_electronico" id="correo" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <label for="tipoUsuario" class="form-label">Tipo de usuario:</label>
                                <select name="tipo_usuario" class="form-select" id="tipoUsuario" required>
                                    <option value="" disabled selected>Seleccionar</option>
                                    <option value="Cliente">Cliente</option>
                                    <option value="Administrador">Administrador</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="contraseña" class="form-label">Contraseña:</label>
                                <input type="password" class="form-control" name="contraseña" id="contraseña" placeholder="Contraseña" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

