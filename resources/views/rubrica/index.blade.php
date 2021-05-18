<x-app-layout>
    <div class="container">
        @include('mensajes-flash')
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        {{ Breadcrumbs::render('constructor') }}
            <div class="card-deck">
                <div class="card shadow-lg">
                    <img class="card-img-top" src="{{asset('images/cero.png')}}" alt="Card image cap">
                    
                    <div class="card-body">
                        <h4 class="card-title"><strong><i class="fas fa-wrench"></i> Desde cero</strong></h4>
                        <p class="card-text">Elaborar una rúbrica desde cero, definiendo todos los componentes
                            como se estime conveniente.</p>
                    </div>
                    <div class="card-footer text-right">
                        <a  href="{{route('rubric.cero')}}"class="btn btn-md btn-secondary">Continuar</a>
                    </div>
                </div>
                <div class="card shadow-lg">
                    <img class="card-img-top" src="{{asset('images/template.png')}}" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title"><strong><i class="fas fa-wrench"></i> A partir de una plantilla</strong></h4>
                        <p class="card-text">Elaborar una rúbrica a partir de una plantilla predefinida, la cual podrá
                            modificar a su gusto.
                        </p>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('plantillas')}}" class="btn btn-md btn-secondary">Continuar</a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>