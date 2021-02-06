<div class="container">

    @include('mensajes-flash')
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

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
                   <!--  <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Buscar..." wire:model="searchTerm" />
                    </div> -->
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
                        @foreach(Auth::user()->modulos as $modulo)
                            @foreach($modulo->evaluacion as $evaluacion)
                                @if($evaluacion->rubrica)
                                    <tr>
                                        <td><i class="far fa-lg fa-list-alt"></i> {{$evaluacion->rubrica->titulo}}</td>
                                        <td>{{$evaluacion->nombre}} - {{$evaluacion->modulo->nombre}}</td>
                                        <td><a class="btn btn-sm btn-sec" 
                                            href="{{route('rubric.edit',$evaluacion->rubrica->id)}}" title="Editar Rúbrica"><i class="far fa-lg fa-edit"></i></a>
                                            <button class="btn btn-sm btn-sec" title="Exportar Rúbrica"><i class="fas fa-lg fa-file-download"></i></button>
                                            <button class="btn btn-sm btn-sec" title="Copiar Rúbrica"><i class="far fa-lg fa-copy"></i></button>
                                            <button tclass="btn btn-sm btn-sec" data-toggle="modal" data-target="#deleteRubrica"
                                                wire:click="delete({{$evaluacion->rubrica->id}})" title="Eliminar Rúbrica"><i style="color:red "
                                                    class="far fa-lg fa-trash-alt"></i></button>
                                        </td>

                                    </tr>
                                @endif
                            @endforeach
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
    <div wire:ignore.self class="modal fade" id="deleteRubrica" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
</div>