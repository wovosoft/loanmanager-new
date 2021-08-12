<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use App\Models\Loan;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class InstallmentController extends Controller
{
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        DB::beginTransaction();
        try {
            $request->validate([
                "loan_id" => "required|numeric",
                "date" => "date_format:Y-m-d|nullable",
                "amount" => "numeric"
            ]);
            $loan = Loan::query()->findOrFail($request->post("loan_id"));
            $item = new Installment();
            $item->forceFill([
                "creator_id" => 1, //auth()->id(),
                "borrower_id" => $loan->borrower_id,
                "account_id" => $loan->account_id,
                "loan_id" => $loan->id,
                "date" => $request->post("date"),
                "previous_debt" => $loan->due_amount ?? 0,
                "amount" => $request->post("amount") ?? 0,
                "current_debt" => ($loan->due_amount ?? 0) - ($request->post("amount") ?? 0),
                "payment_method" => $request->post("payment_method") ?? "cash",
            ]);
            $item->saveOrFail();
            DB::commit();
            return response()
                ->json([
                    "message" => "Successfully Done"
                ]);
        } catch (Throwable $exception) {
            DB::rollBack();
            return response()->json([
                "message" => "Operation Failed",
                "file" => $exception->getFile(),
                "line" => $exception->getLine(),
                "exception" => $exception->getMessage()
            ], 404);
        }
    }

    public function index(Request $request): LengthAwarePaginator
    {
        return Installment::query()
            ->with([
                "borrower:id,name",
                "account:id,account_no,account_name",
                "loan:id,loan_amount,due_amount,disbursement_date"
            ])
            ->when($request->post("borrower_id"), function (Builder $builder) use ($request) {
                $builder->whereBorrowerId($request->post("borrower_id"));
            })
            ->when($request->post("account_id"), function (Builder $builder) use ($request) {
                $builder->whereAccountId($request->post("account_id"));
            })
            ->when($request->post("starting_date") && $request->post("ending_date"), function (Builder $builder) use ($request) {
                $builder->whereBetween("date", [$request->post("starting_date"), $request->post("ending_date")]);
            })
            ->when($request->post("starting_date") && !$request->post("ending_date"), function (Builder $builder) use ($request) {
                $builder->whereDate("date", ">=", $request->post("starting_date"));
            })
            ->when(!$request->post("starting_date") && $request->post("ending_date"), function (Builder $builder) use ($request) {
                $builder->whereDate("date", "<=", $request->post("ending_date"));
            })
            ->when($request->post("account_no"), function (Builder $builder) use ($request) {
                $builder->whereHas("account", function (Builder $subBuilder) use ($request) {
                    $subBuilder->where("account_no", "=", $request->post("account_no"));
                });
            })
            ->orderBy($request->post("sortBy") ?? "id", $request->post("sortDesc") ? "desc" : "asc")
            ->paginate($request->post("perPage") ?? 15);
    }

    public function trash(Installment $installment, Request $request): \Illuminate\Http\JsonResponse
    {
        DB::beginTransaction();
        try {
            $installment->delete();
            DB::commit();
            return response()->json([
                "message" => "Successfully Done"
            ]);
        } catch (Throwable $exception) {
            DB::rollBack();
            return response()->json([
                "message" => "Operation Failed",
                "file" => $exception->getFile(),
                "line" => $exception->getLine(),
                "exception" => $exception->getMessage()
            ], 404);
        }
    }
}
