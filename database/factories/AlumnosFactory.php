<?php

namespace Database\Factories;

use App\Models\Alumnos;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlumnosFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Alumnos::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre'=>ucwords($this->faker->firstName()),
            'apellidos'=>ucwords($this->faker->lastName),
            'email'=>$this->faker->unique()->freeEmail,
            'telefono'=>$this->faker->optional()->e164PhoneNumber,
        ];
    }
}
