<tr style="background-color: #c9c9c9">

    <th >
        <div class="row">
            <button class="btn btn-sm" style="color:red" data-toggle="modal" data-target="#deleteAspecto"
                onclick="deleteAspecto({{$id_aspecto}})"><i class="fas fa-times"></i></button>
            <div class="col-sm-8">
                <textarea style="font-size:small" type='text' class='form-control shadow-md' placeholder="Nombre Aspecto" 
                wire:model="aspecto.nombre" rows="3" cols="8"></textarea> 
            </div>

        </div>
        <div class="row">
            <div class="col-sm-8" style="margin-left: 27px;margin-top: 3px">
                <input style="font-size:small" type="number" class="input col-5 shadow-md"wire:model="aspecto.porcentaje">%
            </div>

        </div>
        <div class="row">
            <div class="col-8" style="margin-left: 27px">
                @error('aspecto.nombre') <small class="error text-danger">{{ $message }}</small> @enderror
                @error('aspecto.porcentaje') <small class="error text-danger">{{ $message }}</small> @enderror  
            </div>
        </div>
        @if($aspecto->criterios->first()->descripcion_avanzada!=null)
            <div class="d-flex justify-content-center" >
                <button wire:loading.attr="disabled" data-toggle="modal" data-target="#addSubcriterio"  onclick="setIdAspecto({{$id_aspecto}})"type="button" class="btn btn-sec" ><i class="far fa-lg fa-plus-square"></i><small> Subcriterio(s)</small></button>
            </div>
        @endif
        

    </th>

    @foreach($aspecto->criterios as $criterio)
        <livewire:criterio-component :criterio="$criterio" :key="time().$loop->index">

    @endforeach

    <script>
    function setIdAspecto(id){
        Livewire.emit('setIdAspecto', id)
    }
    function deleteAspecto(id) {
        var opcion = confirm("¿Está seguro?");
        if (opcion) {
            Livewire.emit('deleteAspecto', id)
            var contenedor = document.getElementById('contenedor_carga');

            contenedor.style.visibility = 'visible';
            contenedor.style.opacity = '0.9';
        }
    }
    </script>
</tr>