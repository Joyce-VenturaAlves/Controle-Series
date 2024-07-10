<x-layout title=" " :mensagem-sucesso="$mensagemSucesso">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Séries</h1>
        @auth
        <a href="{{ route('series.create') }}" class="btn btn-dark">Adicionar</a>
        @endauth
    </div>

    <ul class="list-group">
        @foreach ($series as $serie)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img class="me-3" src="{{ asset('storage/'. $serie->cover ) }}" style="width: 100px" alt="Capa da série" class="thumbnail">

                @auth <a href="{{ route('seasons.index', $serie->id) }}"> @endauth
                {{ $serie->nome }}
                @auth </a> @endauth
            </div>
        
            @auth
            <span class="d-flex">
                <a href="{{ route('series.edit', $serie->id) }}" class="btn btn-secondary btn-sm">
                    E
                </a>

                <form action="{{ route('series.destroy', $serie->id) }}" method="post" class="ms-2">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">
                        X
                    </button>
                </form>
            </span>
            @endauth
        </li>
        @endforeach
    </ul>
</x-layout>
