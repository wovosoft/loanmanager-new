<?php

namespace Database\Factories;

use App\Models\Borrower;
use Illuminate\Database\Eloquent\Factories\Factory;

class BorrowerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Borrower::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $gender = $this->faker->randomElement(['male', 'female']);
        return [
            "name"=>$this->faker->name($gender),
            "nid"=>$this->faker->randomDigitNotNull(),
            "gender"=>$gender,
            "fathers_name"=>$this->faker->name("male"),
            "mothers_name"=>$this->faker->name("female"),
            "spouse_name"=>$this->faker->name($gender==="male"?"male":"female"),
            "date_of_birth"=>$this->faker->date(),
            "phone"=>$this->faker->e164PhoneNumber(),
            "email"=>$this->faker->safeEmail()
        ];
    }
}
