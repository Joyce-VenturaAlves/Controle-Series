<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesFormRequest;
use App\Mail\SeriesCreated;
use App\Models\Series;
use App\Repositories\SeriesRepository;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Mail;
use App\Models\User;


class SeriesController extends Controller
{
    public function __construct(private SeriesRepository $repository)
    {
        $this->middleware('auth')->except('index');
    }

    public function index(Request $request)
    {
        $series = Series::all();
        $mensagemSucesso = session('mensagem.sucesso');

        return view('series.index')->with('series', $series)
            ->with('mensagemSucesso', $mensagemSucesso);
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request)
    {   

        if($request->hasFile('cover')){
            $coverPath = $request->file('cover')->store('series_cover', 'public');
        

        $coverPath = $request->file('cover')->store('series_cover', 'public');

        $data = $request;
        $data['coverPath'] = $coverPath;

        $serie = $this->repository->add($data);
        
        \App\Events\SeriesCreated::dispatch(
            $serie->nome,
            $serie->id,
            $request->seasonsQty,
            $request->episodesPerSeason,
        );
        
        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '{$serie->nome}' adicionada com sucesso");

        } else{
            return redirect()->back()->withErrors('Precisa adicionar uma imagem de capa!');
        }    
    }

    public function destroy(Series $series)
    {
        $series->delete();
        \App\Jobs\DeleteSeriesCover::dispatch($series->cover);

        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '{$series->nome}' removida com sucesso");
    }

    public function edit(Series $series)
    {
        return view('series.edit')->with('serie', $series);
    }

    public function update(Series $series, SeriesFormRequest $request)
    {
        $series->fill($request->all());
        $series->save();

        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '{$series->nome}' atualizada com sucesso");
    }
}
