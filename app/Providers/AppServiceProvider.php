<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\AtendimentoRepositoryInterface;
use App\Repositories\Contracts\PacienteRepositoryInterface;
use App\Repositories\Contracts\MedicoRepositoryInterface;
use App\Repositories\AtendimentoRepository;
use App\Repositories\PacienteRepository;
use App\Repositories\MedicoRepository;

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
