<div class="container p-4" id="contenedor">
    @include('mensajes-flash')
    <form >
        <div class="form-group row">
            <label for="titulo" class="col-sm-2 col-form-label"><strong>Titulo</strong></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="titulo" wire:model.defer="rubrica.titulo" placeholder="Titulo">
            </div>
        </div>
        <div class="form-group row">
            <label for="Descripcion" class="col-sm-2 col-form-label"><strong>Descripción</strong></label>
            <div class="col-sm-5">
                <textarea type="text" class="form-control" id="Descripcion" wire:model.defer="rubrica.descripcion" placeholder="Descripción"></textarea>
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
        <button onclick="anadirDimension()" class="btn btn-md btn-sec add-dim"><i
                class="far fa-lg fa-plus-square"></i> Añadir Dimensión</button>
        <button class="btn btn-success" onclick="emitir()">Guardar Cambios</button>
    </div>
    <hr class="bg-dark">

    @foreach ($rubrica->dimensiones as $dimension)
        <button type="button" onclick="anadirAspecto({{$dimension->id}})" class="btn btn-md btn-sec add-row"><i
                class="far fa-lg fa-plus-square"></i>  Añadir Aspecto</button>
        <button type="button" class="btn btn-md btn-sec add-row"><i
                wire:click="storeNivel({{$dimension->id}})" class="far fa-lg fa-plus-square"></i>  Añadir Nivel</button>
        <button type="button" class="btn btn-md btn-sec add-row" onclick="deleteDimension({{$dimension->id}})" style="color:red">
                <i class="fas fa-lg fa-times"></i>  Eliminar Dimensión</button>
        
        <table class="table table-responsive-md table-bordered" id="table{{$dimension->id}}">
            <thead class="bg-secondary">
                <tr >
                    
                    @livewire('dimension-component',['dimension' => $dimension],key($dimension->id))
                    
                    @foreach($dimension->nivelesDesempeno as $nivel)    
                        @livewire('nivel-desempeno-component',['nivel' => $nivel], key($nivel->id))
                    @endforeach
                </tr>  
            </thead>
            <tbody>
                
                @foreach($dimension->aspectos as $aspecto)
                    @livewire('aspecto-component',['aspecto' => $aspecto],key($loop->index))
                   
                @endforeach
            </tbody>
        </table>
        <br>
    @endforeach
    <!-- Modal Eliminar dimension -->
    <div wire:ignore.self class="modal fade" id="deleteDimension" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Eliminar Dimensión</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro de eliminar esta dimension?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="deleteDimension()">Eliminar Dimension</button>

                </div>
            </div>
        </div>
    </div>
</div>
 
<script>
                
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 4000);
</script>

<script>
    function anadirAspecto(i){
        var markup = "<tr><th class='col-4'><input type='text' class='form-control' placeholder='Aspecto '></th>"+
                    "<th><input type='text' class='form-control' placeholder='Criterio'></th>"+
                    "<th><input type='text' class='form-control' placeholder='Criterio'></th>"+
                    "<th><input type='text' class='form-control' placeholder='Criterio'></th>";
        $("#table"+i+" > tbody").append(markup);
    }
    function emitir(){
        
        Livewire.emit('update')
        var contenedor = document.getElementById('contenedor_carga');

        contenedor.style.visibility = 'visible';
        contenedor.style.opacity = '0.9';
    }
    function anadirAspecto(id){
        var contenedor = document.getElementById('contenedor_carga');

        contenedor.style.visibility = 'visible';
        contenedor.style.opacity = '0.9';
        Livewire.emit('storeAspecto',id)
        
    }
    function anadirDimension(id){
        var contenedor = document.getElementById('contenedor_carga');

        contenedor.style.visibility = 'visible';
        contenedor.style.opacity = '0.9';
        Livewire.emit('storeDimension')
        
    }
    function deleteDimension(id){
        var opcion = confirm("¿Está Seguro?")
        if(opcion == true){
            var contenedor = document.getElementById('contenedor_carga');

            contenedor.style.visibility = 'visible';
            contenedor.style.opacity = '0.9';
            Livewire.emit('deleteDimension',id)
        }
        
        
    }
</script>