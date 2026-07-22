<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;

use App\Http\Requests\StoreAtendimentoRequest;
use App\Services\AtendimentoService;
use App\Http\Resources\AtendimentoResource;
use Illuminate\Http\Request;

class AtendimentoController extends Controller
{
    public function __construct(
        protected AtendimentoService $atendimentoService
    ){}

    public function index(Request $request): AnonymousResourceCollection
    {
        $atendimentos = $this->atendimentoService->all($request->only(['nome_paciente', 'nome_medico']));
        return AtendimentoResource::collection($atendimentos);
    }

    public function store(StoreAtendimentoRequest $request): JsonResponse
    {
        $atendimento= $this->atendimentoService->create($request->validated());
        return (new AtendimentoResource($atendimento))
            ->response()
            ->setStatusCode(201);
    }
}
