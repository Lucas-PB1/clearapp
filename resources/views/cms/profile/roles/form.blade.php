@php $route = !isset($data) ? route('cargos.store') : route('cargos.update', $data->id) @endphp

<form action="{{ $route }}" method="post">
    @csrf

    @isset($data)
        @method('PUT')
    @endisset

    <div class="row ms-0">
        <x-generator.input id="name" titulo="Nome do Cargo" size="12" tipo='text' classesDiv="mb-4"
            placeholder="Insira o nome do cargo" dados="{{ isset($data) ? $data->{'name'} : null }}" mandatory="true" />


        @isset($data)
            <x-generator.input id="cargo_id" titulo="cargo_id" size="12" tipo='hidden' dados="{{ $data->{'id'} }}"
                classesDiv="d-none" />

            @php $actualPerms = $data->permissions->pluck('name')->toArray() @endphp
            <table class="datatable-init table">
                <thead>
                    <tr>
                        <th class="text-center">Permissões</th>
                        <th class="text-center">Listar</th>
                        <th class="text-center">Cadastrar</th>
                        <th class="text-center">Editar</th>
                        <th class="text-center">Deletar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                        <tr valign="middle">
                            <td class="text-center">{{ $permission }}</td>

                            <td class="text-center">
                                @php $read = in_array("read_".slug_fix($permission), $actualPerms) @endphp
                                <x-cms.campos.theme.unique-checkbox id="read_{{ slug_fix($permission) }}"
                                    check="{{ $read }}" />
                            </td>

                            <td class="text-center">
                                @php $create = in_array("create_".slug_fix($permission), $actualPerms) @endphp
                                <x-cms.campos.theme.unique-checkbox id="create_{{ slug_fix($permission) }}"
                                    check="{{ $create }}" />
                            </td>

                            <td class="text-center">
                                @php $update = in_array("update_".slug_fix($permission), $actualPerms) @endphp
                                <x-cms.campos.theme.unique-checkbox id="update_{{ slug_fix($permission) }}"
                                    check="{{ $update }}" />
                            </td>

                            <td class="text-center">
                                @php $delete = in_array("delete_".slug_fix($permission), $actualPerms) @endphp
                                <x-cms.campos.theme.unique-checkbox id="delete_{{ slug_fix($permission) }}"
                                    check="{{ $delete }}" />
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endisset

        @can(['create_cargos', 'update_cargos'])
            <div class="p-3">
                <button class="btn btn-primary" type="submit">
                    Salvar
                </button>
            </div>
        @endcan
    </div>
</form>

@section('other-scripts')
    <script src="{{ url('js/cms/cargos/roles.js') }}" defer></script>
@endsection
