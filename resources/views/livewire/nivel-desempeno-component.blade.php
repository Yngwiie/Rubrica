<th >
    <input type="text" name="nombre" class="input" wire:model="nombre">
    <div class="row">
        <div class="col-sm-6" style="margin-top:4px">
            <small style="color:white">Puntaje </small><input style="font-size:small" type="number" class="input col-6 shadow-md">
        </div>
        @if($nivel->ordenJerarquico>3)
        <div class="col">
            <button class="btn btn-sm btn-danger" style="margin-top:4px" wire:loading.attr="disabled"><i class="fas fa-md fa-times"></i></button>
        </div>
        @endif
    </div> 
</th>

