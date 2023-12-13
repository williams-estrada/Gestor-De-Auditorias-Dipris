
@extends('Layout')

@section('title')
Notificaciones
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Bandeja de notificaciones</h3>
              <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalRegistrar" style="font-family:courier;">Nuevo mensaje</button>
            </div>
            <!-- /.card-header -->
            
            <div class="card-body">
              @if (session('status'))
                  <div class="alert alert-success" role="alert">
                      {{ session('status') }}
                  </div>
              @endif

              <div class="row">
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="exampleFormControlTextarea1" class="form-label">Bandeja de entrada</label>
                    <div class="">
                      <table class="table table-striped table-responsive">
                        <thead>
                          <tr>
                            <th>TITULO</th>
                            <th>FECHA</th>
                            <th>CONTENIDO</th>
                            <th>ENVIADO POR</th>
                            <th>VER</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($mensajes as $mensaje)
                          <tr>
                            <td>{{ $mensaje->titulo }}</td>
                            <td>{{ date("d-m-Y h:m:s", strtotime($mensaje->created_at)) }}</td>
                            <td>{{ $mensaje->contenido }}</td>
                            <td>{{ $mensaje->user->usuario}}</td>
                            <td>
                              <a href="" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $mensaje->id }}" class="btn btn-sm btn-warning">Ver</a>
                            </td>

                            <!-- Modal de Registro-->
                            <div class="modal fade" id="modalEditar{{ $mensaje->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h1 class="modal-title fs-5" id="exampleModalLabel" style="font-family:courier;">Notificación</h1>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body" style="font-family:courier;">
                                          <form action="{{ route('mensaje.create') }}" method="POST">
                                              @csrf

                                                  <div class="form-group">
                                                    <label for="exampleFormControlTextarea1" class="form-label">Título</label>
                                                    <input type="text" class="form-control" name="titulo" rows="3" value="{{$mensaje->titulo}}">
                                                  </div>

                                                    <div class="form-group">
                                                      <label for="exampleFormControlTextarea1" class="form-label">Contenido</label>
                                                      <textarea class="form-control" name="contenido" rows="3">{{$mensaje->contenido}}</textarea>
                                                    </div>
                                                </div>

                                                  <div class="modal-footer">
                                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Salir</button>
                                                  </div>
                                              </div>
                                          </form>
                                      </div>
                                  </div>
                              </div>
                            </div>
                            <!-- Fin Modal de Registro-->

                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                      {{$mensajes->links("pagination::bootstrap-4")}}
                    </div>
                    
                  </div>
                </div>
              </div>
              <!-- /.row -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              Clic en botón VER para visualizar el mensaje completo.
            </div>
          </div>
          <!-- /.card -->
    </div>

<!-- Modal de Registro-->
<div class="modal fade" id="modalRegistrar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel" style="font-family:courier;">Registrar notificación</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="font-family:courier;">
                <form action="{{ route('mensaje.create') }}" method="POST">
                    @csrf
                        <div class="form-group">
                          <label>Para</label>
                          <select class="form-control" style="width: 100%;" name="usuario" required>
                            @if(auth()->user()->tipo_usuario == "Administrador")
                                <option value="3">Todos</option>
                            @endif
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}">{{ $usuario->usuario }}</option>
                            @endforeach
                          </select>
                        </div>

                        <div class="form-group">
                          <label for="exampleFormControlTextarea1" class="form-label">Título</label>
                          <input type="text" class="form-control" name="titulo" rows="3" required>
                        </div>

                          <div class="form-group">
                            <label for="exampleFormControlTextarea1" class="form-label">Contenido</label>
                            <textarea class="form-control" name="contenido" rows="3" required></textarea>
                          </div>
                      </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Registrar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Salir</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal de Registro-->
@endsection