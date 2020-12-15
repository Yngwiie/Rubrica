<div class="container p-4" id="contenedor">
    @include('mensajes-flash')
    <form >
        <div class="form-group row">
            <label for="titulo" class="col-sm-2 col-form-label"><strong>Titulo</strong></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="titulo" value="{{$rubrica->titulo}}"placeholder="Titulo">
            </div>
        </div>
        <div class="form-group row">
            <label for="Descripcion" class="col-sm-2 col-form-label"><strong>Descripción</strong></label>
            <div class="col-sm-5">
                <textarea type="text" class="form-control" id="Descripcion" placeholder="Descripción">{{$rubrica->descripcion}}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="Descripcion" class="col-sm-2 col-form-label"><strong>Evaluación Asociada</strong></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="Descripcion" disabled placeholder="Evaluación" value="{{$rubrica->evaluacion->nombre}} - {{$rubrica->evaluacion->modulo->nombre}}">
            </div>
        </div>
    </form>
    <div class="mb-2">
        <button class="btn btn-md btn-sec add-dim"><i
                class="far fa-lg fa-plus-square"></i> Añadir Dimensión</button>
        <button class="btn btn-primary float-right" wire:click="$emit('update')">Guardar Cambios</button>
    </div>
    <hr class="bg-dark">
    @foreach ($rubrica->dimensiones as $dimension)
       <!--  <button type="button" onclick="anadirAspecto({{$dimension->id}})" class="btn btn-primary add-row" value="Añadir Aspecto"></button> -->
        <button type="button" wire:click="storeAspect({{$dimension->id}})" class="btn btn-md btn-sec add-row"><i
                class="far fa-lg fa-plus-square"></i>  Añadir Aspecto</button>
        <button type="button" class="btn btn-md btn-sec add-row"><i
                class="far fa-lg fa-plus-square"></i>  Añadir Nivel</button>
        <table class="table table-bordered" id="table{{$dimension->id}}">
            <tbody>
                <tr class="bg-secondary">
                    @livewire('dimension-component',['dimension' => $dimension],key($dimension->id))
                    <!-- <th class="col-4"><input type="text" class="form-control" value="{{$dimension->nombre}}"></th> -->
                    @foreach($dimension->nivelesDesempeno as $nivel)
                        @livewire('nivel-desempeno-component',['nivel' => $nivel], key($nivel->id))
                        <!-- <th><input type="text" class="form-control" value="{{$nivel->nombre}}"></th> -->
                    @endforeach
                </tr>  
                @foreach($dimension->aspectos as $aspecto)
                    @livewire('aspecto-component',['aspecto' => $aspecto],key($aspecto->key))
                    <!-- <tr>
                        <th class='col-4'><input type='text' class='form-control' value="{{$aspecto->nombre}}"></th>
                        @foreach($aspecto->criterios as $criterio)
                            <th><input type='text' class='form-control' value="{{$criterio->descripcion}}"></th>
                        @endforeach
                    </tr> -->
                @endforeach
                
                <!-- @livewire('aspecto-component',['dimension' => $dimension],key($dimension->key)) -->
        </table>
        <br>
    @endforeach
    
</div>
<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 4000);
</script>
<script>
$(document).ready(function(){
        $(".add-dim").click(function(){
            var markup = "<button type='button'  class='btn btn-md btn-sec add-row'><i "+
                "class='far fa-lg fa-plus-square'></i>  Añadir Aspecto</button>"+
            "<button type='button' class='btn btn-md btn-sec'><i "+
                "class='far fa-lg fa-plus-square'></i>  Añadir Nivel</button>"+
            "<table class='table table-bordered' id='table{{$dimension->id}}'>"+
                "<tbody>"+
                    "<tr class='bg-secondary'>"+
                        "<th class='col-4'><input type='text' class='form-control' placeholder='Nombre Dimensión'></th>"+
                        "<th><input type='text' class='form-control' placeholder='Nivel 1'></th>"+
                        "<th><input type='text' class='form-control' placeholder='Nivel 2'></th>"+
                        "<th><input type='text' class='form-control' placeholder='Nivel 3'></th>"+
                    "</tr>"+  
                    "<tr>"+
                        "<th class='col-4'><input type='text' class='form-control' placeholder='Aspecto '></th>"+
                        "<th><input type='text' class='form-control' placeholder='Criterio'></th>"+
                        "<th><input type='text' class='form-control' placeholder='Criterio'></th>"+
                        "<th><input type='text' class='form-control' placeholder='Criterio'></th>"+
                    "</tr>"+
                    "<tr>"+
                        "<th class='col-4'><input type='text' class='form-control' placeholder='Aspecto '></th>"+
                        "<th><input type='text' class='form-control' placeholder='Criterio'></th>"+
                        "<th><input type='text' class='form-control' placeholder='Criterio'></th>"+
                        "<th><input type='text' class='form-control' placeholder='Criterio'></th>"+
                    "</tr>"+    
                "</tbody>"+
            "</table>"+
            "<br>";
        $("#contenedor").append(markup);
        });
    });
function anadirAspecto(i){
    var markup = "<tr><th class='col-4'><input type='text' class='form-control' placeholder='Aspecto '></th>"+
                "<th><input type='text' class='form-control' placeholder='Criterio'></th>"+
                "<th><input type='text' class='form-control' placeholder='Criterio'></th>"+
                "<th><input type='text' class='form-control' placeholder='Criterio'></th>";
    $("#table"+i+" > tbody").append(markup);
}
</script>