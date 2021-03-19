<th ><input type="text" class="input" wire:model="nombre">
<input type="number" style="margin-top:4px" class="input col-3" min="0" max="100" wire:model="porcentaje">
<label for="" style="color:white">%</label> 
@error('porcentaje') <span class="error text-warning">{{ $message }}</span> @enderror
@error('nombre') <span class="error text-warning">{{ $message }}</span> @enderror</th>

