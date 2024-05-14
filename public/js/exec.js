let optionsDropzone = {
    paramName: "file",
    maxFilesize: 16,
    dictDefaultMessage: "Arraste e solte arquivos aqui ou clique para enviar",
    init: function () {
        let dzInstance = this;
        this.on("queuecomplete", function () {
            chargeGalery(...paramsGalery);
            dzInstance.removeAllFiles(true);
        });
    }
}

window.onload = function () {
    if (document.querySelector('.cep'))
        [...document.querySelectorAll('.cep')].map(element => element.addEventListener('keyup', ({ target }) => getData(target)))

    const masks = {
        phone: '(00) 00000-0000',
        cep: '00000-000',
        cnpj: '00.000.000/0000-00',
        cpf: '000.000.000-00',
        rg: '00.000.000-0',
        titulo_eleitor: '0000 0000 0000',
        brData: '00/00/0000',
        passaporte: { mask: 'AA0000000', definitions: { 'A': /[A-Z]/ } },
        percent: { mask: 'num[fraction]%', blocks: { num: { mask: Number, thousandsSeparator: '' }, fraction: { mask: '', optional: true } }, lazy: false }
    };

    for (let key in masks) {
        document.querySelectorAll('.' + key).forEach(el => IMask(el, masks[key]));
    }

    let cpfCnpjElements = document.querySelectorAll('.cpf_cnpj');
    cpfCnpjElements.forEach(el => IMask(el, { mask: [{ mask: '000.000.000-00', maxLength: 11 }, { mask: '00.000.000/0000-00' }] }));

    let advancedPhoneElements = document.querySelectorAll('.advanced_phone');
    advancedPhoneElements.forEach(el => IMask(el, { mask: [{ mask: '(00) 0000-0000', maxLength: 10 }, { mask: '(00) 00000-0000' }] }));

    const moneyElements = document.querySelectorAll('.money');
    moneyElements.forEach(element => element.addEventListener('keyup', _ => element.value = moneyMask(element.value)));

    $(".summernote").summernote({
        height: 300,
        lang: "pt-BR",
        popover: {
            image: [
                ["custom", ["imageAttributes"]],
                ["imagesize", ["imageSize100", "imageSize50", "imageSize25"]],
                ["float", ["floatLeft", "floatRight", "floatNone"]],
                ["remove", ["removeMedia"]],
            ],
        },
        callbacks: {
            onImageUpload: function (files, editor, welEditable) {
                let data = new FormData();
                data.append("_token", $("input[name='_token']").val())

                for (let i = 0; i < files.length; i++) {
                    data.append(i, files[i])
                }

                $.ajax({
                    data: data,
                    type: "POST",
                    url: "/cms/summernote-files",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (urls) {
                        urls.forEach(url => {
                            let img = document.createElement('img');
                            img.src = url;
                            img.style.width = '100%';

                            $(".summernote").summernote('insertNode', img);
                        });
                    },
                    error: function (jqXHR, textStatus, errorThrown) { },
                })
            },
        },
    });



    function formatState(state) {
        if (!state.id) return state.text;
        let icon = $(state.element).data('icon');
        let $state = $('<span><i class="' + icon + '"></i> ' + state.text + '</span>');
        return $state;
    };

    $(".js-select2").select2({
        theme: "bootstrap-5",
        templateResult: formatState,
        templateSelection: formatState
    });

    // if (document.querySelector('.clickCloseForm')) {
    //     [...document.querySelectorAll('.clickCloseForm')].map(value => value.addEventListener('click', clickOnCloseForm))
    // }
};

