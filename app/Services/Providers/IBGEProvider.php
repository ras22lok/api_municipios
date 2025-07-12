<?php
    namespace App\Services\Providers;

    use Illuminate\Support\Facades\Http;

    class IBGEProvider
    {
        public function pegar($uf, $pagina, $qtdPorPagina)
        {
            $url = "https://servicodados.ibge.gov.br/api/v1/localidades/estados/{$uf}/municipios";
            $response = Http::get($url);

            if (!$response->ok()) throw new \Exception("Erro IBGE API");

            $dados = collect($response->json());

            return [
                'data' => $dados->slice(($pagina - 1) * $qtdPorPagina, $qtdPorPagina)->values()->map(function ($item) {
                    return [
                        'nome' => $item['nome'],
                        'codigo_ibge' => $item['id']
                    ];
                }),
                'total' => $dados->count(),
                'pagina' => $pagina,
                'qtd_por_pagina' => $qtdPorPagina
            ];
        }
    }
