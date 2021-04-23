<tr style="background-color: #c9c9c9;">
    <th >
        <div class="row">
            <div class="col-sm-9">
                <small>{{$aspecto->nombre}}</small>
            </div>

        </div>
        <div class="row">
            <div class="col-sm-8" style="margin-left: 27px;margin-top: 3px">
                <small>{{$aspecto->porcentaje}}%</small>
            </div>

        </div>
        

    </th>

    @foreach($aspecto->criterios as $criterio)
        @if($revision == 1)
            <livewire:criterio-aplicando :criterio="$criterio" :revision="true" :key="time().$loop->index">
        @else
            <livewire:criterio-aplicando :criterio="$criterio" :key="time().$loop->index">
        @endif
        
    @endforeach
    @if($revision == 0)
        <th>
            <div class="row p-2">
                <textarea style="font-size:small" type='text' class='form-control shadow-md' wire:model.lazy="aspecto.comentario" placeholder="Comentarios" 
                    rows="5" cols="20"></textarea> 
            </div>
        </th>
    @else
        <th style="border-left: 1px solid #8F9194;">
            <div class="row p-2" >
                <small><b>{{$aspecto->comentario}}</b></small>
            </div>
        </th>
    @endif
</tr>
