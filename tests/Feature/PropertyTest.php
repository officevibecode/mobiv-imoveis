<?php

use App\Enums\PropertyCondition;
use App\Enums\PropertyStatus;
use App\Enums\PropertyTypology;
use App\Models\Category;
use App\Models\Property;
use App\Models\Tag;

test('it creates property with required fields', function () {
    $property = Property::factory()->create([
        'title' => 'Test Property Title',
        'price' => 150000.50,
    ]);

    expect($property->title)->toBe('Test Property Title')
        ->and($property->price)->toBe('150000.50')
        ->and($property->exists)->toBeTrue();
});

test('slug is unique', function () {
    $property1 = Property::factory()->create(['slug' => 'test-property-1234']);
    
    expect(fn () => Property::factory()->create(['slug' => 'test-property-1234']))
        ->toThrow(\Illuminate\Database\QueryException::class);
});

test('relations work with tags and categories', function () {
    $property = Property::factory()->create();
    $categories = Category::factory(2)->create();
    $tags = Tag::factory(3)->create();

    $property->categories()->attach($categories->pluck('id'));
    $property->tags()->attach($tags->pluck('id'));

    expect($property->categories)->toHaveCount(2)
        ->and($property->tags)->toHaveCount(3)
        ->and($property->categories->first())->toBeInstanceOf(Category::class)
        ->and($property->tags->first())->toBeInstanceOf(Tag::class);
});

test('factory generates valid gallery json', function () {
    $property = Property::factory()->create();

    expect($property->gallery)->toBeArray()
        ->and($property->gallery)->toHaveCount(5)
        ->and($property->gallery[0])->toContain('placeholder');
});

test('property casts work correctly', function () {
    $property = Property::factory()->create([
        'typology' => PropertyTypology::T2,
        'condition' => PropertyCondition::NOVO,
        'status' => PropertyStatus::ATIVO,
        'noindex' => true,
        'gallery' => ['image1.jpg', 'image2.jpg'],
    ]);

    expect($property->typology)->toBeInstanceOf(PropertyTypology::class)
        ->and($property->condition)->toBeInstanceOf(PropertyCondition::class)
        ->and($property->status)->toBeInstanceOf(PropertyStatus::class)
        ->and($property->noindex)->toBeTrue()
        ->and($property->gallery)->toBeArray();
});

test('property price is decimal with 2 places', function () {
    $property = Property::factory()->create(['price' => 123456.789]);

    expect($property->price)->toBe('123456.79');
});

test('property has clicks relationship', function () {
    $property = Property::factory()->create();

    expect($property->clicks())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
});
