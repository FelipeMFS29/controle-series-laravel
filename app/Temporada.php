<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Temporada extends Model
{
    protected $fillable = ['numero'];
    public $timestamps = false;

    public function serie()
    {
        //a temporada pertence a uma série
        return $this->belongsTo(Serie::class);
    }

    public function episodios()
    {
        //uma temporada tem vários episódios
        return $this->hasMany(Episodio::class);
    }

    public function getEpisodiosAssistidos(): Collection
    {
        //retornando apenas os episódios que foram assistidos
        return $this->episodios->filter(function (Episodio $episodio) {
            return $episodio->assistido;
        });
    }
}
