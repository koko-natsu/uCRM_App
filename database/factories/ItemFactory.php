<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        //     'name' => fake()->jobTitle(),
        //     'memo' => fake()->text(),
        //     'price' => fake()->randomNumber(5, false),
        //     'is_selling' => fake()->boolean(),
        // ];
            [
                'name' => 'カット',
                'memo' => 'カットの詳細',
                'price' => 6000,
                ],
                [
                'name' => 'カラー',
                'memo' => 'カラーの詳細',
                'price' => 8000,
                ],
                [
                'name' => 'パーマ(カット込み)',
                'memo' => 'パーマの詳細',
                'price' => 13000,
                ]
        ];
    }
}
