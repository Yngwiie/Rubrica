<div>
    @include('mensajes-flash')
    
    <div class="d-flex justify-content-between my-4">
        <div class="col-md-4">
            <button class="btn btn-md btn-sec" data-toggle="modal" data-target="#addEstudiante"><i
                    class="far fa-lg fa-plus-square"></i> Nuevo estudiante</button>
        </div>
        <div class="col-md-4">
            <button class="btn btn-md btn-sec" data-toggle="modal" data-target="#importEstudiantes"><i
                    class="fas fa-lg fa-upload"></i> Importar estudiantes</button>
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control" placeholder="Buscar..." wire:model="searchTerm" />
        </div>
    </div>


    <table style="margin-top:10px" class="table table-responsive-md table-striped table-hover">
        <thead class="thead-secondary">
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Email</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($estudiantes as $estudiante)
            <tr>
                <td><i class="fas fa-lg fa-user-graduate"></i> {{$estudiante->estudiante->nombre}} {{$estudiante->estudiante->apellido}}</td>
                <td>{{$estudiante->estudiante->email}}</td>
                <td><button class="btn  btn-sm btn-sec" data-toggle="modal" data-target="#editEstudiante"
                        wire:click="edit({{$estudiante->estudiante->id}})"><i class="far fa-lg fa-edit"></i></button>
                    <button class="btn btn-sm btn-sec" data-toggle="modal" data-target="#deleteEstudiante"
                        wire:click="delete({{$estudiante->estudiante->id}})"><i style="color:red "
                            class="far fa-lg fa-trash-alt"></i></button>
                </td>

            </tr>
            @endforeach

        </tbody>
    </table>
    {{$estudiantes->onEachSide(1)->links('vendor.pagination.tailwind') }}

    <!-- Modal agregar  -->
    <div wire:ignore.self class="modal fade" id="addEstudiante" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Añadir Estudiante</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="Nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control" wire:model.defer="nombre">
                            @error('nombre') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="fecha">Apellido</label>
                            <input type="text" name="fecha" class="form-control" wire:model.defer="apellido">
                            @error('apellido') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="fecha">Correo Electrónico</label>
                            <input type="text" name="fecha" class="form-control" wire:model.defer="email">
                            @error('email') <span class="error text-danger">{{ $message }}</span> @enderror
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
                    <button type="button" class="btn btn-primary" wire:loading.attr="disabled" wire:click="store()">Agregar Estudiante</button>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal Importar  -->
    <div wire:ignore.self class="modal fade" id="importEstudiantes" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Importar Estudiantes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-md btn-success mb-3" wire:click="descargarPlantillaImport"><i class="far fa-lg fa-file-excel"></i> Descargar Plantilla</button>
                    </div>
                    <form wire:submit.prevent="import">
                        <label class="form-label" for="customFile">Seleccione su archivo excel</label>
                        <div class="flex flex-items-center">
                            <div wire:loading wire:target="fileImport" class="mr-3">
                                <x-loading/>
                            </div>
                            <input type="file"  id="customFile" wire:model="fileImport"/>
                        </div>
                        
                        @error('fileImport') <span class="error text-danger">{{ $message }}</span> @enderror
                    </form>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @if($loop->index == 3)
                                        @break
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div wire:loading wire:target="import">
                        <div class="d-flex justify-content-center">
                            <strong>Importando estudiantes...</strong>
                        </div>
                        <div class="d-flex justify-content-center">
                            
                            <x-loading-md></x-loading-md>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" wire:target="fileImport,import" wire:loading.attr="disabled" wire:click="import()">Importar Estudiantes</button>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Eliminar  -->
    <div wire:ignore.self class="modal fade" id="deleteEstudiante" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Eliminar Estudiante</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Esta seguro de eliminar el estudiante de este módulo?</p>
                    <div class="d-flex justify-content-center mt-2">
                        <div wire:loading wire:target="destroy">
                            <x-loading></x-loading>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-danger" wire:loading.attr="disabled" wire:click="destroy()">Eliminar Estudiante</button>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal editar  -->
    <div wire:ignore.self class="modal fade" id="editEstudiante" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Editar Evaluación</h5>
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
                        <div class="form-group">
                            <label for="fecha">Apellido</label>
                            <input type="text" name="fecha" class="form-control" wire:model="apellido">
                            @error('apellido') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="fecha">Correo Electrónico</label>
                            <input type="text" name="fecha" class="form-control" wire:model="email">
                            @error('email') <span class="error text-danger">{{ $message }}</span> @enderror
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
                    <button type="button" class="btn btn-primary" wire:loading.attr="disabled" wire:click="update()">Editar Estudiante</button>
                </div>
            </div>
        </div>
    </div>
    
</div>