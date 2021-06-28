<?php

namespace App\Http\Controllers;

use App\Serie;
use Illuminate\Http\Request;

class TemporadasController extends Controller
{
    public function index(int $serieId)
    {
        //a partir da série fazer uma busca pelo id e buscar as temporadas
        $serie = Serie::find($serieId);
        $temporadas = Serie::find($serieId)->temporadas;

        return view('temporadas.index', compact('serie', 'temporadas'));
    }
}
