<th>


    <textarea type='text' class='input' wire:model="criterio.descripcion" required></textarea>
    <div>
        @error('criterio.descripcion') <small class="error text-danger">{{ $message }}</small> @enderror
    </div>
    
</th>
