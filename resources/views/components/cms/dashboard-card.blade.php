<div class="col-md-6 mb-4">
    <div class="card p-4">
        <h2 class="mb-4">{{ $titulo }}</h2>
        <img class="chart mb-3" src="{{ url($img) }}">
        <div class="row">
            {{ $slot }}
        </div>
    </div>
</div>
