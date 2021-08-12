<?php

namespace Database\Factories;

use App\Models\Installment;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstallmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Installment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
             // "creator_id"=>$this->faker,
            // "borrower_id"=>$this->faker,
            // "account_id"=>$this->faker,
            "date"=>$this->faker->date(),
            "previous_debt"=>random_int(100,1000),
            "amount"=>random_int(100,1000),
            "current_debt"=>random_int(100,1000),
            "payment_method"=>random_int(100,1000),
        ];
    }
}
