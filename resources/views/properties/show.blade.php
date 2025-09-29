@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Back Button - Mobile -->
    <div class="lg:hidden sticky top-0 z-10 bg-white border-b border-gray-200 px-4 py-3">
        <a href="/imoveis" class="text-primary hover:text-primary-700 flex items-center gap-2 font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Voltar
        </a>
    </div>

    <!-- Hero Image -->
    <div class="relative w-full h-64 md:h-96 lg:h-[500px] bg-gray-900">
        <img 
            src="{{ $property->cover_image ?? 'https://via.placeholder.com/1200x600.png?text=Sem+Imagem' }}" 
            alt="{{ $property->title }}"
            class="w-full h-full object-cover"
        >
        <div class="absolute top-4 right-4">
            <span class="bg-primary text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                {{ $property->typology->value }}
            </span>
        </div>
    </div>

    <!-- Gallery Thumbnails - Hidden on mobile -->
    @if($property->gallery && count($property->gallery) > 0)
    <div class="hidden md:block bg-gray-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex gap-2 overflow-x-auto">
                @foreach(array_slice($property->gallery, 0, 6) as $image)
                    <img src="{{ $image }}" alt="Gallery" class="w-32 h-20 object-cover rounded flex-shrink-0 cursor-pointer hover:opacity-75 transition">
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Content -->
    <div class="max-w-7xl mx-auto">
        <!-- Title & Location - Mobile First -->
        <div class="px-4 py-6 border-b border-gray-200">
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-3">{{ $property->title }}</h1>
            <div class="flex items-center text-gray-600 text-sm md:text-base">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ $property->city }}{{ $property->district ? ', ' . $property->district : '' }}
            </div>
        </div>

        <!-- Price - Prominent on Mobile -->
        <div class="px-4 py-6 bg-primary/5 border-b border-gray-200">
            <p class="text-3xl md:text-4xl font-bold text-primary">{{ number_format($property->price, 0, ',', '.') }}€</p>
        </div>

        <!-- Quick Stats - Mobile Optimized -->
        <div class="grid grid-cols-4 gap-2 px-4 py-6 border-b border-gray-200">
            @if($property->area)
            <div class="text-center">
                <p class="text-xl md:text-2xl font-bold text-gray-900">{{ $property->area }}</p>
                <p class="text-xs md:text-sm text-gray-600">m²</p>
            </div>
            @endif
            
            @if($property->bedrooms)
            <div class="text-center">
                <p class="text-xl md:text-2xl font-bold text-gray-900">{{ $property->bedrooms }}</p>
                <p class="text-xs md:text-sm text-gray-600">Quartos</p>
            </div>
            @endif
            
            @if($property->bathrooms)
            <div class="text-center">
                <p class="text-xl md:text-2xl font-bold text-gray-900">{{ $property->bathrooms }}</p>
                <p class="text-xs md:text-sm text-gray-600">WC</p>
            </div>
            @endif
            
            @if($property->parking)
            <div class="text-center">
                <p class="text-xl md:text-2xl font-bold text-gray-900">{{ $property->parking }}</p>
                <p class="text-xs md:text-sm text-gray-600">Garagem</p>
            </div>
            @endif
        </div>

        <div class="lg:grid lg:grid-cols-3 lg:gap-8 lg:px-4 lg:py-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Description -->
                <div class="px-4 py-6 lg:p-0 lg:mb-8">
                    <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-4">Descrição</h2>
                    <div class="text-gray-700 leading-relaxed space-y-3">
                        {!! nl2br(e($property->description)) !!}
                    </div>
                </div>

                <!-- Características -->
                @if($property->tags->count() > 0 || $property->categories->count() > 0)
                <div class="px-4 py-6 border-t border-gray-200 lg:border-0 lg:p-0 lg:mb-8">
                    <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-4">Características</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($property->tags as $tag)
                            <span class="px-3 py-1.5 bg-accent/20 text-gray-800 rounded-full text-sm font-medium">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                        @foreach($property->categories as $category)
                            <span class="px-3 py-1.5 bg-primary/10 text-primary rounded-full text-sm font-medium">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Details -->
                <div class="px-4 py-6 border-t border-gray-200 lg:border-0 lg:p-0">
                    <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-4">Detalhes</h2>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-600">Condição</p>
                            <p class="font-semibold text-gray-900">{{ $property->condition->value }}</p>
                        </div>
                        @if($property->energy_certificate)
                        <div>
                            <p class="text-gray-600">Certificado Energético</p>
                            <p class="font-semibold text-gray-900">{{ $property->energy_certificate->value }}</p>
                        </div>
                        @endif
                        @if($property->year_built)
                        <div>
                            <p class="text-gray-600">Ano de Construção</p>
                            <p class="font-semibold text-gray-900">{{ $property->year_built }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Contact Card - Desktop Only -->
            <div class="hidden lg:block lg:col-span-1">
                <div class="bg-gray-50 rounded-xl p-6 sticky top-8 border border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Interessado?</h3>
                    <p class="text-gray-600 text-sm mb-6">Entre em contacto para mais informações</p>
                    
                    <a 
                        href="https://wa.me/351914337546?text={{ urlencode("Olá MOBIV! Tenho interesse no imóvel {$property->title} (" . url("/imovel/{$property->slug}") . "). Podem ajudar?") }}"
                        target="_blank"
                        onclick="trackWhatsAppClick({{ $property->id }}, 'property_detail')"
                        class="w-full flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white px-6 py-4 rounded-lg font-semibold transition-all shadow-lg hover:shadow-xl"
                    >
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                        Contactar via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- WhatsApp CTA Mobile -->
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
