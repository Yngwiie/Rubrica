<div class="container">
    
    @include('mensajes-flash')
    <div class="max-w-9xl mx-auto py-10 sm:px-6 lg:px-8">
    {{ Breadcrumbs::render('misRubricas')}}
        <div class="card shadow-lg">

            <div class="card-header">
                <h3>Mis Rúbricas</h3>

            </div>
            <div class="card-body">


                <div class="d-flex justify-content-between">
                    <div class="col-md-4">
                        <!-- <button class="btn btn-md btn-sec" data-toggle="modal" data-target="#addModulo"><i
                                class="far fa-lg fa-plus-square"></i> Nuevo Módulo</button> -->
                    </div>
                     <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Buscar..." wire:model="searchTerm" />
                    </div>
                </div>


                <table style="margin-top:10px" class="table table-responsive-md table-striped table-hover">
                    <thead class="thead-secondary">
                        <tr>
                            <th scope="col">Título</th>
                            <th scope="col">Evaluación</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach($rubricas as $rubrica)
                                <tr>
                                    <td><i class="far fa-lg fa-list-alt"></i> {{$rubrica->titulo}}</td>
                                    <td>{{$rubrica->evaluacion->nombre}} - {{$rubrica->evaluacion->modulo->nombre}}</td>
                                    <td>
                                        <a type="button" class="btn btn-outline-secondary" href="{{route('apply.rubrica',$rubrica->id)}}"><i class="fas fa-clipboard-check"></i> Aplicar</a>
                                        <a class="btn btn-sm btn-sec" href="{{route('rubric.edit',$rubrica->id)}}" title="Editar Rúbrica"><i class="far fa-lg fa-edit"></i></a>
                                        <a class="btn btn-sm btn-sec" href="{{route('estadisticas',['id_evaluacion' => $rubrica->id_evaluacion,'misRubricas' => 1])}}" title="Estadísticas"><i class="far fa-lg fa-chart-bar"></i></a>
                                        <button class="btn btn-sm btn-sec" title="Exportar Rúbrica" data-toggle="modal" data-target="#exportRubrica" wire:click="setIdRubrica({{$rubrica->id}})">
                                            <i class="fas fa-lg fa-file-download"></i></button>
                                        <button class="btn btn-sm btn-sec" id="res" title="Copiar Rúbrica" data-tooltip="tooltip" data-toggle="modal" onclick="closeT()" data-target="#copyRubrica" wire:click="setIdRubrica({{$rubrica->id}})"><i class="far fa-lg fa-copy"></i></button>
                                        <button class="btn btn-sm btn-sec" data-toggle="modal" onclick="closeT()" data-target="#deleteRubrica" wire:click="delete({{$rubrica->id}})" 
                                        title="Eliminar Rúbrica"><i style="color:red " class="far fa-lg fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                    </tbody>
                </table>
                {{ $rubricas->onEachSide(1)->links('vendor.pagination.tailwind') }}
            </div>

        </div>

        <script>
            window.setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500, function() {
                    $(this).remove();
                });
            }, 4000);
        </script>
    </div>
    <!-- Modal Eliminar  -->
    <div wire:ignore.self class="modal fade" id="deleteRubrica" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Eliminar Rúbrica</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro de eliminar esta rúbrica?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-danger" wire:click="destroy()">Eliminar Rúbrica</button>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal Exportar  -->
    <div wire:ignore.self class="modal fade" id="exportRubrica" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Exportar Rúbrica</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Formato</p>

                    <div class="form-row">
                        <div class="form-group col-sm">
                            <button class="btn btn-danger" wire:click="exportPDF()"><i class="far fa-lg fa-file-pdf"></i> PDF</button>
                        </div>
                        <div class="form-group col-sm">
                            <button class="btn btn-success" wire:click="exportEXCEL()"><i class="far fa-lg fa-file-excel"></i> EXCEL</button>
                        </div>
                    </div>
                    <div wire:loading wire:target="exportPDF,exportEXCEL">
                        La descarga comenzará pronto... 
                        <div class="d-flex justify-content-center">
                            <x-loading-md></x-loading-md>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal agregar evaluacion -->
    <div wire:ignore.self class="modal fade" id="copyRubrica" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Clonar Rúbrica</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <select class="form-control" name="id_evaluacion" wire:model="id_evaluacion">
                        <option hidden selected>Seleccione la evaluación</option>
                        @foreach($evaluaciones as $evaluacion)
                                <option value="{{$evaluacion->id}}">{{$evaluacion->nombre}} -
                                {{$evaluacion->modulo->nombre}}</option>
                        @endforeach
                    </select>
                    @error('id_evaluacion') 
                            <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary"  onclick="copyRubric()" data-dismiss="modal">Seleccionar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
    function closeT(){
        $('button').focus(function() {
            this.blur();
        });
    }
    function copyRubric(){
        var contenedor = document.getElementById('contenedor_carga');

        contenedor.style.visibility = 'visible';
        contenedor.style.opacity = '0.9';
        Livewire.emit('copyRubric')
    }
</script>
</div>