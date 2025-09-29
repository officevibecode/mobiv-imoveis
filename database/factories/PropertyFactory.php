<?php

namespace Database\Factories;

use App\Enums\EnergyCertificate;
use App\Enums\PropertyCondition;
use App\Enums\PropertyStatus;
use App\Enums\PropertyTypology;
use App\Models\Property;
use App\Support\PortugalGeo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PropertyFactory extends Factory
{
    public function configure(): static
    {
        return $this->afterMaking(function (Property $property) {
            // Recalculate published_at based on final status
            if (in_array($property->status, [PropertyStatus::ATIVO, PropertyStatus::RESERVADO, PropertyStatus::VENDIDO])) {
                if ($property->published_at === null) {
                    $property->published_at = now()->subDays(fake()->numberBetween(1, 180));
                }
            } else {
                $property->published_at = null;
            }
            
            // Recalculate bedrooms based on final typology
            if ($property->typology !== PropertyTypology::TERRENO && $property->typology !== PropertyTypology::LOJA) {
                $property->bedrooms = match ($property->typology) {
                    PropertyTypology::T0 => 0,
                    PropertyTypology::T1 => 1,
                    PropertyTypology::T2 => 2,
                    PropertyTypology::T3 => 3,
                    PropertyTypology::T4 => 4,
                    PropertyTypology::T5 => 5,
                    PropertyTypology::T6 => 6,
                    default => $property->bedrooms,
                };
            }
        });
    }

    public function definition(): array
    {
        // Status distribution: 70% ativo, 15% reservado, 10% vendido, 5% rascunho
        $rand = fake()->numberBetween(1, 100);
        $status = match (true) {
            $rand <= 70 => PropertyStatus::ATIVO,
            $rand <= 85 => PropertyStatus::RESERVADO,
            $rand <= 95 => PropertyStatus::VENDIDO,
            default => PropertyStatus::RASCUNHO,
        };

        // Typology with distribution bias
        $typology = fake()->randomElement([
            PropertyTypology::T0,
            PropertyTypology::T1, PropertyTypology::T1,
            PropertyTypology::T2, PropertyTypology::T2, PropertyTypology::T2,
            PropertyTypology::T3, PropertyTypology::T3,
            PropertyTypology::T4,
            PropertyTypology::T5,
            PropertyTypology::T6,
            PropertyTypology::TERRENO,
            PropertyTypology::LOJA,
        ]);

        // Get coherent data based on typology
        [$area, $priceRange, $bedrooms, $bathrooms] = $this->getTypologyData($typology);
        
        // Location
        $location = PortugalGeo::randomLocation();
        
        // Title construction (10-120 chars)
        $benefits = ['varanda', 'garagem', 'piscina', 'jardim', 'vista mar', 'terraço', 'renovado', 'centro'];
        $benefit = fake()->randomElement($benefits);
        
        $titleVariants = [
            "{$typology->value} em {$location['city']} — {$benefit}",
            "{$typology->value} com {$benefit} em {$location['city']}",
            "{$typology->value} {$location['city']} — {$benefit} e garagem",
            "Excelente {$typology->value} em {$location['city']}",
        ];
        $title = fake()->randomElement($titleVariants);
        $slug = Str::slug($title) . '-' . fake()->unique()->numberBetween(1000, 9999);

        // Description with HTML bullets
        $description = $this->generateDescription($typology, $location, $area);

        // Gallery (5-8 images with Picsum)
        $galleryCount = fake()->numberBetween(5, 8);
        $gallery = [];
        $seedBase = fake()->numberBetween(10000, 99999);
        for ($i = 0; $i < $galleryCount; $i++) {
            $gallery[] = "https://picsum.photos/seed/{$seedBase}-{$i}/800/600";
        }

        // Cover image
        $coverImage = "https://picsum.photos/seed/{$seedBase}-cover/1200/800";

        // SEO
        $seoTitle = Str::limit("{$title} | MOBIV Imóveis", 70);
        $seoDescription = Str::limit("Descubra este {$typology->value} em {$location['city']}, {$location['district']}. {$area}m². Contacte-nos!", 170);

        // Published_at based on status
        $publishedAt = in_array($status, [PropertyStatus::ATIVO, PropertyStatus::RESERVADO, PropertyStatus::VENDIDO])
            ? now()->subDays(fake()->numberBetween(1, 180))
            : null;

        return [
            'title' => $title,
            'slug' => $slug,
            'description' => $description,
            'price' => fake()->randomFloat(2, $priceRange[0], $priceRange[1]),
            'typology' => $typology,
            'area' => $area,
            'bedrooms' => $bedrooms,
            'bathrooms' => $bathrooms,
            'parking' => $typology === PropertyTypology::TERRENO ? 0 : fake()->numberBetween(0, 1),
            'condition' => $this->getCondition(),
            'status' => $status,
            'address' => fake()->streetAddress(),
            'city' => $location['city'],
            'district' => $location['district'],
            'parish' => $location['parish'],
            'latitude' => (float) $location['latitude'],
            'longitude' => (float) $location['longitude'],
            'cover_image' => $coverImage,
            'gallery' => $gallery,
            'seo_title' => $seoTitle,
            'seo_description' => $seoDescription,
            'canonical_url' => null,
            'noindex' => false,
            'energy_certificate' => fake()->randomElement(EnergyCertificate::cases()),
            'year_built' => fake()->numberBetween(1960, 2025),
            'published_at' => $publishedAt,
            'created_by' => null,
            'updated_by' => null,
        ];
    }

    private function getTypologyData(PropertyTypology $typology): array
    {
        return match ($typology) {
            PropertyTypology::T0 => [fake()->numberBetween(25, 45), [80000, 180000], 0, 1],
            PropertyTypology::T1 => [fake()->numberBetween(50, 75), [120000, 280000], 1, 1],
            PropertyTypology::T2 => [fake()->numberBetween(70, 110), [180000, 380000], 2, fake()->numberBetween(1, 2)],
            PropertyTypology::T3 => [fake()->numberBetween(90, 140), [220000, 450000], 3, 2],
            PropertyTypology::T4 => [fake()->numberBetween(120, 200), [280000, 650000], 4, fake()->numberBetween(2, 3)],
            PropertyTypology::T5 => [fake()->numberBetween(180, 280), [400000, 950000], 5, 3],
            PropertyTypology::T6 => [fake()->numberBetween(220, 350), [500000, 1200000], 6, fake()->numberBetween(3, 4)],
            PropertyTypology::LOJA => [fake()->numberBetween(25, 200), [80000, 600000], null, fake()->numberBetween(1, 2)],
            PropertyTypology::TERRENO => [fake()->numberBetween(200, 2000), [40000, 400000], null, null],
        };
    }

    private function getCondition(): PropertyCondition
    {
        $rand = fake()->numberBetween(1, 100);
        return match (true) {
            $rand <= 25 => PropertyCondition::NOVO,
            $rand <= 60 => PropertyCondition::USADO,
            $rand <= 85 => PropertyCondition::RENOVADO,
            default => PropertyCondition::EM_CONSTRUCAO,
        };
    }

    private function generateDescription(PropertyTypology $typology, array $location, int $area): string
    {
        $intro = fake()->randomElement([
            "Esta propriedade representa uma excelente oportunidade em {$location['city']}, {$location['district']}.",
            "Localizada em zona privilegiada de {$location['city']}, esta propriedade oferece conforto e qualidade.",
            "Descubra este imóvel único em {$location['city']}, perfeito para quem valoriza conforto e localização.",
        ]);

        $features = [
            "Acabamentos de alta qualidade",
            "Excelentes acessos e transportes",
            "Proximidade a comércio e serviços",
            "Cozinha equipada",
            "Áreas amplas e luminosas",
            "Ótima exposição solar",
            "Zona calma e residencial",
        ];

        if ($typology !== PropertyTypology::TERRENO && $typology !== PropertyTypology::LOJA) {
            $features[] = "Quartos com roupeiros";
        }

        if ($area > 100) {
            $features[] = "Varanda espaçosa";
        }

        shuffle($features);
        $selectedFeatures = array_slice($features, 0, fake()->numberBetween(4, 5));

        $bullets = "<ul>\n";
        foreach ($selectedFeatures as $feature) {
            $bullets .= "  <li>{$feature}</li>\n";
        }
        $bullets .= "</ul>";

        return $intro . "\n\n" . $bullets . "\n\nAgende já a sua visita!";
    }
}
