<?php

    use Illuminate\Http\Response;

    /**
     * Teste da rota para o provider brasilapi
     */
    it('Testando a rota municipios brasilapi', function() {
        $response = $this->get('/api/v1/municipios/sp/1');

        $response->assertStatus(Response::HTTP_OK);
    });

    /**
     * Teste da rota para o provider ibge
     */
    it('Testando a rota municipios ibge', function() {
        $response = $this->get('/api/v1/municipios/sp/1?provider=ibge');

        $response->assertStatus(Response::HTTP_OK);
    });

    /**
     * Teste da rota fallback
     */
    it('Testando a rota fallback', function() {
        $response = $this->get('/api/v1/teste');

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    });


    /**
     * Teste de parametro invalido
     */
    it('Testando se o parâmetro página passado na rota é inválido', function() {
        $response = $this->get('/api/v1/municipios/sp/a');

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    });

    /**
     * Teste de parametro invalido
     */
    it('Testando se o parâmetro uf passado na rota é inválido', function() {
        $response = $this->get('/api/v1/municipios/1/1');

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    });

