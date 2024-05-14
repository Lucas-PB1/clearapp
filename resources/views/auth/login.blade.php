<x-guest-layout>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="text-center">
            {{-- <img src="{{ url('img/logo.jpg') }}" alt="logo" class="mw-100 object-fit-cover"
                style="height: 300px;"> --}}
        </div>

        <x-cms.auth.input id="email" placeholder="name@example.com" type="email" titulo="E-mail" />
        <x-cms.auth.input id="password" placeholder="Senha" type="password" classes="mt-2" titulo="Senha" />

        <div class="d-flex justify-content-between align-items-center">

            <!-- Checkbox -->
            <div class="form-check mb-0">
                <input class="form-check-input me-2" type="checkbox" id="remember_me" name="remember" />
                <label class="form-check-label" for="remember_me">
                    Lembre-se
                </label>
            </div>

            @if (Route::has('password.request'))
                <a class="text-body mt-2" href="{{ route('password.request') }}">Esqueceu a Senha?</a>
            @endif
        </div>

        <div class="text-center text-lg-start mt-4 pt-2">
            <button type="submit" class="btn btn-primary btn-lg px-4">
                Login
            </button>

            <p class="small fw-bold mt-2 pt-1 mb-0">Não tem uma conta?
                <a href="{{ route('register') }}" class="link-danger">Registre-se</a>
            </p>
        </div>
    </form>
</x-guest-layout>
