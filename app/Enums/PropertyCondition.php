<?php

namespace App\Enums;

enum PropertyCondition: string
{
    case NOVO = 'novo';
    case USADO = 'usado';
    case RENOVADO = 'renovado';
    case EM_CONSTRUCAO = 'em_construcao';
}
