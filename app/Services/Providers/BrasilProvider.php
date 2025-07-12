<?php
    namespace App\Services\Providers;

    use Illuminate\Support\Facades\Http;

    class BrasilProvider
    {
        public function pegar($uf, $pagina, $qtdPorPagina)
        {
            $url = "https://brasilapi.com.br/api/ibge/municipios/v1/" . strtoupper($uf);
            $response = Http::get($url);

            if (!$response->ok()) throw new \Exception("Erro BrasilAPI");

            $dados = collect($response->json());

            return [
                'data' => $dados->slice(($pagina - 1) * $qtdPorPagina, $qtdPorPagina)->values()->map(function ($item) {
                    return [
                        'nome' => $item['nome'],
                        'codigo_ibge' => $item['codigo_ibge']
                    ];
                }),
                'total' => $dados->count(),
                'pagina' => $pagina,
                'qtd_por_pagina' => $qtdPorPagina
            ];
        }
    }
