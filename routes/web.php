<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/atendimentos', 301);

Route::get('/atendimentos', function () {
    return view('atendimentos.index');
}
);
Route::get('/atendimentos/criar', function () {
    return view('atendimentos.criar');
});
