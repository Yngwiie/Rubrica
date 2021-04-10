<div class="container pt-9">
    {{ Breadcrumbs::render('plantilla') }}
    @include('mensajes-flash')
    <div class="max-w-7xl mx-auto py-3 sm:px-6 lg:px-8">
        <div class="row mb-3 justify-content-center">
            <h3>Plantillas</h3>
        </div>
        <div class="row justify-content-center ">
        
            @foreach($plantillas as $plantilla)
                <div class="col-md-4ths col-xs-6 col-lg-4">
                
                    <div class="card shadow p-3" style="margin-bottom: 30px; height: 95%;border-radius: 25px;" >
                        <img class="card-img-top" src="{{asset('images/titulo.jpg')}}" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">{{$plantilla->titulo}}</h5>
                            @if($plantilla->descripcion == "descripcion")
                                <small style="height:400px" class="card-text">Descripcion</small>
                            @else
                                <small class="card-text">{{$plantilla->descripcion}}</small>
                            @endif
                        </div>
                        <div class="text-center"style="margin-top:8px">
                            <button data-toggle="modal" data-target="#confirmPlantilla" wire:click="setIdRubrica({{$plantilla->id}})" class="btn btn-sm btn-secondary"> Seleccionar</button>
                        </div>    
                    </div>
                
                </div>
            @endforeach  
        </div>
    </div>
    <!-- Modal agregar evaluacion -->
<div wire:ignore.self class="modal fade" id="confirmPlantilla" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Seleccione la evaluación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <select class="form-control" name="id_evaluacion" wire:model="id_evaluacion">
                    <option hidden selected>Selecciona una opción</option>
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
                <button type="button" class="btn btn-primary"  onclick="copyTemplate()" data-dismiss="modal">Seleccionar</button>
            </div>
        </div>
    </div>
</div>
<script>
    function copyTemplate(){
        var contenedor = document.getElementById('contenedor_carga');

        contenedor.style.visibility = 'visible';
        contenedor.style.opacity = '0.9';
        Livewire.emit('copyTemplate')
    }
</script>
</div>