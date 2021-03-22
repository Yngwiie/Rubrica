@if(session()->has('success'))
<div id="successAlert" class="alert alert-success alert-block animated shake" >

    <button type="button" class="close" data-dismiss="alert">×</button>
    <h5>{{session('success')}}</h5>
</div>
@endif
@if(session()->has('successMini'))
<div id="successAlert" class="alert alert-success alert-block animated shake" >

    <button type="button" class="close" data-dismiss="alert">×</button>
    <small><i class="fas fa-xs fa-check"></i> {{session('successMini')}}</small>
</div>
@endif
@if(session()->has('error'))
<div class="alert alert-danger alert-block animated shake">
    <button type="button" class="close" data-dismiss="alert">×</button>    
    <strong>{{session('error')}}</strong>
</div>
@endif
   
@if(session()->has('warning'))
<div class="alert alert-warning alert-block animated shake">
    <button type="button" class="close" data-dismiss="alert">×</button>    
    <strong>{!!session('warning')!!}</strong>
</div>
@endif
   
@if(session()->has('info'))
<div class="alert alert-info alert-block animated shake">
    <button type="button" class="close" data-dismiss="alert">×</button>    
    <strong>{{session('info')}}</strong>
</div>
@endif
  