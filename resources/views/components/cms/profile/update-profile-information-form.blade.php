<section class="mb-3">
    <header>
        <h2 class="title-section"> Informação do Perfil </h2>
        <p> Atualize as informações do perfil da sua conta e o endereço de e-mail. </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('usuarios.update', Auth::user()->id) }}">
        @csrf
        @method('put')
        <input type="text" class="form-control d-none" value="{{ Auth::user()->id }}" name="userId">

        <x-cms.campos.input identificador="name" classes="mt-2" tipo="text" titulo="Nome" placeholder="Insira Seu Nome"
            valor="{{ old('name', Auth::user()->name) }}" />

        <x-cms.campos.input identificador="email" classes="mt-2" tipo="email" titulo="E-mail"
            placeholder="exemplo@gmail.com" valor="{{ old('email', Auth::user()->email) }}" />

        <div>
            @if (Auth::user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !Auth::user()->hasVerifiedEmail())
                <div>
                    <p class="text-secondary">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="btn bgSecondaryColor">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-success">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="px-1 pt-2">
            <button class="btn btn-success">Salvar</button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-success">
                    Salvo com sucesso
                </p>
            @endif
        </div>
    </form>
</section>
