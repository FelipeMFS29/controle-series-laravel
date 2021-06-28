<?php

namespace App\Services;

use App\{Serie, Temporada, Episodio};
use App\Events\SerieApagada;
use App\Jobs\ExcluirCapaSerie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RemovedorDeSerie
{
    public function removerSerie(int $serieId): string
    {
        $nomeSerie = '';
        //utilizando o db transaction para que tudo seja executado 
        //em apenas uma transação
        DB::transaction(function () use ($serieId, &$nomeSerie) {
            //buscando o id da série a ser deletada
            $serie = Serie::find($serieId);
            $serieObj = (object) $serie->toArray();
            $nomeSerie = $serie->nome;

            $this->removerTemporadas($serie);

            //por fim, deletando a série
            $serie->delete();

            $evento = new SerieApagada($serieObj);
            event($evento);
            ExcluirCapaSerie::dispatch($serieObj);
        });

        return $nomeSerie;
    }

    private function removerTemporadas(Serie $serie)
    {
        //deletando cada temporada dentro da série
        $serie->temporadas->each(function (Temporada $temporada) {
            $this->removerEpisodios($temporada);
            $temporada->delete();
        });
    }

    private function removerEpisodios(Temporada $temporada)
    {
        //deletando cada episódio dentro da temporada
        $temporada->episodios()->each(function (Episodio $episodio) {
            $episodio->delete();
        });
    }
}
