<?php
    namespace App\Services;

    use App\Services\Providers\{Provider};

    class MunicipioService
    {
        public function pegar($uf, $pagina = 1, $qtdPorPagina = 10, $provider = false)
        {
            $provider = (!$provider) ? config('municipios.provider') : $provider;

            $url = match ($provider) {
                'brasilapi' => "https://brasilapi.com.br/api/ibge/municipios/v1/" . strtoupper($uf),
                'ibge' => "https://servicodados.ibge.gov.br/api/v1/localidades/estados/{$uf}/municipios",
                default => throw new \Exception("Provider inválido!"),
            };

            $class = new Provider();
            return $class->pegar($url, $pagina, $qtdPorPagina, $provider);
        }
    }
