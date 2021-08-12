<?php

namespace Database\Factories;

use App\Models\Account;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
           "created_by"=>random_int(1,10),
           "borrower_id"=>random_int(1,10),
           "account_no"=>uniqid(),
           "account_name"=>$this->faker->name(),
           "is_active"=>true,
           "opening_date"=>Carbon::now()->format("Y-m-d"),
        //    "closing_date"=>$this->faker,
        //    "description"=>$this->faker,
           "type"=>"simple",
        ];
    }
}
