

<tr>
    <th class='col-4'><input type='text' class='form-control' wire:model="nombre"></th>
    @foreach($aspecto->criterios as $criterio)
        <!-- <th><textarea type='text' class='form-control'>{{$criterio->descripcion}}</textarea></th> -->
        @livewire('criterio-component',['criterio' => $criterio],key($criterio->descripcion))
    @endforeach
</tr>

