<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Rubrica;
use App\Models\Dimension;
use App\Models\NivelDesempeno;
use App\Models\Aspecto;
use App\Models\Modulo;
use App\Models\Criterio;
use App\Models\Evaluacion;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $usuario = User::create([
            'name' => "Javier Aliaga",
            'email' => "reivaj_31@hotmail.com",
            'password' => Hash::make("12345678"),
            'email_verified_at' => now(),
        ]);
        
        $modulo = Modulo::create([
            'nombre' => "memoria",
            'id_usuario' => $usuario->id,
        ]);

        Evaluacion::create([
            'nombre' => "Prueba 1",
            'fecha' => now(),
            'id_modulo' => $modulo->id,
        ]);
        /**
         * Rubrica 1 - plantilla trabajo en equipo
         * 
         */
        $rubrica1 = Rubrica::create([
            'titulo' => "Trabajo en equipo",
            'descripcion' => "El trabajo en equipo es un comportamiento que está bajo el control de cada uno de los miembros del equipo (el esfuerzo que ponen en las tareas del equipo, su forma de interactuar con los demás en el equipo y la cantidad y calidad de contribuciones que hacen en la toma de desición del equipo).",
            'plantilla' => TRUE,
        ]);
        $dimension1 = Dimension::create([
            'nombre' => 'Trabajo en equipo',
            'id_rubrica' => $rubrica1->id,
            'porcentaje' => 100,
        ]);
        $nivel1 = NivelDesempeno::create([
            'nombre' => 'Necesita mejorar',
            'ordenJerarquico' => 1,
            'id_dimension' => $dimension1->id,
            'puntaje' => 1,
        ]);
        $nivel2 = NivelDesempeno::create([
            'nombre' => 'En desarrollo',
            'ordenJerarquico' => 2,
            'id_dimension' => $dimension1->id,
            'puntaje' => 2,
        ]);
        $nivel3 = NivelDesempeno::create([
            'nombre' => 'Suficiente',
            'ordenJerarquico' => 3,
            'id_dimension' => $dimension1->id,
            'puntaje' => 3,
        ]);
        $nivel4 = NivelDesempeno::create([
            'nombre' => 'Superior al promedio',
            'ordenJerarquico' => 4,
            'id_dimension' => $dimension1->id,
            'puntaje' => 4,
        ]);
        
        
        $aspecto1 = Aspecto::create([
            'nombre' => 'Contribuye en las reuniones del equipo',
            'id_dimension' => $dimension1->id,
            'porcentaje' => 20,
        ]);
        Criterio::create([
            'descripcion' => 'Comparte ideas pero no hace avanzar el trabajo del grupo.',
            'id_aspecto' => $aspecto1->id,
            'id_nivel' => $nivel1->id,
        ]);
        Criterio::create([
            'descripcion' => 'Ofrece nuevas sugerencias para avanzar en el trabajo del grupo.',
            'id_aspecto' => $aspecto1->id,
            'id_nivel' => $nivel2->id,
        ]);
        Criterio::create([
            'descripcion' => 'Ofrece soluciones o lineas de acción alternativas que se basan en las ideas de otros.',
            'id_aspecto' => $aspecto1->id,
            'id_nivel' => $nivel3->id,
        ]);
        Criterio::create([
            'descripcion' => 'Ayuda al equipo a avanzar articulando los méritos de las ideas o propuestas alternativas.',
            'id_aspecto' => $aspecto1->id,
            'id_nivel' => $nivel4->id,
        ]);
        $aspecto2 = Aspecto::create([
            'nombre' => 'Facilita la participacion de los miembros del equipo.',
            'id_dimension' => $dimension1->id,
            'porcentaje' => 20,
        ]);
        Criterio::create([
            'descripcion' => 'Hace participar a los miembros del equipo tomando turnos y escuchando a los demás sin interrumpir.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel1->id,
        ]);
        Criterio::create([
            'descripcion' => 'Hace partícipes a los miembros del equipo de forma que facilite sus contribuciones a las reuniones, reafirmando las opiniones de otros miembros del equipo y/o haciendo preguntas de aclaración.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel2->id,
        ]);
        Criterio::create([
            'descripcion' => 'Hace partícipes a los miembros del equipo de manera que faciliten sus contribuciones a las reuniones, aprovechando o sintetizando constructivamente las contribuciones de los demás.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel3->id,
        ]);
        Criterio::create([
            'descripcion' => 'Hace partícipes a los miembros del equipo de forma que se faciliten sus contribuciones a las reuniones, tanto aprovechando o sintetizando de forma constructiva las contribuciones de los demás, como notando cuando alguien no está participando e invitándole a participar.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel4->id,
        ]);
        $aspecto2 = Aspecto::create([
            'nombre' => 'Contribuciones individuales fuera de las reuniones de equipo',
            'id_dimension' => $dimension1->id,
            'porcentaje' => 20,
        ]);
        Criterio::create([
            'descripcion' => 'Completa todas las tareas asignadas en el plazo previsto',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel1->id,
        ]);
        Criterio::create([
            'descripcion' => 'Completa todas las tareas asignadas dentro del plazo; el trabajo realizado hace avanzar el proyecto.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel2->id,
        ]);
        Criterio::create([
            'descripcion' => 'Completa todas las tareas asignadas dentro del plazo;el trabajo realizado es minucioso, exhaustivo y hace avanzar el proyecto',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel3->id,
        ]);
        Criterio::create([
            'descripcion' => 'Completa todas las tareas asignadas dentro del plazo;el trabajo realizado es minucioso, exhaustivo y hace avanzar el proyecto. Ayuda de forma proactiva a otros miembros del equipo a completar las tareas asignadas con un nivel de excelencia similar.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel4->id,
        ]);

        $aspecto2 = Aspecto::create([
            'nombre' => 'Fomenta un clima de equipo constructivo',
            'id_dimension' => $dimension1->id,
            'porcentaje' => 20,
        ]);
        Criterio::create([
            'descripcion' => 'Apoya un clima de equipo constructivo haciendo cualquiera de las siguientes acciones:
- Tratar a los miembros del equipo con respeto, siendo educado y constructivo en la comunicación.
- Utiliza un tono vocal o escrito positivo, expresiones faciales y/o lenguaje corporal para transmitir una actitud positiva sobre el equipo y su trabajo.
- Motiva a los compañeros de equipo expresando confianza en la importancia de la tarea y en la capacidad del equipo para llevarla a cabo.
- Proporciona ayuda y/o ánimo a los miembros del equipo.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel1->id,
        ]);
        Criterio::create([
            'descripcion' => 'Apoya un clima de equipo constructivo haciendo cualquiera de las siguientes acciones:
- Tratar a los miembros del equipo con respeto, siendo educado y constructivo en la comunicación.
- Utiliza un tono vocal o escrito positivo, expresiones faciales y/o lenguaje corporal para transmitir una actitud positiva sobre el equipo y su trabajo.
- Motiva a los compañeros de equipo expresando confianza en la importancia de la tarea y en la capacidad del equipo para llevarla a cabo.
- Proporciona ayuda y/o ánimo a los miembros del equipo.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel2->id,
        ]);
        Criterio::create([
            'descripcion' => 'Apoya un clima de equipo constructivo haciendo cualquiera de las siguientes acciones:
- Tratar a los miembros del equipo con respeto, siendo educado y constructivo en la comunicación.
- Utiliza un tono vocal o escrito positivo, expresiones faciales y/o lenguaje corporal para transmitir una actitud positiva sobre el equipo y su trabajo.
- Motiva a los compañeros de equipo expresando confianza en la importancia de la tarea y en la capacidad del equipo para llevarla a cabo.
- Proporciona ayuda y/o ánimo a los miembros del equipo.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel3->id,
        ]);
        Criterio::create([
            'descripcion' => 'Apoya un clima de equipo constructivo haciendo cualquiera de las siguientes acciones:
- Tratar a los miembros del equipo con respeto, siendo educado y constructivo en la comunicación.
- Utiliza un tono vocal o escrito positivo, expresiones faciales y/o lenguaje corporal para transmitir una actitud positiva sobre el equipo y su trabajo.
- Motiva a los compañeros de equipo expresando confianza en la importancia de la tarea y en la capacidad del equipo para llevarla a cabo.
- Proporciona ayuda y/o ánimo a los miembros del equipo.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel4->id,
        ]);
        $aspecto2 = Aspecto::create([
            'nombre' => 'Respuesta al conflicto.',
            'id_dimension' => $dimension1->id,
            'porcentaje' => 20,
        ]);
        Criterio::create([
            'descripcion' => 'Acepta pasivamente puntos de vista/ideas/opiniones alternativas.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel1->id,
        ]);
        Criterio::create([
            'descripcion' => 'Redirigir la atención hacia un terreno común, hacia la tarea en cuestión (lejos del conflicto).',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel2->id,
        ]);
        Criterio::create([
            'descripcion' => 'Identifica y reconoce el conflicto y se mantiene comprometido con él.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel3->id,
        ]);
        Criterio::create([
            'descripcion' => 'Aborda los conflictos destructivos de forma directa y constructiva, ayudando a gestionarlos/resolverlos de forma que se refuerce la cohesión general del equipo y la eficacia futura.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel4->id,
        ]);
        
        /**
         * Rubrica 2
         */
        $rubrica1 = Rubrica::create([
            'titulo' => "Comunicación Oral",
            'descripcion' => "La comunicación oral es una presentación preparada y con un propósito diseñado para aumentar el conocimiento, fomentar la comprensión o promover cambios en las actitudes, valores, creencias o comportamientos de los oyentes.",
            'plantilla' => TRUE,
        ]);
        $dimension1 = Dimension::create([
            'nombre' => 'Comunicación Oral',
            'id_rubrica' => $rubrica1->id,
            'porcentaje' => 100,
        ]);
        $nivel1 = NivelDesempeno::create([
            'nombre' => 'Necesita mejorar',
            'ordenJerarquico' => 1,
            'id_dimension' => $dimension1->id,
            'puntaje' => 1,
        ]);
        $nivel2 = NivelDesempeno::create([
            'nombre' => 'En desarrollo',
            'ordenJerarquico' => 2,
            'id_dimension' => $dimension1->id,
            'puntaje' => 2,
        ]);
        $nivel3 = NivelDesempeno::create([
            'nombre' => 'Suficiente',
            'ordenJerarquico' => 3,
            'id_dimension' => $dimension1->id,
            'puntaje' => 3,
        ]);
        $nivel4 = NivelDesempeno::create([
            'nombre' => 'Superior al promedio',
            'ordenJerarquico' => 4,
            'id_dimension' => $dimension1->id,
            'puntaje' => 4,
        ]);
        $aspecto1 = Aspecto::create([
            'nombre' => 'Organización',
            'id_dimension' => $dimension1->id,
            'porcentaje' => 20,
        ]);
        Criterio::create([
            'descripcion' => 'El patrón organizativo (introducción y conclusión específicas, material secuenciado dentro del cuerpo y transiciones) no es observable dentro de la presentación.',
            'id_aspecto' => $aspecto1->id,
            'id_nivel' => $nivel1->id,
        ]);
        Criterio::create([
            'descripcion' => 'El patrón organizativo (introducción y conclusión específicas, material secuenciado dentro del cuerpo y transiciones) se observa de forma intermitente dentro de la presentación',
            'id_aspecto' => $aspecto1->id,
            'id_nivel' => $nivel2->id,
        ]);
        Criterio::create([
            'descripcion' => 'El patrón organizativo (introducción y conclusión específicas, material secuenciado dentro del cuerpo y transiciones) es clara y consistentemente observable dentro de la presentación.',
            'id_aspecto' => $aspecto1->id,
            'id_nivel' => $nivel3->id,
        ]);
        Criterio::create([
            'descripcion' => 'El patrón de organización (introducción y conclusión específicas, material secuenciado dentro del cuerpo, y transiciones) es clara y consistentemente observable y es hábil y hace que el contenido de la presentación sea cohesivo.',
            'id_aspecto' => $aspecto1->id,
            'id_nivel' => $nivel4->id,
        ]);
        $aspecto2 = Aspecto::create([
            'nombre' => 'Lenguaje.',
            'id_dimension' => $dimension1->id,
            'porcentaje' => 20,
        ]);
        Criterio::create([
            'descripcion' => 'Las elecciones linguísticas son poco claras y apoyan mínimamente la eficacia de la presentación. El lenguaje de la presentación no es apropiado para la audiencia.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel1->id,
        ]);
        Criterio::create([
            'descripcion' => 'Las elecciones linguísticas son mundanas y comunes y apoyan parcialmente la eficacia de la presentación. El lenguaje de la presentación es apropiado para la audiencia.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel2->id,
        ]);
        Criterio::create([
            'descripcion' => 'Las elecciones lingüísticas son reflexivas y, en general, apoyan la eficacia de la presentación. El lenguaje de la presentación es apropiado para la audiencia.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel3->id,
        ]);
        Criterio::create([
            'descripcion' => 'Las elecciones lingüísticas son imaginativas, memorables y convincentes, y aumentan la eficacia de la presentación. El lenguaje de la presentación es apropiado para la audiencia.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel4->id,
        ]);
        $aspecto2 = Aspecto::create([
            'nombre' => 'Tecnica para presentar.',
            'id_dimension' => $dimension1->id,
            'porcentaje' => 20,
        ]);
        Criterio::create([
            'descripcion' => 'Las técnicas de presentación (postura, gestos, contacto visual y expresividad vocal) restan comprensibilidad a la presentación y el presentador se muestra incómodo.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel1->id,
        ]);
        Criterio::create([
            'descripcion' => 'Las técnicas de presentación (postura, gestos, contacto visual y expresividad vocal) hacen que la presentación sea comprensible, y el presentador parece tímido.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel2->id,
        ]);
        Criterio::create([
            'descripcion' => 'Las técnicas de presentación (postura, gestos, contacto visual y expresividad vocal) hacen que la presentación sea interesante y que el presentador se sienta cómodo.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel3->id,
        ]);
        Criterio::create([
            'descripcion' => 'Las técnicas de presentación (postura, gestos, contacto visual y expresividad vocal) hacen que la presentación sea convincente, y el presentador se muestra pulido y seguro.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel4->id,
        ]);

        $aspecto2 = Aspecto::create([
            'nombre' => 'Material de apoyo.',
            'id_dimension' => $dimension1->id,
            'porcentaje' => 20,
        ]);
        Criterio::create([
            'descripcion' => 'Los materiales de apoyo insuficientes (explicaciones, ejemplos, ilustraciones, estadísticas, analogías, citas de autoridades relevantes) hacen referencia a información o análisis que apoyan mínimamente la presentación o establecen la credibilidad/autoridad del presentador en el tema.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel1->id,
        ]);
        Criterio::create([
            'descripcion' => 'Los materiales de apoyo (explicaciones, ejemplos, ilustraciones, estadísticas, analogías, citas de autoridades relevantes) hacen referencia apropiada a información o análisis que apoyan parcialmente la presentación o establecen la credibilidad/autoridad del presentador en el tema.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel2->id,
        ]);
        Criterio::create([
            'descripcion' => 'Los materiales de apoyo (explicaciones, ejemplos, ilustraciones, estadísticas, analogías, citas de autoridades relevantes) hacen referencia apropiada a la información o al análisis que generalmente apoya la presentación o establece la credibilidad/autoridad del presentador en el tema.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel3->id,
        ]);
        Criterio::create([
            'descripcion' => 'Una variedad de tipos de materiales de apoyo (explicaciones, ejemplos, ilustraciones, estadísticas, analogías, citas de autoridades relevantes) hacen referencia apropiada a información o análisis que apoyan significativamente la presentación o establecen la credibilidad/autoridad del presentador en el tema.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel4->id,
        ]);
        $aspecto2 = Aspecto::create([
            'nombre' => 'Tema central.',
            'id_dimension' => $dimension1->id,
            'porcentaje' => 20,
        ]);
        Criterio::create([
            'descripcion' => 'El mensaje central puede deducirse, pero no se indica explícitamente en la presentación.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel1->id,
        ]);
        Criterio::create([
            'descripcion' => 'El mensaje central es básicamente comprensible, pero no se repite a menudo y no es memorable.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel2->id,
        ]);
        Criterio::create([
            'descripcion' => 'El mensaje central es claro y coherente con el material de apoyo.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel3->id,
        ]);
        Criterio::create([
            'descripcion' => 'El mensaje central es convincente (se enuncia con precisión, se repite adecuadamente, se recuerda y se apoya con fuerza).',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel4->id,
        ]);


        /**
         * Rubrica 3 - Resolucion de problemas
         */
        $rubrica1 = Rubrica::create([
            'titulo' => "Resolución de problemas",
            'descripcion' => "La resolución de problemas es el proceso de diseñar, evaluar y aplicar una estrategia para responder a una pregunta abierta o alcanzar un objetivo deseado.",
            'plantilla' => TRUE,
        ]);
        $dimension1 = Dimension::create([
            'nombre' => 'Resolución de problemas',
            'id_rubrica' => $rubrica1->id,
            'porcentaje' => 100,
        ]);
        $nivel1 = NivelDesempeno::create([
            'nombre' => 'Necesita mejorar',
            'ordenJerarquico' => 1,
            'id_dimension' => $dimension1->id,
            'puntaje' => 1,
        ]);
        $nivel2 = NivelDesempeno::create([
            'nombre' => 'En desarrollo',
            'ordenJerarquico' => 2,
            'id_dimension' => $dimension1->id,
            'puntaje' => 2,
        ]);
        $nivel3 = NivelDesempeno::create([
            'nombre' => 'Suficiente',
            'ordenJerarquico' => 3,
            'id_dimension' => $dimension1->id,
            'puntaje' => 3,
        ]);
        $nivel4 = NivelDesempeno::create([
            'nombre' => 'Superior al promedio',
            'ordenJerarquico' => 4,
            'id_dimension' => $dimension1->id,
            'puntaje' => 4,
        ]);
        $aspecto1 = Aspecto::create([
            'nombre' => 'Definición del problema',
            'id_dimension' => $dimension1->id,
            'porcentaje' => 17,
        ]);
        Criterio::create([
            'descripcion' => 'Demuestra una capacidad limitada para identificar el planteamiento del problema o los factores contextuales relacionados.',
            'id_aspecto' => $aspecto1->id,
            'id_nivel' => $nivel1->id,
        ]);
        Criterio::create([
            'descripcion' => 'Comienza a demostrar la capacidad de construir el planteamiento de un problema con evidencia de los factores contextuales más relevantes, pero el planteamiento del problema es superficial.',
            'id_aspecto' => $aspecto1->id,
            'id_nivel' => $nivel2->id,
        ]);
        Criterio::create([
            'descripcion' => 'Demuestra la capacidad de construir el planteamiento del problema con evidencia de los factores contextuales más relevantes, y el planteamiento del problema está adecuadamente detallado.',
            'id_aspecto' => $aspecto1->id,
            'id_nivel' => $nivel3->id,
        ]);
        Criterio::create([
            'descripcion' => 'Demuestra la capacidad de construir un planteamiento claro y perspicaz del problema con evidencia de todos los factores contextuales relevantes.',
            'id_aspecto' => $aspecto1->id,
            'id_nivel' => $nivel4->id,
        ]);
        $aspecto2 = Aspecto::create([
            'nombre' => 'Identificar las estrategias.',
            'id_dimension' => $dimension1->id,
            'porcentaje' => 17,
        ]);
        Criterio::create([
            'descripcion' => 'Identifica uno o varios enfoques para resolver el problema que no se aplican en un contexto específico.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel1->id,
        ]);
        Criterio::create([
            'descripcion' => 'Identifica un único enfoque para resolver el problema que sí se aplica dentro de un contexto específico.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel2->id,
        ]);
        Criterio::create([
            'descripcion' => 'Identifica múltiples enfoques para resolver el problema, de los cuales sólo algunos se aplican en un contexto específico.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel3->id,
        ]);
        Criterio::create([
            'descripcion' => 'Identifica múltiples enfoques para resolver el problema que se aplican dentro de un contexto específico.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel4->id,
        ]);
        $aspecto2 = Aspecto::create([
            'nombre' => 'Propuestas de solución/hipótesis',
            'id_dimension' => $dimension1->id,
            'porcentaje' => 17,
        ]);
        Criterio::create([
            'descripcion' => 'Propone una solución/hipótesis que es difícil de evaluar porque es vaga o sólo aborda indirectamente el planteamiento del problema.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel1->id,
        ]);
        Criterio::create([
            'descripcion' => 'Propone una solución/hipótesis que es "de cajón" en lugar de estar diseñada individualmente para abordar los factores contextuales específicos del problema.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel2->id,
        ]);
        Criterio::create([
            'descripcion' => 'Propone una o más soluciones/hipótesis que indican la comprensión del problema. Las soluciones/hipótesis son sensibles a los factores contextuales, así como a una de las siguientes dimensiones: ética, lógica o cultural del problema.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel3->id,
        ]);
        Criterio::create([
            'descripcion' => 'Propone una o más soluciones/hipótesis que indican una profunda comprensión del problema. Las soluciones/hipótesis son sensibles a los factores contextuales, así como a todas las dimensiones éticas, lógicas y culturales del problema.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel4->id,
        ]);

        $aspecto2 = Aspecto::create([
            'nombre' => 'Evaluar las posibles soluciones.',
            'id_dimension' => $dimension1->id,
            'porcentaje' => 17,
        ]);
        Criterio::create([
            'descripcion' => 'La evaluación de las soluciones es superficial (por ejemplo, contiene una explicación superficial) e incluye lo siguiente: considera la historia del problema, revisa la lógica/razonamiento, examina la viabilidad de la solución y considera los impactos de la misma.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel1->id,
        ]);
        Criterio::create([
            'descripcion' => 'La evaluación de las soluciones es breve (por ejemplo, la explicación carece de profundidad) e incluye lo siguiente: considera la historia del problema, revisa la lógica/razonamiento, examina la viabilidad de la solución y considera los impactos de la misma.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel2->id,
        ]);
        Criterio::create([
            'descripcion' => 'La evaluación de las soluciones es adecuada (por ejemplo, contiene una explicación exhaustiva) e incluye lo siguiente: considera la historia del problema, revisa la lógica/razonamiento, examina la viabilidad de la solución y considera los impactos de la misma.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel3->id,
        ]);
        Criterio::create([
            'descripcion' => 'La evaluación de las soluciones es profunda y elegante (por ejemplo, contiene una explicación exhaustiva y perspicaz) e incluye, de forma profunda y exhaustiva, todo lo siguiente: considera la historia del problema, revisa la lógica/razonamiento, examina la viabilidad de la solución y considera los impactos de la misma',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel4->id,
        ]);
        $aspecto2 = Aspecto::create([
            'nombre' => 'Implementar la solución.',
            'id_dimension' => $dimension1->id,
            'porcentaje' => 17,
        ]);
        Criterio::create([
            'descripcion' => 'Implementa la solución de una manera que no aborda directamente el planteamiento del problema.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel1->id,
        ]);
        Criterio::create([
            'descripcion' => 'Implementa la solución de manera que aborda el planteamiento del problema pero ignora los factores contextuales relevantes.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel2->id,
        ]);
        Criterio::create([
            'descripcion' => 'Implementa la solución de manera que aborda múltiples factores contextuales del problema de manera superficial.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel3->id,
        ]);
        Criterio::create([
            'descripcion' => 'Implementa la solución de manera que aborda a fondo y en profundidad múltiples factores contextuales del problema.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel4->id,
        ]);
        $aspecto2 = Aspecto::create([
            'nombre' => 'Evaluar los resultados.',
            'id_dimension' => $dimension1->id,
            'porcentaje' => 15,
        ]);
        Criterio::create([
            'descripcion' => 'Revisa los resultados superficialmente en términos del problema definido sin considerar la necesidad de trabajo adicional.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel1->id,
        ]);
        Criterio::create([
            'descripcion' => 'Revisa los resultados en función del problema definido con poca o ninguna consideración sobre la necesidad de seguir trabajando.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel2->id,
        ]);
        Criterio::create([
            'descripcion' => 'Revisa los resultados relativos al problema definido con alguna consideración sobre la necesidad de seguir trabajando.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel3->id,
        ]);
        Criterio::create([
            'descripcion' => 'Revisa los resultados relativos al problema definido con consideraciones exhaustivas y específicas sobre la necesidad de seguir trabajando.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel4->id,
        ]);

        /**
         * Rúbrica 4
         * 
         * Participación en clases
         */
        $rubrica1 = Rubrica::create([
            'titulo' => "Participación en clases",
            'descripcion' => "La participación en clase es una estrategia para fomentar el aprendizaje activo y reflexivo por parte de los estudiantes.",
            'plantilla' => TRUE,
        ]);
        $dimension1 = Dimension::create([
            'nombre' => 'Participación en clases',
            'id_rubrica' => $rubrica1->id,
            'porcentaje' => 100,
        ]);
        $nivel1 = NivelDesempeno::create([
            'nombre' => 'Problemas serios',
            'ordenJerarquico' => 1,
            'id_dimension' => $dimension1->id,
            'puntaje' => 1,
        ]);
        $nivel2 = NivelDesempeno::create([
            'nombre' => 'Bajo de las expectativas',
            'ordenJerarquico' => 2,
            'id_dimension' => $dimension1->id,
            'puntaje' => 2,
        ]);
        $nivel3 = NivelDesempeno::create([
            'nombre' => 'Suficiente',
            'ordenJerarquico' => 3,
            'id_dimension' => $dimension1->id,
            'puntaje' => 3,
        ]);
        $nivel4 = NivelDesempeno::create([
            'nombre' => 'Superior al promedio',
            'ordenJerarquico' => 4,
            'id_dimension' => $dimension1->id,
            'puntaje' => 4,
        ]);
        $aspecto1 = Aspecto::create([
            'nombre' => 'Participación Activa',
            'id_dimension' => $dimension1->id,
            'porcentaje' => 25,
        ]);
        Criterio::create([
            'descripcion' => 'Ausente, no contribuye.',
            'id_aspecto' => $aspecto1->id,
            'id_nivel' => $nivel1->id,
        ]);
        Criterio::create([
            'descripcion' => 'Pocas contribuciones; rara vez se ofrece como voluntario, pero responde a las consultas directas.',
            'id_aspecto' => $aspecto1->id,
            'id_nivel' => $nivel2->id,
        ]);
        Criterio::create([
            'descripcion' => 'Contribuye voluntariamente al debate sin que se le solicite.',
            'id_aspecto' => $aspecto1->id,
            'id_nivel' => $nivel3->id,
        ]);
        Criterio::create([
            'descripcion' => 'Contribuye de forma activa y regular al debate; inicia el debate sobre cuestiones relacionadas con el tema de la clase.',
            'id_aspecto' => $aspecto1->id,
            'id_nivel' => $nivel4->id,
        ]);
        $aspecto2 = Aspecto::create([
            'nombre' => 'Relevancia de la participación en el tema que se debate.',
            'id_dimension' => $dimension1->id,
            'porcentaje' => 25,
        ]);
        Criterio::create([
            'descripcion' => 'Las contribuciones se salen del tema o distraen a la clase del debate.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel1->id,
        ]);
        Criterio::create([
            'descripcion' => 'Las contribuciones a veces se salen del tema o distraen.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel2->id,
        ]);
        Criterio::create([
            'descripcion' => 'Las contribuciones son siempre relevantes para el debate.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel3->id,
        ]);
        Criterio::create([
            'descripcion' => 'Las contribuciones son relevantes y promueven el análisis en profundidad del material.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel4->id,
        ]);
        $aspecto2 = Aspecto::create([
            'nombre' => 'Evidencias del nivel de preparación',
            'id_dimension' => $dimension1->id,
            'porcentaje' => 25,
        ]);
        Criterio::create([
            'descripcion' => 'No se ha preparado adecuadamente; no parece haber leído el material antes de la clase.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel1->id,
        ]);
        Criterio::create([
            'descripcion' => 'Parece haber leído el material, pero no detenidamente o no ha leído todo el material.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel2->id,
        ]);
        Criterio::create([
            'descripcion' => 'Leer y reflexionar claramente sobre el material antes de la clase.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel3->id,
        ]);
        Criterio::create([
            'descripcion' => 'Se prepara con regularidad; investiga y comparte material relevante no asignado explícitamente.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel4->id,
        ]);

        $aspecto2 = Aspecto::create([
            'nombre' => 'Escucha/Cooperación.',
            'id_dimension' => $dimension1->id,
            'porcentaje' => 25,
        ]);
        Criterio::create([
            'descripcion' => 'No está atento o hace comentarios inapropiados o perturbadores.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel1->id,
        ]);
        Criterio::create([
            'descripcion' => 'Participa ocasionalmente; no responde a las contribuciones de los demás.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel2->id,
        ]);
        Criterio::create([
            'descripcion' => 'Participa regularmente sin monopolizar; escucha y responde a las contribuciones de los demás.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel3->id,
        ]);
        Criterio::create([
            'descripcion' => 'Es un modelo de buen comportamiento en el aula. Escucha sin interrumpir. Responde adecuadamente a los demás. Promueve la participación activa de los demás.',
            'id_aspecto' => $aspecto2->id,
            'id_nivel' => $nivel4->id,
        ]);
       
    }
}
