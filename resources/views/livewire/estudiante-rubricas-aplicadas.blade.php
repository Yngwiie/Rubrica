<div class="container">
    
    @include('mensajes-flash')
    <div class="max-w-9xl mx-auto py-10 sm:px-6 lg:px-8">
        {{ Breadcrumbs::render('rubricasAplicadas') }}
        <div class="card shadow-lg">

            <div class="card-header">
                <h3>Rúbricas Aplicadas Asociadas</h3>

            </div>
            <div class="card-body">


                <div class="d-flex justify-content-between">
                    <div class="col-md-4">
                        <!-- <button class="btn btn-md btn-sec" data-toggle="modal" data-target="#addModulo"><i
                                class="far fa-lg fa-plus-square"></i> Nuevo Módulo</button> -->
                    </div>
                     <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Buscar por título..." wire:model="searchTerm" />
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
                                        <a type="button" class="btn btn-outline-secondary" href="{{route('revision',$rubrica->id)}}"><i class="far fa-eye"></i> Revisión</a>
                                        <a type="button" class="btn btn-sec" title="Estadísticas" href="{{route('estadisticas',['id_evaluacion' => $rubrica->id_evaluacion])}}"><i class="far fa-lg fa-chart-bar"></i></a>
                                        <a type="button" class="btn btn-sec" data-toggle="modal" data-target="#exportResultados" wire:click="setIdRubrica({{$rubrica->id}})" title="Exportar Resultados"><i class="fas fa-lg fa-file-download"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                    </tbody>
                </table>
                {{ $rubricas->onEachSide(1)->links('vendor.pagination.tailwind') }}
            </div>

        </div>
        <!-- Modal Exportar  -->
        <div wire:ignore.self class="modal fade" id="exportResultados" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Exportar Resultados</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-center">
                            <p>Seleccione Formato</p>
                        </div>
                        <div class="d-flex justify-content-center">
                                <button class="btn btn-danger" wire:click="exportPDF()"><i class="far fa-lg fa-file-pdf"></i> PDF</button>
                            <!-- <div class="form-group col-sm">
                                <button class="btn btn-success" wire:click="exportEXCEL()"><i class="far fa-lg fa-file-excel"></i> EXCEL</button>
                            </div> -->
                        </div>
                        <div wire:loading wire:target="exportPDF">
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
</div>
