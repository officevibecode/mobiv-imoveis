<?php

namespace App\Livewire;

use App\Enums\PropertyStatus;
use App\Models\Property;
use Livewire\Component;
use Livewire\WithPagination;

class PropertyGrid extends Component
{
    use WithPagination;

    public $search = '';
    public $city = '';
    public $typology = '';
    public $minPrice = '';
    public $maxPrice = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'city' => ['except' => ''],
        'typology' => ['except' => ''],
        'minPrice' => ['except' => ''],
        'maxPrice' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCity()
    {
        $this->resetPage();
    }

    public function updatingTypology()
    {
        $this->resetPage();
    }

    public function render()
    {
        $properties = Property::query()
            ->with(['categories', 'tags'])
            ->where('status', PropertyStatus::ATIVO)
            ->whereNotNull('published_at')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
                      ->orWhere('city', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->city, fn($q) => $q->where('city', $this->city))
            ->when($this->typology, fn($q) => $q->where('typology', $this->typology))
            ->when($this->minPrice, fn($q) => $q->where('price', '>=', $this->minPrice))
            ->when($this->maxPrice, fn($q) => $q->where('price', '<=', $this->maxPrice))
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        $cities = Property::where('status', PropertyStatus::ATIVO)
            ->distinct()
            ->pluck('city')
            ->filter()
            ->sort()
            ->values();

        return view('livewire.property-grid', [
            'properties' => $properties,
            'cities' => $cities,
        ]);
    }
}
