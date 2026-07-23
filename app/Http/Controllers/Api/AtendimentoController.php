<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAtendimentoRequest;
use App\Http\Resources\AtendimentoResource;
use App\Services\AtendimentoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AtendimentoController extends Controller
{
    public function __construct(
        protected AtendimentoService $atendimentoService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $atendimentos = $this->atendimentoService->all($request->only(['nome_paciente', 'nome_medico', 'ordenar_por', 'direcao']));

        return AtendimentoResource::collection($atendimentos);
    }

    public function store(StoreAtendimentoRequest $request): JsonResponse
    {
        $atendimento = $this->atendimentoService->create($request->validated());

        return (new AtendimentoResource($atendimento))
            ->response()
            ->setStatusCode(201);
    }
}
