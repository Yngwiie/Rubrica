<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    
    <!-- Styles -->
    <!-- 
    <link rel="stylesheet" href="{{ mix('css/app.css') }}"> -->
    
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"> 
</head>
<body style="font-family: 'Nunito', sans-serif;">
        <form>
            <div class="form-group justify-content-center row">
                    <h1>{{$rubrica->titulo}}</h1>
            </div>
            <div class="form-group justify-content-center row">
                <p>{{$rubrica->descripcion}}</p>
            </div>
            <div class="form-group row">
                @if($rubrica->plantilla != 1)
                    <div class="col">
                        <p><strong>Evaluación:</strong> {{$rubrica->evaluacion->nombre}}</p>
                    </div>
                @endif
            </div>
            <div class="form-group row">
                @if($rubrica->plantilla != 1)
                    <div class="col">
                        <p><strong>Módulo:</strong> {{$rubrica->evaluacion->modulo->nombre}}</p>
                    </div>
                    
                @endif
            </div>
        </form>
        <hr class="bg-dark">
    @foreach ($rubrica->dimensiones as $dimension)
        <table class="table shadow" style="font-size:smaller"id="table{{$dimension->id}}">
            <thead class="bg-secondary">
                <tr>
                    <th >
                        <p style="color:white">{{$dimension->nombre}}</p>
                        <div class="row">
                            <div class="col-sm-8" style="margin-top:4px">
                                <small style="color:white">{{$dimension->porcentaje}} %</small>
                            </div>
                        </div>
                    </th>

                    @foreach($dimension->nivelesDesempeno as $nivel)
                    <th >
                        <p style="color:white">{{$nivel->nombre}}</p>
                        <div class="row">
                            <div class="col-sm-6" style="margin-top:4px">
                                <small style="color:white">Puntaje: {{$nivel->puntaje}}</small>
                            </div>
                        </div> 
                    </th>

                    @endforeach
                </tr>
            </thead>
            <tbody>

                @foreach($dimension->aspectos as $aspecto)
                    <tr style="background-color: #c9c9c9">
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
</body>
</html>