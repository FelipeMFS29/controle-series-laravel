<?php

namespace App\Services;

use App\Serie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CriadorDeSerie
{

    public function criarSerie(string $nomeSerie, int $qtdTemporadas, int $epPorTemporada, ?string $capa): Serie
    {
        //Iniciando a transação
        DB::beginTransaction();

        //pegando os dados que vem do formulário
        $serie = Serie::create([
            'nome' => $nomeSerie,
            'capa' => $capa
        ]);
        $this->criaTemporadas($qtdTemporadas, $epPorTemporada, $serie);

        //Terminando a transação e enviando os dados para o banco
        DB::commit();

        return $serie;
    }

    private function criaTemporadas(int $qtdTemporadas, int $epPorTemporada, Serie $serie)
    {
        //a partir da série inserida, criar uma nova temporada com o número definido
        //o eloquent já faz a relação da temporada criada com a série que já existe
        for ($i = 1; $i <= $qtdTemporadas; $i++) {
            $temporada = $serie->temporadas()->create(['numero' => $i]);

            $this->criaEpisodios($epPorTemporada, $temporada);
        }
    }

    private function criaEpisodios(int $epPorTemporada, Model $temporada)
    {
        for ($j = 1; $j <= $epPorTemporada; $j++) {
            $temporada->episodios()->create(['numero' => $j]);
        }
    }
}
