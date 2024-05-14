let paramsGalery = [];

if (document.querySelector("#dropzone")) new Dropzone("#dropzone", optionsDropzone);

async function chargeGalery(table, id) {
    paramsGalery = [table, id];
    document.querySelector('#galeria').innerHTML = '';

    const data = await myFetch(`/cms/galeria/${table}/${id}`);

    if (data && data.length > 0) {
        data.forEach(dados => {
            const galleryCol = create_element({ tag: 'div', classes: 'col-sm-4 col-lg-3 mt-2' });
            const galleryCard = create_element({ tag: 'div', classes: 'gallery card card-bordered' });

            const galleryImageLink = create_element({
                tag: 'a',
                classes: 'gallery-image popup-image',
                estilos: 'height: 200px; display: block;'
            });

            const galleryImage = create_element({
                tag: 'img',
                classes: 'w-100 rounded-top',
                src: dados.path,
                estilos: 'object-fit: cover; height: 100%;'
            });

            galleryImageLink.appendChild(galleryImage);
            galleryCard.appendChild(galleryImageLink);

            const galleryBody = create_element({ tag: 'div', classes: 'gallery-body card-inner align-center justify-center flex-wrap g-2' });

            const btnGroup = create_element({ tag: 'div', classes: 'text-center' });
            const viewBtn = createButton('btn-primary', 'fa fa-eye', [{ key: 'href', value: dados.path }, { key: 'target', value: '_blank' }]);
            const downloadBtn = createButton('btn-success', 'fa fa-download', [{ key: 'href', value: dados.path }, { key: 'download', value: '' }]);
            const deleteBtn = createButton('btn-danger', 'fa fa-trash', [{ key: 'type', value: 'submit' }], 'button');

            btnGroup.append(viewBtn, downloadBtn, deleteBtn);
            galleryBody.append(btnGroup);
            galleryCard.appendChild(galleryBody);
            galleryCol.appendChild(galleryCard);

            document.querySelector('#galeria').append(galleryCol);

            // Event listener para deletar imagem
            deleteBtn.addEventListener('click', async (e) => {
                e.preventDefault();
                const result = await myFetch(`/cms/delete/archives/${dados.id}`, 'DELETE');
                if (result.success) chargeGalery(table, id);
            });
        });
    }
}



function createButton(classes, iconClass, params = [], tag = 'a') {
    return create_element({
        tag: tag,
        classes: `btn ${classes} text-center m-1 flex-grow-0`,
        params: params,
        conteudo: `<em class="icon ${iconClass}"></em>`
    });
}

