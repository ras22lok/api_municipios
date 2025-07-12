<?php
    namespace App\Services\Providers;

    use Illuminate\Support\Facades\Http;

    class Provider
    {
        public function pegar($url, $pagina, $qtdPorPagina, $provider)
        {
            $response = Http::get($url);
            $identificador = ($provider == 'brasilapi') ? 'codigo_ibge' : 'id';

            if (!$response->ok()) throw new \Exception("Erro ao acessar a api $provider");

            $dados = collect($response->json());
            unset($provider, $url, $response);

            return [
                'data' => $dados->slice(($pagina - 1) * $qtdPorPagina, $qtdPorPagina)->values()->map(function ($item) use ($identificador) {
                    return [
                        'nome' => $item['nome'],
                        'codigo_ibge' => $item[$identificador]
                    ];
                }),
                'total' => $dados->count(),
                'pagina' => $pagina,
                'qtd_por_pagina' => $qtdPorPagina,
                'qtd_de_paginas' => ceil($dados->count() / $qtdPorPagina),
            ];
        }
    }
