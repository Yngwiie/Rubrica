<div class="container p-4" id="contenedor">
    @include('mensajes-flash')
    <form>
        <div class="form-group row">
            <label for="titulo" class="col-sm-2 col-form-label"><strong>Título</strong></label>
            <div class="col-sm-5">
                <input type="text" style="font-size:small" class="form-control" id="titulo" wire:model.defer="rubrica.titulo" placeholder="Titulo">
            </div>
        </div>
        <div class="form-group row">
            <label for="Descripcion" class="col-sm-2 col-form-label"><strong>Descripción</strong></label>
            <div class="col-sm-5">
                <textarea type="text" style="font-size:small" class="form-control" id="Descripcion" wire:model.defer="rubrica.descripcion" placeholder="Descripción" rows="6"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="Descripcion" class="col-sm-2 col-form-label"><strong>Evaluación Asociada</strong></label>
            @if($rubrica->plantilla != 1)
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="Descripcion" disabled placeholder="Evaluación" value="{{$rubrica->evaluacion->nombre}} - {{$rubrica->evaluacion->modulo->nombre}}">
                </div>
            @endif
        </div>
        <div class="form-group row">
            <label for="Descripcion" class="col-sm-2 col-form-label"><strong>Escala de notas</strong></label>
            <div class="col-sm-5">
                <select class="custom-select" required wire:model.defer="rubrica.escala_notas">
                    <option hidden value="">Seleccione la escala de notas</option>
                    <option value="1-5">1-5</option>
                    <option value="1-6">1-6</option>
                    <option value="1-7">1-7</option>
                    <option value="1-10">1-10</option>
                    <option value="1-12">1-12</option>
                    <option value="1-20">1-20</option>
                    <option value="1-100">1-100</option>
                </select>
            </div>
            
        </div>
        <div>
        <div class="form-group row">
            <label for="Descripcion" class="col-sm-2 col-form-label"><strong>Tipo de puntajes</strong></label>
            <div class="col-sm-5">
                <select class="custom-select" required wire:model.lazy="rubrica.tipo_puntaje">
                    <option hidden value="">Seleccione la escala de notas</option>
                    <option value="unico">Puntaje único</option>
                    <option value="rango">Rango de notas</option>
                </select>
            </div>
        </div>
        </div>
    </form>
    <div class="col-8 mb-2">
            <div class="row">
                @error('rubrica.titulo') <small class="error text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="row">
                @error('rubrica.descripcion') <small class="error text-danger">{{ $message }}</small> @enderror  
            </div>
            <div class="row">
                @error('rubrica.escala_notas') <small class="error text-danger">{{ $message }}</small> @enderror  
            </div>  
    </div>
    <div class="mb-2">
        <button onclick="anadirDimension()" class="btn btn-md btn-sec add-dim"><i class="far fa-lg fa-plus-square"></i> Añadir Dimensión</button>
        
        <button class="btn btn-success" wire:loading.attr="disabled" wire:click="update">Guardar Cambios</button>
        <div wire:loading wire:target="update" >
            <x-loading-md/>
        </div>
    </div>
    <hr class="bg-dark">
    <div wire:key="foo">
    @foreach ($rubrica->dimensiones as $dimension)
        <button type="button" class="btn btn-sec" data-tooltip="tooltip" data-html="true" title="Existen dos opciones para crear un aspecto.
        El primero de ellos creará un aspecto sin ninguna configuración previa, en cambio el añadir aspecto avanzado se podran asignar los subcriterios
        del aspecto, los cuales se clonaran en cada uno de los niveles.">
            <i class="far fa-lg fa-question-circle"></i>
        </button>
        <button type="button" onclick="anadirAspecto({{$dimension->id}})" class="btn btn-md btn-sec add-row"><i class="far fa-lg fa-plus-square"></i> Añadir Aspecto Normal</button>
        <button type="button" class="btn btn-md btn-sec add-row" data-toggle="modal" data-target="#addAspectoCriterios" wire:click="setDimension({{$dimension->id}})"><i class="far fa-lg fa-plus-square"></i> Añadir Aspecto Avanzado</button>
        @if($dimension->nivelesDesempeno->count() < 7)
            <button type="button" class="btn btn-md btn-sec add-row" onclick="storeNivel({{$dimension->id}})"><i class="far fa-lg fa-plus-square"></i> Añadir Nivel</button>
        @else
            <button type="button" disabled class="btn btn-md btn-sec add-row"><i class="far fa-lg fa-plus-square"></i> Añadir Nivel</button>
        @endif
        <button type="button" class="btn btn-md btn-sec add-row" data-toggle="modal" data-target="#deleteDimension" wire:click="setDimension({{$dimension->id}})" style="color:red">
            <i class="fas fa-lg fa-times"></i> Eliminar Dimensión</button>
        <div  class="double-scroll shadow" style="overflow-x:auto;">
            <table class="table shadow " id="table{{$dimension->id}}">
                <thead class="bg-secondary">
                    <tr>
                        <livewire:dimension-component :dimension="$dimension" :key="time().$loop->index">
                        <!-- @livewire('dimension-component',['dimension' => $dimension],key($loop->index)) -->

                        @foreach($dimension->nivelesDesempeno as $nivel)
                            <livewire:nivel-desempeno-component :nivel="$nivel" :rubrica="$rubrica" :key="time().$loop->index">
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
                    <p>¿Está seguro de eliminar esta dimensión?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-danger" onclick="pantallacarga()" data-dismiss="modal" wire:click="deleteDimension()" >Eliminar Dimension</button>
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
                    <hr class="bg-dark">
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <input type="text" class="form-control" placeholder="Descripción sub criterio" wire:model.defer="sub_criterio">
                        </div>
                        <div class="col-md-3 mb-3">
                            <select class="custom-select" required wire:model.defer="magnitud_subcriterio">
                                <option wire:ignore hidden value="">Seleccione tipo de Magnitud</option>
                                <option wire:ignore value="porcentaje1">Porcentajes Ascendentes [30%,60%,80%,etc.]</option>
                                <option wire:ignore value="porcentaje2">Porcentajes Descendentes[100%,80%,60%,etc.]</option>
                                <option wire:ignore value="escala">Escala Numerica/cantidad [1,2,3,4,etc.]</option>
                                <option wire:ignore value="rango_asc">Rango Ascendente [{0->1},{2->3},{4->5},etc.]</option>
                                <option wire:ignore value="none">Sin magnitud</option>
                            </select>
                        </div>
                        
                        <div class="col col-lg-2">
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" placeholder="1" data-toggle="tooltip" data-placement="top"
                                title="Porcentaje de importancia del subcriterio." wire:model.defer="porcentaje_subcriterio">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-sec" wire:click="addSubcriterio()"><i class="far fa-lg fa-plus-square"></i> Añadir sub criterio</button>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">
                            @error('subcriterio_porcentaje') <small class="error text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">
                            @error('subcriterio_descripcion') <small class="error text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">
                            @error('subcriterio_magnitud') <small class="error text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <hr class="bg-dark">
                    <ul class="list-group">
                        @foreach($sub_criterios as $item)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col">
                                    <p>{{$item['text']}}</p>
                                </div>

                                <div class="col">
                                    @if($item['magnitud']=="porcentaje1")
                                        <p>Porcentajes Ascendentes [30%,60%,80%,etc.]</p>
                                    @elseif($item['magnitud']=="escala")
                                        <p>Escala Numerica [1,2,3,4,etc.]</p>
                                    @elseif($item['magnitud']=="porcentaje2")
                                        <p>Porcentajes Descendentes[100%,80%,60%,etc.]</p>
                                    @elseif($item['magnitud']=="rango_asc")
                                        <p>Rango Ascendente [{0->1},{2->3},{4->5},etc.]</p>
                                    @else
                                        <p>Sin Magnitud</p>
                                    @endif
                                </div>

                                <div class="col">
                                    <p>{{$item['porcentaje']}}%</p>
                                </div>

                                <div class="col">
                                    <button class="btn btn-danger" wire:loading.attr="disabled" wire:click="removeSubcriterio({{$loop->index}})"><i class="fas fa-lg fa-times"></i> Eliminar</button>
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
     <!-- Modal Añadir Subcriterio -->
     <div wire:ignore.self class="modal fade" id="addSubcriterio" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Añadir Subcriterio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <input type="text" class="form-control" placeholder="Descripción sub criterio" wire:model.defer="sub_criterio">
                        </div>
                        <div class="col-md-3 mb-3">
                            <select class="custom-select" required wire:model.defer="magnitud_subcriterio">
                                <option wire:ignore hidden value="">Seleccione tipo de Magnitud</option>
                                <option wire:ignore value="porcentaje1">Porcentajes Ascendentes[30%,60%,80%,etc.]</option>
                                <option wire:ignore value="porcentaje2">Porcentajes Descendentes[100%,80%,60%,etc.]</option>
                                <option wire:ignore value="escala">Escala Numerica [1,2,3,4,etc.]</option>
                                <option wire:ignore value="rango_asc">Rango Ascendente [{0->1},{2->3},{4->5},etc.]</option>
                                <option wire:ignore value="none">Sin magnitud</option>
                            </select>
                        </div>
                        
                        <div class="col col-lg-2">
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" placeholder="1" 
                                title="Porcentaje de importancia del subcriterio." wire:model.defer="porcentaje_subcriterio">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                        <!-- <label class="col-auto col-form-label" for="porcentaje">%</label> -->
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-sec" wire:click="addSubcriterio()"><i class="far fa-lg fa-plus-square"></i> Añadir sub criterio</button>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">
                            @error('subcriterio_porcentaje') <small class="error text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">
                            @error('subcriterio_descripcion') <small class="error text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">
                            @error('subcriterio_magnitud') <small class="error text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <hr class="bg-dark">
                    <ul class="list-group">
                        @foreach($sub_criterios as $item)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col">
                                    <p>{{$item['text']}}</p>
                                </div>

                                <div class="col">
                                    @if($item['magnitud']=="porcentaje1")
                                        <p>Porcentajes [30%,60%,80%,etc.]</p>
                                    @elseif($item['magnitud']=="escala")
                                        <p>Escala Numerica [1,2,3,4,etc.]</p>
                                    @elseif($item['magnitud']=="porcentaje2")
                                        <p>Porcentajes Descendentes[100%,80%,60%,etc.]</p>
                                    @elseif($item['magnitud']=="rango_asc")
                                        <p>Rango Ascendente [{0->1},{2->3},{4->5},etc.]</p>
                                    @else
                                        <p>Sin Magnitud</p>
                                    @endif
                                </div>

                                <div class="col">
                                    <p>{{$item['porcentaje']}}%</p>
                                </div>

                                <div class="col">
                                    <button class="btn btn-danger" wire:loading.attr="disabled" wire:target="" wire:click="removeSubcriterio({{$loop->index}})"><i class="fas fa-lg fa-times"></i> Eliminar</button>
                                </div>
                                
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="storeSubcriterios()">Crear subcriterio(s)</button>
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
    function storeSubcriterios(){
        var contenedor = document.getElementById('contenedor_carga');

        contenedor.style.visibility = 'visible';
        contenedor.style.opacity = '0.9';
        Livewire.emit('addSubcriterios')
    }
    function pantallacarga(){
        var contenedor = document.getElementById('contenedor_carga');

        contenedor.style.visibility = 'visible';
        contenedor.style.opacity = '0.9';
    }
    function storeNivel(id){
        var contenedor = document.getElementById('contenedor_carga');

        contenedor.style.visibility = 'visible';
        contenedor.style.opacity = '0.9';
        Livewire.emit('storeNivel',id)
    }
    function storeAspectoAvanzado(){
        var contenedor = document.getElementById('contenedor_carga');

        contenedor.style.visibility = 'visible';
        contenedor.style.opacity = '0.9';
        Livewire.emit('storeAspectoAvanzado')
    }
    function emitir() {

        Livewire.emit('update')
        
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