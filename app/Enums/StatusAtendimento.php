<?php

namespace App\Enums;

/**
 * Status possíveis de um atendimento.
 *
 */
enum StatusAtendimento: string
{
    case Agendado = 'agendado';
    case Realizado = 'realizado';
    case Cancelado = 'cancelado';
}
