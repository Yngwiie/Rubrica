<th style="border-top: 1px solid #8F9194;">
    @if($revision == 0)
        @if($deshabilitado == 0)
            <div>
                @if($criterio_avanzado == true)
                    <ul >
                        @foreach($descripcion_avanzada as $desc)
                            <li wire:key="{{$loop->index}}">
                            <small style="font-size:11px"> <b>ID#{{$desc->id}}</b></small>
                            
                            @if($desc->aplicado == true)
                                <div class="p-1" style="background-color:#D0FFD0">
                                    <div class="form-row mb-1">
                                        @if($desc->magnitud == "porcentaje1")
                                            <div class="w-41 ml-1">
                                                <small>{!!nl2br($desc->text)!!}</small>
                                                <small><b>[Magnitud: {{$desc->porcentaje_magnitud}}%]</b></small>
                                            </div>
                                    
                                        @elseif($desc->magnitud == "escala")
                                            <div class="w-41 ml-1">
                                                <small>{!!nl2br($desc->text)!!}</small>
                                                <small><b>[Magnitud: {{$desc->escala_magnitud}}]</b></small>
                                            </div>
                                        @elseif($desc->magnitud == "porcentaje2")
                                            <div class="w-41 ml-1">
                                                <small>{!!nl2br($desc->text)!!}</small>
                                                <small><b>[Magnitud: {{$desc->porcentaje_magnitud}}%]</b></small>
                                            </div>
                                        @elseif($desc->magnitud == "rango_asc")
                                            <div class="w-41 ml-1">
                                                <small>{!!nl2br($desc->text)!!}</small>
                                                <small><b>[Magnitud: {{$desc->valor_min}}->{{$desc->valor_max}}]</b></small>
                                            </div>
                                        @elseif($desc->magnitud == "frecuencia")
                                            <div class="w-41 ml-1">
                                                <small>{!!nl2br($desc->text)!!}</small>
                                                <small><b>[Magnitud: {{$desc->frecuencia}}]</b></small>
                                            </div>
                                        @else
                                            <div class="w-41 ml-1">
                                                <small>{!!nl2br($desc->text)!!}</small>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="col-6">
                                            <div class="input-group mb-1">
                                                <small><i>[Peso: {{$desc->porcentaje}}%]</i></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="p-1">
                                    <div class="form-row mb-1">
                                        @if($desc->magnitud == "porcentaje1")
                                            <div class="w-41 ml-1">
                                                <small>{!!nl2br($desc->text)!!}</small>
                                                <small><b>[Magnitud: {{$desc->porcentaje_magnitud}}%]</b></small>
                                            </div>
                                    
                                        @elseif($desc->magnitud == "escala")
                                            <div class="w-41 ml-1">
                                                <small>{!!nl2br($desc->text)!!}</small>
                                                <small><b>[Magnitud: {{$desc->escala_magnitud}}]</b></small>
                                            </div>
                                        @elseif($desc->magnitud == "porcentaje2")
                                            <div class="w-41 ml-1">
                                                <small>{!!nl2br($desc->text)!!}</small>
                                                <small><b>[Magnitud: {{$desc->porcentaje_magnitud}}%]</b></small>
                                            </div>
                                        @elseif($desc->magnitud == "rango_asc")
                                            <div class="w-41 ml-1">
                                                <small>{!!nl2br($desc->text)!!}</small>
                                                <small><b>[Magnitud: {{$desc->valor_min}}->{{$desc->valor_max}}]</b></small>
                                            </div>
                                        @elseif($desc->magnitud == "frecuencia")
                                            <div class="w-41 ml-1">
                                                <small>{!!nl2br($desc->text)!!}</small>
                                                <small><b>[Magnitud: {{$desc->frecuencia}}]</b></small>
                                            </div>
                                        @else
                                            <div class="w-41 ml-1">
                                                <small>{!!nl2br($desc->text)!!}</small>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="col-6">
                                            <div class="input-group mb-1">
                                                <small><i>[Peso: {{$desc->porcentaje}}%]</i></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($loop->index != (count($descripcion_avanzada)-1))
                                <hr class="bg-dark">
                            @endif
                            </li>
                            
                        @endforeach
                        <div>
                            @error('subcriterio') <small class="error text-danger"><b>{{ $message }}</b></small> @enderror
                        </div>
                    </ul>
                @else
                    @if($aplicado==0)
                        <div class="p-1" >
                            <small >{!!nl2br($criterio->descripcion)!!}</small>
                        </div>
                    @else
                        <div class="p-1" style="background-color:#D0FFD0">
                            <small >{!!nl2br($criterio->descripcion)!!}</small>
                        </div>
                    @endif
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="blankCheckbox" value="1" wire:loading.attr="disabled" wire:model="aplicado" style="margin-top:6px">
                        <small ><strong>Aplicado</strong></small>
                        <div wire:loading wire:target="aplicado">
                                <x-loading-small></x-loading-small>
                        </div>
                    </div>
                @endif
            </div>

        @endif
    @else
        @if($deshabilitado == 0)
            <div>
                @if($criterio_avanzado == true)
                    <ul >
                        @foreach($descripcion_avanzada as $desc)
                            <li wire:key="{{$loop->index}}">
                            @if($desc->aplicado == true)
                                <div class="p-1" style="background-color:#D0FFD0">
                                    <div class="form-row mb-1">
                                        @if($desc->magnitud == "porcentaje1")
                                            <div class="w-41 ml-1">
                                                <small>{!!nl2br($desc->text)!!}</small>
                                                <small><b>[Magnitud: {{$desc->porcentaje_magnitud}}%]</b></small>
                                            </div>
                                    
                                        @elseif($desc->magnitud == "escala")
                                            <div class="w-41 ml-1">
                                                <small>{!!nl2br($desc->text)!!}</small>
                                                <small><b>[Magnitud: {{$desc->escala_magnitud}}]</b></small>
                                            </div>
                                        @elseif($desc->magnitud == "porcentaje2")
                                            <div class="w-41 ml-1">
                                                <small>{!!nl2br($desc->text)!!}</small>
                                                <small><b>[Magnitud: {{$desc->porcentaje_magnitud}}%]</b></small>
                                            </div>
                                        @elseif($desc->magnitud == "rango_asc")
                                            <div class="w-41 ml-1">
                                                <small>{!!nl2br($desc->text)!!}</small>
                                                <small><b>[Magnitud: {{$desc->valor_min}}->{{$desc->valor_max}}]</b></small>
                                            </div>
                                        @elseif($desc->magnitud == "frecuencia")
                                            <div class="w-41 ml-1">
                                                <small>{!!nl2br($desc->text)!!}</small>
                                                <small><b>[Magnitud: {{$desc->frecuencia}}]</b></small>
                                            </div>
                                        @else
                                            <div class="w-41 ml-1">
                                                <small>{!!nl2br($desc->text)!!}</small>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="col-6">
                                            <div class="input-group mb-1">
                                                <small><i>[Peso: {{$desc->porcentaje}}%]</i></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="p-1">
                                    <div class="form-row mb-1">
                                        @if($desc->magnitud == "porcentaje1")
                                            <div class="w-41 ml-1">
                                                <small>{!!nl2br($desc->text)!!}</small>
                                                <small><b>[Magnitud: {{$desc->porcentaje_magnitud}}%]</b></small>
                                            </div>
                                    
                                        @elseif($desc->magnitud == "escala")
                                            <div class="w-41 ml-1">
                                                <small>{!!nl2br($desc->text)!!}</small>
                                                <small><b>[Magnitud: {{$desc->escala_magnitud}}]</b></small>
                                            </div>
                                        @elseif($desc->magnitud == "porcentaje2")
                                            <div class="w-41 ml-1">
                                                <small>{!!nl2br($desc->text)!!}</small>
                                                <small><b>[Magnitud: {{$desc->porcentaje_magnitud}}%]</b></small>
                                            </div>
                                        @elseif($desc->magnitud == "rango_asc")
                                            <div class="w-41 ml-1">
                                                <small>{!!nl2br($desc->text)!!}</small>
                                                <small><b>[Magnitud: {{$desc->valor_min}}->{{$desc->valor_max}}]</b></small>
                                            </div>
                                        @elseif($desc->magnitud == "frecuencia")
                                            <div class="w-41 ml-1">
                                                <small>{!!nl2br($desc->text)!!}</small>
                                                <small><b>[Magnitud: {{$desc->frecuencia}}]</b></small>
                                            </div>
                                        @else
                                            <div class="w-41 ml-1">
                                                <small>{!!nl2br($desc->text)!!}</small>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="col-6">
                                            <div class="input-group mb-1">
                                                <small><i>[Peso: {{$desc->porcentaje}}%]</i></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($loop->index != (count($descripcion_avanzada)-1))
                                <hr class="bg-dark">
                            @endif
                            </li>
                            
                        @endforeach
                        <div>
                            @error('subcriterio') <small class="error text-danger"><b>{{ $message }}</b></small> @enderror
                        </div>
                    </ul>
                @else
                    @if($aplicado==0)
                        <div class="p-1" >
                            <small >{!!nl2br($criterio->descripcion)!!}</small>
                    </div>
                    @else
                        <div class="p-1" style="background-color:#D0FFD0">
                            <small >{!!nl2br($criterio->descripcion)!!}</small>
                    </div>
                    @endif
                @endif
            </div>

        @endif
    @endif
    
</th>
