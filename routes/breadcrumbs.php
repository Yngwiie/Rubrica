<?php

// Home
Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Modulos', route('dashboard'));
});


// modulos > [modulo]
Breadcrumbs::for('modulo', function ($trail, $modulo) {
    $trail->parent('dashboard');
    $trail->push($modulo->nombre, route('show.modulo', $modulo));
});

// constructor 
Breadcrumbs::for('constructor', function ($trail) {
    $trail->push('Constructor', route('rubric.index'));
});

// constructor > [desdeCero]
Breadcrumbs::for('cero', function ($trail) {
    $trail->parent('constructor');
    $trail->push('Desde Cero', route('rubric.cero'));
});

// constructor > [plantilla]
Breadcrumbs::for('plantilla', function ($trail) {
    $trail->parent('constructor');
    $trail->push('Plantillas', route('plantillas'));
});
?>