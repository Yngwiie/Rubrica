@include('mensajes-flash')
<div class="d-flex justify-content-between my-4">
    <div class="col-md-4">
        <button class="btn btn-md btn-sec" data-toggle="modal" data-target="#addEvaluacion"><i
                class="far fa-lg fa-plus-square"></i> Nueva evaluacion</button>
    </div>
    <div class="col-md-4">
        <input type="text" class="form-control" placeholder="Buscar..." wire:model="searchTerm" />
    </div>
</div>


<table style="margin-top:10px" class="table table-responsive-md table-striped table-hover">
    <thead class="thead-secondary">
        <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Fecha</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($evaluaciones as $evaluacion)
        <tr>
            <td><i class="far fa-lg fa-file-alt"></i> {{$evaluacion->nombre}}</td>
            <td>{{$evaluacion->fecha}}</td>
            <td><button class="btn  btn-sm btn-sec" data-toggle="modal" data-target="#editEvaluacion"
                    wire:click="edit({{$evaluacion->id}})"><i class="far fa-lg fa-edit"></i></button>
                <button class="btn btn-sm btn-sec" data-toggle="modal" data-target="#deleteEvaluacion"
                    wire:click="delete({{$evaluacion->id}})"><i style="color:red "
                        class="far fa-lg fa-trash-alt"></i></button>
            </td>

        </tr>
        @endforeach

    </tbody>
</table>
{{$evaluaciones->onEachSide(1)->links('vendor.pagination.tailwind') }}

<!-- Modal agregar  -->
<div wire:ignore.self class="modal fade" id="addEvaluacion" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Añadir Evaluación</h5>
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
                        <label for="fecha">Fecha</label>
                        <input type="date" name="fecha" class="form-control" wire:model="fecha">
                        @error('fecha') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" wire:click="store()">Agregar Evaluación</button>

            </div>
        </div>
    </div>
</div>
<!-- Modal Eliminar  -->
<div wire:ignore.self class="modal fade" id="deleteEvaluacion" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Eliminar Evaluación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Esta seguro de eliminar la evaluación?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-danger" wire:click="destroy()">Eliminar Evaluación</button>

            </div>
        </div>
    </div>
</div>
<!-- Modal editar  -->
<div wire:ignore.self class="modal fade" id="editEvaluacion" tabindex="-1" role="dialog"
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
                        @error('Nombre') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="Fecha">Fecha</label>
                        <input type="date" name="nombre" class="form-control" wire:model="fecha">
                        @error('Nombre') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" wire:click="update()">Editar Evaluación</button>

            </div>
        </div>
    </div>
</div>