<th style="border-top: 1px solid #8F9194;">
    @if($deshabilitado==0)
        <div>
            @if($criterio_avanzado == true)
                <div style="height:10px" class="d-flex justify-content-center">
                    <div wire:loading>
                        <x-loading-small></x-loading-small>
                    </div>
                </div>
                <ul >
                    @foreach($descripcion_avanzada as $desc)
                        <li wire:key="{{$loop->index}}">
                        
                        <small style="font-size:11px"> <b>ID#{{$desc->id}}</b></small>
                        <div class="form-row mb-1">
                            @if($desc->magnitud == "porcentaje1")
                                <div class="col-8">
                                    <textarea style="font-size:small" class="form-control shadow" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.text"></textarea>
                                </div>

                                <div class="col-4" >
                                    <input type="number" id="subcriterio{{$criterio->id.$desc->id}}" style="display:none" wire:model="id_subcriterio">
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <input title="Magnitud que se aplica el subcriterio" style="font-size:small;margin-left:-5px" class="p-1 form-control col-12 @error('subcriterio'.$desc->id) is-invalid @enderror" min="1" max="100" wire:model="descripcion_avanzada.{{$loop->index}}.porcentaje_magnitud" type="number">
                                        </div>
                                        <div class="w-3" style="margin-left:-13px" >
                                            <small>%</small> 
                                        </div>
                                    </div>
                                    
                                    <div class="row" style="margin-top:-2px">
                                        <div class="col-sm-7">
                                            <small>Asc-></small>
                                        </div>
                                    </div>
                                </div>
                            @elseif($desc->magnitud == "escala")
                                <div class="col-8">
                                    <textarea style="font-size:small" class="form-control shadow" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.text"></textarea>
                                </div>
                                
                                <div class="col-3">
                                    <input type="number" id="subcriterio{{$criterio->id.$desc->id}}" style="display:none" wire:model="id_subcriterio">
                                    <input title="Magnitud que se aplica el subcriterio"  style="font-size:small;margin-left:-5px" class="p-1 form-control col-12 @error('subcriterio'.$desc->id) is-invalid @enderror" min="1" max="100" wire:model="descripcion_avanzada.{{$loop->index}}.escala_magnitud" type="number">
                                </div>
                            @elseif($desc->magnitud == "porcentaje2")
                                <div class="col-8">
                                    <textarea style="font-size:small" class="form-control shadow" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.text"></textarea>
                                </div>
                                <div class="col-4" >
                                    <input type="number" id="subcriterio{{$criterio->id.$desc->id}}" style="display:none" wire:model="id_subcriterio">
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <input title="Magnitud que se aplica el subcriterio" style="font-size:small;margin-left:-5px" class="p-1 form-control col-12 @error('subcriterio'.$desc->id) is-invalid @enderror"   min="1" max="100" wire:model="descripcion_avanzada.{{$loop->index}}.porcentaje_magnitud" type="number">
                                        </div>
                                        <div class="w-3" style="margin-left:-13px" >
                                            <small>%</small> 
                                        </div>
                                    </div>
                                    
                                    <div class="row" style="margin-top:-2px">
                                        <div class="col-sm-8">
                                            <small>desc-></small>
                                        </div>
                                    </div>
                                </div>
                            @elseif($desc->magnitud == "rango_asc")
                                <div class="col-8">
                                    <textarea style="font-size:small" class="form-control shadow" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.text"></textarea>
                                </div>
                                
                                <div class="col-4" style="margin-top:-4px;margin-left:-5px">
                                    <input type="number" id="subcriterio{{$criterio->id.$desc->id}}" style="display:none" wire:model="id_subcriterio">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <small>mín.</small>
                                        </div>
                                        <div class="col-sm-9">
                                            <input title="Magnitud que se aplica el subcriterio" style="font-size:small;padding: 1px;" wire:change="$set('id_subcriterio',{{$loop->index}})"
                                             class="form-control form-control-sm @error('subcriterio'.$desc->id) is-invalid @enderror" min="1" max="100" wire:model="descripcion_avanzada.{{$loop->index}}.valor_min" type="number">
                                        </div>
                                    </div>
                                    
                                    <div class="row" style="margin-top:3px">
                                        <div class="col-sm-1">
                                            <small>máx.</small>
                                        </div>
                                        <div class="col-sm-9">
                                            <input title="Magnitud que se aplica el subcriterio" style="font-size:small;padding: 1px;" wire:change="$set('id_subcriterio',{{$loop->index}})" 
                                            class="form-control form-control-sm @error('subcriterio'.$desc->id) is-invalid @enderror" min="1" max="100" wire:model="descripcion_avanzada.{{$loop->index}}.valor_max" type="number">
                                        </div>
                                    </div>
                                </div>
                            @elseif($desc->magnitud == "frecuencia")
                                <textarea style="font-size:small" class="form-control shadow ml-1" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.text"></textarea>
                                <div class="col-8 mt-1">
                                    <input type="number" id="subcriterio{{$criterio->id.$desc->id}}" style="display:none" wire:model="id_subcriterio">
                        
                                    <select style="font-size:small;" title="Magnitud que se aplica el subcriterio" 
                                    class="form-control p-1 @error('subcriterio'.$desc->id) is-invalid @enderror" name="frecuencias" wire:model="descripcion_avanzada.{{$loop->index}}.frecuencia">
                                        <option wire:ignore value="Nunca">1.- Nunca</option>
                                        <option wire:ignore value="Casi nunca">2.- Casi nunca</option>
                                        <option wire:ignore value="Ocasionalmente">3.- Ocasionalmente</option>
                                        <option wire:ignore value="A veces">4.- A veces</option>
                                        <option wire:ignore value="A menudo">5.- A menudo</option>
                                        <option wire:ignore value="Generalmente">6.- Generalmente</option>
                                        <option wire:ignore value="Usualmente">7.- Usualmente</option>
                                        <option wire:ignore value="Siempre">8.- Siempre</option>
                                    </select>
                                </div>
                            @else
                                <textarea style="font-size:small" class="form-control shadow ml-1" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.text"></textarea>
                            @endif
                        </div>
                        
                        <div class="form-row">
                            <div class="col-6">
                                <div class="input-group mb-1">
                                        <input title="Porcentaje de importancia del subcriterio." style="font-size:small" class="form-control @error('subcriterios_porcentajes'.$criterio->id) is-invalid @enderror" min="1" max="100" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.porcentaje" wire:change="porcentajeChange({{$loop->index}})" type="number"/>
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
                        @error('subcriterio'.$desc->id)
                            <div class="alert-danger p-1 rounded border-danger" style="width:94%">
                                <small class="error text-danger"><b>- {{ $message }}</b></small> 
                            </div>
                        @enderror
                        @if($criterio->aspecto->criterios->first()->id == $criterio->id)
                            @error('subcriterios_porcentajes'.$criterio->id)
                                <div class="alert-danger p-1 rounded border-danger" style="width:94%">
                                    <small class="error text-danger"><b>- {{ $message }}</b></small> 
                                </div>
                            @enderror
                        @endif
                        @if($loop->index != (count($descripcion_avanzada)-1))
                            <hr class="bg-dark">
                        @endif
                        </li>
                    @endforeach
                    
                </ul>
            @else
                <textarea style="font-size:small" type='text' class='form-control shadow-md' wire:model.lazy="criterio.descripcion" rows="10" cols="40" required></textarea>
            @endif
        </div>
    @else
        <div style="height:10px" class="d-flex justify-content-center">
            <div wire:loading>
                <x-loading-small></x-loading-small>
            </div>
        </div>
        <div>
            @if($criterio_avanzado == true)
                <ul>
                @foreach($descripcion_avanzada as $desc)
                        <li wire:key="{{$loop->index}}">
                        <small style="font-size:11px"> <b>ID#{{$desc->id}}</b></small>
                        <div class="form-row mb-1">
                            @if($desc->magnitud == "porcentaje1")
                                <div class="col-8">
                                    <textarea disabled style="font-size:small" class="form-control shadow">{{$desc->text}}</textarea>
                                </div>
                                
                                <div class="col-4" >
                                    <input type="number" id="subcriterio{{$criterio->id.$desc->id}}" style="display:none" wire:model="id_subcriterio">
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <input disabled title="Magnitud que se aplica el subcriterio" style="font-size:small;margin-left:-5px" onchange="setIdSubcriterio({{$criterio->id}},{{$desc->id}})" class="p-1 form-control col-12 @error('subcriterio'.$desc->id) is-invalid @enderror" min="1" max="100" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.porcentaje_magnitud" type="number">
                                        </div>
                                        <div class="w-3" style="margin-left:-13px" >
                                            <small>%</small> 
                                        </div>
                                    </div>
                                    
                                    <div class="row" style="margin-top:-2px">
                                        <div class="col-sm-7">
                                            <small>Asc-></small>
                                        </div>
                                    </div>
                                </div>
                            @elseif($desc->magnitud == "escala")
                                <div class="col-8">
                                    <textarea disabled style="font-size:small" class="form-control shadow" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.text"></textarea>
                                </div>
                                
                                <div class="col-3">
                                    <input type="number" id="subcriterio{{$criterio->id.$desc->id}}" style="display:none" wire:model="id_subcriterio">
                                    <input disabled title="Magnitud que se aplica el sub-criterio"  style="font-size:small;margin-left:-5px" onchange="setIdSubcriterio({{$criterio->id}},{{$desc->id}})" class="input col-12" min="1" max="100" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.escala_magnitud" type="number">
                                    
                                </div>
                            @elseif($desc->magnitud == "porcentaje2")
                                <div class="col-8">
                                    <textarea disabled style="font-size:small" class="form-control shadow" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.text"></textarea>
                                </div>
                                
                                <div class="col-4" >
                                    <input type="number" id="subcriterio{{$criterio->id.$desc->id}}" style="display:none" wire:model="id_subcriterio">
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <input disabled title="Magnitud que se aplica el subcriterio" style="font-size:small;margin-left:-5px" onchange="setIdSubcriterio({{$criterio->id}},{{$desc->id}})" class="p-1 form-control col-12 @error('subcriterio'.$desc->id) is-invalid @enderror"   min="1" max="100" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.porcentaje_magnitud" type="number">
                                        </div>
                                        <div class="w-3" style="margin-left:-13px" >
                                            <small>%</small> 
                                        </div>
                                    </div>
                                    
                                    <div class="row" style="margin-top:-2px">
                                        <div class="col-sm-8">
                                            <small>desc-></small>
                                        </div>
                                    </div>
                                </div>
                            @elseif($desc->magnitud == "rango_asc")
                                <div class="col-8">
                                    <textarea disabled style="font-size:small" class="form-control shadow" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.text"></textarea>
                                </div>
                                
                                <div class="col-4" style="margin-top:-4px;;margin-left:-5px">
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
                            @elseif($desc->magnitud == "frecuencia")
                                <textarea disabled style="font-size:small" class="form-control shadow ml-1">{{$desc->text}}</textarea>

                                
                                <div class="col-8 mt-1">
                                    <!-- <input type="number" id="subcriterio{{$criterio->id.$desc->id}}" style="display:none" wire:model="id_subcriterio"> -->
                        
                                    <select disabled style="font-size:small;" title="Magnitud que se aplica el subcriterio" 
                                    class="form-control p-1 @error('subcriterio'.$desc->id) is-invalid @enderror" wire:change="$set('id_subcriterio',{{$desc->id}})"  name="frecuencias" wire:model="descripcion_avanzada.{{$loop->index}}.frecuencia">
                                        <option wire:ignore value="Nunca">1.- Nunca</option>
                                        <option wire:ignore value="Casi nunca">2.- Casi nunca</option>
                                        <option wire:ignore value="Ocasionalmente">3.- Ocasionalmente</option>
                                        <option wire:ignore value="A veces">4.- A veces</option>
                                        <option wire:ignore value="A menudo">5.- A menudo</option>
                                        <option wire:ignore value="Generalmente">6.- Generalmente</option>
                                        <option wire:ignore value="Usualmente">7.- Usualmente</option>
                                        <option wire:ignore value="Siempre">8.- Siempre</option>
                                    </select>
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
        var opcion = confirm("Se eliminarán los subcriterios de todos los niveles de desempeño, ¿Está Seguro?")
        if (opcion == true) {
            Livewire.emit('removeSubCriteria'+idaspecto,idloop)
        }
    }
    </script>

</th>
