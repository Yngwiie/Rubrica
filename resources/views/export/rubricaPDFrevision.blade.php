<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    
    
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
                <div class="col">
                    <p><strong>Evaluación:</strong> {{$rubrica->evaluacion->nombre}}</p>
                </div>
            </div>
            <div class="form-group row">
                <div class="col">
                    <p><strong>Módulo:</strong> {{$rubrica->evaluacion->modulo->nombre}}</p>
                </div>
            </div>
            <div class="form-group row">
                <div class="col">
                    <p><strong>Nota Final:</strong> 
                    @if($rubrica->nota==-1)
                        No Calculada
                    @else
                        {{$rubrica->nota}}
                    @endif
                    </p>
                </div>
            </div>
        </form>
        <hr class="bg-dark">
    @foreach ($rubrica->dimensiones as $dimension)
        <table class="table shadow" style="font-size:smaller"id="table{{$dimension->id}}">
            <thead class="bg-secondary">
                <tr>
                    <th >
                        <p style="color:white"><u>{{$dimension->nombre}}</u></p>
                        <div class="row">
                            <div class="col-sm-8" style="margin-top:4px">
                                <small style="color:white"><i>{{$dimension->porcentaje}} %</i></small>
                            </div>
                        </div>
                    </th>

                    @foreach($dimension->nivelesDesempeno as $nivel)
                    <th >
                        <p style="color:white">{{$nivel->nombre}}</p>
                        <div class="row">
                            @if($rubrica->tipo_puntaje=="rango")
                                <div class="col-sm-6" style="margin-top:4px">
                                    <small style="color:white">Puntaje: [{{$nivel->puntaje_minimo}} - {{$nivel->puntaje_maximo}}]</small>
                                </div>
                            @elseif($rubrica->tipo_puntaje=="unico")
                                <div class="col-sm-6" style="margin-top:4px">
                                    <small style="color:white">Puntaje: {{$nivel->puntaje}}</small>
                                </div>
                            @endif
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
                                   <small><i>{{$aspecto->porcentaje}}%</i></small>
                                </div>

                            </div>
                        </th>

                        @foreach($aspecto->criterios as $criterio)
                            <th >
                                @if($criterio->deshabilitado==0)
                                    <div >
                                        @if(empty($criterio->descripcion))
                                            @foreach(json_decode($criterio->descripcion_avanzada) as $desc)
                                                @if($desc->aplicado == true)
                                                    <div style="background-color:#D0FFD0">
                                                        <div class="form-row mb-1">
                                                            @if($desc->magnitud == "porcentaje1")
                                                                <div class="col">
                                                                    <small>- {{$desc->text}} [Magnitud:{{$desc->porcentaje_magnitud}}%]</small>
                                                                </div>
                                                            @elseif($desc->magnitud == "porcentaje2")
                                                                <div class="col">
                                                                    <small>- {{$desc->text}} [Magnitud:{{$desc->porcentaje_magnitud}}%]</small>
                                                                </div>
                                                            @elseif($desc->magnitud == "escala")
                                                                <div class="col">
                                                                    <small>- {{$desc->text}} [Magnitud:#{{$desc->escala_magnitud}}]</small>
                                                                </div>
                                                            @elseif($desc->magnitud == "rango_asc")
                                                                <div class="col">
                                                                    <small>- {{$desc->text}} [Magnitud:[{{$desc->valor_min}}-{{$desc->valor_max}}]</small>
                                                                </div>
                                                            @elseif($desc->magnitud == "frecuencia")
                                                                <div class="col">
                                                                    <small>- {{$desc->text}} [Magnitud:[{{$desc->frecuencia}}]</small>
                                                                </div>
                                                            @else
                                                                <div class="col">
                                                                    <small>- {{$desc->text}}</small>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        
                                                        <div class="form-row">
                                                            <div class="col">
                                                                <small><i>[Peso:{{$desc->porcentaje}}%]</i></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                        <div class="form-row mb-1">
                                                            @if($desc->magnitud == "porcentaje1")
                                                                <div class="col">
                                                                    <small>- {{$desc->text}} [Magnitud:{{$desc->porcentaje_magnitud}}%]</small>
                                                                </div>
                                                            @elseif($desc->magnitud == "porcentaje2")
                                                                <div class="col">
                                                                    <small>- {{$desc->text}} [Magnitud:{{$desc->porcentaje_magnitud}}%]</small>
                                                                </div>
                                                            @elseif($desc->magnitud == "escala")
                                                                <div class="col">
                                                                    <small>- {{$desc->text}} [Magnitud:#{{$desc->escala_magnitud}}]</small>
                                                                </div>
                                                            @elseif($desc->magnitud == "rango_asc")
                                                                <div class="col">
                                                                    <small>- {{$desc->text}} [Magnitud:[{{$desc->valor_min}}-{{$desc->valor_max}}]</small>
                                                                </div>
                                                            @elseif($desc->magnitud == "frecuencia")
                                                                <div class="col">
                                                                    <small>- {{$desc->text}} [Magnitud:[{{$desc->frecuencia}}]</small>
                                                                </div>
                                                            @else
                                                                <div class="col">
                                                                    <small>- {{$desc->text}}</small>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        
                                                        <div class="form-row">
                                                            <div class="col">
                                                                <small><i>[Peso:{{$desc->porcentaje}}%]</i></small>
                                                            </div>
                                                        </div>
                                                @endif
                                            @endforeach

                                        @else
                                            @if($criterio->aplicado==0)
                                                <div class="p-1" >
                                                    <small style="white-space: pre-line;">{{$criterio->descripcion}}</small>
                                                </div>
                                            @else
                                                <div class="p-1" style="background-color:#D0FFD0">
                                                    <small style="white-space: pre-line;">{{$criterio->descripcion}}</small>
                                                </div>
                                            @endif
                                            
                                        @endif
                                    </div>
                                @else
                                    <div class="row justify-content-center">
                                        
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
    <H5>Comentarios</H5>
    @foreach ($rubrica->dimensiones as $dimension)
    <table class="table shadow" style="font-size:smaller"id="table{{$dimension->id}}">
            <thead class="bg-secondary">
                <tr>
                    <th >
                        <p style="color:white"><u>{{$dimension->nombre}}</u></p>
                        <div class="row">
                            <div class="col-sm-8" style="margin-top:4px">
                                <small style="color:white"><i>{{$dimension->porcentaje}} %</i></small>
                            </div>
                        </div>
                    </th>
                    <th>
                        <p style="color:white">Comentarios</p>
                    </th>
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
                        </th>
                        <th>
                            <div class="row p-2" >
                                @if($aspecto->comentario == "")
                                    <small><b>Sin Comentarios</b></small>
                                @else
                                    <small><b>{{$aspecto->comentario}}</b></small>
                                @endif
                            </div>
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>
</html>