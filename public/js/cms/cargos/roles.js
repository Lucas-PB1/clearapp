if (document.querySelector('.custom-control-input')) {
    [...document.querySelectorAll('.custom-control-input')].map(item => {
        item.addEventListener('click', () => {
            let cargo = document.querySelector('#cargo_id');
            myFetch('/cms/update/cargos', 'POST', { cargo_id: cargo.value, perm: item.id, checked: item.checked });
        })
    })
}
