<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<table>
    <tbody>
        <tr >
            <td colspan="2" align="center"><strong>{{ $rubrica->titulo }}</strong></td>
        </tr>
        <tr >
            <th style="border:1px solid #000000" ><strong>Descripción: </strong></th>
            <td style="border:1px solid #000000">{{ $rubrica->descripcion }}</td>
        </tr>
        <tr >
            <th style="border:1px solid #000000"><strong>Evaluación: </strong></th>
            <td style="border:1px solid #000000">{{ $rubrica->evaluacion->nombre }}</td>
        </tr>
        <tr style="border:1px solid #000000">
            <th style="border:1px solid #000000"><strong>Módulo: </strong></th>
            <td style="border:1px solid #000000">{{ $rubrica->evaluacion->modulo->nombre }}</td>
        </tr>
    </tbody>
</table>
<br>
@foreach ($rubrica->dimensiones as $dimension)
    <table style="border: 1px dashed #CCC" id="table{{$dimension->id}}">
        <thead class="bg-secondary">
            <tr>
                <th style="border:1px solid #000000;font-size:16">
                    <div class="row">
                        <p> <strong>{!!nl2br($dimension->nombre."\n".$dimension->porcentaje)!!}% </strong></p>
                    </div>
                </th>

                @foreach($dimension->nivelesDesempeno as $nivel)
                <th style="border:1px solid #000000;font-size:16" >
                    <p ><strong>{!!nl2br($nivel->nombre."\n")!!}</strong></p>
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
                    <th valign="top" style="border:1px solid #000000" >
                        <div class="row">
                            <div class="col-12">
                                <small>{!!nl2br($aspecto->nombre."\n")!!}</small>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-8" style="margin-top: 6px">
                                <small>{{$aspecto->porcentaje}}%</small>
                            </div>

                        </div>
                    </th>

                    @foreach($aspecto->criterios as $criterio)
                        <th valign="top" style="border:1px solid #000000" >
                            @if($criterio->deshabilitado==0)
                                <div >
                                @if(empty($criterio->descripcion))
                                            @foreach(json_decode($criterio->descripcion_avanzada) as $desc)
                                                    <div class="form-row mb-1">
                                                        @if($desc->magnitud == "porcentaje1")
                                                            <div class="col">
                                                                <small>- {!!nl2br($desc->text)!!} [Magnitud:{{$desc->porcentaje_magnitud}}%]{!!nl2br("\n")!!}</small>
                                                            </div>
                                                        @else
                                                            <div class="col">
                                                                <small>- {!!nl2br($desc->text."\n")!!}</small>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="form-row">
                                                        <div class="col">
                                                            <small><i>[Peso:{{$desc->porcentaje}}%]{!!nl2br("\n")!!}</i></small>
                                                        </div>
                                                    </div>
                                                @endforeach

                                        @else
                                        <small style="white-space: pre-line;">{!!nl2br($criterio->descripcion)!!}</small>
                                    @endif
                                </div>
                            @else
                                <div class="justify-content-center">
                                    
                                </div>
                            @endif
                        </th>

                    @endforeach
                </tr>
            @endforeach
        </tbody>
        </table>
    <br>
@endforeach