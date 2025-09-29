<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Imóveis Disponíveis</h1>
            <p class="text-gray-600">Encontre o seu imóvel ideal</p>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search"
                    placeholder="Pesquisar..."
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                >
                
                <select wire:model.live="city" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                    <option value="">Todas as Cidades</option>
                    @foreach($cities as $cityOption)
                        <option value="{{ $cityOption }}">{{ $cityOption }}</option>
                    @endforeach
                </select>

                <select wire:model.live="typology" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                    <option value="">Todas as Tipologias</option>
                    <option value="T0">T0</option>
                    <option value="T1">T1</option>
                    <option value="T2">T2</option>
                    <option value="T3">T3</option>
                    <option value="T4">T4</option>
                    <option value="T5">T5</option>
                    <option value="T6">T6</option>
                    <option value="terreno">Terreno</option>
                    <option value="loja">Loja</option>
                </select>

                <input 
                    type="number" 
                    wire:model.live.debounce.500ms="minPrice"
                    placeholder="Preço Mín."
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                >

                <input 
                    type="number" 
                    wire:model.live.debounce.500ms="maxPrice"
                    placeholder="Preço Máx."
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                >
            </div>
        </div>

        <!-- Results Count -->
        <div class="mb-6">
            <p class="text-gray-600">
                <span class="font-semibold">{{ $properties->total() }}</span> imóveis encontrados
            </p>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @forelse($properties as $property)
                <a 
                    href="/imovel/{{ $property->slug }}" 
                    onclick="trackPropertyClick({{ $property->id }}, 'listagem')"
                    class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 group"
                >
                    <div class="relative h-64 overflow-hidden">
                        <img 
                            src="{{ $property->cover_image ?? 'https://via.placeholder.com/400x300.png?text=Sem+Imagem' }}" 
                            alt="{{ $property->title }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                        >
                        <div class="absolute top-4 right-4">
                            <span class="bg-primary text-white px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $property->typology->value }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">
                            {{ $property->title }}
                        </h3>

                        <p class="text-gray-600 text-sm mb-4 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $property->city }}{{ $property->district ? ', ' . $property->district : '' }}
                        </p>

                        <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                            @if($property->area)
                                <span>{{ $property->area }}m²</span>
                            @endif
                            @if($property->bedrooms)
                                <span>{{ $property->bedrooms }} Quartos</span>
                            @endif
                            @if($property->bathrooms)
                                <span>{{ $property->bathrooms }} WC</span>
                            @endif
                        </div>

                        <div class="pt-4 border-t border-gray-200">
                            <p class="text-3xl font-bold text-primary">
                                {{ number_format($property->price, 0, ',', '.') }}€
                            </p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <p class="mt-4 text-lg text-gray-600">Nenhum imóvel encontrado</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $properties->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
function trackPropertyClick(propertyId, source) {
    // Send tracking request
    fetch('/api/clicks', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            property_id: propertyId,
            source: source
        })
    });

    // Track with GA4/Pixel if consent given
    if (window.dataLayer && hasConsent('analytics')) {
        window.dataLayer.push({
            event: 'property_click',
            property_id: propertyId,
            source: source
        });
    }
}
</script>
@endpush
