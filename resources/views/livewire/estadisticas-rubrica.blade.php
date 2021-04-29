<div class="container">
    
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    {{ Breadcrumbs::render('rubricaAsociadaEstadistica',$rubrica_aplicada) }}
        <div class="card shadow-lg">
            <div class="card-header">
                <h3>Estadísticas</h3>
                <h6>Módulo: {{$rubrica_aplicada->evaluacion->modulo->nombre}}<i></i></h6>
                <h6>Evaluación: {{$rubrica_aplicada->evaluacion->nombre}}<i></i></h6>
            </div>
            <div class="card-body" >
                <div style="height: 400px !important">
                    <livewire:livewire-pie-chart
                        :pie-chart-model="$pieChartModel"
                    />
                </div>
                @if($rubrica_aplicada->tipo_puntaje == "unico")
                    <div style="height: 400px !important">
                        <livewire:livewire-column-chart
                            :column-chart-model="$columnChartModel"
                        />
                    </div>
                @endif
            </div>
        <div>
    </div>
    
</div>
