<div class="container">
    
    @include('mensajes-flash')
    
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

        <div class="card shadow-lg">

            <div class="card-header">
                <h3>Modulos</h3>

            </div>
            <div class="card-body">

                <div class="d-flex justify-content-between">
                    <div class="col-md-4">
                        <button class="btn btn-md btn-sec" data-toggle="modal" data-target="#addModulo"><i
                                class="far fa-lg fa-plus-square"></i> Nuevo Módulo</button>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Buscar..." wire:model="searchTerm" />
                    </div>
                </div>


                <table style="margin-top:10px" class="table table-responsive-md table-striped table-hover">
                    <thead class="thead-secondary">
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modulos as $modulo)
                        <tr>
                            <td><i class="far fa-lg fa-folder"></i> <a href="{{route('show.modulo',$modulo->id)}}"
                                    class="text-dark">{{$modulo->nombre}}</a></td>
                            <td><button class="btn  btn-sm btn-sec" data-toggle="modal" data-target="#editModulo"
                                    wire:click="edit({{$modulo->id}})"><i class="far fa-lg fa-edit"></i></button>
                                <button class="btn btn-sm btn-sec" data-toggle="modal" data-target="#deleteModulo"
                                    wire:click="delete({{$modulo->id}})"><i style="color:red "
                                        class="far fa-lg fa-trash-alt"></i></button>
                            </td>

                        </tr>
                        @endforeach

                    </tbody>
                </table>
                {{ $modulos->onEachSide(1)->links('vendor.pagination.tailwind') }}
            </div>
            <script>
                
                window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function() {
                        $(this).remove();
                    });
                }, 5000);
        </script>
        </div>
        
        
    </div>

    <!-- Modal agregar  -->
    <div wire:ignore.self class="modal fade" id="addModulo" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Añadir Módulo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="Nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control" wire:model="nombre">
                            @error('nombre') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </form>
                    <div class="d-flex justify-content-center mt-2">
                        <div wire:loading wire:target="store">
                            <x-loading></x-loading>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" wire:loading.attr="disabled" class="btn btn-primary" wire:click="store()">Agregar Modulo</button>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal editar  -->
    <div wire:ignore.self class="modal fade" id="editModulo" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Editar Módulo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="Nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control" wire:model.lazy="nombre">
                            @error('Nombre') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </form>
                    <div class="d-flex justify-content-center mt-2">
                        <div wire:loading wire:target="update">
                            <x-loading></x-loading>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" wire:loading.attr="disabled" class="btn btn-primary" wire:click="update()">Editar Modulo</button>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal Eliminar  -->
    <div wire:ignore.self class="modal fade" id="deleteModulo" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Eliminar Módulo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Esta seguro de eliminar el modulo?</p>
                    <div class="d-flex justify-content-center mt-2">
                        <div wire:loading wire:target="destroy">
                            <x-loading></x-loading>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" wire:loading.attr="disabled" class="btn btn-danger" wire:click="destroy()">Eliminar Módulo</button>

                </div>
            </div>
        </div>
    </div>

</div>