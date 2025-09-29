<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->enum('typology', ['T0', 'T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'terreno', 'loja']);
            $table->integer('area')->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->tinyInteger('parking')->nullable();
            $table->enum('condition', ['novo', 'usado', 'renovado', 'em_construcao']);
            $table->enum('status', ['ativo', 'reservado', 'vendido', 'rascunho'])->default('rascunho');
            $table->string('address')->nullable();
            $table->string('city', 120)->nullable();
            $table->string('district', 120)->nullable();
            $table->string('parish', 120)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('cover_image')->nullable();
            $table->json('gallery')->nullable();
            $table->string('seo_title', 70)->nullable();
            $table->string('seo_description', 170)->nullable();
            $table->string('canonical_url')->nullable();
            $table->boolean('noindex')->default(false);
            $table->enum('energy_certificate', ['A+', 'A', 'B', 'C', 'D', 'E', 'F'])->nullable();
            $table->smallInteger('year_built')->unsigned()->nullable();
            $table->dateTime('published_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            // Índices
            $table->index('slug');
            $table->index('city');
            $table->index('district');
            $table->index('price');
            $table->index('published_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
