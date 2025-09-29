<?php

use App\Enums\PropertyStatus;
use App\Models\Property;

test('property factory generates valid gallery array', function () {
    $property = Property::factory()->make();
    
    expect($property->gallery)->toBeArray()
        ->and(count($property->gallery))->toBeGreaterThanOrEqual(5)
        ->and(count($property->gallery))->toBeLessThanOrEqual(8);
    
    foreach ($property->gallery as $imageUrl) {
        expect($imageUrl)->toBeString()
            ->toContain('https://');
    }
});

test('property status follows distribution bias', function () {
    $properties = Property::factory(100)->make();
    
    $statusCounts = [
        PropertyStatus::ATIVO->value => 0,
        PropertyStatus::RESERVADO->value => 0,
        PropertyStatus::VENDIDO->value => 0,
        PropertyStatus::RASCUNHO->value => 0,
    ];
    
    foreach ($properties as $property) {
        expect($property->status)->toBeInstanceOf(PropertyStatus::class);
        $statusCounts[$property->status->value]++;
    }
    
    // Verify bias (approximate): 70% ativo, 15% reservado, 10% vendido, 5% rascunho
    expect($statusCounts[PropertyStatus::ATIVO->value])->toBeGreaterThan(50); // At least 50%
    expect($statusCounts[PropertyStatus::RESERVADO->value])->toBeGreaterThan(5);
});

test('property slug is unique', function () {
    $property1 = Property::factory()->make();
    $property2 = Property::factory()->make();
    
    expect($property1->slug)->not->toBe($property2->slug);
});

test('published_at is null when status is rascunho', function () {
    $properties = Property::factory(20)->make([
        'status' => PropertyStatus::RASCUNHO,
    ]);
    
    foreach ($properties as $property) {
        expect($property->published_at)->toBeNull();
    }
});

test('published_at is set when status is ativo', function () {
    $properties = Property::factory(10)->make([
        'status' => PropertyStatus::ATIVO,
    ]);
    
    foreach ($properties as $property) {
        expect($property->published_at)->not->toBeNull();
    }
});

test('bedrooms matches typology', function () {
    $t3Property = Property::factory()->make(['typology' => \App\Enums\PropertyTypology::T3]);
    expect($t3Property->bedrooms)->toBe(3);
    
    $t0Property = Property::factory()->make(['typology' => \App\Enums\PropertyTypology::T0]);
    expect($t0Property->bedrooms)->toBe(0);
});

test('property has valid portuguese city and coordinates', function () {
    $property = Property::factory()->make();
    
    expect($property->city)->toBeString()->not->toBeEmpty()
        ->and($property->district)->toBeString()->not->toBeEmpty()
        ->and((float)$property->latitude)->toBeFloat()->toBeGreaterThan(36.0)->toBeLessThan(43.0)
        ->and((float)$property->longitude)->toBeFloat()->toBeGreaterThan(-10.0)->toBeLessThan(-6.0);
});

test('property description contains HTML bullets', function () {
    $property = Property::factory()->make();
    
    expect($property->description)->toContain('<ul>')
        ->toContain('<li>')
        ->toContain('</li>')
        ->toContain('</ul>');
});

test('seo title is within 70 characters', function () {
    $property = Property::factory()->make();
    
    expect(strlen($property->seo_title))->toBeLessThanOrEqual(70);
});

test('seo description is within 170 characters', function () {
    $property = Property::factory()->make();
    
    expect(strlen($property->seo_description))->toBeLessThanOrEqual(170);
});
