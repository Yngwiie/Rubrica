<div class="container">
    
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="card shadow-lg">

            <div class="card-header">
                {{ Breadcrumbs::render('modulo', $modulo) }}

            </div>
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" role="tab" data-toggle="tab" href="#evaluaciones">Evaluaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " role="tab" data-toggle="tab" href="#estudiantes">Estudiantes</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="evaluaciones" role="tabpanel" aria-labelledby="pills-home-tab">
                        @include('livewire.evaluaciones')
                    </div>
                    <div class="tab-pane " id="estudiantes" role="tabpanel" aria-labelledby="pills-profile-tab">
                        @livewire('estudiantes',['id_modulo' => $modulo->id])
                    </div>
                </div>


            </div>

        </div>


        
    </div>
</div>