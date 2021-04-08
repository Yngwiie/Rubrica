<style>
/* tr > td {
    border: 1px solid #000000;
    border-collapse: collapse;
} */
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>
<table>
    <tbody>
        <tr>
            <td>{{ $rubrica->titulo }}</td>
        </tr>
        <tr>
            <th><strong>Descripción: </strong></th>
            <td >{{ $rubrica->descripcion }}</td>
        </tr>
        <tr>
            <th><strong>Evaluación: </strong></th>
            <td>{{ $rubrica->evaluacion->nombre }}</td>
        </tr>
        <tr>
            <th><strong>Módulo: </strong></th>
            <td>{{ $rubrica->evaluacion->modulo->nombre }}</td>
        </tr>
    </tbody>
</table>
<br>
@foreach ($rubrica->dimensiones as $dimension)
        <table style="border: 1px dashed #CCC" id="table{{$dimension->id}}">
            <thead class="bg-secondary">
                <tr>
                    <th >
                        <p >{{$dimension->nombre}}</p>
                        <div class="row">
                            <div class="col-sm-8" style="margin-top:4px">
                                <small >{{$dimension->porcentaje}} %</small>
                            </div>
                        </div>
                    </th>

                    @foreach($dimension->nivelesDesempeno as $nivel)
                    <th >
                        <p >{{$nivel->nombre}}</p>
                        <div class="row">
                            <div class="col-sm-6" style="margin-top:4px">
                                <small >Puntaje: {{$nivel->puntaje}}</small>
                            </div>
                        </div> 
                    </th>

                    @endforeach
                </tr>
            </thead>
            <tbody>

                @foreach($dimension->aspectos as $aspecto)
                    <tr>
                        <th >
                            <div class="row">
                                <div class="col-12">
                                    <small>{{$aspecto->nombre}}</small>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-sm-8" style="margin-top: 6px">
                                   <small>{{$aspecto->porcentaje}}%</small>
                                </div>

                            </div>
                        </th>

                        @foreach($aspecto->criterios as $criterio)
                            <!-- <livewire:criterio-component :criterio="$criterio" :key="time().$loop->index"> -->
                            <th >
                                @if($criterio->deshabilitado==0)
                                    <div >
                                        @if($criterio->criterio_avanzado == true)
                                            <ul>
                                                @foreach($descripcion_avanzada as $desc)
                                                    <li wire:key="{{$loop->index}}">
                                                    <div class="form-row mb-1">
                                                        @if($desc->magnitud == "porcentaje1")
                                                            <div class="w-41">
                                                                <textarea style="font-size:small" class="form-control shadow" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.text" title="descripcion_avanzada.{{$loop->index}}.text"></textarea>
                                                            </div>
                                                            
                                                            <div class="col-3">
                                                                <input style="font-size:small;margin-left:-5px" class="input col-12" min="1" max="100" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.porcentaje_magnitud" type="number">
                                                                <!-- <small >%</small>  -->
                                                            </div>
                                                            <div class="w-3" style="margin-left:-7px" >
                                                                <small>%</small> 
                                                            </div>
                                                        @else
                                                            <textarea style="font-size:small" class="form-control shadow ml-1" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.text" title="descripcion_avanzada.{{$loop->index}}.text"></textarea>
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="form-row">
                                                        <div class="col-6">
                                                            <div class="input-group mb-1">
                                                                <input style="font-size:small" class="form-control" min="1" max="100" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.porcentaje" type="number"/>
                                                                <div class="input-group-append">
                                                                    <span style="font-size:small" class="input-group-text">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-3" style="font-size:small">
                                                            <button class="btn btn-sm btn-danger" wire:loading.attr="disabled" wire:click="removeSubCriteria({{$loop->index}})"><i class="fas fa-md fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                    @if($loop->index != (count($descripcion_avanzada)-1))
                                                        <hr class="bg-dark">
                                                    @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <small style="white-space: pre-line;">{{$criterio->descripcion}}</small>
                                        @endif
                                    </div>
                                @else
                                    <div class="justify-content-center">
                                        -
                                    </div>
                                @endif
                                <div>
                                    @error('criterio.descripcion') <small class="error text-danger">{{ $message }}</small> @enderror
                                </div>
                            </th>

                        @endforeach
                    </tr>
                @endforeach
            </tbody>
            </table>
        <br>
    @endforeach