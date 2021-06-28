<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Serie extends Model
{
    public $timestamps = false;
    //é necessário informar ao laravel o que salvar no banco
    //com o atributo fillable
    protected $fillable = ['nome', 'capa'];

    public function getCapaUrlAttribute()
    {
        if ($this->capa) {
            return Storage::url($this->capa);
        }

        return Storage::url('serie/sem-imagem.jpg');
    }

    //nome do método precisa ser o nome pelo qual quer acessar
    //a relação no banco de dados
    public function temporadas()
    {
        //uma série tem várias temporadas
        return $this->hasMany(Temporada::class);
    }
}
