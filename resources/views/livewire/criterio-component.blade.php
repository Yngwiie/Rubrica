<th >
    @if($deshabilitado==0)
        <div>
            @if($criterio_avanzado == true)
                <ul>
                    @foreach($descripcion_avanzada as $desc)
                        <li wire:key="{{$loop->index}}">
                        <div class="form-row mb-1">
                            @if($desc->magnitud == "porcentaje1")
                                <div class="w-41">
                                    <textarea style="font-size:small" class="form-control shadow" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.text"></textarea>
                                </div>
                                
                                <div class="col-3">
                                    <input style="font-size:small;margin-left:-5px" class="input col-12" min="1" max="100" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.porcentaje_magnitud" type="number">
                                    <!-- <small >%</small>  -->
                                </div>
                                <div class="w-3" style="margin-left:-7px" >
                                    <small>%</small> 
                                </div>
                            @else
                                <textarea style="font-size:small" class="form-control shadow ml-1" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.text"></textarea>
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
                <textarea style="font-size:small" type='text' class='form-control shadow-md' wire:model="criterio.descripcion" rows="10" cols="40" required></textarea>
            @endif
        </div>
    @else
        <div>
            @if($criterio_avanzado == true)
                <ul>
                    @foreach($descripcion_avanzada as $desc)
                        <li wire:key="{{$loop->index}}">
                        <div class="form-row mb-1">
                            @if($desc->magnitud == "porcentaje1")
                                <div class="w-41">
                                    <textarea disabled style="font-size:small" class="form-control shadow" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.text" ></textarea>
                                </div>
                                
                                <div class="col-3">
                                    <input disabled style="font-size:small;margin-left:-5px" class="input col-12" min="1" max="100" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.porcentaje_magnitud" type="number">
                                    <!-- <small >%</small>  -->
                                </div>
                                <div class="w-3" style="margin-left:-7px" >
                                    <small>%</small> 
                                </div>
                            @else
                                <textarea disabled style="font-size:small" class="form-control shadow ml-1" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.text"></textarea>
                            @endif
                        </div>
                        
                        <div class="form-row">
                            <div class="col-6">
                                <div class="input-group mb-1">
                                    <input disabled style="font-size:small" class="form-control" min="1" max="100" wire:model.lazy="descripcion_avanzada.{{$loop->index}}.porcentaje" type="number"/>
                                    <div class="input-group-append">
                                        <span style="font-size:small" class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-3" style="font-size:small">
                                <button disabled class="btn btn-sm btn-danger" wire:loading.attr="disabled" wire:click="removeSubCriteria({{$loop->index}})"><i class="fas fa-md fa-times"></i></button>
                            </div>
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
    </div>
</th>
