<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'curso';
    protected $fillable = ['titulo', 'descricao', 'atributos'];

    public function Matricula()
    {
        return $this->belongsTo('App\Matricula', 'curso_id');
    }

    public function ListaMatriculas()
    {
        return $this->hasMany('App\Curso');
    }
}
