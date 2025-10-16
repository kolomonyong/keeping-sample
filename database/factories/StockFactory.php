<?php

namespace Database\Factories;

use App\Models\ProductType;
use App\Models\Rack;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ambil ID acak dari tabel yang ada
        $rackIds = Rack::pluck('id')->all();
        $productTypeIds = ProductType::pluck('id')->all();

        $productionDate = $this->faker->dateTimeBetween('-1 year', 'now');
        $expirationDate = $this->faker->dateTimeBetween($productionDate, '+2 years');

        return [
            'rack_id' => $this->faker->randomElement($rackIds),
            'product_type_id' => $this->faker->randomElement($productTypeIds),
            'production_code' => 'PROD-' . $this->faker->unique()->numberBetween(1000, 9999),
            'batch' => 'B' . $this->faker->numberBetween(100, 999),
            'production_date' => $productionDate->format('Y-m-d'),
            'expiration_date' => $expirationDate->format('Y-m-d'),
            'status' => 'in_storage',
        ];
    }
}
