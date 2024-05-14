<footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
    <div class="col-md-4 d-flex align-items-center">
        <span class="mb-3 mb-md-0 text-muted">© 2022 DeveloperX</span>
    </div>

    <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
        @foreach ($redes as $item)
            <li class="ms-3">
                <a class="text-muted" href="{{ $item->link }}">
                    <i class="{{ $item->icone }}"></i>
                </a>
            </li>
        @endforeach
    </ul>
</footer>
