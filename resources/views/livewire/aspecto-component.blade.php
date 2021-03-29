<tr style="background-color: #c9c9c9">

    <th >
        <div class="row">
            <button class="btn btn-sm" style="color:red" data-toggle="modal" data-target="#deleteAspecto"
                onclick="deleteAspecto({{$id_aspecto}})"><i class="fas fa-times"></i></button>
            <div class="col-sm-8">
                <input style="font-size:small" type='text' class='form-control shadow-md' wire:model="aspecto.nombre">
                
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

    </th>

    @foreach($aspecto->criterios as $criterio)
        <livewire:criterio-component :criterio="$criterio" :key="time().$loop->index">

    @endforeach

    <script>
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