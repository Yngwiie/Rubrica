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



?>