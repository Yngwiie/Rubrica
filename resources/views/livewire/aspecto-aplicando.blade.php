<tr style="background-color: #c9c9c9;">
    <th style="border-top: 1px solid #8F9194;">
        <div class="row">
            <div class="col-sm-12">
                <small>{{$aspecto->nombre}}</small>
                
            </div>

        </div>
            <div class="d-flex justify-content-center" >
                <small>{{$aspecto->porcentaje}}%</small>
            </div>
        @if($revision!=true)
            @if($aspecto->criterios->first()->descripcion_avanzada!=null)
                <div class="d-flex justify-content-center" >
                    <button data-toggle="modal" data-target="#aplicarAspecto{{$aspecto->id}}" type="button" class="btn btn-sm btn-secondary" >Aplicar</button>
                </div>
            @endif
        @endif
        @if($tipo_puntaje == "unico")
            @if($aspecto->puntaje_obtenido != -1)
                <div class="d-flex justify-content-center mt-2" >
                    <u><small>Puntaje Obtenido: {{$aspecto->puntaje_obtenido}}</small></u>
                </div>
            @endif
        @else
            @if($aspecto->puntaje_minimo != -1 and $aspecto->puntaje_maximo != -1)
                <div class="d-flex justify-content-center mt-2" >
                    <small>Pts. mínimo obtenido: {{$aspecto->puntaje_minimo}}</small>
                </div>
                <div class="d-flex justify-content-center mt-2" >
                    <small>Pts. máximo obtenido: {{$aspecto->puntaje_maximo}}</small>
                </div>
            @endif
        @endif
        <!-- Modal Eliminar dimension -->
        <div wire:ignore.self class="modal fade" id="aplicarAspecto{{$aspecto->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Aplicar Aspecto</h5>
                        <button type="button" class="btn btn-sec" data-tooltip="tooltip" data-html="true" title="Los aspectos avanzados se pueden elegir subcriterios
                        de diferentes niveles, y se calculará el mejor nivel segun los subcriterios que se elijan.">
                            <i class="far fa-lg fa-question-circle"></i>
                        </button>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="font-weight:normal">
                        
                        @if($aspecto_avanzado == TRUE)
                            @foreach(json_decode($criterios->first()->descripcion_avanzada) as $key => $desc)
                                @if($desc->magnitud != "none")
                                    <li>{{$desc->text}}</li>
                                    <select class="form-control" required name="id_evaluacion" wire:model="aplicados.{{$loop->index}}.id_criterio">
                                        @foreach($criterios as $criterio)
                                            @if($criterio->deshabilitado != true)
                                                @if(json_decode($criterio->descripcion_avanzada)[$key]->magnitud == "porcentaje1")
                                                    <option hidden selected>Seleccione una magnitud</option>
                                                    <option value="{{$criterio->id}}">[{{$criterio->nivel->nombre}}] {{json_decode($criterio->descripcion_avanzada)[$key]->porcentaje_magnitud}}%</option>
                                                @endif
                                                @if(json_decode($criterio->descripcion_avanzada)[$key]->magnitud == "escala")
                                                    <option hidden selected>Seleccione una magnitud</option>
                                                    <option value="{{$criterio->id}}">[{{$criterio->nivel->nombre}}] {{json_decode($criterio->descripcion_avanzada)[$key]->escala_magnitud}}</option>
                                                @endif
                                                @if(json_decode($criterio->descripcion_avanzada)[$key]->magnitud == "porcentaje2")
                                                    <option hidden selected>Seleccione una magnitud</option>
                                                    <option value="{{$criterio->id}}">[{{$criterio->nivel->nombre}}] {{json_decode($criterio->descripcion_avanzada)[$key]->porcentaje_magnitud}}%</option>
                                                @endif
                                                @if(json_decode($criterio->descripcion_avanzada)[$key]->magnitud == "rango_asc")
                                                    <option hidden selected>Seleccione una magnitud</option>
                                                    <option value="{{$criterio->id}}">[{{$criterio->nivel->nombre}}] [{{json_decode($criterio->descripcion_avanzada)[$key]->valor_min}}->{{json_decode($criterio->descripcion_avanzada)[$key]->valor_max}}]</option>
                                                @endif
                                                @if(json_decode($criterio->descripcion_avanzada)[$key]->magnitud == "frecuencia")
                                                    <option hidden selected>Seleccione una magnitud</option>
                                                    <option value="{{$criterio->id}}">[{{$criterio->nivel->nombre}}] {{json_decode($criterio->descripcion_avanzada)[$key]->frecuencia}}</option>
                                                @endif
                                            @endif
                                        @endforeach
                                    </select>
                                @else
                                    <li>Subcriterios sin magnitud</li>
                                        <select class="form-control" name="id_evaluacion" wire:model="aplicados.{{$loop->index}}.id_criterio">
                                            <option hidden selected>Seleccione un subcriterio</option>
                                            @foreach($criterios as $criterio)
                                                    <option style="white-space: nowrap;width: 50px;" value="{{$criterio->id}}"> [{{$criterio->nivel->nombre}}] {{json_decode($criterio->descripcion_avanzada)[$key]->text}}</option>
                                            @endforeach
                                        </select>
                                    
                                @endif
                                <hr class="bg-dark">
                            @endforeach
                        @endif
                        <div class="form-row">
                            @error('aspectoAvanzadoNoAplicado') <span class="error text-danger">{{ $message }}</span> @enderror  
                        </div>
                        <div class="d-flex justify-content-center">
                            <div wire:loading wire:target="aplicarAspectoAvanzado">
                                <x-loading></x-loading>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" wire:loading.attr="disabled" wire:click="aplicarAspectoAvanzado()" >Aplicar</button>

                    </div>
                </div>
            </div>
        </div>
        @if($revision == 0)
            <div class="row p-2">
                <textarea style="font-size:small" type='text' class='form-control shadow-md' wire:model="aspecto.comentario" placeholder="Comentarios" 
                    rows="5" cols="20"></textarea> 
            </div>
        @endif
    </th>

    @foreach($aspecto->criterios as $criterio)
        @if($revision == 1)
            <livewire:criterio-aplicando :criterio="$criterio" :revision="true" :key="time().$criterio->id">
        @else
            <livewire:criterio-aplicando :criterio="$criterio" :key="time().$criterio->id">
        @endif
        
    @endforeach
    @if($revision == 0)
        <!-- <th>
            <div class="row p-2">
                <textarea style="font-size:small" type='text' class='form-control shadow-md' wire:model="aspecto.comentario" placeholder="Comentarios" 
                    rows="5" cols="20"></textarea> 
            </div>
        </th> -->
    @else
        <th style="border-left: 1px solid #8F9194;">
            <div class="row p-2" >
                @if($aspecto->comentario == "")
                    <small><b>Sin Comentarios</b></small>
                @else
                    <small><b>{{$aspecto->comentario}}</b></small>
                @endif
                
            </div>
        </th>
    @endif
    
</tr>
