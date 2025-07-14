<?php

    use App\Http\Controllers\MunicipioController;
    use App\Http\Middleware\ValidaRota;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;

    Route::get('/v1/municipios/{uf}/{pagina}', [MunicipioController::class, 'listar'])
        ->where(['uf' => '[a-zA-Z]+','pagina' => '[0-9]+']);

    Route::fallback(function() {
        return response()->json([
                'message' => 'Erro ao acessar a página!',
                'data' => ''
            ],
            404
        );
    });
