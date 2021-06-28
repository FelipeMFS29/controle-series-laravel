<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Episodio extends Model
{
    protected $fillable = ['numero'];
    public $timestamps = false;

    public function temporada()
    {
        //os episódios pertencem a uma temporada
        return $this->belongsTo(Temporada::class);
    }
}
