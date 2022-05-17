<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $table = 'aluno';
    protected $fillable = ['nome', 'email', 'data_nascimento'];

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }
}
