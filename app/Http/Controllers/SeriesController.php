<?php

namespace App\Http\Controllers;

use App\Events\NovaSerie;
use App\Http\Requests\SeriesFormRequest;
use App\Serie;
use App\Services\CriadorDeSerie;
use App\Services\RemovedorDeserie;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SeriesController extends Controller
{

    public function index(Request $request)
    {
        //busca todos os registros inseridos na tabela serie em ordem alfabética
        $series = Serie::query()
            ->orderBy('nome')
            ->get();

        //pegando a mensagem definida na função store
        $mensagem = $request->session()->get('mensagem');

        //procurando na pasta series o arquivo index
        //se a chave do array e a variável tiverem o mesmo nome é possível 
        //usar o compact para encurtar o código
        //enviando a mensagem para a view
        return view('series.index', compact('series', 'mensagem'));
    }

    //buscando o formulário de inserção de séries
    public function create()
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request, CriadorDeSerie $criadorDeSerie)
    {

        $capa = null;
        if ($request->hasFile('capa')) {
            $capa = $request->file('capa')->store('serie');
        }

        $serie = $criadorDeSerie->criarSerie(
            $request->nome,
            $request->qtd_temporadas,
            $request->ep_por_temporada,
            $capa
        );

        $eventoNovaSerie = new NovaSerie(
            $request->nome,
            $request->qtd_temporadas,
            $request->ep_por_temporada
        );

        event($eventoNovaSerie);

        //usando o session do request para enviar uma mensagem para o usuário
        $request->session()
            ->flash(
                'mensagem',
                "Série {$serie->id} e suas temporadas e episódios criada com sucesso {$serie->nome}"
            );

        //redirecionando o usuário para a página principal
        //utilizando a rota nomeada
        return redirect()->route('listar_series');
    }

    public function destroy(Request $request, RemovedorDeSerie $removedorDeSerie)
    {
        $nomeSerie = $removedorDeSerie->removerSerie($request->id);
        $request->session()
            ->flash(
                'mensagem',
                "Série $nomeSerie removida com sucesso "
            );
        return redirect('/series');
    }

    public function editaNome(int $id, Request $request)
    {
        //pegando o novo nome que vem pelo request e salvando no banco
        $novoNome = $request->nome;
        $serie = Serie::find($id);
        $serie->nome = $novoNome;
        $serie->save();
    }
}
