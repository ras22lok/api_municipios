<?php

    use App\Http\Controllers\MunicipioController;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;

    Route::get('/v1/municipios/{uf}/{pagina}', [MunicipioController::class, 'listar']);

    Route::fallback(function() {
        return response()->json([
                'message' => 'Erro ao acessar a página!',
                'data' => ''
            ],
            404
        );
    });
