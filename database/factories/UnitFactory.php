<?php

namespace Database\Factories;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Unit>
 */
class UnitFactory extends Factory
{
    protected $model = Unit::class;

    public function definition(): array
    {
        $nama = fake()->unique()->company() . ' ' . fake()->randomElement(['Sejahtera', 'Nusantara', 'Mandiri', 'Bangsa']);

        return [
            'nama_sekolah' => $nama,
            'slug'         => Str::slug($nama),
            'jenjang'      => fake()->randomElement(['tk', 'smp', 'smk']),
            'is_active'    => true,
        ];
    }

    public function tk(): static
    {
        return $this->state(fn (array $attributes) => [
            'jenjang' => 'tk',
        ]);
    }

    public function smp(): static
    {
        return $this->state(fn (array $attributes) => [
            'jenjang' => 'smp',
        ]);
    }

    public function smk(): static
    {
        return $this->state(fn (array $attributes) => [
            'jenjang' => 'smk',
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
