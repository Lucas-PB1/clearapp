let id = 0;
let open_modal = 0;

document.querySelector('#generator-button').addEventListener('click', (event) => {
    event.preventDefault();
    let area = document.querySelector('#generator-input');

    id += 1;
    let div = create_element({ tag: 'div', classes: 'generator-div mt-2 d-flex', id: `generator_${id}` });

    let input = create_element({
        tag: 'input', classes: 'generator-inputs form-control',
        params: [{ key: 'name', value: `generator[${id}][title]` }, { key: 'placeholder', value: 'Coluna ' }]
    });

    let select = create_element({
        tag: 'select', classes: 'generator-select form-select ms-2',
        params: [{ key: 'name', value: `generator[${id}][type]` }]
    });

    let type = [
        { text: 'Selecione o tipo de campo', value: '0' },
        { text: 'Campo livre', value: 'text' }, { text: 'Texto', value: 'text' },
        { text: 'Sim ou Não', value: 'boolean' }, { text: 'Seleção', value: 'select' },
        { text: 'Número', value: 'integer' }, { text: 'Data', value: 'date' }
    ];

    type.map(element => {
        select.append(create_element({
            tag: 'option', conteudo: element.text, classes: 'generator-option',
            params: [{ key: 'value', value: element.value }]
        }));
    })

    let mandatory = create_element({
        tag: 'select', classes: 'generator-select form-select ms-2',
        params: [{ key: 'name', value: `generator[${id}][required]` }]
    });

    let type_mandatory = [{ text: 'Opcional', value: 'optional' }, { text: 'Obrigatório', value: 'required' },];

    type_mandatory.map(element => {
        mandatory.append(create_element({
            tag: 'option', conteudo: element.text, classes: 'generator-option',
            params: [{ key: 'value', value: element.value }]
        }));
    })

    let size = create_element({
        tag: 'select', classes: 'generator-select form-select ms-2',
        params: [{ key: 'name', value: `generator[${id}][size]` }]
    })

    size.append(create_element(
        { tag: 'option', conteudo: "Selecione o tamanho", classes: 'generator-option', params: [{ key: 'value', value: '0' }] }
    ));

    for (let index = 1; index <= 12; index++) {
        size.append(create_element({ tag: 'option', conteudo: index, classes: 'generator-option', params: [{ key: 'value', value: index }] }));
    }

    let btnDelete = create_element({
        tag: 'button', classes: 'generator-button-delete ms-2 btn btn-danger', conteudo: '<em class="icon fa fa-trash"></em>',
        params: [{ key: 'data-bs-toggle', value: `tooltip` }, { key: 'data-bs-placement', value: 'right' }, { key: 'title', value: 'Deletar coluna' }]
    })

    let options = create_element({ tag: 'div', classes: 'options' });
    div.append(input, select, mandatory, size, btnDelete, options);

    area.append(div);
    let tooltip = new window.Bootstrap.Tooltip(btnDelete);

    btnDelete.addEventListener('click', event => {
        event.preventDefault();
        tooltip.dispose();
        div.remove();
    })

    let actual_valor = id;
    select.addEventListener('change', () => {
        if (select.value == 'select') {
            let modal = new window.Bootstrap.Modal(document.getElementById('modalOpcoesId'), {});
            modal.show();
            open_modal = actual_valor;
        }
    })
})

document.querySelector('.add-option').addEventListener('click', () => {
    let text = document.querySelector('.nova-opcao');
    if (text.value || text.value.replace(' ', text.value) != '') {
        let new_option = create_element({ tag: 'span', classes: 'badge bg-primary m-2', conteudo: `${text.value}<i class="fa fa-close ms-2"></i>` });

        let options = document.querySelector(`#generator_${open_modal}`).querySelector('.options');

        let name = `generator[${open_modal}][options][${[...options.children].length}]`;

        let input = create_element({
            tag: 'input', classes: 'd-none', value: text.value,
            params: [{ value: name, key: 'name' }]
        });

        options.append(input);
        document.querySelector('.all-options').append(new_option);
        text.value = '';

        new_option.addEventListener('click', () => {
            let field = document.getElementsByName(name)[0];
            new_option.remove();
            field.remove();
        });
    }
})

document.getElementById('modalOpcoesId').addEventListener('hidden.bs.modal', () => {
    document.querySelector('.all-options').innerHTML = ''
    document.querySelector('.nova-opcao').value = '';
});

[...document.querySelectorAll('.delete-all-options')].map(value => {
    value.addEventListener('click', () => document.querySelector(`#generator_${open_modal}`).querySelector('.options').innerHTML = '')
})
