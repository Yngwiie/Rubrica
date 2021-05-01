<div class="container">
    
    <div class="max-w-9xl mx-auto py-10 sm:px-6 lg:px-8">

    @if($misRubricas==1)
        {{ Breadcrumbs::render('rubricaEstadistica',$rubrica_aplicada) }}
    @elseif($misRubricas==2)
        {{ Breadcrumbs::render('estadisticas',$rubrica_aplicada->evaluacion->rubrica) }}
    @else
        {{ Breadcrumbs::render('rubricaAsociadaEstadistica',$rubrica_aplicada) }}
    @endif

    @if($pocosDatos == false)
        <div class="card shadow-lg">
            <div class="card-header">
                <h3>Estadísticas</h3>
                <h6>Módulo: {{$rubrica_aplicada->evaluacion->modulo->nombre}}<i></i></h6>
                <h6>Evaluación: {{$rubrica_aplicada->evaluacion->nombre}}<i></i></h6>
            </div>
            <div class="card-body" >
                <div class="d-flex justify-content-center mt-2">
                    <b style="font-size:13px">Estudiantes Aprobados/Reprobados</b>
                </div>
                <div style="height: 400px !important">
                    <livewire:livewire-pie-chart
                        :pie-chart-model="$pieChartModel"
                    />
                </div>
                @if($tipo_puntaje == "unico")
                    <hr class="bg-dark">
                    <div class="d-flex justify-content-center mt-2">
                        <b style="font-size:13px">Promedio notas en dimensiones de aspectos</b>
                    </div>
                    <div style="height: 400px !important">
                        <livewire:livewire-column-chart
                            :column-chart-model="$columnChartModel"
                        />
                    </div>
                @endif
            </div>
        <div>
    @else
        <div class="card shadow-lg">
            <div class="card-header">
                <h3>Estadísticas</h3>
                <h6>Módulo: {{$rubrica_aplicada->evaluacion->modulo->nombre}}<i></i></h6>
                <h6>Evaluación: {{$rubrica_aplicada->evaluacion->nombre}}<i></i></h6>
            </div>
            <div class="card-body" >
                <h3>No hay suficientes datos.</h3>
            </div>
        <div>

    @endif
    </div>
    
</div>
