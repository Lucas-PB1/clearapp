<x-app-layout mainPage={{ true }}>
    <div class="row">
        <div class="col-md-3 text-center">
            @foreach ($jardins as $item)
                <div class="card" style="width: 18rem;">

                    <a href="{{ route('jardim.index', ['slug' => $item->slug]) }}">
                        <img class="card-img-top" src="{{ $item->destaque->path }}"
                            alt="Jardim de {{ $item->{'nome-da-galeria'} }}">
                    </a>

                    <div class="card-body">
                        <p class="card-text text-default-color">Jardim de {{ $item->{'nome-da-galeria'} }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
