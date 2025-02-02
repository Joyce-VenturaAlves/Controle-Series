<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeriesFormRequest;
use Illuminate\Http\Request;
use App\Models\Series;
use App\Repositories\SeriesRepository;

class SeriesController extends Controller
{   

    public function __construct(private SeriesRepository $seriesRepository){

    }
        
    public function index(Request $request){
        $query = Series::query();
        if ($request->has('nome')){
            $query->where('nome', $request->nome);
        }
        return $query->paginate(5);
    }

    public function store(SeriesFormRequest $request){
        return response()
            ->json($this->seriesRepository->add($request), 201);
    }

    public function show(int $series){
        
        $seriesModel = Series::with('series.episodes')->find($series);
        if($seriesModel === null) {
            return response()->json(['message' => 'Not Found!'], 404);
        }
        return $seriesModel;
    }

    public function update(Series $series, SeriesFormRequest $request){
        $series->fill($request->all());
        $series->save();

        return $series;
    }
    public function destroy(int $series){
        Series::destroy($series);
        return response()->noContent();
    }

}
