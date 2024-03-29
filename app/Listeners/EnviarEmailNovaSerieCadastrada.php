<?php

namespace App\Listeners;

use App\Events\NovaSerie;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class EnviarEmailNovaSerieCadastrada implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NovaSerie  $event
     * @return void
     */
    public function handle(NovaSerie $event)
    {
        $nomeSerie = $event->nomeSerie;
        $qtdTemporadas = $event->qtdTemporadas;
        $qtdEpisodios = $event->qtdEpisodios;
        //buscando todos os usuários cadastrados no sistema
        $users = User::all();

        //enviando email para todos os usuários
        foreach ($users as $indice => $user) {
            $multiplicador = $indice + 1;
            $email = new \App\Mail\NovaSerie(
                $nomeSerie,
                $qtdTemporadas,
                $qtdEpisodios
            );

            $email->subject = 'Nova Série Adicionada';
            $when = now()->addSeconds($multiplicador * 10);
            Mail::to($user)->later($when, $email);
            //sleep(5);
        }
    }
}
