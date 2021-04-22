<th >
    <p style="width:200px;color:white">{{$nombre}}</p>
    
    <div class="row">
        @if($rubrica->tipo_puntaje=="unico")
            <div class="col-sm-10" style="margin-top:4px">
                <small style="color:white">Puntaje {{$puntaje}}</small>
            </div>
        @elseif($rubrica->tipo_puntaje=="rango")
            <div class="col-sm-12" style="margin-top:4px">
                <small style="color:white">Mín. </small><input style="font-size:small"  step="0.01" title="Puntaje mínimo" type="number" min="0" wire:model.debounce.900ms="puntaje_minimo" class="input col-3 shadow-md">
                <small style="color:white">Máx. </small><input style="font-size:small" step="0.01" title="Puntaje máximo" type="number" min="0" wire:model.debounce.900ms="puntaje_maximo" class="input col-3 shadow-md">
                @if($nivel->ordenJerarquico>3)
                        <button class="btn btn-sm btn-danger" wire:loading.attr="disabled" onclick="deleteNivel({{$id_nivel}})"><i class="fas fa-md fa-times"></i></button>
                @endif
            <div>
        @endif
    </div> 
    <div class="row">
        @error('puntaje_minimo') <small class="error text-warning">{{ $message }}</small> @enderror        
    </div>
    <div class="row">
        @error('puntaje_maximo') <small class="error text-warning">{{ $message }}</small> @enderror        
    </div>
    <div class="row">
        @error('orden_rangos') <small class="error text-warning">{{ $message }}</small> @enderror         
    </div>
    <div class="row">
        @error('puntaje') <small class="error text-warning">{{ $message }}</small> @enderror         
    </div>
    <script>
    function deleteNivel(id) {
        var opcion = confirm("¿Está seguro de eliminar el nivel completo?");
        if (opcion) {
            Livewire.emit('deleteLevel', id)
            var contenedor = document.getElementById('contenedor_carga');

            contenedor.style.visibility = 'visible';
            contenedor.style.opacity = '0.9';
        }
    }
    </script>
</th>