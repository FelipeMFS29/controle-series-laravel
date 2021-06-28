<?php

use Illuminate\Support\Facades\Autenticador;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//nomeando a rota para ter um nome fixo e não ter perigo 
//de errar o caminho dela
Route::get('/series', 'SeriesController@index')
    ->name('listar_series');
Route::get('/series/criar', 'SeriesController@create')
    ->name('form_criar_serie')
    ->middleware('autenticador');
Route::post('/series/criar', 'SeriesController@store')
    ->middleware('autenticador');
Route::delete('/series/{id}', 'SeriesController@destroy')
    ->middleware('autenticador');
Route::get('/series/{serieId}/temporadas', 'TemporadasController@index');
Route::post('/series/{id}/editaNome', 'SeriesController@editaNome')
    ->middleware('autenticador');
Route::get('/temporadas/{temporada}/episodios', 'EpisodiosController@index');

Route::post('/temporadas/{temporada}/episodios/assistir', 'EpisodiosController@assistir')
    ->middleware('autenticador');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/entrar', 'EntrarController@index');
Route::post('/entrar', 'EntrarController@entrar');
Route::get('/registrar', 'RegistroController@create');
Route::post('/registrar', 'RegistroController@store');

Route::get('/sair', function () {
    Auth::logout();
    return redirect('/entrar');
});

Auth::routes();

Route::get('/visualizando-email', function () {
    return new \App\Mail\NovaSerie(
        'Arrow',
        '5',
        '10'
    );
});

Route::get('/enviando-email', function () {
    $email = new \App\Mail\NovaSerie(
        'Arrow',
        '5',
        '10'
    );
    
    //definindo o título do email
    $email->subject = 'Nova Série Adicionada';

    //precisa passar o array como objeto pois é como o laravel trabalha
    $user = (object)[
        'email' => 'felipe@teste.com',
        'name' => 'Felipe'
    ];

    \Illuminate\Support\Facades\Mail::to($user)->send($email);
    return 'Email enviado!';
});
