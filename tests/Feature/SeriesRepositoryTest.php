<?php

namespace Tests\Feature;

use App\Http\Requests\SeriesFormRequest;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Repositories\SeriesRepository;
use Tests\Feature\EloquentSeriesRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;


class SeriesRepositoryTest extends TestCase
{
    use RefreshDatabase;
    public function test_when_a_series_is_created_its_seasons_and_episodes_must_also_be_created()
    {   
        
        // Arrange
        /** @var SeriesRepository $repository */

            $repository = $this->app->make(SeriesRepository::class);
            $request = new SeriesFormRequest();

            $request->merge([
                'nome' => 'Série',
                'seasonsQty' => 1,
                'episodesPerSeason' => 1
            ]);

                // Act
                $repository->add($request);

                //Assert

                $this->assertDatabaseHas('series', ['nome' => 'Nome']);
                $this->assertDatabaseHas('seasons', ['number' => 1]);
                $this->assertDatabaseHas('episodes', ['number' => 1]);
    }
}
