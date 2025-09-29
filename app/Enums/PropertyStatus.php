<?php

namespace App\Enums;

enum PropertyStatus: string
{
    case ATIVO = 'ativo';
    case RESERVADO = 'reservado';
    case VENDIDO = 'vendido';
    case RASCUNHO = 'rascunho';
}
