<?php

namespace App\Enums;

enum TransactionTypes: string
{
    case UPDATE = 'UPDATE';
    case CREATE = 'CREATE';
    case DELETE = 'DELETE';
    case CANCELLED = 'CANCELLED';
}
