@extends('layouts.app')

@php
    $seoTitle = 'Encontre o Imóvel Perfeito em Portugal';
    $seoDescription = 'Descubra apartamentos, moradias e terrenos em Portugal. A MOBIV oferece os melhores imóveis com localização privilegiada.';
@endphp

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-primary-50 to-accent-50 overflow-hidden" aria-label="Banner principal">
    <div class="container mx-auto px-4 py-20 lg:py-32">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Left Column -->
            <div class="space-y-8">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-ink leading-tight">
                    Encontre o Imóvel
                    <span class="text-primary">Perfeito</span>
                    em Portugal
                </h1>
                
                <p class="text-lg md:text-xl text-muted max-w-xl">
                    Descubra apartamentos, moradias e terrenos com localização privilegiada.
                </p>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="/imoveis" class="inline-flex items-center justify-center gap-2 bg-primary hover:bg-primary-600 text-white px-8 py-4 rounded-2xl font-bold text-lg transition-all shadow-lg hover:shadow-xl hover:scale-105 focus:outline-none focus:ring-4 focus:ring-primary-200 active:scale-95">
                        Ver Imóveis
                    </a>
                    <a href="https://wa.me/351914337546" target="_blank" class="inline-flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-2xl font-bold text-lg transition-all shadow-lg hover:shadow-xl hover:scale-105 focus:outline-none focus:ring-4 focus:ring-green-200 active:scale-95">
                        Falar no WhatsApp
                    </a>
                </div>
            </div>

            <!-- Right Column -->
            <div class="relative hidden lg:block">
                <div class="aspect-[16/9] rounded-3xl overflow-hidden shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800&h=600" alt="Moradia moderna" class="w-full h-full object-cover" loading="eager" fetchpriority="high">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
