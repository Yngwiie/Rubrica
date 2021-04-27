<th >
<input type="text" class="input" wire:model.lazy="nombre" placeholder="Nombre Dimensión">
<div class="row">
    <div class="col-sm-8" style="margin-top:4px">
        <input type="number" style="margin-top:4px;font-size:small;" class="input col-5" min="0" max="100" wire:model.lazy="porcentaje">
        <small style="color:white">%</small> 
    </div>
</div>
<div class="row">
    <div class="col-8">
        @error('porcentaje') <small class="error text-warning">{{ $message }}</small> @enderror
        @error('nombre') <small class="error text-warning">{{ $message }}</small> @enderror
    </div>
</div>
</th>

