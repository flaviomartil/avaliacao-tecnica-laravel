<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Matricula;

class MatriculaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = Matricula::all();

        foreach ($result as $matricula) {
            $matricula->curso = $matricula->getCurso()->get();
        }

        return count($result) > 0  ? ['response' => $result] :  ['response' => 'Sem matriculas cadastradas'];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'curso_id' => 'required',
                'aluno_id' => 'required',
            ],
            [
                'curso_id.required' => 'Preencha o campo curso_id  !',
                'aluno_id.required' => 'Preencha o campo aluno_id  !',
            ]
        );

        if ($validator->fails()) {
            return ['response' => $validator->errors()];
        }

        Matricula::create($request->all());
        return ['response' => 'Matricula adicionada com sucesso'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $matricula = Matricula::find($id);
        return $matricula != null ? $matricula : ['response' => 'Matricula não encontrada'];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $params = $request->all();
        $matricula = Matricula::find($id);
        $validator = Validator::make(
            $request->all(),
            [
                'curso_id' => 'required',
                'aluno_id' => 'required',
            ],
            [
                'curso_id.required' => 'Preencha o campo curso_id  !',
                'aluno_id.required' => 'Preencha o campo aluno_id  !',
            ]
        );

        if ($validator->fails()) {
            return ['response' => $validator->errors()];
        }

        if ($matricula) {
            $matricula->curso_id = $params['curso_id'];
            $matricula->aluno_id = $params['aluno_id'];
            $matricula->save();
            return ['response' => 'Matricula atualizada com sucesso'];
        }

        return ['response' => 'Erro ao atualizar matricula'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $matricula = Matricula::find($id);

        if ($matricula) {
            $matricula->delete();
            return ['response' => 'Matricula excluído com sucesso'];
        }

        return ['response' => 'Falha ao excluir Matricula'];
    }
}
