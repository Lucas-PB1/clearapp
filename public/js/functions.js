function hiddenItems(...selectors) {
    selectors.forEach(selector => {
        const elements = document.querySelectorAll(selector);
        elements.forEach(element => element.style.display = 'none');
    });
}


function createChunks() {
    Object.defineProperty(Array.prototype, 'chunk', {
        value: function (chunkSize) {
            let R = [];
            for (let i = 0; i < this.length; i += chunkSize)
                R.push(this.slice(i, i + chunkSize));
            return R;
        }
    });
}

async function myFetch(url, type = 'GET', data = null) {
    try {
        let response;
        if (type.toUpperCase() === 'GET') {
            response = await fetch(url);
        } else {
            response = await fetch(url, {
                headers: {
                    "Content-type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                method: type,
                body: data ? JSON.stringify(data) : '',
            });
        }

        let result = await response.json();

        return result;
    } catch (err) {
        console.log(`Erro: ${err.message}\nRequisição: ${url}\nData: ${data ? data : 'Sem Dados enviados'}\nTipo: ${type}`);
    }

}

function myXHR(url, type = 'GET', data) {
    const xhr = new XMLHttpRequest();
    const method = type.toUpperCase();

    if (method === 'GET' || method === 'POST') {
        xhr.open(method, url);
    } else {
        xhr.open('POST', `${url}?_method=${method}`);
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]');

    if (csrfToken) xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken.content);
    if (method === 'POST' && data) xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

    xhr.send(data ? JSON.stringify(data) : null);

    return xhr;
}

/**
 * @param {{tag: string, id: any, classes: string, estilos: string, conteudo: string, value: any, src: string, params: array, download: boolean}} object
 * @return {null|*}
 * Função responsável por criar e retornar um elemento HTML.
 */
function create_element({ tag, id, classes, estilos, conteudo, value, src, params, download = false }) {
    if (!tag) return null;

    const element = document.createElement(tag);

    const attributes = { id, class: classes, style: estilos, value, src, download: download ? "" : undefined };

    Object.entries(attributes).forEach(([key, val]) => val !== undefined ? element.setAttribute(key, val) : '');

    if (conteudo) element.innerHTML = conteudo;
    params && params.forEach(({ key, value }) => element.setAttribute(key, value));

    return element;
}

function prevenirDefault(...elements) {
    const targets = elements.length ? elements : document.querySelectorAll('button:not(.dont-prevent)');
    targets.forEach(el => el.addEventListener('click', e => e.preventDefault()));
}


function styleInPage(css, verbose = false) {
    const getStyle = (elem, pseudo) => {
        return (window.getComputedStyle
            ? window.getComputedStyle(elem, pseudo)
            : elem.currentStyle)[css];
    };

    const uniqueValues = new Set();
    const verboseValues = [];
    const nodes = document.body.getElementsByTagName('*');

    for (let node of nodes) {
        if (!node.style) continue;

        const selectors = [
            [null, getStyle(node, null)],
            [':before', getStyle(node, ':before')],
            [':after', getStyle(node, ':after')]
        ];

        for (let [pseudo, value] of selectors) {
            if (!value) continue;

            const identifier = '#' + (node.id || node.nodeName + pseudo);

            if (verbose) {
                verboseValues.push([identifier, value]);
            } else {
                uniqueValues.add(value);
            }
        }
    }

    return verbose ? verboseValues : [...uniqueValues];
}


function moneyMask(value) {
    value = value.replace('.', '').replace(',', '').replace(/\D/g, '')
    const options = { minimumFractionDigits: 2 }
    const result = value != '00' ? new Intl.NumberFormat('pt-BR', options).format(parseFloat(value) / 100) : '';
    return result != 'NaN' ? result : '';
}

function hasError(element, condicao) {
    if (condicao) {
        element.parentElement.classList.add("has-error");
        return true;
    } else {
        element.parentElement.classList.remove("has-error");
        return false;
    }
}

function timeToBRFormat(data) {
    return `${data.split('-')[2]}/${data.split('-')[1]}/${data.split('-')[0]}`;
}

function clearValue(element) {
    element.value = element.value.replace(/\D/g, '');
    return element.value;
}

function clearInputs(...references) {
    references.map(value => {
        document.querySelector(value).value = '';
        document.querySelector(value).setAttribute("value", '');
    });
}

function formatarTelefone(telefone) {
    return telefone.length === 11 ? `(${telefone.substring(0, 2)}) ${telefone.substring(2, 7)}-${telefone.substring(7)}` : `(${telefone.substring(0, 2)}) ${telefone.substring(2, 6)}-${telefone.substring(6)}`;
}

function formatarData(data) {
    const [ano, mes, dia] = data.split('-');
    return `${dia}/${mes}/${ano}`;
}

async function getData(element) {
    const cep = element.value.replace(/\D/g, '');
    const prefixClass = [...element.classList].find(cls => cls.startsWith('prefix'));

    if (cep.length !== 8) return;

    let data = await myFetch(`https://viacep.com.br/ws/${cep}/json/`);
    if (data && !data.erro) {
        const { logradouro, complemento, bairro, localidade } = data;
        const prefix = prefixClass ? `${prefixClass}` : '';
        const logradouroSelector = `[name="${prefix}_logradouro"]`;
        const complementoSelector = `[name="${prefix}_complemento"]`;
        const bairroSelector = `[name="${prefix}_bairro"]`;
        const cidadeSelector = `[name="${prefix}_cidade"]`;

        document.querySelector(logradouroSelector).value = logradouro ?? '';
        document.querySelector(complementoSelector).value = complemento ?? '';
        document.querySelector(bairroSelector).value = bairro ?? '';
        document.querySelector(cidadeSelector).value = localidade ?? '';

        toastr["success"]("Dados de CEP carregados com sucesso!", 'Sucesso!');
        document.querySelector(`[name="${prefix}_numero"]`)?.focus();
    } else {
        toastr["error"]("CEP não encontrado ou erro na busca.");
    }
}


