<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Despesa;
use Illuminate\Http\Request;
use App\Http\Requests\DespesasRequest;
use Illuminate\Support\Facades\Auth;
use App\Notifications\EnviarEmail;


class DespesasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        // Consulta apenas as despesas do usuário atual
        $despesas = Despesa::where('user_id', $user->id)->get();

        if ($user->can('view', $despesas)) {
            // O usuário não está autorizado a visualizar as despesas.
            return response()->json(['mensagem' => 'Acesso não autorizado'], 403);
        }

        return response()->json(['despesas' => $despesas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\DespesasRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DespesasRequest $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['mensagem' => 'Acesso não autorizado'], 401);
        }

        $despesa = Despesa::create($request->all());

        $user->notify(new EnviarEmail($despesa));

        return response()->json($despesa, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $despesa
     * @return \Illuminate\Http\Response
     */
    public function show(int $despesa)
    {
        $despesaModel = Despesa::find($despesa);

        if ($despesaModel === null) {
            return response()->json(['mensagem' => 'Despesa não encontrada'], 404);
        }

        $user = Auth::user();

        if (!$user->can('view', $despesaModel)) {
            // O usuário não está autorizado a visualizar despesa.
            return response()->json(['mensagem' => 'Acesso não autorizado'], 403);
        }

        return $despesaModel;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\DespesasRequest  $request
     * @param int  $despesa
     * @return \Illuminate\Http\Response
     */
    public function update(int $despesa, DespesasRequest $request)
    {
        $despesaModel = Despesa::find($despesa);

        if ($despesaModel === null) {
            return response()->json(['mensagem' => 'Despesa não encontrada'], 404);
        }

        $user = Auth::user();

        if (!$user->can('update', $despesaModel)) {
            // O usuário não está autorizado a editar a despesa.
            return response()->json(['mensagem' => 'Acesso não autorizado'], 403);
        }

        $despesaModel->update($request->all());

        return $despesaModel;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $despesa
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $despesa)
    {
        $despesaModel = Despesa::find($despesa);

        if ($despesaModel === null) {
            return response()->json(['mensagem' => 'Despesa não encontrada'], 404);
        }

        $user = Auth::user();

        if (!$user->can('delete', $despesaModel)) {
            // O usuário não está autorizado a deletar a despesa.
            return response()->json(['mensagem' => 'Acesso não autorizado'], 403);
        }

        Despesa::destroy($despesa);
        return response()->noContent();
    }
}
