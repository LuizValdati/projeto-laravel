<?php

namespace App\Providers;

use App\Repositories\AtendimentoRepository;
use App\Repositories\Contracts\AtendimentoRepositoryInterface;
use App\Repositories\Contracts\MedicoRepositoryInterface;
use App\Repositories\Contracts\PacienteRepositoryInterface;
use App\Repositories\MedicoRepository;
use App\Repositories\PacienteRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AtendimentoRepositoryInterface::class, AtendimentoRepository::class);
        $this->app->bind(PacienteRepositoryInterface::class, PacienteRepository::class);
        $this->app->bind(MedicoRepositoryInterface::class, MedicoRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
