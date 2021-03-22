<th >
<input type="text" class="input" wire:model="nombre" placeholder="Nombre Dimensión">
<input type="number" style="margin-top:4px" class="input col-3" min="0" max="100" wire:model="porcentaje">
<label for="" style="color:white">%</label> 
<div class="row">
    <div class="col-8">
        @error('porcentaje') <small class="error text-warning">{{ $message }}</small> @enderror
        @error('nombre') <small class="error text-warning">{{ $message }}</small> @enderror
    </div>
</div>
</th>

