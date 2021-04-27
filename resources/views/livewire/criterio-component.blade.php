<th >
    @if($deshabilitado==0)
        <div>
            @if($criterio_avanzado == true)
                <ul >
                    @foreach($descripcion_avanzada as $desc)
                        <li wire:key="{{$loop->index}}">
                        
                        <small style="font-size:11px"> <b>ID#{{$desc->id}}</b></small>
                        <div class="form-row mb-1">
                            @if($desc->magnitud == "porcentaje1")
                                <div class="w-41">
                                    <textarea style="font-size:small" class="form-control shadow" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.text"></textarea>
                                </div>
                                
                                <div class="col-3">
                                    <input type="number" id="subcriterio{{$criterio->id.$desc->id}}" style="display:none" wire:model="id_subcriterio">
                                    <input title="Magnitud que se aplica el sub-criterio" style="font-size:small;margin-left:-5px" onchange="setIdSubcriterio({{$criterio->id}},{{$desc->id}})" class="input col-12 " min="1" max="100" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.porcentaje_magnitud" type="number">
                                    
                                </div>
                                <div class="w-3" style="margin-left:-7px" >
                                    <small>%</small> 
                                </div>
                            @elseif($desc->magnitud == "escala")
                                <div class="w-41">
                                    <textarea style="font-size:small" class="form-control shadow" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.text"></textarea>
                                </div>
                                
                                <div class="col-3">
                                    <input type="number" id="subcriterio{{$criterio->id.$desc->id}}" style="display:none" wire:model="id_subcriterio">
                                    <input title="Magnitud que se aplica el sub-criterio"  style="font-size:small;margin-left:-5px" onchange="setIdSubcriterio({{$criterio->id}},{{$desc->id}})" class="input col-12" min="1" max="100" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.escala_magnitud" type="number">
                                    
                                </div>
                            @elseif($desc->magnitud == "porcentaje2")
                                <div class="w-41">
                                    <textarea style="font-size:small" class="form-control shadow" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.text"></textarea>
                                </div>
                                
                                <div class="col-3">
                                    <input type="number" id="subcriterio{{$criterio->id.$desc->id}}" style="display:none" wire:model="id_subcriterio">
                                    <input title="Magnitud que se aplica el sub-criterio" style="font-size:small;margin-left:-5px" onchange="setIdSubcriterio({{$criterio->id}},{{$desc->id}})" class="input col-12" min="1" max="100" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.porcentaje_magnitud" type="number">
                                    
                                </div>
                                <div class="w-3" style="margin-left:-7px" >
                                    <small>%</small> 
                                </div>
                            @elseif($desc->magnitud == "rango_asc")
                                <div class="w-41">
                                    <textarea style="font-size:small" class="form-control shadow" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.text"></textarea>
                                </div>
                                
                                <div class="col-4" style="margin-top:-4px">
                                    <input type="number" id="subcriterio{{$criterio->id.$desc->id}}" style="display:none" wire:model="id_subcriterio">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <small>mín.</small>
                                        </div>
                                        <div class="col-sm-9">
                                            <input title="Magnitud que se aplica el sub-criterio" style="font-size:small;padding: 1px;" onchange="setIdSubcriterio({{$criterio->id}},{{$desc->id}})" class="form-control form-control-sm" min="1" max="100" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.valor_min" type="number">
                                        </div>
                                    </div>
                                    
                                    <div class="row" style="margin-top:3px">
                                        <div class="col-sm-1">
                                            <small>máx.</small>
                                        </div>
                                        <div class="col-sm-9">
                                            <input title="Magnitud que se aplica el sub-criterio" style="font-size:small;padding: 1px;" onchange="setIdSubcriterio({{$criterio->id}},{{$desc->id}})" class="form-control form-control-sm" min="1" max="100" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.valor_max" type="number">
                                        </div>
                                    </div>
                                </div>
                            @elseif($desc->magnitud == "frecuencia")
                                <div class="w-41">
                                    <textarea style="font-size:small" class="form-control shadow" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.text"></textarea>
                                </div>
                                
                                <div class="col-4">
                                    <input type="number" id="subcriterio{{$criterio->id.$desc->id}}" style="display:none" wire:model="id_subcriterio">
                                    <select style="font-size:small;" class="form-control p-1" onchange="setIdSubcriterio({{$criterio->id}},{{$desc->id}})" name="id_evaluacion" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.frecuencia">
                                        <option hidden selected>Selecciona una opción</option>
                                        <option value="Siempre">Siempre</option>
                                        <option value="Usualmente">Usualmente</option>
                                        <option value="Generalmente">Generalmente</option>
                                        <option value="A menudo">A menudo</option>
                                        <option value="A veces">A veces</option>
                                        <option value="Ocasionalmente">Ocasionalmente</option>
                                        <option value="Casi nunca">Casi nunca</option>
                                        <option value="Nunca">Nunca</option>
                                    </select>
                                </div>
                            @else
                                <textarea style="font-size:small" class="form-control shadow ml-1" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.text"></textarea>
                            @endif
                        </div>
                        
                        <div class="form-row">
                            <div class="col-6">
                                <div class="input-group mb-1">
                                    @if($criterio->aspecto->criterios->first()->id == $criterio->id)
                                        <input title="Porcentaje de importancia del subcriterio." style="font-size:small" class="form-control" min="1" max="100" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.porcentaje" wire:change="porcentajeChange({{$loop->index}})" type="number"/>
                                    @else
                                        <input title="Porcentaje de importancia del subcriterio." disabled style="font-size:small" class="form-control" min="1" max="100" value="{{$desc->porcentaje}}"  type="number"/>
                                    @endif
                                    <div class="input-group-append">
                                        <span style="font-size:small" class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            @if($criterio->aspecto->criterios->first()->id == $criterio->id)
                                <div class="col-3" style="font-size:small">
                                    <button class="btn btn-sm btn-danger" onclick="emitremove({{$criterio->id_aspecto}},{{$loop->index}})"><i class="fas fa-md fa-times"></i></button>
                                </div>
                            @endif
                        </div>
                        
                        @if($loop->index != (count($descripcion_avanzada)-1))
                            <hr class="bg-dark">
                        @endif
                        </li>
                        
                    @endforeach
                    <div>
                        @error('subcriterio') <small class="error text-danger"><b>{{ $message }}</b></small> @enderror
                    </div>
                    @if($criterio->aspecto->criterios->first()->id == $criterio->id)
                        <div>
                            @error('porcentaje_subcriterio') <small class="error text-danger"><b>{{ $message }}</b></small> @enderror
                        </div>
                    @endif
                </ul>
            @else
                <textarea style="font-size:small" type='text' class='form-control shadow-md' wire:model.lazy="criterio.descripcion" rows="10" cols="40" required></textarea>
            @endif
        </div>
    @else
        <div>
            @if($criterio_avanzado == true)
                <ul>
                @foreach($descripcion_avanzada as $desc)
                        <li wire:key="{{$loop->index}}">
                        <small style="font-size:11px"> <b>ID#{{$desc->id}}</b></small>
                        <div class="form-row mb-1">
                            @if($desc->magnitud == "porcentaje1")
                                <div class="w-41">
                                    <textarea disabled style="font-size:small" class="form-control shadow" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.text"></textarea>
                                </div>
                                
                                <div class="col-3">
                                    <input type="number" id="subcriterio{{$criterio->id.$desc->id}}" style="display:none" wire:model="id_subcriterio">
                                    <input disabled title="Magnitud que se aplica el sub-criterio" style="font-size:small;margin-left:-5px" onchange="setIdSubcriterio({{$criterio->id}},{{$desc->id}})" class="input col-12 " min="1" max="100" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.porcentaje_magnitud" type="number">
                                    
                                </div>
                                <div class="w-3" style="margin-left:-7px" >
                                    <small>%</small> 
                                </div>
                            @elseif($desc->magnitud == "escala")
                                <div class="w-41">
                                    <textarea disabled style="font-size:small" class="form-control shadow" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.text"></textarea>
                                </div>
                                
                                <div class="col-3">
                                    <input type="number" id="subcriterio{{$criterio->id.$desc->id}}" style="display:none" wire:model="id_subcriterio">
                                    <input disabled title="Magnitud que se aplica el sub-criterio"  style="font-size:small;margin-left:-5px" onchange="setIdSubcriterio({{$criterio->id}},{{$desc->id}})" class="input col-12" min="1" max="100" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.escala_magnitud" type="number">
                                    
                                </div>
                            @elseif($desc->magnitud == "porcentaje2")
                                <div class="w-41">
                                    <textarea disabled style="font-size:small" class="form-control shadow" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.text"></textarea>
                                </div>
                                
                                <div class="col-3">
                                    <input type="number" id="subcriterio{{$criterio->id.$desc->id}}" style="display:none" wire:model="id_subcriterio">
                                    <input disabled title="Magnitud que se aplica el sub-criterio" style="font-size:small;margin-left:-5px" onchange="setIdSubcriterio({{$criterio->id}},{{$desc->id}})" class="input col-12" min="1" max="100" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.porcentaje_magnitud" type="number">
                                    
                                </div>
                                <div class="w-3" style="margin-left:-7px" >
                                    <small>%</small> 
                                </div>
                            @elseif($desc->magnitud == "rango_asc")
                                <div class="w-41">
                                    <textarea disabled style="font-size:small" class="form-control shadow" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.text"></textarea>
                                </div>
                                
                                <div class="col-4" style="margin-top:-4px">
                                    <input type="number" id="subcriterio{{$criterio->id.$desc->id}}" style="display:none" wire:model="id_subcriterio">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <small>mín.</small>
                                        </div>
                                        <div class="col-sm-9">
                                            <input disabled title="Magnitud que se aplica el sub-criterio" style="font-size:small;padding: 1px;" onchange="setIdSubcriterio({{$criterio->id}},{{$desc->id}})" class="form-control form-control-sm" min="1" max="100" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.valor_min" type="number">
                                        </div>
                                    </div>
                                    
                                    <div class="row" style="margin-top:3px">
                                        <div class="col-sm-1">
                                            <small>máx.</small>
                                        </div>
                                        <div class="col-sm-9">
                                            <input disabled title="Magnitud que se aplica el sub-criterio" style="font-size:small;padding: 1px;" onchange="setIdSubcriterio({{$criterio->id}},{{$desc->id}})" class="form-control form-control-sm" min="1" max="100" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.valor_max" type="number">
                                        </div>
                                    </div>
                                </div>
                            @else
                                <textarea disabled style="font-size:small" class="form-control shadow ml-1" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.text"></textarea>
                            @endif
                        </div>
                        
                        <div class="form-row">
                            <div class="col-6">
                                <div class="input-group mb-1">
                                    <input disabled title="Porcentaje de importancia del subcriterio." style="font-size:small" class="form-control" min="1" max="100" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.porcentaje" type="number"/>
                                    <div class="input-group-append">
                                        <span style="font-size:small" class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            
                            @if($criterio->aspecto->criterios->first()->id == $criterio->id)
                                <div class="col-3" style="font-size:small">
                                    <button class="btn btn-sm btn-danger" disabled><i class="fas fa-md fa-times"></i></button>
                                </div>
                            @endif
                        </div>
                        @if($loop->index != (count($descripcion_avanzada)-1))
                            <hr class="bg-dark">
                        @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <textarea disabled style="font-size:small" type='text' class='form-control shadow-md' wire:model="criterio.descripcion" rows="10" cols="40" required></textarea>
            @endif
        </div>
    @endif
    <div>
        @error('criterio.descripcion') <small class="error text-danger">{{ $message }}</small> @enderror
    </div>
    <div class="form-check">
        
        <input class="form-check-input" type="checkbox" id="blankCheckbox" value="1" wire:loading.attr="disabled" wire:model="deshabilitado" style="margin-top:6px">
        <small >Deshabilitar</small>
        <div wire:loading wire:target="deshabilitado">
                <x-loading-small></x-loading-small>
        </div>
    </div>
        

    <script>
    
    function setIdSubcriterio(idcriterio,idloop){
        document.getElementById("subcriterio"+idcriterio+idloop).value = idloop
        document.getElementById("subcriterio"+idcriterio+idloop).dispatchEvent(new Event('input'))
    }

    function emitremove(idaspecto,idloop){
        var opcion = confirm("Se eliminarán los subcriterios de todos los criterios, ¿Está Seguro?")
        if (opcion == true) {
            Livewire.emit('removeSubCriteria'+idaspecto,idloop)
        }
    }
    </script>
    <!-- Modal Eliminar dimension -->
<!-- <div wire:ignore.self class="modal fade" id="modal-confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Eliminar Subcriterio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Se eliminarán los subcriterios de todos los niveles. ¿Está seguro de eliminar este Subcriterio?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-danger" onclick="emitremove()" data-dismiss="modal">Eliminar Subcriterio</button>
            </div>
        </div>
    </div>
</div> -->
</th>
