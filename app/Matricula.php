<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    protected $table = 'matricula';
    protected $fillable = ['curso_id', 'aluno_id'];

    public function getCurso()
    {
        return Curso::where('id', '=', $this->curso_id);
    }
}
