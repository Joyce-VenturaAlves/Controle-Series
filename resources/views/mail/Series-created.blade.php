@component('mail::message')
# Série com o nome{{$nomeSerie}} foi adicionada com sucesso

- A série {{$nomeSerie}} foi criada com sucesso.
- A quantidade de temporadas é {{$seasonsQty}}.
- A quantidade de episódios é {{$episodesQty}}.

    @component('mail::button', ['url' => route('seasons.index', $idSerie)])
        Ver série
    @endcomponent

@endcomponent
