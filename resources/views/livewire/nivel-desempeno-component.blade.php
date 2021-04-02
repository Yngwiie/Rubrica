<th >
    <input type="text" name="nombre" class="input" wire:model="nombre">
    <div class="row">
        <div class="col-sm-6" style="margin-top:4px">
            <small style="color:white">Puntaje </small><input style="font-size:small" type="number" wire:model.lazy="nivel.puntaje" class="input col-6 shadow-md">
        </div>
        @if($nivel->ordenJerarquico>3)
            <div class="col">
                <button class="btn btn-sm btn-danger" style="margin-top:4px" wire:loading.attr="disabled" onclick="deleteNivel({{$id_nivel}})"><i class="fas fa-md fa-times"></i></button>
            </div>
        @endif
    </div> 
    <script>
    function deleteNivel(id) {
        var opcion = confirm("¿Está seguro?");
        if (opcion) {
            Livewire.emit('deleteLevel', id)
            var contenedor = document.getElementById('contenedor_carga');

            contenedor.style.visibility = 'visible';
            contenedor.style.opacity = '0.9';
        }
    }
    </script>
</th>

