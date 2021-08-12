<?php

namespace Database\Factories;

use App\Models\Loan;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Loan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $loan = random_int(10000, 50000);
        $installment_amount = random_int(100, 1000);
        $installment_quantity = ceil($loan / $installment_amount);
        return [
            // "creator_id"=>$this->faker,
            // "borrower_id"=>$this->faker,
            // "account_id"=>$this->faker,
            "disbursement_date" => $this->faker->date(),
            // "closing_date"=>$this->faker,
            "loan_amount" => $loan,
            "installment_amount" => $installment_amount,
            "installment_quantity" => $installment_quantity,
            "status" => "active",
            "due_amount" => $loan
        ];
    }
}
