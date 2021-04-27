<div class="container">
    
    @include('mensajes-flash')
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        {{ Breadcrumbs::render('aplicarEstudiantes', $rubrica) }}
        <div class="card shadow-lg">

            <div class="card-header">
                <h3>Estudiantes</h3>
                <h6>Modulo: {{$nombre_modulo}}<i></i></h6>

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
                            <th scope="col">Nombre</th>
                            <th scope="col">Email</th>
                            <th scope="col">Nota</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach($estudiantes as $estudiante)
                                <tr>
                                    <td><i class="fas fa-lg fa-user-graduate"></i> {{$estudiante->nombre}} {{$estudiante->apellido}}</td>
                                    <td>{{$estudiante->email}}</td>
                                    <td>
                                        @if($estudiante->pivot->nota!= -1)
                                            <p>{{$estudiante->pivot->nota}}</p>
                                        @else
                                            <p>No aplicada</p>
                                        @endif
                                    </td>
                                    <td>
                                        @if($estudiante->pivot->nota!= -1)
                                            <a type="button" class="btn btn-outline-secondary" onclick="loading()" wire:click="aplicar({{$estudiante->id}})">Revisión</a>
                                        @else
                                            <button type="button" class="btn btn-outline-secondary" onclick="loading()" wire:click="aplicar({{$estudiante->id}})">Aplicar</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                    </tbody>
                </table>
                {{ $estudiantes->onEachSide(1)->links('vendor.pagination.tailwind') }}
            </div>

        </div>
<!-- Modal editar  -->
<div wire:ignore.self class="modal fade" id="confirmarNewVersion" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Confirmar Borrar Aplicación Anterior</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <p>Existe una nueva versión de la rúbrica, en caso de que la haya aplicado a este estudiante se perderán esos datos.
                        ¿Está seguro de eliminar la rúbrica aplicada anterior?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="loading()" data-dismiss="modal" wire:click="nuevaVersion()" >Versión Nueva</button>
                    <button type="button" class="btn btn-primary" onclick="loading()" data-dismiss="modal" wire:click="versionAntigua()" >Continuar con Versión Antigua</button>
                </div>
        </div>
    </div>
</div>

<script>
function loading(){
    var contenedor = document.getElementById('contenedor_carga');

    contenedor.style.visibility = 'visible';
    contenedor.style.opacity = '0.9';
}

</script>
</div>
