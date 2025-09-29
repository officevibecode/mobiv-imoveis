<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedsToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'token',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}
