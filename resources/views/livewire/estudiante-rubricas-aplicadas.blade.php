<div class="container">
    
    @include('mensajes-flash')
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
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
                                        <a type="button" class="btn btn-outline-secondary" href="{{route('estadisticas',$rubrica->id)}}"><i class="far fa-chart-bar"></i> Estadisticas</a>
                                    </td>
                                </tr>
                            @endforeach
                    </tbody>
                </table>
                {{ $rubricas->onEachSide(1)->links('vendor.pagination.tailwind') }}
            </div>

        </div>
</div>
