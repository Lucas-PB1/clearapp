<nav id="sidebar">
    <div class="sidebar-header">
        <h3>{{ $siteName }}</h3>
    </div>

    <ul class="list-unstyled components">
        <p>Menu Principal</p>

        @foreach ($menus as $item)
            @can('read_' . slug_fix($item['nome']))
                <li>
                    <a href="{{ $item['link'] }}">{{ $item['nome'] }}</a>
                </li>
            @endcan
        @endforeach

        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <a href="#" class="clickCloseForm">
                    {{ __('Log Out') }}
                </a>
            </form>

        </li>
    </ul>
</nav>
