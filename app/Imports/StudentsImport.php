<?php

namespace App\Imports;

use App\Models\Estudiante;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Models\Modulo_estudiante;

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
        $estudiante = Estudiante::create([
            'nombre' => $row['nombre'],
            'apellido' => $row['apellido'],
            'email' => $row['email'],
        ]);

        return new modulo_estudiante([
            'id_modulo' => $this->id_modulo,
            'id_estudiante' => $estudiante->id,
        ]);
    }


    public function rules(): array
    {
        return [
            '*.nombre' => ['required'],
            '*.apellido' => ['required'],
            '*.email' => ['required','email','unique:estudiantes,email'],
        ];
    }
}
