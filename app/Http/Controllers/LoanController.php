<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Loan;
use Illuminate\Http\Request;
use Throwable;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        return Loan::query()
            ->with([
                "borrower:id,name",
                "account:id,account_no,account_name"
            ])
            ->orderBy($request->post("sortBy") ?? "id", $request->post("sortDesc") ? "desc" : "asc")
            ->paginate($request->post("perPage") ?? 15);
    }

    public function getLoanByAccountNo(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $request->validate([
                "account_no" => "string|required|min:3"
            ]);
            return response()
                ->json(
                    Account::query()
                        ->whereAccountNo($request->post("account_no"))
                        ->firstOrFail()
                        ->loans()
                        ->select([
                            "id",
                            "account_id",
                            "borrower_id",
                            "loan_amount",
                            "disbursement_date",
                            "due_amount",
                            "collection_amount",
                            "installment_amount",
                        ])
                        ->active()
                        ->get()
                );
        } catch (Throwable $exception) {
            return response()
                ->json([
                    "message" => "Not Found",
                    "exception" => $exception->getMessage(),
                    "code" => $exception->getCode(),
                    "line" => $exception->getLine(),
                    "file" => $exception->getFile()
                ], 404);
        }
    }
}
