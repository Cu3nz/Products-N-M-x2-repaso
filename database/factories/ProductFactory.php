<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        fake()->addProvider(new \Mmo\Faker\PicsumProvider(fake()));
        $stock = random_int(0,50);
        return [
            //

            'nombre' => fake() -> unique() -> sentence(),
            'descripcion' => fake() -> text(),
            'disponible' => ($stock) ? 'SI' : 'NO',
            'stock' => $stock,
            'pvp' => fake() -> randomFloat(2,1,300),
            'imagen' => "products/" . fake()->picsum("public/storage/products", 400, 400, false),
            'user_id' => User::all() -> random() -> id


        ];
    }
}
