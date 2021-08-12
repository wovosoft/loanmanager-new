<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Borrower;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::factory(1)->create();
        echo json_encode($user, JSON_PRETTY_PRINT) . "\n";

        Borrower::factory()
            ->count(50)
            ->create()
            ->each(function (Borrower $borrower) {
                Account::factory()
                    ->count(1)
                    ->create([
                        "account_name" => $borrower->name,
                        "borrower_id" => $borrower->id,
                        "created_by" => 1,
                        "opening_date" => Carbon::now()->subMonths(10)->format("Y-m-d")
                    ])
                    ->each(function (Account $account) use ($borrower) {
                        Loan::factory()
                            ->count(1)
                            ->create([
                                "creator_id"=>1,
                                "borrower_id" => $borrower->id,
                                "account_id" => $account->id,
                                "disbursement_date" => Carbon::now()->subMonths(random_int(1,10))->addDays(random_int(-31,31))->format("Y-m-d"),
                            ]);
                    });
            });
    }
}
