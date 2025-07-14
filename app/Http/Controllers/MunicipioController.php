<?php

    namespace App\Http\Controllers;

    use App\Services\MunicipioService;
    use Illuminate\Http\{JsonResponse};

    class MunicipioController extends Controller
    {
        /**
         * Listagem de municípios
         */
        public function listar(string $uf, int $pagina = 1, MunicipioService $service): JsonResponse {
            try {
                $qtdPorPagina = env('QUANTIDADE_POR_PAGINA', 30);
                $dados = $service->pegar($uf, $pagina, $qtdPorPagina);

                unset($uf, $pagina, $qtdPorPagina);

                /**
                 * O retorno será um json com os dados recuperados do provider, informação da quantidade de registros total por páginas, informação da página atual, informação da quantidade total de páginas existentes,  informação da quantidade de registros retornado na página atual e informação da quantidade total de registros existente.
                */
                return response()->json($dados, 200);
            } catch (\Exception $e) {
                /**
                 * Caso algum erro ocorra durante o processo do retorno dos dados irá retornar o erro 'Erro ao buscar municípios.' e na propriedade message retornará o tipo do erro.
                 */
                return response()->json([
                    'error' => 'Erro ao buscar municípios.',
                    'message' => $e->getMessage()
                ], 400);
            }
        }
    }
