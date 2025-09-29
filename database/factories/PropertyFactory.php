<?php

namespace Database\Factories;

use App\Enums\EnergyCertificate;
use App\Enums\PropertyCondition;
use App\Enums\PropertyStatus;
use App\Enums\PropertyTypology;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->randomElement([
            'Apartamento T2 com Vista Mar',
            'Moradia T3 com Jardim',
            'Apartamento T1 Renovado Centro',
            'Vivenda T4 com Piscina',
            'Loja Comercial Zona Prime',
            'Terreno para Construção',
            'Apartamento T3 Luxo',
            'Moradia Geminada T2',
            'Penthouse T4 Vista Rio',
            'Estúdio Moderno Centro',
        ]);

        $cities = ['Lisboa', 'Porto', 'Braga', 'Coimbra', 'Faro', 'Aveiro', 'Setúbal', 'Évora'];
        $city = fake()->randomElement($cities);
        
        $districts = [
            'Lisboa' => ['Lisboa', 'Sintra', 'Cascais', 'Oeiras'],
            'Porto' => ['Porto', 'Matosinhos', 'Vila Nova de Gaia', 'Maia'],
            'Braga' => ['Braga', 'Guimarães', 'Barcelos'],
            'Coimbra' => ['Coimbra', 'Figueira da Foz'],
            'Faro' => ['Faro', 'Albufeira', 'Portimão', 'Lagos'],
            'Aveiro' => ['Aveiro', 'Ílhavo', 'Ovar'],
            'Setúbal' => ['Setúbal', 'Almada', 'Seixal'],
            'Évora' => ['Évora', 'Estremoz'],
        ];

        $district = fake()->randomElement($districts[$city]);
        
        $slug = Str::slug($title) . '-' . fake()->unique()->numberBetween(1000, 9999);

        $typology = fake()->randomElement(PropertyTypology::cases());
        $bedrooms = match($typology) {
            PropertyTypology::T0 => 0,
            PropertyTypology::T1 => 1,
            PropertyTypology::T2 => 2,
            PropertyTypology::T3 => 3,
            PropertyTypology::T4 => 4,
            PropertyTypology::T5 => 5,
            PropertyTypology::T6 => 6,
            default => null,
        };

        // Real estate images from Unsplash
        $imageIds = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        $randomId = fake()->randomElement($imageIds);
        
        $gallery = [];
        for ($i = 1; $i <= 5; $i++) {
            $gallery[] = "https://images.unsplash.com/photo-" . (1560184564 + $i * 1000000) . "?w=800&h=600&fit=crop&auto=format&q=80";
        }

        $description = "Esta propriedade única oferece um equilíbrio perfeito entre conforto moderno e elegância atemporal. Com acabamentos de alta qualidade e atenção meticulosa aos detalhes, cada espaço foi cuidadosamente projetado para proporcionar uma experiência de vida excepcional.\n\nOs amplos espaços interiores são banhados por luz natural, criando um ambiente acolhedor e sofisticado. A cozinha totalmente equipada e as áreas de estar generosas tornam esta propriedade ideal tanto para o dia a dia como para receber convidados.\n\nLocalizada numa zona privilegiada com excelentes acessos e todas as comodidades nas proximidades, esta é uma oportunidade rara de adquirir uma propriedade verdadeiramente especial.";

        return [
            'title' => $title,
            'slug' => $slug,
            'description' => $description,
            'price' => fake()->randomFloat(2, 50000, 1500000),
            'typology' => $typology,
            'area' => fake()->numberBetween(40, 500),
            'bedrooms' => $bedrooms,
            'bathrooms' => fake()->numberBetween(1, 5),
            'parking' => fake()->numberBetween(0, 3),
            'condition' => fake()->randomElement(PropertyCondition::cases()),
            'status' => fake()->randomElement([PropertyStatus::ATIVO, PropertyStatus::ATIVO, PropertyStatus::RESERVADO, PropertyStatus::RASCUNHO]),
            'address' => fake()->streetAddress(),
            'city' => $city,
            'district' => $district,
            'parish' => fake()->city(),
            'latitude' => fake()->latitude(36.5, 42.5),
            'longitude' => fake()->longitude(-9.5, -6.0),
            'cover_image' => "https://images.unsplash.com/photo-156018" . str_pad($randomId, 4, '0', STR_PAD_LEFT) . "?w=1920&h=1080&fit=crop&auto=format&q=85",
            'gallery' => $gallery,
            'seo_title' => Str::limit($title, 70),
            'seo_description' => Str::limit(fake()->sentence(15), 170),
            'canonical_url' => null,
            'noindex' => false,
            'energy_certificate' => fake()->randomElement(EnergyCertificate::cases()),
            'year_built' => fake()->numberBetween(1980, 2024),
            'published_at' => fake()->boolean(80) ? now() : null,
            'created_by' => null,
            'updated_by' => null,
        ];
    }
}
