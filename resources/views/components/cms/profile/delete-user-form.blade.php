<section class="mt-4">
    <header>
        <h2> Deletar Conta </h2>
        <p> Depois que sua conta for excluída, todos os seus recursos e dados serão excluídos permanentemente. Antes de
            excluir sua conta, baixe todos os dados ou informações que deseja reter. </p>
    </header>

    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">Deletar Conta</button>

    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('usuarios.destroy', Auth::user()->id) }}" class="p-6">
                    @csrf
                    @method('delete')

                    <input type="text" class="form-control d-none" value="{{ Auth::user()->id }}" name="userId">

                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmUserDeletionModalLabel">{{ __('Delete Account') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <h2> Tem certeza que deseja deletar sua conta? </h2>

                        <p> Uma vez que sua conta seja excluída, todos os seus recursos e dados serão excluídos
                            permanentemente. Por favor, digite sua senha para confirmar que você deseja excluir
                            permanentemente sua conta. </p>

                        <div class="mt-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="*******">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Deletar Conta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
