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


                <table style="margin-top:10px" class="table table-striped table-hover">
                    <thead class="thead-secondary">
                        <tr>
                            <th scope="col">Titulo</th>
                            <th scope="col">Evaluación</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rubricas as $rubrica)
                        <tr>
                            <td><i class="far fa-lg fa-list-alt"></i> {{$rubrica->titulo}}</td>
                            <td>{{$rubrica->evaluacion->nombre}} - {{$rubrica->evaluacion->modulo->nombre}}</td>
                            <td><button class="btn  btn-sm btn-sec" data-toggle="modal" data-target="#editModulo"
                                    wire:click="edit({{$rubrica->id}})"><i class="far fa-lg fa-edit"></i></button>
                                <button class="btn btn-sm btn-sec" data-toggle="modal" data-target="#deleteRubrica"
                                    wire:click="delete({{$rubrica->id}})"><i style="color:red "
                                        class="far fa-lg fa-trash-alt"></i></button>
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
                    <p>¿Esta seguro de eliminar esta rúbrica?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-danger" wire:click="destroy()">Eliminar Rúbrica</button>

                </div>
            </div>
        </div>
    </div>
</div>