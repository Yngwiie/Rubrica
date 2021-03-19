<th>
    <textarea type='text' class='form-control shadow-md' wire:model="criterio.descripcion" rows="8" cols="40" required></textarea>
    <div>
        @error('criterio.descripcion') <small class="error text-danger">{{ $message }}</small> @enderror
    </div>
    
</th>
