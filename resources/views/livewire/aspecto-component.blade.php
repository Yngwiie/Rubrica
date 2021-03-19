<tr style="background-color: #c9c9c9">

    <th>
        <div class="row">
            <button class="btn btn-sm" style="color:red" data-toggle="modal" data-target="#deleteAspecto"
                onclick="deleteAspecto({{$id_aspecto}})"><i class="fas fa-times"></i></button>
            <div class="col-sm-8">
                <input type='text' class='form-control shadow-md' wire:model="aspecto.nombre">
                
            </div>

        </div>
        <div class="row">
            <div class="col-sm-8" style="margin-left: 27px">
                <input type="number" class="input col-5 shadow-md"wire:model="aspecto.porcentaje">%
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
        <!-- @livewire('criterio-component',['criterio' => $criterio],key($loop->index)) -->

    @endforeach

    <!-- Modal Eliminar  -->
    <!-- <div class="modal fade" id="deleteAspecto" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Eliminar Aspecto</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>¿Está seguro de eliminar este aspecto{{$id_aspecto}}?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="deleteAspecto()">Eliminar Aspecto</button>

                                </div>
                            </div>
                        </div>
                    </div>  -->
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