<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aluno;
use Illuminate\Support\Facades\Validator;
use App\Curso;

class AlunoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = Aluno::with('matriculas')->get();
        foreach ($result as $aluno) {
            foreach ($aluno->matriculas as $matricula) {
                $matricula->cursos =  Curso::Find($matricula->curso_id)->get();
            }
        }

        return count($result) > 0  ? ['response' => $result] :  ['response' => 'Sem alunos cadastrados'];
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
                'nome' => 'required',
                'email' => 'required|unique:aluno',
            ],
            [
                'nome.required' => 'Preencha o campo nome! !',
                'email.required' => 'Preencha o campo E-mail !',
                'email.unique' => 'E-mail existente !',
            ]
        );

        if ($validator->fails()) {
            return ['response' => $validator->errors()];
        }

        Aluno::create($request->all());
        return ['response' => 'Aluno adicionado com sucesso'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $aluno = Aluno::find($id);
        return $aluno != null ? $aluno : ['response' => 'Aluno não encontrado'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function searchAluno(Request $request)
    {
        $params = $request->all();
        $aluno = Aluno::all();

        if (isset($params['email'])) {
            $aluno->orWhere(['email' => $params['email']]);
        }
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
        $aluno = Aluno::find($id);
        $validator = Validator::make(
            $request->all(),
            [
                'nome' => 'required',
                'email'  =>  'required|email|unique:aluno,email,' . $id
            ],
            [
                'nome.required' => 'Preencha o campo nome! !',
                'email.required' => 'Preencha o campo E-mail !',
                'email.unique' => 'E-mail existente !',
            ]
        );

        if ($validator->fails()) {
            return ['response' => $validator->errors()];
        }

        if ($aluno) {
            $aluno->nome = $params['nome'];
            $aluno->email = $params['email'];
            $aluno->save();
            return ['response' => 'Aluno atualizado com sucesso'];
        }

        return ['response' => 'Erro ao atualizar aluno'];
    }

    /** Using delete against SoftDelete because LGPD
     * Remove the specified resource from storage.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $aluno = Aluno::find($id);

        if ($aluno) {
            $aluno->delete();
            return ['response' => 'Aluno excluído com sucesso'];
        }

        return ['response' => 'Falha ao excluir aluno'];
    }
}
