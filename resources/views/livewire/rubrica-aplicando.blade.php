<div class="container p-4" id="contenedor">
    {{ Breadcrumbs::render('estudianteAplicando', $estudiante, $rubrica) }}
    @include('mensajes-flash')
    <form>
        <div class="form-group row">
            <label for="titulo" class="col-sm-2 col-form-label"><strong>Título</strong></label>
            <div class="col-sm-5 mt-2">
                <p >{{$rubrica_aplicando->titulo}}</p>
            </div>
        </div>
        <div class="form-group row">
            <label for="Descripcion" class="col-sm-2 col-form-label"><strong>Descripción</strong></label>
            <div class="col-sm-5 mt-1">
                <p >{{$rubrica_aplicando->descripcion}}</p>
            </div>
        </div> 
        <div class="form-group row">
            <label for="Descripcion" class="col-sm-2 col-form-label"><strong>Evaluación Asociada</strong></label>
            @if($rubrica_aplicando->plantilla != 1)
                <div class="col-sm-5 mt-2">
                    <p>{{$rubrica_aplicando->evaluacion->nombre}} - {{$rubrica_aplicando->evaluacion->modulo->nombre}}</p>
                </div>
            @endif
        </div>
        <div class="form-group row">
            <label for="Descripcion" class="col-sm-2 col-form-label"><strong>Escala de notas</strong></label>
            <div class="col-sm-5">
                <label for="Descripcion" class="col-sm-2 col-form-label">{{$rubrica_aplicando->escala_notas}}</label>
                
            </div>
            
        </div>
        <div class="form-group row">
            <label for="Descripcion" class="col-sm-2 col-form-label"><strong>Nota Final:</strong></label>
            <div class="col-sm-5">
                
                @if($rubrica_aplicando->nota==-1)
                    <p style="margin-top:7px">No Calculada</p>
                @else
                    <label for="Nota" class="col-sm-2 col-form-label">{{$rubrica_aplicando->nota}}</label>
                @endif
            </div>
            
        </div>
    </form>
    <div class="col-8 mb-2">
            <div class="row">
                @error('rubrica_aplicando.titulo') <small class="error text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="row">
                @error('rubrica_aplicando.descripcion') <small class="error text-danger">{{ $message }}</small> @enderror  
            </div>
            <div class="row">
                @error('rubrica_aplicando.escala_notas') <small class="error text-danger">{{ $message }}</small> @enderror  
            </div>  
    </div>
    <hr class="bg-dark">
    <div wire:key="foo">
    @foreach ($rubrica_aplicando->dimensiones as $dimension)
        <div  class="double-scroll shadow-lg" style="overflow-x:auto;">
            <table class="table shadow " id="table{{$dimension->id}}">
                <thead class="bg-secondary">
                    <tr>
                        <livewire:dimension-aplicando :dimension="$dimension" :key="time().$loop->index">

                        @foreach($dimension->nivelesDesempeno as $nivel)
                            <livewire:nivel-aplicando :nivel="$nivel" :rubrica="$rubrica_aplicando" :key="time().$loop->index">
                        @endforeach
                        <th >
                        <p style="width:200px;color:white">Comentarios</p>
                        </th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($dimension->aspectos as $aspecto)
                        <livewire:aspecto-aplicando :aspecto="$aspecto" :key="time().$loop->index">
                    @endforeach
                </tbody>
            </table>
        </div>
        <br>
    @endforeach
    </div>
    <div class="p-3">
        <div class="d-flex justify-content-center">
            <p><strong>Nota Final: </strong></p>
            @if($rubrica_aplicando->nota==-1)
                <p class="ml-2">No Calculada</p>
            @else
                <p class="ml-2">{{$rubrica_aplicando->nota}}</p>
            @endif

        </div>
        <div class="d-flex justify-content-center">
            <button class="btn btn-primary" wire:loading.attr="disabled" wire:target="aplicarSubcriterio" wire:click="aplicarRubrica">Aplicar y Guardar Cambios</button>
            <div wire:loading wire:target="aplicarRubrica" class="mr-3">
                <x-loading/>
            </div>
        </div>
        
    </div>
</div>
