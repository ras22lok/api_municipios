<?php

namespace App\Http\Controllers;

use App\Services\MunicipioService;
use Illuminate\Http\Request;

class MunicipioController extends Controller
{
    public function listar(Request $request, $uf, $pagina = 1, MunicipioService $service) {
        try {
            $qtdPorPagina = 50;
            $dados = $service->pegar($uf, $pagina, $qtdPorPagina, $request->get('provider'));

            unset($uf, $pagina, $qtdPorPagina, $request);

            return response()->json($dados, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao buscar municípios.',
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
