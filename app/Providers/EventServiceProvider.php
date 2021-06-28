<?php

namespace App\Providers;

use App\Listeners\EnviarEmailNovaSerieCadastrada;
use App\Listeners\ExcluirCapaSerie;
use App\Listeners\LogNovaSerieCadastrada;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        \App\Events\NovaSerie::class => [
            EnviarEmailNovaSerieCadastrada::class,
            LogNovaSerieCadastrada::class
        ]/*,
        \App\Events\SerieApagada::class => [
            ExcluirCapaSerie::class,
        ]*/
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
