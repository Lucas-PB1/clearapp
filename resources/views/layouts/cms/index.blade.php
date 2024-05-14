<x-cms-layout>
    <div class="container-fluid mt-4">
        <div class="row">
            <x-cms.dashboard-card titulo='Consultoria para TCC em Saúdes' img='img/dashboard/grafico.jpg'>
                <p>Você está enfrentando desafios para desenvolver o seu Trabalho de Conclusão de Curso
                    na área de Saúde? Nós podemos te ajudar!</p>
            </x-cms.dashboard-card>

            <x-cms.dashboard-card titulo='Resultados Alcançados' img='img/dashboard/consultoria.jpg'>
                <div class="col">
                    <p class="mb-1">Total de Trabalhos Concluídos:</p>
                    <p class="emphasis">256</p>
                </div>
                <div class="col">
                    <p class="mb-1">Índice de Satisfação dos Clientes:</p>
                    <p class="emphasis">94%</p>
                </div>
            </x-cms.dashboard-card>

        </div>

        <div class="row mt-4">
            <x-cms.dashboard-card titulo='Áreas de Saúde Atendidas' img='img/dashboard/data.png'>
                <div class="col">
                    <p class="mb-1">Número de Áreas:</p>
                    <p class="emphasis">12</p>
                </div>
                <div class="col">
                    <p class="mb-1">Área Mais Solicitada:</p>
                    <p class="emphasis">Cardiologia</p>
                </div>
            </x-cms.dashboard-card>

            <x-cms.dashboard-card titulo='Clientes Satisfeitos' img='img/dashboard/cliente.jpg'>
                <div class="col">
                    <p class="mb-1">Número de Clientes:</p>
                    <p class="emphasis">195</p>
                </div>
                <div class="col">
                    <p class="mb-1">Recomendariam nossos serviços:</p>
                    <p class="emphasis">98%</p>
                </div>
            </x-cms.dashboard-card>
        </div>
    </div>

    @section('other-scripts')
        <script src="{{ url('js/cms/dashboard/dashboard.js') }}" defer></script>
    @endsection
</x-cms-layout>
