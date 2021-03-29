<div class="container p-4" id="contenedor">
    <!-- <input type="text" class="form-control" wire:model.debounce.500ms="text_sub_criterio"> -->
    @include('mensajes-flash')
    <form>
        <div class="form-group row">
            <label for="titulo" class="col-sm-2 col-form-label"><strong>Título</strong></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="titulo" wire:model.defer="rubrica.titulo" placeholder="Titulo">
            </div>
        </div>
        <div class="form-group row">
            <label for="Descripcion" class="col-sm-2 col-form-label"><strong>Descripción</strong></label>
            <div class="col-sm-5">
                <textarea type="text" class="form-control" id="Descripcion" wire:model.defer="rubrica.descripcion" placeholder="Descripción"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="Descripcion" class="col-sm-2 col-form-label"><strong>Evaluación Asociada</strong></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="Descripcion" disabled placeholder="Evaluación" value="{{$rubrica->evaluacion->nombre}} - {{$rubrica->evaluacion->modulo->nombre}}">
            </div>
        </div>
    </form>
    <div class="mb-2">
        <button onclick="anadirDimension()" class="btn btn-md btn-sec add-dim"><i class="far fa-lg fa-plus-square"></i> Añadir Dimensión</button>
        <button class="btn btn-success" onclick="emitir()">Guardar Cambios</button>
    </div>
    <hr class="bg-dark">
    <div wire:key="foo">
    @foreach ($rubrica->dimensiones as $dimension)
        <button type="button" class="btn btn-sec" data-toggle="tooltip" data-html="true" title="Existen dos opciones para crear un aspecto.
        El primero de ellos creara un aspecto sin ninguna configuración previa, en cambio el añadir aspecto avanzado se podran asignar los subcriterios
        del aspecto, los cuales se clonaran en cada uno de los niveles.">
            <i class="far fa-lg fa-question-circle"></i>
        </button>
        <button type="button" onclick="anadirAspecto({{$dimension->id}})" class="btn btn-md btn-sec add-row"><i class="far fa-lg fa-plus-square"></i> Añadir Aspecto</button>
        <button type="button" class="btn btn-md btn-sec add-row" data-toggle="modal" data-target="#addAspectoCriterios" wire:click="setDimension({{$dimension->id}})"><i class="far fa-lg fa-plus-square"></i> Añadir Aspecto Avanzado</button>
        <button type="button" class="btn btn-md btn-sec add-row" wire:click="storeNivel({{$dimension->id}})"><i class="far fa-lg fa-plus-square"></i> Añadir Nivel</button>
        <button type="button" class="btn btn-md btn-sec add-row" onclick="deleteDimension({{$dimension->id}})" style="color:red">
            <i class="fas fa-lg fa-times"></i> Eliminar Dimensión</button>
        
        <div style="overflow-x:auto;">
            <table class="table shadow" id="table{{$dimension->id}}">
                <thead class="bg-secondary">
                    <tr>
                        <livewire:dimension-component :dimension="$dimension" :key="time().$loop->index">
                        <!-- @livewire('dimension-component',['dimension' => $dimension],key($loop->index)) -->

                        @foreach($dimension->nivelesDesempeno as $nivel)
                            <livewire:nivel-desempeno-component :nivel="$nivel" :key="time().$loop->index">
                            <!-- @livewire('nivel-desempeno-component',['nivel' => $nivel], key($loop->index)) -->
                        @endforeach
                    </tr>
                </thead>
                <tbody>

                    @foreach($dimension->aspectos as $aspecto)
                        <livewire:aspecto-component :aspecto="$aspecto" :key="time().$loop->index">

                    @endforeach
                </tbody>
            </table>
        </div>
        <br>
    @endforeach
    </div>
    <!-- Modal Eliminar dimension -->
    <div wire:ignore.self class="modal fade" id="deleteDimension" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Eliminar Dimensión</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro de eliminar esta dimension?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="deleteDimension()">Eliminar Dimension</button>

                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Añadir Aspecto -->
    <div wire:ignore.self class="modal fade" id="addAspectoCriterios" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Añadir Aspecto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="aspectonombre" class="col-sm-2 col-form-label">Nombre Aspecto</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nombre_aspecto" wire:model.defer="nombre_aspecto" placeholder="Nombre">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <input type="text" class="form-control" placeholder="Descripción sub criterio" wire:model.defer="sub_criterio">
                        </div>
                        <div class="col-md-3 mb-3">
                            <select class="custom-select" required wire:model.defer="magnitud_subcriterio">
                                <option wire:ignore hidden value="">Seleccione Nivel Magnitud</option>
                                <option wire:ignore value="porcentaje1">Porcentajes [30%,60%,80%,etc.]</option>
                                <!-- <option wire:ignore value="2">Porcentajes [100%,60%,30%,etc.]</option> -->
                                <option wire:ignore value="none">Sin magnitud</option>
                            </select>
                        </div>
                        
                        <div class="col col-lg-2">
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" placeholder="1" data-toggle="tooltip" data-placement="top"
                                title="Porcentaje del subcriterio" wire:model.defer="porcentaje_subcriterio">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                        <!-- <label class="col-auto col-form-label" for="porcentaje">%</label> -->
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-sec" wire:click="addText()"><i class="far fa-lg fa-plus-square"></i> Añadir sub criterio</button>
                        </div>

                    </div>
                    <!-- <div class="input-group mb-1">
                        <input type="text" class="form-control" placeholder="Descripción sub criterio" wire:model.lazy="sub_criterio">
                        <div class="input-group-append">
                            <button class="btn btn-sec" wire:click="addText()"><i class="far fa-lg fa-plus-square"></i> Añadir sub criterio</button>
                        </div>
                    </div> -->
                    <hr class="bg-dark">
                    <ul class="list-group">
                        @foreach($sub_criterios as $item)
                            <li class="list-group-item" wire:key="{{$loop->index}}">
                            <div class="input-group mb-1">
                                <input class="form-control" wire:model.lazy="sub_criterios.{{$loop->index}}.text" type="text"/>
                                <select class="custom-select" required wire:model.defer="sub_criterios.{{$loop->index}}.magnitud">
                                    <option wire:ignore hidden value="">Seleccione Nivel Magnitud</option>
                                    <option wire:ignore value="porcentaje1">Porcentajes [30%,60%,80%,etc.]</option>
                                    <!-- <option wire:ignore value="2">Porcentajes [100%,60%,30%,etc.]</option> -->
                                    <option wire:ignore value="none">Sin magnitud</option>
                                </select>
                                <input type="number" class="form-control" placeholder="%" data-toggle="tooltip" data-placement="top"
                                title="Porcentaje del subcriterio" wire:model.defer="sub_criterios.{{$loop->index}}.porcentaje">
                                <div class="input-group-append">
                                    <button class="btn btn-danger" wire:click="removeText({{$loop->index}})"><i class="fas fa-lg fa-times"></i> Eliminar</button>
                                </div>
                            </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="storeAspectoAvanzado()">Crear Aspecto</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 5000);
    
</script>

<script>

    function storeAspectoAvanzado(){
        var contenedor = document.getElementById('contenedor_carga');

        contenedor.style.visibility = 'visible';
        contenedor.style.opacity = '0.9';
        Livewire.emit('storeAspectoAvanzado')
    }
    function emitir() {

        Livewire.emit('update')
        var contenedor = document.getElementById('contenedor_carga');

        contenedor.style.visibility = 'visible';
        contenedor.style.opacity = '0.9';
    }

    function anadirAspecto(id) {
        var contenedor = document.getElementById('contenedor_carga');

        contenedor.style.visibility = 'visible';
        contenedor.style.opacity = '0.9';
        Livewire.emit('storeAspecto', id)

    }

    function anadirDimension(id) {
        var contenedor = document.getElementById('contenedor_carga');

        contenedor.style.visibility = 'visible';
        contenedor.style.opacity = '0.9';
        Livewire.emit('storeDimension')

    }

    function deleteDimension(id) {
        var opcion = confirm("¿Está Seguro?")
        if (opcion == true) {
            var contenedor = document.getElementById('contenedor_carga');

            contenedor.style.visibility = 'visible';
            contenedor.style.opacity = '0.9';
            Livewire.emit('deleteDimension', id)
        }


    }
</script>