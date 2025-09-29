<?php

namespace App\Enums;

enum AuditAction: string
{
    case CREATE = 'create';
    case UPDATE = 'update';
    case DELETE = 'delete';
}
