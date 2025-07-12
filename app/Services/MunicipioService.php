<?php
    namespace App\Services;

    use App\Services\Providers\BrasilProvider;
    use App\Services\Providers\IBGEProvider;

    class MunicipioService
    {
        public function pegar($uf, $pagina = 1, $qtdPorPagina = 10)
        {
            $provider = config('municipios.provider');

            $class = match ($provider) {
                'brasilapi' => new BrasilProvider(),
                'ibge' => new IBGEProvider(),
                default => throw new \Exception("Provider inválido!"),
            };

            return $class->pegar($uf, $pagina, $qtdPorPagina);
        }
    }
