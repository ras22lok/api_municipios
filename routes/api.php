<?php

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;

    Route::fallback(function() {
        return response()->json([
                'message' => 'Erro ao acessar a página!',
                'data' => ''
            ],
            404
        );
    });
