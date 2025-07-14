<?php
    namespace App\Services\Providers;

    use Illuminate\Support\Facades\Http;

    class Provider
    {
        public function pegar($url, $provider) {
            $response = Http::get($url);
            $identificador = ($provider == 'brasilapi') ? 'codigo_ibge' : 'id';

            if (!$response->ok()) throw new \Exception("Erro ao buscar municípios do $provider");

            $dados = collect($response->json());
            unset($provider, $url, $response);

            return $dados->map(function ($item) use ($identificador) {
                return [
                    'nome' => $item['nome'],
                    'codigo' => $item[$identificador]
                ];
            })->toArray();
        }
    }
