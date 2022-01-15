<?php

namespace Database\Factories;

use App\Models\GeoIp;
use Illuminate\Database\Eloquent\Factories\Factory;

class GeoIpFactory extends Factory
{

    protected $model = GeoIp::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'visitor_ip_address' => $this->faker->ipv4(),
            'visiting_count' => 1,
            'continent_geo_id' => $this->faker->numerify('#######'),
            'continent_iso_code' => $this->faker->countryCode(),
            'continent_iso_name' => $this->faker->country(),
            'country_geo_id' => $this->faker->numerify('#######'),
            'country_iso_code' => $this->faker->countryCode(),
            'country_iso_name' => $this->faker->country(),
            'country_is_in_european_union' => $this->faker->boolean(),
            'city_geo_id' => $this->faker->numerify('#######'),
            'city_geo_name' => $this->faker->city(),
            'postal_code' => 1111,
            'province' => $this->faker->city(),
            'accuracy_radius' => $this->faker->numerify('##'),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'time_zone' => $this->faker->timezone(),
            'autonomous_system_number' => $this->faker->numerify('####'),
            'autonomous_system_organization' => $this->faker->numerify('####'),
            'autonomous_network' => 'Somme Network',
            'is_hosting_provider' => $this->faker->boolean(),
        ];
    }
}
