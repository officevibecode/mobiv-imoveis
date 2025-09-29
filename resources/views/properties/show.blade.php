@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Image Full Width -->
    <div class="relative w-full h-[40vh] md:h-[60vh] lg:h-[70vh] bg-black">
        <img 
            src="{{ $property->cover_image }}" 
            alt="{{ $property->title }}"
            class="w-full h-full object-cover opacity-90"
        >
        
        <!-- Back Button Overlay -->
        <div class="absolute top-4 left-4 lg:top-8 lg:left-8">
            <a href="/imoveis" class="flex items-center gap-2 bg-white/90 backdrop-blur-sm px-4 py-2 rounded-full text-gray-900 font-medium hover:bg-white transition-all shadow-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Voltar
            </a>
        </div>

        <!-- Property Type Badge -->
        <div class="absolute top-4 right-4 lg:top-8 lg:right-8">
            <span class="bg-primary text-white px-5 py-2 rounded-full text-sm font-bold shadow-xl">
                {{ $property->typology->value }}
            </span>
        </div>

        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
    </div>

    <!-- Main Content Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 relative z-10">
        <div class="lg:grid lg:grid-cols-3 lg:gap-8">
            <!-- Left Column (Content) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Title Card -->
                <div class="bg-white rounded-2xl shadow-xl p-6 lg:p-8">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $property->title }}</h1>
                    
                    <div class="flex items-center text-gray-600 mb-6">
                        <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="font-medium">{{ $property->city }}, {{ $property->district }}</span>
                    </div>

                    <!-- Price -->
                    <div class="border-t border-gray-200 pt-6">
                        <p class="text-sm text-gray-600 mb-1">Preço</p>
                        <p class="text-4xl md:text-5xl font-bold text-primary">{{ number_format($property->price, 0, ',', '.') }}€</p>
                    </div>
                </div>

                <!-- Key Features -->
                <div class="bg-white rounded-2xl shadow-lg p-6 lg:p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Características Principais</h2>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        @if($property->area)
                        <div class="text-center p-4 bg-gray-50 rounded-xl">
                            <div class="text-3xl font-bold text-primary mb-1">{{ $property->area }}</div>
                            <div class="text-sm text-gray-600">m² área</div>
                        </div>
                        @endif
                        
                        @if($property->bedrooms !== null)
                        <div class="text-center p-4 bg-gray-50 rounded-xl">
                            <div class="text-3xl font-bold text-primary mb-1">{{ $property->bedrooms }}</div>
                            <div class="text-sm text-gray-600">Quartos</div>
                        </div>
                        @endif
                        
                        @if($property->bathrooms)
                        <div class="text-center p-4 bg-gray-50 rounded-xl">
                            <div class="text-3xl font-bold text-primary mb-1">{{ $property->bathrooms }}</div>
                            <div class="text-sm text-gray-600">Casas de banho</div>
                        </div>
                        @endif
                        
                        @if($property->parking)
                        <div class="text-center p-4 bg-gray-50 rounded-xl">
                            <div class="text-3xl font-bold text-primary mb-1">{{ $property->parking }}</div>
                            <div class="text-sm text-gray-600">Lugar garagem</div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-white rounded-2xl shadow-lg p-6 lg:p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Sobre o Imóvel</h2>
                    <div class="text-gray-700 text-lg leading-relaxed prose prose-lg max-w-none prose-ul:list-disc prose-ul:pl-6 prose-li:mb-3 prose-p:mb-4">
                        {!! $property->description !!}
                    </div>
                </div>

                <!-- Tags & Categories -->
                @if($property->tags->count() > 0 || $property->categories->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg p-6 lg:p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Tags & Categorias</h2>
                    <div class="flex flex-wrap gap-3">
                        @foreach($property->tags as $tag)
                            <span class="px-4 py-2 bg-accent/20 text-gray-800 rounded-lg text-sm font-medium">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                        @foreach($property->categories as $category)
                            <span class="px-4 py-2 bg-primary/10 text-primary rounded-lg text-sm font-bold">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Additional Details -->
                <div class="bg-white rounded-2xl shadow-lg p-6 lg:p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Informação Adicional</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="flex items-start gap-3">
                            <div class="p-2 bg-primary/10 rounded-lg">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Condição</p>
                                <p class="font-bold text-gray-900">{{ $property->condition->value }}</p>
                            </div>
                        </div>
                        
                        @if($property->energy_certificate)
                        <div class="flex items-start gap-3">
                            <div class="p-2 bg-green-100 rounded-lg">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Cert. Energético</p>
                                <p class="font-bold text-gray-900">Classe {{ $property->energy_certificate->value }}</p>
                            </div>
                        </div>
                        @endif
                        
                        @if($property->year_built)
                        <div class="flex items-start gap-3">
                            <div class="p-2 bg-blue-100 rounded-lg">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Ano construção</p>
                                <p class="font-bold text-gray-900">{{ $property->year_built }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column (Sidebar) -->
            <div class="lg:col-span-1 mt-6 lg:mt-0">
                <div class="sticky top-8 space-y-6">
                    <!-- Contact Card -->
                    <div class="bg-white rounded-2xl shadow-xl p-6 lg:p-8 border-2 border-primary/20">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Interessado?</h3>
                        <p class="text-gray-600 mb-6">Contacte-nos para agendar visita ou saber mais detalhes</p>
                        
                        <a 
                            href="https://wa.me/351914337546?text={{ urlencode("Olá! Tenho interesse no imóvel: {$property->title}") }}"
                            target="_blank"
                            onclick="trackWhatsAppClick({{ $property->id }}, 'property_detail')"
                            class="w-full flex items-center justify-center gap-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-4 rounded-xl font-bold text-lg transition-all transform hover:scale-105 shadow-lg hover:shadow-2xl"
                        >
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                            WhatsApp
                        </a>

                        <p class="text-xs text-center text-gray-500 mt-4">Resposta rápida garantida</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile WhatsApp CTA -->
    <x-whatsapp-cta :property="$property" />
</div>

<!-- JSON-LD Structured Data -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "RealEstateListing",
    "name": "{{ $property->title }}",
    "description": "{{ strip_tags(Str::limit($property->description, 200)) }}",
    "url": "{{ url('/imovel/' . $property->slug) }}",
    "image": "{{ $property->cover_image ?? url('/images/placeholder.png') }}",
    "offers": {
        "@type": "Offer",
        "price": "{{ $property->price }}",
        "priceCurrency": "EUR",
        "availability": "https://schema.org/InStock"
    },
    "address": {
        "@type": "PostalAddress",
        "addressLocality": "{{ $property->city }}",
        "addressRegion": "{{ $property->district }}",
        "addressCountry": "PT"
    }
    @if($property->latitude && $property->longitude)
    ,
    "geo": {
        "@type": "GeoCoordinates",
        "latitude": "{{ $property->latitude }}",
        "longitude": "{{ $property->longitude }}"
    }
    @endif
}
</script>

@push('scripts')
<script>
// Track property view
if (window.dataLayer && hasConsent('analytics')) {
    window.dataLayer.push({
        event: 'property_view',
        property_id: {{ $property->id }},
        property_title: '{{ $property->title }}',
        property_price: {{ $property->price }}
    });
}

function trackWhatsAppClick(propertyId, source) {
    if (window.dataLayer && hasConsent('analytics')) {
        window.dataLayer.push({
            event: 'whatsapp_click',
            property_id: propertyId,
            source: source
        });
    }
    
    if (typeof fbq !== 'undefined' && hasConsent('marketing')) {
        fbq('track', 'Contact', {
            content_name: 'WhatsApp CTA',
            property_id: propertyId
        });
    }
}
</script>
@endpush
@endsection
