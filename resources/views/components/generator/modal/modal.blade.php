<!-- Modal -->
<div class="modal fade" id="modalOpcoesId" tabindex="-1" aria-labelledby="modalOpcoes" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalOpcoes">Adicionar opções</h1>
                <button type="button" class="btn-close delete-all-options" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="div-principal">
                    <div class="div-opcoes my-2">
                        <input type="text" class="form-control nova-opcao" placeholder="Nome da opção">
                    </div>
                    <button class="btn btn-primary add-option">Adicionar Opção</button>

                    <div class="list-options mt-3">
                        <h5>Opções Adicionadas</h5>
                        <div class="all-options"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary delete-all-options" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Salvar</button>
            </div>
        </div>
    </div>
</div>
