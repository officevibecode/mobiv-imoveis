<?php

namespace App\Models;

use App\Enums\EnergyCertificate;
use App\Enums\PropertyCondition;
use App\Enums\PropertyStatus;
use App\Enums\PropertyTypology;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    use HasFactory;

    /**
     * Validation rules reference (for form requests):
     * - title: required|string|min:10|max:120
     * - price: required|numeric|min:0
     * - seo_title: nullable|string|max:70
     * - seo_description: nullable|string|max:170
     */

    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'typology',
        'area',
        'bedrooms',
        'bathrooms',
        'parking',
        'condition',
        'status',
        'address',
        'city',
        'district',
        'parish',
        'latitude',
        'longitude',
        'cover_image',
        'gallery',
        'seo_title',
        'seo_description',
        'canonical_url',
        'noindex',
        'energy_certificate',
        'year_built',
        'published_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'typology' => PropertyTypology::class,
        'condition' => PropertyCondition::class,
        'status' => PropertyStatus::class,
        'energy_certificate' => EnergyCertificate::class,
        'gallery' => 'array',
        'noindex' => 'boolean',
        'published_at' => 'datetime',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function clicks(): HasMany
    {
        return $this->hasMany(PropertyClick::class);
    }
}
