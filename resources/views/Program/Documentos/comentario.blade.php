<div class="modal fade" id="editarComentario{{ $datos->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar Comentario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            @csrf
            <textarea 
                class="form-control" 
                placeholder="digite comentario..." 
                autofocus 
                name="comentario-{{$datos->id}}"
                id="comentario-{{$datos->id}}" 
                rows="6">{{ $datos->comentario }}</textarea>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" id="btn-comentario-{{ $datos->id }}" class="btn btn-primary">Guardar Cambios</button>
        </div>
            
        </div>
    </div>
    
</div>

<script>

    $('#btn-comentario-{{ $datos->id }}').click(function() {

        const url = '/documentos-comentario/' + {{ $datos->id }};
        const datos = {
            comentario: $('#comentario-{{$datos->id}}').val(),
        };
        
        const token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
        url: url,
        type: 'POST',
        data: { ...datos, _token: token }, 
        dataType: 'json',
        success: function(data) {
            location.reload();
        },
        error: function(error) {
            console.error('Error al realizar la solicitud:', error);
        }
        });
    })
</script>