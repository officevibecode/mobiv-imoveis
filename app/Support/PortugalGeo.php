<?php

namespace App\Support;

class PortugalGeo
{
    public static function getLocations(): array
    {
        return [
            'Lisboa' => [
                'district' => 'Lisboa',
                'lat_range' => [38.68, 38.80],
                'lng_range' => [-9.25, -9.05],
                'parishes' => ['Parque das Nações', 'Avenidas Novas', 'Belém', 'Campo de Ourique', 'Alvalade', 'Areeiro'],
            ],
            'Cascais' => [
                'district' => 'Lisboa',
                'lat_range' => [38.68, 38.77],
                'lng_range' => [-9.47, -9.35],
                'parishes' => ['Estoril', 'Carcavelos', 'Parede', 'São Domingos de Rana'],
            ],
            'Oeiras' => [
                'district' => 'Lisboa',
                'lat_range' => [38.68, 38.74],
                'lng_range' => [-9.35, -9.27],
                'parishes' => ['Algés', 'Linda-a-Velha', 'Carnaxide', 'Paço de Arcos'],
            ],
            'Sintra' => [
                'district' => 'Lisboa',
                'lat_range' => [38.78, 38.82],
                'lng_range' => [-9.42, -9.35],
                'parishes' => ['Queluz', 'Massamá', 'Agualva-Cacém', 'Rio de Mouro'],
            ],
            'Porto' => [
                'district' => 'Porto',
                'lat_range' => [41.12, 41.19],
                'lng_range' => [-8.70, -8.55],
                'parishes' => ['Foz do Douro', 'Boavista', 'Cedofeita', 'Campanhã', 'Ramalde'],
            ],
            'Vila Nova de Gaia' => [
                'district' => 'Porto',
                'lat_range' => [41.10, 41.15],
                'lng_range' => [-8.65, -8.58],
                'parishes' => ['Mafamude', 'Canidelo', 'Vilar de Andorinho', 'Santa Marinha'],
            ],
            'Matosinhos' => [
                'district' => 'Porto',
                'lat_range' => [41.18, 41.22],
                'lng_range' => [-8.72, -8.66],
                'parishes' => ['Senhora da Hora', 'São Mamede de Infesta', 'Leça da Palmeira'],
            ],
            'Braga' => [
                'district' => 'Braga',
                'lat_range' => [41.52, 41.57],
                'lng_range' => [-8.45, -8.40],
                'parishes' => ['Centro', 'São Vicente', 'Maximinos', 'Nogueira'],
            ],
            'Coimbra' => [
                'district' => 'Coimbra',
                'lat_range' => [40.19, 40.23],
                'lng_range' => [-8.44, -8.40],
                'parishes' => ['Sé Nova', 'Santo António', 'Almedina', 'São Martinho'],
            ],
            'Aveiro' => [
                'district' => 'Aveiro',
                'lat_range' => [40.63, 40.66],
                'lng_range' => [-8.66, -8.63],
                'parishes' => ['Glória', 'Vera Cruz', 'Esgueira', 'São Bernardo'],
            ],
            'Setúbal' => [
                'district' => 'Setúbal',
                'lat_range' => [38.50, 38.54],
                'lng_range' => [-8.92, -8.86],
                'parishes' => ['Centro', 'São Sebastião', 'São Julião', 'Sado'],
            ],
            'Faro' => [
                'district' => 'Faro',
                'lat_range' => [37.00, 37.03],
                'lng_range' => [-7.97, -7.92],
                'parishes' => ['Centro', 'Montenegro', 'São Pedro', 'Santa Bárbara'],
            ],
            'Albufeira' => [
                'district' => 'Faro',
                'lat_range' => [37.08, 37.10],
                'lng_range' => [-8.26, -8.23],
                'parishes' => ['Centro', 'Ferreiras', 'Guia', 'Paderne'],
            ],
        ];
    }

    public static function randomLocation(): array
    {
        $locations = self::getLocations();
        $city = array_rand($locations);
        $data = $locations[$city];

        return [
            'city' => $city,
            'district' => $data['district'],
            'parish' => $data['parishes'][array_rand($data['parishes'])],
            'latitude' => self::randomFloat($data['lat_range'][0], $data['lat_range'][1], 6),
            'longitude' => self::randomFloat($data['lng_range'][0], $data['lng_range'][1], 6),
        ];
    }

    private static function randomFloat(float $min, float $max, int $decimals = 6): float
    {
        return round($min + mt_rand() / mt_getrandmax() * ($max - $min), $decimals);
    }
}
