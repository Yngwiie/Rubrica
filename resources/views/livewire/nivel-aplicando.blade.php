<th style="width:250px" >
    <p style="width:200px;color:white">{{$nombre}}</p>
    
    <div class="row">
        @if($rubrica->tipo_puntaje=="unico")
            <div class="col-sm-10" style="margin-top:4px">
                <small style="color:white">Puntaje {{$puntaje}}</small>
            </div>
        @elseif($rubrica->tipo_puntaje=="rango")
            <div class="col-sm-12" style="margin-top:4px">
                <small style="color:white">Mín. {{$puntaje_minimo}}</small>
                <small style="color:white">Máx. {{$puntaje_maximo}}</small>
        @endif
    </div> 
    <div class="row">
        @error('puntaje_minimo') <small class="error text-warning">{{ $message }}</small> @enderror        
    </div>
    <div class="row">
        @error('puntaje_maximo') <small class="error text-warning">{{ $message }}</small> @enderror        
    </div>
    <div class="row">
        @error('orden_rangos') <small class="error text-warning">{{ $message }}</small> @enderror         
    </div>
    <div class="row">
        @error('puntaje') <small class="error text-warning">{{ $message }}</small> @enderror         
    </div>
    <script>
    function deleteNivel(id) {
        var opcion = confirm("¿Está seguro de eliminar el nivel completo?");
        if (opcion) {
            Livewire.emit('deleteLevel', id)
            var contenedor = document.getElementById('contenedor_carga');

            contenedor.style.visibility = 'visible';
            contenedor.style.opacity = '0.9';
        }
    }
    </script>
</th>