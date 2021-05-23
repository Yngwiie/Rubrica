<th >
    <input type="text" name="nombre" class="input" wire:model="nombre">
    <div class="row">
        @if($rubrica->tipo_puntaje=="unico")
            <div class="col-sm-7" style="margin-top:4px">
                <small style="color:white">Puntaje </small><input style="font-size:small" type="number" wire:model="puntaje" min="0" max="1000" class="input col-5 shadow-md">
                @if($nivel->ordenJerarquico>2)
                        <button class="btn btn-sm btn-danger" style="margin-top:-2px" wire:loading.attr="disabled" onclick="deleteNivel({{$id_nivel}})"><i class="fas fa-md fa-times"></i></button>
                @endif
            </div>
            <div style="width:4px;margin-top:4px; margin-left:-14px">
                <div wire:loading>
                    <x-loading-small-white></x-loading-small-white>
                </div>
            </div>
        @elseif($rubrica->tipo_puntaje=="rango")
            <div class="col-sm-11" style="margin-top:4px">
                <small style="color:white">Mín. </small><input style="font-size:small;width:59px"  step="0.01" title="Puntaje mínimo" type="number" min="0" wire:model="puntaje_minimo" class="input shadow-md">
                <small style="color:white">Máx. </small><input style="font-size:small;width:59px" step="0.01" title="Puntaje máximo" type="number" min="0" wire:model="puntaje_maximo" class="input shadow-md">
                @if($nivel->ordenJerarquico>2)
                        <button class="btn btn-sm btn-danger" style="margin-top:-2px" wire:loading.attr="disabled" onclick="deleteNivel({{$id_nivel}})"><i class="fas fa-md fa-times"></i></button>
                @endif
                
            </div>
            <div style="width:1px;margin-top:4px;margin-left:-16px;">
                    <div wire:loading>
                        <x-loading-small-white></x-loading-small-white>
                    </div>
                </div>
        @endif
    </div> 
    @error('puntaje_minimo')
        <div class="alert-danger p-1 rounded">
            <small class="error text-danger"><strong>{{ $message }}</strong>  </small>
        </div>
    @enderror   
    @error('puntaje_maximo')
    <div class="alert-danger p-1 rounded">
         <small class="error text-danger"><strong>{{ $message }}</strong></small>  
    </div>
    @enderror
    @error('orden_rangos')
        <div class="alert-danger p-1 rounded">
            <small class="error text-danger"><strong>{{ $message }}</strong></small>         
        </div>
    @enderror
    @error('puntaje')
        <div class="alert-danger p-1 rounded">
            <small class="error text-danger"><strong>{{ $message }}</strong></small>           
        </div>
    @enderror
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

