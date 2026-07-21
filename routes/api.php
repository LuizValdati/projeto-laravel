<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AtendimentoController;

Route::get('/atendimentos', [AtendimentoController::class, 'index']);
Route::post('/atendimentos', [AtendimentoController::class, 'store']);