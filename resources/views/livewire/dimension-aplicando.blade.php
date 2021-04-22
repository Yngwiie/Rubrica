<th >
<p style="width:170px;color:white">{{$nombre}}</p>
<div class="row" >
    <div class="col-sm-12" style="margin-top:4px">
        <small style="color:white">{{$porcentaje}}%</small> 
    </div>
</div>
<div class="row">
    <div class="col-8">
        @error('porcentaje') <small class="error text-warning">{{ $message }}</small> @enderror
        @error('nombre') <small class="error text-warning">{{ $message }}</small> @enderror
    </div>
</div>
</th>

