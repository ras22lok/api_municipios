<?php
    namespace App\Services;

    use App\Services\Providers\{Provider};
    use Illuminate\Support\Facades\Cache;

    class MunicipioService
    {
        public function pegar(string $uf, int $pagina = 1, int $qtdPorPagina = 10)
        {
            $provider = config('municipios.provider');

            $url = match ($provider) {
                'brasilapi' => "https://brasilapi.com.br/api/ibge/municipios/v1/" . strtoupper($uf),
                'ibge' => "https://servicodados.ibge.gov.br/api/v1/localidades/estados/{$uf}/municipios",
                default => throw new \Exception("Provider inválido!"),
            };

            $classProvider = new Provider();
            $cacheKey = "municipios_{$uf}_{$pagina}_" . env('MUNICIPIOS_PROVIDER');
            $municipios = Cache::remember($cacheKey, env('CACHE_TTL', 300), fn() => $classProvider->pegar($url, $provider));

            $qtd_paginas = ceil(count($municipios) / $qtdPorPagina);

            if ($qtd_paginas < $pagina) throw new \Exception("Página não encontrada");

            $offset = ($pagina - 1) * $qtdPorPagina;
            $dados = array_slice($municipios, $offset, $qtdPorPagina);
            return [
                'data' => $dados,
                'pagination' => [
                    'per_page' => $qtdPorPagina,
                    'current_page' => $pagina,
                    'number_of_pages' => $qtd_paginas,
                    'total_records_on_the_page' => count($dados),
                    'total' => count($municipios),
                ]
            ];
        }
    }
