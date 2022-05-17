<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Curso;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = Curso::all();
        return count($result) > 0  ? ['response' => $result] :  ['response' => 'Sem cursos cadastrados'];
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
                'titulo' => 'required',
                'descricao' => 'required',
            ],
            [
                'titulo.required' => 'Preencha o campo titulo! !',
                'descricao.required' => 'Preencha o campo descricao !',
            ]
        );

        if ($validator->fails()) {
            return ['response' => $validator->errors()];
        }

        Curso::create($request->all());
        return ['response' => 'Curso adicionado com sucesso'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $curso = Curso::find($id);
        return $curso != null ? $curso : ['response' => 'Curso não encontrado'];
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
        $curso = Curso::find($id);
        $validator = Validator::make(
            $request->all(),
            [
                'titulo' => 'required',
                'descricao' => 'required',
            ],
            [
                'titulo.required' => 'Preencha o campo titulo! !',
                'descricao.required' => 'Preencha o campo descricao !',
            ]
        );

        if ($validator->fails()) {
            return ['response' => $validator->errors()];
        }

        if ($curso) {
            $curso->titulo = $params['titulo'];
            $curso->descricao = $params['descricao'];
            $curso->atributos = $params['atributos'];
            $curso->save();
            return ['response' => 'Curso atualizado com sucesso'];
        }

        return ['response' => 'Erro ao atualizar curso'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $curso = Curso::find($id);

        if ($curso) {
            $curso->delete();
            return ['response' => 'Curso excluído com sucesso'];
        }

        return ['response' => 'Falha ao excluir Curso'];
    }
}
