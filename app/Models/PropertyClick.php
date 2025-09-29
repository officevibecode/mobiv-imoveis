<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyClick extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'property_id',
        'source',
        'user_agent',
        'ip_hash',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
