<?php

namespace Database\Factories;

use App\Models\Device;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeviceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Device::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text,
            'token' => Str::random(16),
            'variables' => [[
                    'value' => 'temp',
                    'label' => 'Temprature'
                ],
                [
                    'value' => 'humidity',
                    'label' => 'Humidity' 
                ]
            ]
        ];
    }
}
