<?php

namespace App\Imports;

use App\Models\Estudiante;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Models\Modulo_estudiante;
use App\Models\estudiante_evaluacion;
use App\Models\Evaluacion;

class StudentsImport implements ToModel, WithValidation, WithHeadingRow
{
    public $id_modulo;
    public function __construct($id_modulo)
    {
        $this->id_modulo = $id_modulo;
    }


    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $estudiante = Estudiante::where('email',$row['email'])->first();
        if($estudiante == null){
            $estudiante = Estudiante::create([
                'nombre' => $row['nombre'],
                'apellido' => $row['apellido'],
                'email' => $row['email'],
            ]);
            $evaluaciones_modulo = Evaluacion::where('id_modulo',$this->id_modulo)->get();

            foreach($evaluaciones_modulo as $evaluacion){
                estudiante_evaluacion::create([
                    'id_estudiante' => $estudiante->id,
                    'id_evaluacion' => $evaluacion->id,
                ]);
            }

            return new Modulo_estudiante([
                'id_modulo' => $this->id_modulo,
                'id_estudiante' => $estudiante->id,
            ]);
        }else{
            $modulo_estudiante = Modulo_estudiante::where('id_modulo',$this->id_modulo)->where('id_estudiante',$estudiante->id)->first();
            if($modulo_estudiante == null){
                $evaluaciones_modulo = Evaluacion::where('id_modulo',$this->id_modulo)->get();

                foreach($evaluaciones_modulo as $evaluacion){
                    estudiante_evaluacion::create([
                        'id_estudiante' => $estudiante->id,
                        'id_evaluacion' => $evaluacion->id,
                    ]);
                }

                return new Modulo_estudiante([
                    'id_modulo' => $this->id_modulo,
                    'id_estudiante' => $estudiante->id,
                ]);
            }
            
        }
        
    }


    public function rules(): array
    {
        return [
            '*.nombre' => ['required'],
            '*.apellido' => ['required'],
            '*.email' => ['required','email'],
        ];
    }
}
