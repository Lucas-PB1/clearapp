let table = route = null;
let permissions = {};

function generateTable(apiRoute, buttonsToShow = ['edit', 'delete'], includeActionColumn = true, customButton = null) {
    route = apiRoute;

    document.addEventListener('DOMContentLoaded', async function () {
        let data = await myFetch(route);
        tableData = data.content;

        if (tableData.length == 0) return document.querySelector('#tabulator-table').style.display = 'none';

        // Armazene as permissões
        permissions.edit = data.perm_edit;
        permissions.delete = data.perm_delete;

        const tableWidth = document.querySelector("#tabulator-table").offsetWidth;
        const actionColumnWidth = tableWidth * 0.10;

        let columns = Object.keys(tableData[0])
            .filter(key => key !== "id" && key !== "deletable" && key !== 'customshow')
            .map(key => {
                return { title: key.charAt(0).toUpperCase() + key.slice(1), field: key, };
            });

        if (includeActionColumn) {
            columns.push({
                title: "Ações",
                field: "actionsField",
                headerSort: false,
                formatter: (cell, formatterParams) => actionFormatter(cell, formatterParams, buttonsToShow, customButton),
                cellClick: (e, cell) => actionCellClick(e, cell, customButton),
                width: actionColumnWidth
            });
        }

        if (tableData.length > 0) {
            table = new window.Tabulator("#tabulator-table", {
                data: tableData,
                layout: "fitColumns",
                pagination: "remote",
                paginationSize: 10,
                paginationSizeSelector: [10, 25, 50, 100],
                ajaxURL: route,
                ajaxParams: { page: 1 },
                columns: columns,
                locale: true,
                langs: {
                    "pt-br": {
                        "pagination": {
                            "first": "Primeiro",
                            "first_title": "Primeira Página",
                            "last": "Último",
                            "last_title": "Última Página",
                            "prev": "Anterior",
                            "prev_title": "Página Anterior",
                            "next": "Próximo",
                            "next_title": "Próxima Página",
                            "page_size": "Tamanho da Página"
                        },
                        "headerFilters": {
                            "default": "filtrar coluna...",
                        },
                        "ajax": {
                            "loading": "Carregando...",
                            "error": "Erro",
                        },
                        "groups": {
                            "itemCount": "data in || {count} datas"
                        },
                        "filters": {
                            "equals": "igual a",
                            "notEquals": "diferente de",
                        }
                    }
                },
            });
        }

        setTimeout(() => {
            if (document.querySelector('.tabulator-page')) {
                let paginationButtons = document.querySelectorAll('.tabulator-page');
                paginationButtons.forEach(function (button) {
                    button.removeAttribute('title');
                });
            }
        }, 1000);

        if (document.getElementById('search-input')) {
            document.getElementById('search-input').addEventListener('input', function () {
                const searchTerm = this.value;

                if (searchTerm) {
                    table.setFilter(function (data) {
                        for (let prop in data) {
                            if (String(data[prop]).includes(searchTerm)) return true;
                        }
                        return false;
                    });
                } else {
                    table.clearFilter();
                }
            });
        }

    });

    document.querySelectorAll(".tabulator-arrow").forEach(arrow => {
        arrow.addEventListener("click", function () {
            if (this.classList.contains("active")) {
                this.classList.remove("active");
            } else {
                this.classList.add("active");
            }
        });
    });
}


function actionFormatter(cell, formatterParams, buttonsToShow, customButton) {
    let rowData = cell.getRow().getData();
    let output = '';

    let element = cell.getElement();
    element.classList.add("d-flex");
    element.classList.add("justify-content-center");
    element.classList.add("align-items-center");

    if (customButton && rowData.customshow) {
        let buttonElement = create_element({ tag: 'button', classes: `btn ${customButton.classes} btn-custom`, conteudo: customButton.content });

        if (customButton.attributes) {
            for (let attr in customButton.attributes) {
                buttonElement.setAttribute(attr, customButton.attributes[attr]);
            }
        }
        output += buttonElement.outerHTML;
    }

    if (buttonsToShow.includes('edit') && permissions.edit)
        output += create_element({ tag: 'button', classes: 'btn btn-primary btn-edit mx-2', conteudo: '<i class="fa fa-pencil btn-edit"></i>' }).outerHTML;

    if (buttonsToShow.includes('delete') && rowData.deletable != false && permissions.delete)
        output += create_element({ tag: 'button', classes: 'btn btn-danger btn-delete', conteudo: '<i class="fa fa-trash btn-delete"></i>' }).outerHTML;

    return output;
}

async function actionCellClick(e, cell, customButton) {
    let rowData = cell.getRow().getData();

    if (e.target.classList.contains('btn-edit')) {
        let fullURL = window.location.href;
        let baseURL = fullURL.split('?')[0];
        window.location.href = `${baseURL}/${rowData.id}/edit`;
    }

    if (e.target.classList.contains('btn-delete')) {

        Swal.fire({
            title: "Tem certeza?",
            text: "Você não poderá reverter esta ação!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sim, delete!",
            cancelButtonText: "Não, cancelar!"
        }).then(async (result) => {
            if (result.isConfirmed) {
                Swal.fire("Deletado!", "", "success");

                let dados = await myFetch(route);
                await myFetch(`delete/${dados.tableName}/${rowData.id}`, 'DELETE', { id: rowData.id });
                reloadTable();
            }
        });
    }

    if (e.target.classList.contains('btn-custom') && customButton && customButton.onClick)
        customButton.onClick(e, rowData);
}

window.addEventListener('resize', function () {
    if (table) {
        const newTableWidth = document.querySelector("#tabulator-table").offsetWidth;
        const newActionColumnWidth = newTableWidth * 0.10;
        table.updateColumnDefinition("actionsField", { width: newActionColumnWidth });
    }
});

async function reloadTable() {
    let data = await myFetch(route);
    tableData = data.content;
    table.replaceData(tableData);
}
