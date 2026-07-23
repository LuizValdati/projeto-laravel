<?php

use App\Http\Controllers\Api\AtendimentoController;
use Illuminate\Support\Facades\Route;

Route::get('/atendimentos', [AtendimentoController::class, 'index']);
Route::post('/atendimentos', [AtendimentoController::class, 'store']);
