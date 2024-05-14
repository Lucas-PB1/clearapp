<?php


use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;



Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home.index'));
});

//Produtos
Breadcrumbs::for('produtos', function ($trail) {
    $trail->parent('home');
    $trail->push('Produtos', route('produtos.index'));
});

Breadcrumbs::for('produtos.index', function ($trail, $produtos) {
    $trail->parent('produtos');
    $trail->push($produtos->name, route('produtos.index', $produtos->id));
});

//Sobre
Breadcrumbs::for('sobre', function ($trail) {
    $trail->parent('home');
    $trail->push('Sobre', route('sobre.index'));
});

Breadcrumbs::for('sobre.index', function ($trail, $sobre) {
    $trail->parent('sobre');
    $trail->push($sobre->name, route('produtos.index', $sobre->id));
});

//Contato
Breadcrumbs::for('contato', function ($trail) {
    $trail->parent('home');
    $trail->push('Contatos', route('contato.index'));
});

Breadcrumbs::for('contato.index', function ($trail, $contato) {
    $trail->parent('contato');
    $trail->push($contato->name, route('contato.index', $contato->id));
});

//Sou Aluno
Breadcrumbs::for('aluno', function ($trail) {
    $trail->parent('home');
    $trail->push('Aluno', route('aluno.login'));
});

Breadcrumbs::for('aluno.register', function ($trail) {
    $trail->parent('aluno');
    $trail->push('Registro de Aluno', route('aluno.register'));
});

Breadcrumbs::for('dashboard-aluno', function ($trail) {
    $trail->parent('aluno');
    $trail->push('Dashboard', route('aluno.dashboard'));
});


//Consultorias
Breadcrumbs::for('consultoria', function ($trail) {
    $trail->parent('home');
    $trail->push('Consultorias', route('consultorias.index'));
});

Breadcrumbs::for('consultorias.index', function ($trail, $consultoria) {
    $trail->parent('consultoria');
    $trail->push($consultoria->name, route('consultorias.index', $consultoria->id));
});

// E-Books
Breadcrumbs::for('e-books', function ($trail) {
    $trail->parent('home');
    $trail->push('E-Books', route('e-books.index'));
});

// Essa rota é para listar todos os e-books, então não precisa de um ID específico.
Breadcrumbs::for('e-books.index', function ($trail) {
    $trail->parent('e-books');
    $trail->push('Índice', route('e-books.index'));
});

// // Esta é a rota para mostrar um e-book específico.
// Breadcrumbs::for('e-book.show', function ($trail, $ebook) {
//     $trail->parent('e-books.index');
//     $trail->push($ebook->name, route('e-book.show', $ebook->id));
// });
