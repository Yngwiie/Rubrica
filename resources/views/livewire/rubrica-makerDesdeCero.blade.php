<div class="container">
    @include('mensajes-flash')

    <div class="p-4">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#infoPanel" role="tab" id="adsBack">Info.
                    General</a>
            <li>
            <!-- <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#ads" role="tab" id="infoContinue" disabled>Info.
                    Preliminar</a>
            <li> -->

        </ul>

        <form wire:submit.prevent="store">
            <div class="tab-content mt-4">
                <div class="tab-pane fade show active" id="infoPanel" role="tabpanel" href="#infoPanel">
                    <div class="form-group" id="panel_1">

                        <div class="col-xl-12 mx-auto">
                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label for="inputAddressLine1">Titulo</label>
                                    <label style="color:red"> (*) </label>
                                    <div class="form-group">
                                        <!-- <span class="fas fa-pencil-alt fa-lg form-control-feedback"
                                            aria-hidden="true"></span> -->
                                        <input type="text" class="form-control" id="titulo" oninput="validar();"
                                            name="titulo" wire:model="titulo" placeholder="Ej:Rúbrica Unidad 1">
                                        @error('titulo') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <label for="inputAddressLine2">Evaluación asociada</label>
                                    <label style="color:red"> (*) </label>
                                    <div class="form-group">
                                        <select class="form-control" name="id_evaluacion" wire:model="id_evaluacion">
                                            <option hidden selected>Selecciona una opción</option>
                                            @foreach(Auth::user()->modulos as $modulo)
                                                @foreach($modulo->evaluacion as $evaluacion)
                                                    @if(!$evaluacion->rubrica)
                                                        <option value="{{$evaluacion->id}}">{{$evaluacion->nombre}} -
                                                        {{$evaluacion->modulo->nombre}}</option>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                            
                                        </select>
                                        @error('id_evaluacion') <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="form-group row">

                                <div class="col-sm-8">
                                    <label for="inputAddressLine2">Descripción General</label>
                                    <label style="color:red"> (*) </label>
                                    <div class="form-group">
                                        <textarea type="text" class="form-control" id="descripcion" oninput="validar();"
                                            name="descripcion" wire:model="descripcion"
                                            placeholder="Ej: Rubrica para medir el desempeño de la Unidad 1"></textarea>
                                        @error('descripcion') <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>

                            </div>

                        </div>
                        <label style="color:red">(*)</label>
                        <label>Campos obligatorios</label>
                        <div wire:ignore class="float-right">
                            <button id="btnguardar" class="btn btn-secondary" type="submit" disabled>Guardar</button>
                        </div>
                        <br></br>
                    </div>

                </div>


                <div class="tab-pane fade" id="ads" role="tabpanel" href="#ads">

                    <div class="form-group">
                        <div class="col-xl-12 mx-auto">

                            <div class="form-group row">

                                <div class="col-sm-4">

                                    <label for="inputFirstname">Matrícula</label>
                                    <label style="color:red"> (*) </label>
                                    <div class="form-group icono-input">
                                        <span class="fas fa-hashtag fa-lg form-control-feedback"
                                            aria-hidden="true"></span>
                                        <input type="text" class="form-control" id="matricula" name="matricula"
                                            placeholder="2015307020">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <label style="color:red">(*)</label>
                    <label>Campos obligatorios</label>

                    <div class="float-right">
                        <button type="button" id="adsBack2" class="btn btn-info" data-dismiss="modal">volver</button>
                        <button class="btn btn-secondary" type="submit">Guardar</button>

                    </div>
        </form>
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
function validar() {
    var titulo = document.getElementById("titulo").value;
    var descripcion = document.getElementById("descripcion").value;
    if (titulo.length != 0 && descripcion.length != 0) {
       /*  $("#btnguardar").removeClass('disabled'); */
        $('#btnguardar').prop('disabled', false);


    } else {
        /* $("#btnguardar").addClass('disabled'); */
        $('#btnguardar').prop('disabled', true);
    }
};
$(function() {
    $('#modalToggle').click(function() {
        $('#modal').modal({
            backdrop: 'static'
        });
    });


    $('#infoContinue').click(function(e) {
        e.preventDefault();
        /* $('.progress-bar').css('width', '100%');
        $('.progress-bar').html('Paso 2 de 2'); */
        $('#myTab a[href="#ads"]').tab('show');
    });

    $('#adsBack').click(function(e) {
        e.preventDefault();
        /*  $('.progress-bar').css('width', '50%');
         $('.progress-bar').html('Paso 1 de 2'); */
        $('#myTab a[href="#infoPanel"]').tab('show');
    });
    $('#adsBack2').click(function(e) {
        e.preventDefault();
        /*  $('.progress-bar').css('width', '50%');
         $('.progress-bar').html('Paso 1 de 2'); */
        $('#myTab a[href="#infoPanel"]').tab('show');
    });


    $('#scheduleContinue').click(function(e) {
        var titulo = document.getElementById("titulo").value;
        var descripcion = document.getElementById("descripcion").value;

        if (titulo.length != 0 && descripcion.length != 0) {
            e.preventDefault();
            /*                 $('.progress-bar').css('width', '100%');
                            $('.progress-bar').html('Paso 2 of 2'); */
            $('#myTab a[href="#ads"]').tab('show');
        }
    });
})
</script>
</div>